<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
            <p class="text-sm text-gray-500 mt-1">Track your store orders</p>
        </div>
    </header>

    <main class="p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-amber-600">{{ $orderStatuses['pending'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Processing</p>
                <p class="text-2xl font-bold text-blue-600">{{ $orderStatuses['processing'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Shipped</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $orderStatuses['shipped'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Delivered</p>
                <p class="text-2xl font-bold text-green-600">{{ $orderStatuses['delivered'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $order->order_number ?? ('ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $order->user?->name ?? 'Guest' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match($order->status) {
                                            'delivered' => 'bg-green-100 text-green-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    </main>
</x-seller-layout>
