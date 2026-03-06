@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 text-white">
    <h1 class="text-3xl font-bold mb-6">My Cart</h1>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500/50 px-4 py-3 text-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-600/20 border border-red-500/50 px-4 py-3 text-red-200">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            @forelse($cartItems as $item)
                <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-4 flex gap-4">
                    <div class="w-20 h-20 bg-[#12132a] rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $item->product?->imageUrl() ?? asset('images/no-image.png') }}" alt="{{ $item->product?->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">{{ $item->product?->name ?? 'Deleted product' }}</p>
                        <p class="text-sm text-gray-400">{{ $item->product?->category?->name ?? 'Uncategorized' }}</p>
                        <p class="text-orange-400 font-bold mt-1">₱{{ number_format((float)($item->product?->price ?? 0), 2) }}</p>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <form method="POST" action="{{ route('buyer.cart.update', $item) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" class="w-20 rounded-lg bg-[#12132a] border border-white/20 text-white px-2 py-1">
                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-500 text-sm">Update</button>
                        </form>
                        <form method="POST" action="{{ route('buyer.cart.remove', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-500 text-sm">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-8 text-center text-gray-300">
                    Your cart is empty.
                </div>
            @endforelse
        </div>

        <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-5 h-fit">
            <h2 class="text-xl font-semibold mb-4">Checkout</h2>
            <div class="flex justify-between text-gray-300 mb-2">
                <span>Subtotal</span>
                <span>₱{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold mb-4">
                <span>Total</span>
                <span class="text-orange-400">₱{{ number_format($total, 2) }}</span>
            </div>

            <form method="POST" action="{{ route('buyer.cart.checkout') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-sm text-gray-300">Shipping Address</label>
                    <textarea name="shipping_address" rows="3" class="w-full mt-1 rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2" required>{{ old('shipping_address') }}</textarea>
                </div>
                <div>
                    <label class="text-sm text-gray-300">Notes (optional)</label>
                    <textarea name="notes" rows="2" class="w-full mt-1 rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="w-full px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-400 font-semibold disabled:opacity-50" @disabled($cartItems->isEmpty())>
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
