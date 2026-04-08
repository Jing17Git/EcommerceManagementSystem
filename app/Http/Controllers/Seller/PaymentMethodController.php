<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = SellerPaymentMethod::where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('seller.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('seller.payment-methods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'method_type' => 'required|in:gcash,paymaya,bank',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'is_primary' => 'boolean',
        ]);

        $validated['seller_id'] = Auth::id();

        // If this is set as primary, unset other primary methods
        if ($validated['is_primary'] ?? false) {
            SellerPaymentMethod::where('seller_id', Auth::id())
                ->update(['is_primary' => false]);
        }

        SellerPaymentMethod::create($validated);

        return redirect()->route('seller.payment-methods.index')
            ->with('success', 'Payment method added successfully.');
    }

    public function edit(SellerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->seller_id !== Auth::id()) {
            abort(403);
        }

        return view('seller.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, SellerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->seller_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'method_type' => 'required|in:gcash,paymaya,bank',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'is_primary' => 'boolean',
        ]);

        // If this is set as primary, unset other primary methods
        if ($validated['is_primary'] ?? false) {
            SellerPaymentMethod::where('seller_id', Auth::id())
                ->where('id', '!=', $paymentMethod->id)
                ->update(['is_primary' => false]);
        }

        $paymentMethod->update($validated);

        return redirect()->route('seller.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(SellerPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->seller_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod->delete();

        return redirect()->route('seller.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
