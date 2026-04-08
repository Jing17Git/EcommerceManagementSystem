@extends('layouts.admin')

@section('title', 'Payment History')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Payment History</h1>
        <p class="text-gray-400 text-sm mt-1">View all payment transactions</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5">
            <div class="text-gray-400 text-sm mb-1">Total Payments</div>
            <div class="text-2xl font-bold text-white">{{ number_format($stats['total_payments']) }}</div>
        </div>
        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5">
            <div class="text-gray-400 text-sm mb-1">Total Amount</div>
            <div class="text-2xl font-bold text-green-400">₱{{ number_format($stats['total_amount'], 2) }}</div>
        </div>
        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5">
            <div class="text-gray-400 text-sm mb-1">Pending</div>
            <div class="text-2xl font-bold text-yellow-400">₱{{ number_format($stats['pending_amount'], 2) }}</div>
        </div>
        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5">
            <div class="text-gray-400 text-sm mb-1">Failed</div>
            <div class="text-2xl font-bold text-red-400">₱{{ number_format($stats['failed_amount'], 2) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-4 mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <select name="status" class="rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2 text-sm">
                <option value="">All Status</option>
                <option value="initiated" {{ request('status') == 'initiated' ? 'selected' : '' }}>Initiated</option>
                <option value="captured" {{ request('status') == 'captured' ? 'selected' : '' }}>Captured</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            <select name="provider" class="rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2 text-sm">
                <option value="">All Methods</option>
                <option value="gcash" {{ request('provider') == 'gcash' ? 'selected' : '' }}>GCash</option>
                <option value="paymaya" {{ request('provider') == 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                <option value="bank" {{ request('provider') == 'bank' ? 'selected' : '' }}>Bank</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2 text-sm">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2 text-sm">
            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-lg text-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-[#1c1e38] border border-white/10 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#12132a] border-b border-white/10">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Buyer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Seller</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($payments as $payment)
                    <tr class="text-white hover:bg-white/5">
                        <td class="px-6 py-4 text-sm font-mono">{{ $payment->reference }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->order?->order_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->order?->user?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->order?->seller?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded bg-blue-600/20 text-blue-300">
                                {{ strtoupper($payment->provider) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($payment->status === 'captured')
                                <span class="px-2 py-1 text-xs rounded bg-green-600/20 text-green-300">Captured</span>
                            @elseif($payment->status === 'initiated')
                                <span class="px-2 py-1 text-xs rounded bg-yellow-600/20 text-yellow-300">Pending</span>
                            @elseif($payment->status === 'failed')
                                <span class="px-2 py-1 text-xs rounded bg-red-600/20 text-red-300">Failed</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-gray-600/20 text-gray-300">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.payment-history.show', $payment) }}" class="text-orange-400 hover:text-orange-300 text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                            No payment records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-white/10">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
