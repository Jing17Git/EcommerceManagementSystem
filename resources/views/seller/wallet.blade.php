<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Wallet & Payments</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Manage your earnings and withdrawals</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-money-bill-wave mr-2"></i>Request Withdrawal
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Wallet Content -->
    <main class="p-8">
        
        <!-- Wallet Card -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-8 mb-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-1">Available Balance</p>
                    <p class="text-4xl font-bold mb-4">$12,847.00</p>
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <p class="text-gray-400 text-xs mb-1">This Month</p>
                            <p class="text-xl font-semibold">$45,231</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Pending</p>
                            <p class="text-xl font-semibold">$2,184</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Total Withdrawn</p>
                            <p class="text-xl font-semibold">$127,500</p>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-gray-400 text-sm mb-2">Store ID</div>
                    <div class="text-2xl font-bold">#SLR-00234</div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Earnings Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>12.5%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Earnings</h3>
                <p class="text-3xl font-bold text-gray-900">$185,031</p>
                <p class="text-gray-400 text-xs mt-2">All time</p>
            </div>

            <!-- This Month Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>8.2%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">This Month</h3>
                <p class="text-3xl font-bold text-gray-900">$45,231</p>
                <p class="text-gray-400 text-xs mt-2">February 2026</p>
            </div>

            <!-- Pending Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pending</h3>
                <p class="text-3xl font-bold text-gray-900">$2,184</p>
                <p class="text-gray-400 text-xs mt-2">Processing</p>
            </div>

            <!-- Withdrawn Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-up text-purple-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Withdrawn</h3>
                <p class="text-3xl font-bold text-gray-900">$127,500</p>
                <p class="text-gray-400 text-xs mt-2">All time</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            
            <!-- Earnings Trend Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Earnings Trend</h3>
                        <p class="text-sm text-gray-500 mt-1">Monthly earnings overview</p>
                    </div>
                </div>
                <canvas id="earningsChart" height="200"></canvas>
            </div>

            <!-- Transactions by Type -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Transactions</h3>
                        <p class="text-sm text-gray-500 mt-1">Breakdown by type</p>
                    </div>
                </div>
                <canvas id="transactionsChart" height="200"></canvas>
            </div>

        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                        <p class="text-sm text-gray-500 mt-1">Your latest payment activity</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">TXN-88421</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-arrow-down text-green-600"></i> Order Payment
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,199</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 16, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">TXN-88420</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-arrow-up text-blue-600"></i> Withdrawal
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">-$5,000</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 15, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">TXN-88419</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-arrow-down text-green-600"></i> Order Payment
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$249</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 14, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">TXN-88418</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-arrow-down text-green-600"></i> Order Payment
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,499</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 13, 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
    // Earnings Trend Chart
    const earningsCtx = document.getElementById('earningsChart').getContext('2d');
    const earningsGradient = earningsCtx.createLinearGradient(0, 0, 0, 300);
    earningsGradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    earningsGradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(earningsCtx, {
        type: 'bar',
        data: {
            labels: ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb'],
            datasets: [{
                label: 'Earnings',
                data: [28500, 32100, 35800, 41200, 45800, 45231],
                backgroundColor: earningsGradient,
                borderColor: '#10b981',
                borderWidth: 2,
                borderRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        callback: function(value) {
                            return '$' + (value / 1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Transactions by Type Chart
    const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
    new Chart(transactionsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Order Payments', 'Refunds', 'Withdrawals', 'Fees'],
            datasets: [{
                data: [45800, 2300, 35000, 1200],
                backgroundColor: ['#10b981', '#ef4444', '#3b82f6', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            }
        }
    });
    </script>
</x-seller-layout>
