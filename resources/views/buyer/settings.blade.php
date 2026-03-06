@extends('layouts.app')

@section('title', 'Buyer Settings')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 text-white">
    <h1 class="text-3xl font-bold mb-6">Buyer Settings</h1>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500/50 px-4 py-3 text-green-200">{{ session('success') }}</div>
    @endif

    <div class="bg-[#1c1e38] border border-white/10 rounded-xl p-6">
        <p class="text-gray-300">Manage buyer-specific settings from your profile page for now.</p>
        <a href="{{ route('profile.edit') }}" class="inline-block mt-4 px-4 py-2 rounded bg-orange-500 hover:bg-orange-400 font-semibold">
            Open Profile Settings
        </a>
    </div>
</div>
@endsection
