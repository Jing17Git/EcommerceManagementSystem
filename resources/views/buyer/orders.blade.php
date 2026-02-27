@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 text-white">
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500/50 px-4 py-3 text-green-200">{{ session('success') }}</div>
    @endif

    <div class="mb-6 bg-[#1c1e38] border border-white/10 rounded-xl p-5">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold">Order Notifications</h2>
            <span class="text-xs text-gray-400">{{ ($notifications ?? collect())->count() }} updates</span>
        </div>

        <div class="space-y-2">
            @forelse(($notifications ?? collect()) as $note)
                <div class="rounded-lg border border-white/10 bg-[#12132a] px-4 py-3">
                    <p class="text-sm text-white">{{ $note['message'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $note['time']->format('M d, Y h:i A') }}
                        @if($note['is_update'])
                            <span class="ml-2 text-blue-300">Updated</span>
                        @else
                            <span class="ml-2 text-amber-300">New</span>
                        @endif
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-300">No order notifications yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-[#1c1e38] border border-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#12132a]">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Seller</th>
                        <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3">{{ $order->order_number ?? ('ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}</td>
                            <td class="px-4 py-3">{{ $order->seller?->name ?? 'Seller' }}</td>
                            <td class="px-4 py-3">₱{{ number_format((float)$order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs bg-white/10">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-300">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-white/10">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
