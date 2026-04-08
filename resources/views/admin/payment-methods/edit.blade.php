@extends('layouts.admin')

@section('title', 'Edit Payment Method')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Payment Method</h1>
        <p class="text-gray-600 text-sm mt-1">Update platform payment method details</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6 max-w-2xl shadow-sm">
        <form method="POST" action="{{ route('admin.payment-methods.update', $paymentMethod) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" placeholder="e.g., GCash - Main Account" class="w-full rounded-lg border border-gray-300 text-gray-900 px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                <select name="type" class="w-full rounded-lg border border-gray-300 text-gray-900 px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <option value="">Select Type</option>
                    <option value="gcash" {{ old('type', $paymentMethod->type) == 'gcash' ? 'selected' : '' }}>GCash</option>
                    <option value="paymaya" {{ old('type', $paymentMethod->type) == 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                    <option value="bank" {{ old('type', $paymentMethod->type) == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                </select>
                @error('type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Account Name *</label>
                <input type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}" placeholder="Your full name" class="w-full rounded-lg border border-gray-300 text-gray-900 px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                @error('account_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Account Number *</label>
                <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" placeholder="09XXXXXXXXX or account number" class="w-full rounded-lg border border-gray-300 text-gray-900 px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                @error('account_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Instructions</label>
                <textarea name="instructions" rows="4" placeholder="Payment instructions for sellers..." class="w-full rounded-lg border border-gray-300 text-gray-900 px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                @error('instructions')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium shadow-sm transition">
                    Update Payment Method
                </button>
                <a href="{{ route('admin.payment-methods.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
