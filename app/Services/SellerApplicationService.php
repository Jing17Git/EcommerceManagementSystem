<?php

namespace App\Services;

use App\Models\SellerApplication;
use App\Models\SellerApplicationDocument;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SellerApplicationService
{
    /**
     * Validate application automatically
     * 
     * @param SellerApplication $application
     * @return array Array of validation errors (empty if valid)
     */
    public function autoValidateApplication(SellerApplication $application): array
    {
        $errors = [];

        // Check 1: Business permit expiry
        if ($this->isPermitExpired($application)) {
            $errors[] = 'Business permit has expired';
        }

        // Check 2: Name matching validation
        $nameErrors = $this->validateNameMatching($application);
        $errors = array_merge($errors, $nameErrors);

        return $errors;
    }

    /**
     * Check if business permit is expired
     * 
     * @param SellerApplication $application
     * @return bool
     */
    private function isPermitExpired(SellerApplication $application): bool
    {
        if (!$application->permit_expiry_date) {
            return false;
        }

        return Carbon::parse($application->permit_expiry_date)->isPast();
    }

    /**
     * Validate that all three names match
     * 
     * @param SellerApplication $application
     * @return array
     */
    private function validateNameMatching(SellerApplication $application): array
    {
        $errors = [];

        // Normalize names for comparison
        $businessName = $this->normalizeName($application->business_name);
        $permitName = $this->normalizeName($application->business_permit_name);
        $idCardName = $this->normalizeName($application->id_card_name);

        // Check: Business Name vs ID Card Name
        if ($businessName && $idCardName && $businessName !== $idCardName) {
            $errors[] = 'Business name does not match ID card name';
        }

        // Check: Business Permit Name vs Business Name
        if ($permitName && $businessName && $permitName !== $businessName) {
            $errors[] = 'Business permit name does not match business name';
        }

        // Check: Business Permit Name vs ID Card Name
        if ($permitName && $idCardName && $permitName !== $idCardName) {
            $errors[] = 'Business permit name does not match ID card name';
        }

        return $errors;
    }

    /**
     * Normalize name for comparison (lowercase, trim)
     * 
     * @param string|null $name
     * @return string
     */
    private function normalizeName(?string $name): string
    {
        return strtolower(trim($name ?? ''));
    }

    /**
     * Process application (validate and approve/reject)
     * 
     * @param SellerApplication $application
     * @return void
     */
    public function processApplication(SellerApplication $application): void
    {
        $errors = $this->autoValidateApplication($application);

        if (empty($errors)) {
            $this->approveApplication($application);
        } else {
            $this->rejectApplication($application, implode('. ', $errors));
        }
    }

    /**
     * Approve application and grant seller role
     * 
     * @param SellerApplication $application
     * @return void
     */
    public function approveApplication(SellerApplication $application): void
    {
        DB::transaction(function () use ($application) {
            $user = $application->user;
            
            // Update application status
            $application->update([
                'status' => SellerApplication::STATUS_APPROVED,
                'approved_at' => now(),
                'rejection_reason' => null,
            ]);
            
            // Grant seller role to user
            $user->addRole('seller');
            $user->update([
                'current_role' => 'seller',
                'role' => 'buyer', // Keep primary role as buyer
            ]);

            Log::info('Seller application approved', [
                'application_id' => $application->id,
                'user_id' => $user->id,
            ]);
        });
    }

    /**
     * Reject application with reason
     * 
     * @param SellerApplication $application
     * @param string $reason
     * @return void
     */
    public function rejectApplication(SellerApplication $application, string $reason): void
    {
        $application->update([
            'status' => SellerApplication::STATUS_REJECTED,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        Log::info('Seller application rejected', [
            'application_id' => $application->id,
            'user_id' => $application->user_id,
            'reason' => $reason,
        ]);
    }

    /**
     * Store uploaded document
     * 
     * @param SellerApplication $application
     * @param UploadedFile $file
     * @param string $documentType
     * @return SellerApplicationDocument
     */
    public function storeDocument(
        SellerApplication $application,
        UploadedFile $file,
        string $documentType
    ): SellerApplicationDocument {
        // Determine storage path based on document type
        $path = match($documentType) {
            SellerApplicationDocument::TYPE_BUSINESS_PERMIT => 'seller_documents/permits',
            SellerApplicationDocument::TYPE_ID_CARD => 'seller_documents/ids',
            default => 'seller_documents/other',
        };

        // Store file
        $filePath = $file->store($path, 'public');

        // Create document record
        return $application->documents()->create([
            'document_type' => $documentType,
            'document_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now(),
        ]);
    }

    /**
     * Delete document and its file
     * 
     * @param SellerApplicationDocument $document
     * @return bool
     */
    public function deleteDocument(SellerApplicationDocument $document): bool
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete database record
        return $document->delete();
    }

    /**
     * Get validation summary for application
     * 
     * @param SellerApplication $application
     * @return array
     */
    public function getValidationSummary(SellerApplication $application): array
    {
        return [
            'permit_expired' => $this->isPermitExpired($application),
            'names_match' => $application->namesMatch(),
            'is_valid' => empty($this->autoValidateApplication($application)),
            'errors' => $this->autoValidateApplication($application),
        ];
    }
}
