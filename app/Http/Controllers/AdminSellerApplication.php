<?php

namespace App\Http\Controllers\Admin;

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
        $application->update(['status' => 'approved']);
        // Optionally: assign user role to seller
        $application->user->update(['role' => 'seller']);
        return back()->with('success','Seller application approved.');
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