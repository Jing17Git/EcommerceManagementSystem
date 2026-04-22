<?php

namespace App\Services;

use App\Models\SellerApplication;
use Carbon\Carbon;

class SellerApplicationService
{
    public function autoValidateApplication(SellerApplication $application): array
    {
        $errors = [];

        // Check if business permit is expired
        if ($application->permit_expiry_date && Carbon::parse($application->permit_expiry_date)->isPast()) {
            $errors[] = 'Business permit has expired';
        }

        // Normalize names for comparison (case-insensitive, trim whitespace)
        $businessName = $application->business_name ? strtolower(trim($application->business_name)) : '';
        $idCardName = $application->id_card_name ? strtolower(trim($application->id_card_name)) : '';
        $permitName = $application->business_permit_name ? strtolower(trim($application->business_permit_name)) : '';

        // Check if business name matches ID card name
        if ($businessName && $idCardName && $businessName !== $idCardName) {
            $errors[] = 'Business name does not match ID card name';
        }

        // Check if business permit name matches business name
        if ($permitName && $businessName && $permitName !== $businessName) {
            $errors[] = 'Business permit name does not match business name';
        }

        // Check if business permit name matches ID card name
        if ($permitName && $idCardName && $permitName !== $idCardName) {
            $errors[] = 'Business permit name does not match ID card name';
        }

        return $errors;
    }

    public function processApplication(SellerApplication $application): void
    {
        $errors = $this->autoValidateApplication($application);

        if (empty($errors)) {
            $this->approveApplication($application);
        } else {
            $this->rejectApplication($application, implode('. ', $errors));
        }
    }

    private function approveApplication(SellerApplication $application): void
    {
        $user = $application->user;
        
        $application->update(['status' => 'approved']);
        
        $user->addRole('seller');
        $user->update([
            'current_role' => 'seller',
            'role' => 'buyer'
        ]);
    }

    private function rejectApplication(SellerApplication $application, string $reason): void
    {
        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }
}
