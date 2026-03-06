<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    /**
     * Switch between buyer and seller roles.
     * 
     * @param string $role The role to switch to (buyer or seller)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request)
    {
        $user = Auth::user();
        $targetRole = $request->input('role');

        // Validate the target role
        if (!in_array($targetRole, ['buyer', 'seller'])) {
            return back()->with('error', 'Invalid role selected.');
        }

        // Check if user has the target role (using the new hasAnyRole method)
        if (!$user->canSwitchToRole($targetRole)) {
            return back()->with('error', 'You do not have this role.');
        }

        // Update current_role to switch
        $user->update(['current_role' => $targetRole]);

        // Redirect based on the target role
        if ($targetRole === 'seller') {
            return redirect()->route('seller.dashboard')->with('success', 'Switched to seller account.');
        }

        return redirect()->route('buyer.dashboard')->with('success', 'Switched to buyer account.');
    }

    /**
     * Check if user can switch to a specific role.
     * 
     * @param string $role The role to check
     * @return bool
     */
    public function canSwitch($role)
    {
        $user = Auth::user();
        
        // Admin can switch to any role
        if ($user->isAdministrator()) {
            return true;
        }

        // For buyer/seller, use the new canSwitchToRole method
        return $user->canSwitchToRole($role);
    }

    /**
     * Get available roles for the current user.
     * 
     * @return array
     */
    public function getAvailableRoles()
    {
        $user = Auth::user();
        $roles = [];

        // Admin can switch to any role
        if ($user->isAdministrator()) {
            return ['buyer', 'seller'];
        }

        // Use getAllRoles from User model
        return $user->getAllRoles();
    }
}
