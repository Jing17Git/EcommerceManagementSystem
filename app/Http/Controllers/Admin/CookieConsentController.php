<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    public function edit()
    {
        $cookie = CookieConsent::first();
        return view('admin.cookie-consent.edit', compact('cookie'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'accept_button_text' => 'required|string|max:50',
            'decline_button_text' => 'required|string|max:50',
            'is_enabled' => 'boolean'
        ]);

        $cookie = CookieConsent::first();
        if ($cookie) {
            $cookie->update($validated);
        } else {
            CookieConsent::create($validated);
        }

        return redirect()->route('admin.cookie-consent.edit')->with('success', 'Cookie consent updated successfully!');
    }
}
