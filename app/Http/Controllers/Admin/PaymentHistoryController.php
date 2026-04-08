<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'order.seller'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->paginate(20);

        // Statistics
        $stats = [
            'total_payments' => Payment::count(),
            'total_amount' => Payment::where('status', 'captured')->sum('amount'),
            'pending_amount' => Payment::where('status', 'initiated')->sum('amount'),
            'failed_amount' => Payment::where('status', 'failed')->sum('amount'),
        ];

        return view('admin.payment-history.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['order.user', 'order.seller', 'order.items.product']);
        
        return view('admin.payment-history.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:initiated,authorized,captured,failed,refunded',
        ]);

        $payment->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'captured' ? now() : $payment->paid_at,
        ]);

        return back()->with('success', 'Payment status updated successfully.');
    }
}
