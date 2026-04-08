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
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-600/20 border border-red-500/50 px-4 py-3 text-red-200">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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

            <form method="POST" action="{{ route('buyer.cart.checkout') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="text-sm text-gray-300">Shipping Address *</label>
                    <textarea name="shipping_address" rows="3" class="w-full mt-1 rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2" required>{{ old('shipping_address') }}</textarea>
                </div>
                <div>
                    <label class="text-sm text-gray-300">Notes (optional)</label>
                    <textarea name="notes" rows="2" class="w-full mt-1 rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2">{{ old('notes') }}</textarea>
                </div>
                
                <div>
                    <label class="text-sm text-gray-300 mb-2 block">Payment Method *</label>
                    <div class="space-y-2" id="payment-methods">
                        @forelse($paymentMethods as $method)
                            <label class="flex items-start gap-3 p-3 rounded-lg bg-[#12132a] border border-white/20 cursor-pointer hover:border-orange-400 transition payment-method-option">
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="mt-1" required data-account-name="{{ $method->account_name }}" data-account-number="{{ $method->account_number }}" data-instructions="{{ $method->instructions }}">
                                <div class="flex-1">
                                    <div class="font-semibold">{{ $method->name }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $method->type }}</div>
                                </div>
                            </label>
                        @empty
                            <p class="text-gray-400 text-sm">No payment methods available</p>
                        @endforelse
                    </div>
                </div>

                <div id="payment-details" class="hidden">
                    <div class="bg-[#12132a] border border-orange-400/50 rounded-lg p-4 space-y-2">
                        <h3 class="font-semibold text-orange-400">Payment Instructions</h3>
                        <p class="text-sm text-gray-300" id="payment-instructions"></p>
                        <div class="mt-3 space-y-1">
                            <p class="text-sm"><span class="text-gray-400">Account Name:</span> <span class="font-semibold" id="account-name"></span></p>
                            <p class="text-sm"><span class="text-gray-400">Account Number:</span> <span class="font-semibold" id="account-number"></span></p>
                            <p class="text-sm"><span class="text-gray-400">Amount to Pay:</span> <span class="font-semibold text-orange-400">₱{{ number_format($total, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-300">Upload Payment Proof *</label>
                    <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/jpg" class="w-full mt-1 rounded-lg bg-[#12132a] border border-white/20 text-white px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-orange-500 file:text-white file:cursor-pointer hover:file:bg-orange-400" required>
                    <p class="text-xs text-gray-400 mt-1">Upload screenshot or photo of payment (JPG, PNG, max 2MB)</p>
                </div>

                <button type="submit" class="w-full px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-400 font-semibold disabled:opacity-50" @disabled($cartItems->isEmpty())>
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodOptions = document.querySelectorAll('input[name="payment_method_id"]');
    const paymentDetails = document.getElementById('payment-details');
    const paymentInstructions = document.getElementById('payment-instructions');
    const accountName = document.getElementById('account-name');
    const accountNumber = document.getElementById('account-number');

    paymentMethodOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.checked) {
                paymentDetails.classList.remove('hidden');
                paymentInstructions.textContent = this.dataset.instructions;
                accountName.textContent = this.dataset.accountName;
                accountNumber.textContent = this.dataset.accountNumber;
            }
        });
    });
});
</script>
@endsection
