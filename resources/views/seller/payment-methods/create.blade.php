@extends('layouts.sellersidebar')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Add Payment Method</h1>
        <p class="text-gray-400 text-sm mt-1">Add where you want to receive payments</p>
    </div>

    <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-6 max-w-2xl">
        <form method="POST" action="{{ route('seller.payment-methods.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Payment Type *</label>
                <select name="method_type" id="method_type" class="w-full rounded-lg bg-[#12132a] border border-white/20 text-white px-4 py-2" required>
                    <option value="">Select Type</option>
                    <option value="gcash" {{ old('method_type') == 'gcash' ? 'selected' : '' }}>GCash</option>
                    <option value="paymaya" {{ old('method_type') == 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                    <option value="bank" {{ old('method_type') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                </select>
                @error('method_type')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="bank_name_field" style="display: none;">
                <label class="block text-sm font-medium text-gray-300 mb-2">Bank Name</label>
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g., BDO, BPI, Metrobank" class="w-full rounded-lg bg-[#12132a] border border-white/20 text-white px-4 py-2">
                @error('bank_name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Account Name *</label>
                <input type="text" name="account_name" value="{{ old('account_name') }}" placeholder="Your full name as registered" class="w-full rounded-lg bg-[#12132a] border border-white/20 text-white px-4 py-2" required>
                @error('account_name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Account Number *</label>
                <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="Mobile number or account number" class="w-full rounded-lg bg-[#12132a] border border-white/20 text-white px-4 py-2" required>
                <p class="text-xs text-gray-400 mt-1">For GCash/PayMaya: 09XXXXXXXXX | For Bank: Account number</p>
                @error('account_number')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Instructions (Optional)</label>
                <textarea name="instructions" rows="3" class="w-full rounded-lg bg-[#12132a] border border-white/20 text-white px-4 py-2" placeholder="Additional instructions for buyers">{{ old('instructions') }}</textarea>
                @error('instructions')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="text-sm text-gray-300">Active</span>
                </label>
                
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_primary" value="1" class="rounded" {{ old('is_primary') ? 'checked' : '' }}>
                    <span class="text-sm text-gray-300">Set as Primary</span>
                </label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-lg">
                    Add Payment Method
                </button>
                <a href="{{ route('seller.payment-methods.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('method_type').addEventListener('change', function() {
    const bankField = document.getElementById('bank_name_field');
    if (this.value === 'bank') {
        bankField.style.display = 'block';
    } else {
        bankField.style.display = 'none';
    }
});

// Trigger on page load if bank is selected
if (document.getElementById('method_type').value === 'bank') {
    document.getElementById('bank_name_field').style.display = 'block';
}
</script>
@endsection
