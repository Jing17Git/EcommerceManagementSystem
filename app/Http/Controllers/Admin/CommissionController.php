<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->orWhereJsonContains('roles', 'seller')
            ->latest()
            ->paginate(20);

        $defaultCommission = 5.00; // Default platform commission

        return view('admin.commission.index', compact('sellers', 'defaultCommission'));
    }

    public function update(Request $request, User $seller)
    {
        $validated = $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $seller->update([
            'commission_rate' => $validated['commission_rate'],
        ]);

        return back()->with('success', 'Commission rate updated successfully.');
    }

    public function updateDefault(Request $request)
    {
        $validated = $request->validate([
            'default_commission' => 'required|numeric|min:0|max:100',
        ]);

        // Update all sellers without custom commission
        User::where(function($query) {
            $query->where('role', 'seller')
                  ->orWhereJsonContains('roles', 'seller');
        })
        ->whereNull('commission_rate')
        ->update(['commission_rate' => $validated['default_commission']]);

        return back()->with('success', 'Default commission rate updated for all sellers.');
    }
}
