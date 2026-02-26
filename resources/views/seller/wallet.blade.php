<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Wallet / Payments</h1>
            <p class="text-sm text-gray-500 mt-1">Live payment summary based on your seller orders</p>
        </div>
    </header>

    <main class="p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Available Balance</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($walletStats['availableBalance'], 2) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($walletStats['thisMonthEarnings'], 2) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-amber-600">${{ number_format($walletStats['pendingAmount'], 2) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Refunded</p>
                <p class="text-2xl font-bold text-red-600">${{ number_format($walletStats['refundedAmount'], 2) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Total Earnings</p>
                <p class="text-2xl font-bold text-blue-600">${{ number_format($walletStats['totalEarnings'], 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                <p class="text-sm text-gray-500">Latest payment and refund activity</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Transaction</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentTransactions as $transaction)
                            @php
                                $statusClass = match($transaction['status']) {
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-indigo-100 text-indigo-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-amber-100 text-amber-700',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $transaction['id'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction['type'] }}</td>
                                <td class="px-4 py-3 text-sm font-semibold {{ $transaction['type'] === 'Refund' ? 'text-red-700' : 'text-gray-900' }}">
                                    {{ $transaction['type'] === 'Refund' ? '-' : '+' }}${{ number_format($transaction['amount'], 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($transaction['status']) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $transaction['date']->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No transactions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-seller-layout>
