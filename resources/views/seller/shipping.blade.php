<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Shipping</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Track and manage your shipments</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-plus mr-2"></i>Create Shipment
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Shipping Content -->
    <main class="p-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Total Shipments Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>15.3%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Shipments</h3>
                <p class="text-3xl font-bold text-gray-900">312</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

            <!-- In Transit Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-truck-moving text-purple-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">In Transit</h3>
                <p class="text-3xl font-bold text-gray-900">68</p>
                <p class="text-gray-400 text-xs mt-2">On the way</p>
            </div>

            <!-- Delivered Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>12%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Delivered</h3>
                <p class="text-3xl font-bold text-gray-900">228</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

            <!-- Failed Delivery Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-down mr-1"></i>2
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Failed Delivery</h3>
                <p class="text-3xl font-bold text-gray-900">16</p>
                <p class="text-gray-400 text-xs mt-2">Need attention</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            
            <!-- Shipping Performance Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Shipping Performance</h3>
                        <p class="text-sm text-gray-500 mt-1">Shipments over time</p>
                    </div>
                </div>
                <canvas id="shippingChart" height="200"></canvas>
            </div>

            <!-- Delivery Time Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Average Delivery Time</h3>
                        <p class="text-sm text-gray-500 mt-1">By shipping method</p>
                    </div>
                </div>
                <canvas id="deliveryTimeChart" height="200"></canvas>
            </div>

        </div>

        <!-- Active Shipments Table -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Active Shipments</h3>
                        <p class="text-sm text-gray-500 mt-1">Currently in transit</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Carrier</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Destination</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ETA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">1Z999AA10123456784</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4521</td>
                            <td class="px-6 py-4 text-sm text-gray-700">UPS</td>
                            <td class="px-6 py-4 text-sm text-gray-700">New York, NY</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    In Transit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 18, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">1Z999AA10123456785</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4520</td>
                            <td class="px-6 py-4 text-sm text-gray-700">FedEx</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Los Angeles, CA</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                    Out for Delivery
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 17, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">1Z999AA10123456786</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4519</td>
                            <td class="px-6 py-4 text-sm text-gray-700">USPS</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Chicago, IL</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Processing
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 19, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">1Z999AA10123456787</td>
                            <td class="px-6 py-4 text-sm text-gray-700">#ORD-4518</td>
                            <td class="px-6 py-4 text-sm text-gray-700">DHL</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Miami, FL</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    In Transit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 20, 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
    // Shipping Performance Chart
    const shippingCtx = document.getElementById('shippingChart').getContext('2d');
    const shippingGradient = shippingCtx.createLinearGradient(0, 0, 0, 300);
    shippingGradient.addColorStop(0, 'rgba(139, 92, 246, 0.3)');
    shippingGradient.addColorStop(1, 'rgba(139, 92, 246, 0)');

    new Chart(shippingCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Shipments',
                data: [68, 82, 75, 87],
                borderColor: '#8b5cf6',
                backgroundColor: shippingGradient,
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

    // Delivery Time Chart
    const deliveryCtx = document.getElementById('deliveryTimeChart').getContext('2d');
    new Chart(deliveryCtx, {
        type: 'bar',
        data: {
            labels: ['Standard', 'Express', 'Overnight', '2-Day'],
            datasets: [{
                label: 'Avg. Days',
                data: [5, 3, 1, 2],
                backgroundColor: ['#6b7280', '#3b82f6', '#10b981', '#f59e0b'],
                borderRadius: 6
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
                            return value + ' days';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    </script>
</x-seller-layout>
