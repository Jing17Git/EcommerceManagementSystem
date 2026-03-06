<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Returns / Refunds</h1>
            <p class="text-sm text-gray-500 mt-1">Cancelled orders and refund totals from your store</p>
        </div>
    </header>

    <main class="p-8 space-y-6">
        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Total Returns</p>
                <p class="text-2xl font-bold text-gray-900">{{ $returnsStats['totalReturns'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-amber-600">{{ $returnsStats['pending'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Approved</p>
                <p class="text-2xl font-bold text-blue-600">{{ $returnsStats['approved'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Refunded Amount</p>
                <p class="text-2xl font-bold text-red-600">${{ number_format($returnsStats['refundedAmount'], 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Return Requests</h3>
                <p class="text-sm text-gray-500">Buyer-submitted return workflow</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Return ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($returnRequests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">RET-{{ str_pad($request->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $request->order?->order_number ?? ('ORD-' . str_pad($request->order_id, 6, '0', STR_PAD_LEFT)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $request->buyer?->name ?? 'Guest' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $request->reason ?: 'No reason provided' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-red-700">${{ number_format((float)($request->order?->total_amount ?? 0), 2) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($request->status === 'requested') bg-amber-100 text-amber-700
                                        @elseif($request->status === 'approved') bg-blue-100 text-blue-700
                                        @elseif($request->status === 'rejected') bg-red-100 text-red-700
                                        @else bg-green-100 text-green-700 @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($request->status === 'requested')
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('seller.returns.approve', $request) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-700 text-xs font-semibold hover:bg-blue-200 transition">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('seller.returns.reject', $request) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-100 text-red-700 text-xs font-semibold hover:bg-red-200 transition">Reject</button>
                                            </form>
                                        </div>
                                    @elseif($request->status === 'approved')
                                        <form method="POST" action="{{ route('seller.returns.refund', $request) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 rounded-md bg-green-100 text-green-700 text-xs font-semibold hover:bg-green-200 transition">Mark Refunded</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $request->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">No return/refund records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-seller-layout>
