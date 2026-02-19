<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Returns & Refunds</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Manage return requests and refunds</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-cog mr-2"></i>Return Settings
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Returns Content -->
    <main class="p-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Total Returns Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-undo text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>3.1%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Returns</h3>
                <p class="text-3xl font-bold text-gray-900">45</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

            <!-- Pending Requests Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>2
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pending</h3>
                <p class="text-3xl font-bold text-gray-900">12</p>
                <p class="text-gray-400 text-xs mt-2">Awaiting review</p>
            </div>

            <!-- Approved Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>8%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Approved</h3>
                <p class="text-3xl font-bold text-gray-900">28</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

            <!-- Refund Amount Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>$1,240
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Refunded</h3>
                <p class="text-3xl font-bold text-gray-900">$8,450</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            
            <!-- Returns Trend Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Returns Trend</h3>
                        <p class="text-sm text-gray-500 mt-1">Return requests over time</p>
                    </div>
                </div>
                <canvas id="returnsChart" height="200"></canvas>
            </div>

            <!-- Return Reasons Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Return Reasons</h3>
                        <p class="text-sm text-gray-500 mt-1">Why customers return items</p>
                    </div>
                </div>
                <canvas id="reasonsChart" height="200"></canvas>
            </div>

        </div>

        <!-- Return Requests Table -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Return Requests</h3>
                        <p class="text-sm text-gray-500 mt-1">Pending and recent return requests</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Return ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#RET-128</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4515</td>
                            <td class="px-6 py-4 text-sm text-gray-700">iPhone 15 Case</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Defective</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$29</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 16, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#RET-127</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4502</td>
                            <td class="px-6 py-4 text-sm text-gray-700">AirPods Max</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Wrong Item</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$549</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 15, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#RET-126</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4498</td>
                            <td class="px-6 py-4 text-sm text-gray-700">MacBook Charger</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Not as Described</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$79</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 14, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#RET-125</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4485</td>
                            <td class="px-6 py-4 text-sm text-gray-700">iPad Screen Protector</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Changed Mind</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$19</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Rejected
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
    // Returns Trend Chart
    const returnsCtx = document.getElementById('returnsChart').getContext('2d');
    const returnsGradient = returnsCtx.createLinearGradient(0, 0, 0, 300);
    returnsGradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
    returnsGradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

    new Chart(returnsCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Returns',
                data: [8, 12, 10, 15],
                borderColor: '#ef4444',
                backgroundColor: returnsGradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4
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
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Return Reasons Chart
    const reasonsCtx = document.getElementById('reasonsChart').getContext('2d');
    new Chart(reasonsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Defective', 'Wrong Item', 'Not as Described', 'Changed Mind', 'Other'],
            datasets: [{
                data: [15, 8, 12, 7, 3],
                backgroundColor: ['#ef4444', '#f97316', '#eab308', '#10b981', '#6b7280'],
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
