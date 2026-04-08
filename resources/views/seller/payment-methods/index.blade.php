@extends('layouts.sellersidebar')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">My Payment Methods</h1>
            <p class="text-gray-400 text-sm mt-1">Manage where you receive payments from buyers</p>
        </div>
        <a href="{{ route('seller.payment-methods.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-lg">
            + Add Payment Method
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500/50 px-4 py-3 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($paymentMethods->isEmpty())
        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-8 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <h3 class="text-lg font-semibold text-white mb-2">No Payment Methods Yet</h3>
                <p class="text-sm mb-4">Add your GCash, PayMaya, or Bank account to receive payments</p>
                <a href="{{ route('seller.payment-methods.create') }}" class="inline-block px-6 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-lg">
                    Add Your First Payment Method
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($paymentMethods as $method)
                <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5 relative">
                    @if($method->is_primary)
                        <span class="absolute top-3 right-3 px-2 py-1 text-xs rounded bg-orange-500/20 text-orange-300 border border-orange-500/50">
                            Primary
                        </span>
                    @endif
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                            @if($method->method_type === 'gcash')
                                <span class="text-2xl">💳</span>
                            @elseif($method->method_type === 'paymaya')
                                <span class="text-2xl">💰</span>
                            @else
                                <span class="text-2xl">🏦</span>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                {{ ucfirst($method->method_type) }}
                                @if($method->bank_name)
                                    - {{ $method->bank_name }}
                                @endif
                            </h3>
                            <p class="text-gray-400 text-sm mt-1">{{ $method->account_name }}</p>
                            <p class="text-gray-300 text-sm font-mono mt-1">{{ $method->account_number }}</p>
                            
                            <div class="flex items-center gap-2 mt-3">
                                @if($method->is_active)
                                    <span class="px-2 py-1 text-xs rounded bg-green-600/20 text-green-300">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-600/20 text-gray-300">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 mt-4 pt-4 border-t border-white/10">
                        <a href="{{ route('seller.payment-methods.edit', $method) }}" class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded text-sm text-center">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('seller.payment-methods.destroy', $method) }}" onsubmit="return confirm('Delete this payment method?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-600 hover:bg-red-500 text-white rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
