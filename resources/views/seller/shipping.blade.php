<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Shipping</h1>
            <p class="text-sm text-gray-500 mt-1">Live shipment status from your seller orders</p>
        </div>
    </header>

    <main class="p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Total Shipments</p>
                <p class="text-2xl font-bold text-gray-900">{{ $shippingStats['totalShipments'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">In Transit</p>
                <p class="text-2xl font-bold text-blue-600">{{ $shippingStats['inTransit'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Delivered</p>
                <p class="text-2xl font-bold text-green-600">{{ $shippingStats['delivered'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Failed / Cancelled</p>
                <p class="text-2xl font-bold text-red-600">{{ $shippingStats['failed'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Active Shipments</h3>
                <p class="text-sm text-gray-500">Orders currently processing or shipped</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Address</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Carrier</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tracking</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($activeShipments as $shipment)
                            @php
                                $statusClass = $shipment->status === 'shipped' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $shipment->order_number ?? ('ORD-' . str_pad($shipment->id, 6, '0', STR_PAD_LEFT)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $shipment->user?->name ?? 'Guest' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $shipment->shipping_address ?: 'No address' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $shipment->shipping_carrier ?: 'Standard Courier' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $shipment->tracking_number ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($shipment->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $shipment->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">No active shipments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-seller-layout>
