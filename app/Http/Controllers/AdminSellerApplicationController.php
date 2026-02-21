<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SellerApplication;
use Illuminate\Http\Request;

class AdminSellerApplicationController extends Controller
{
    // List all seller applications
    public function index()
    {
        $applications = SellerApplication::with('user')->latest()->paginate(10);
        return view('admin.sellers.index', compact('applications'));
    }

    // Show single seller application details
    public function show(SellerApplication $application)
    {
        return view('admin.sellers.show', compact('application'));
    }

    // Approve application
    public function approve(SellerApplication $application)
    {
        $user = $application->user;
        
        // Update application status
        $application->update(['status' => 'approved']);
        
        // Add seller role to user's roles JSON array (while keeping buyer role)
        $user->addRole('seller');
        
        // Set current_role to seller so they can start as seller
        $user->update([
            'current_role' => 'seller',
            'role' => 'buyer' // Keep primary role as buyer
        ]);
        
        return back()->with('success','Seller application approved. User can now switch between buyer and seller accounts.');
    }

    // Reject application
    public function reject(SellerApplication $application)
    {
        $application->update(['status' => 'rejected']);
        return back()->with('success','Seller application rejected.');
    }

    // Delete application
    public function destroy(SellerApplication $application)
    {
        $application->delete();
        return back()->with('success','Seller application deleted.');
    }
}