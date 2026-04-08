@extends('layouts.admin')

@section('title', 'Platform Payment Methods')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Platform Payment Methods</h1>
            <p class="text-gray-600 text-sm mt-1">For platform fees, commissions, and subscriptions (NOT for product sales)</p>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium shadow-sm">
            + Add Payment Method
        </a>
    </div>

    <!-- Info Banner -->
    <div class="mb-6 rounded-lg bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-semibold mb-1">ℹ️ Important: Payment Method Purpose</p>
                <p class="text-sm">These payment methods are for <strong>platform fees and commissions</strong> only.</p>
                <p class="text-sm mt-1">Buyers pay directly to <strong>sellers' payment methods</strong> for product purchases.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Account Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Account Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($paymentMethods as $method)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $method->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ strtoupper($method->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $method->account_name }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $method->account_number }}</td>
                        <td class="px-6 py-4">
                            @if($method->is_active)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm font-medium transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.payment-methods.destroy', $method) }}" onsubmit="return confirm('Delete this payment method?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <p class="text-gray-600 font-medium">No payment methods found.</p>
                                <p class="text-gray-500 text-sm mt-1">Add your first payment method to start collecting platform fees.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
