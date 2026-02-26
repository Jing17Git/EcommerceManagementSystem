@extends('layouts.app')

@section('title', 'Track Order')

@section('content')

{{-- HERO --}}
<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">
        Track Order
    </span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Where's<br>my order?</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">
        Enter your order number below to get real-time updates on your delivery status.
    </p>
</section>

<section class="px-6 md:px-14 py-12">

    {{-- SEARCH BOX --}}
    <div class="max-w-lg mx-auto bg-[#1c1e38] border border-white/5 rounded-2xl p-10 text-center mb-12">
        <div class="text-5xl mb-5">📦</div>
        <h3 class="text-white font-bold text-xl mb-2">Track your package</h3>
        <p class="text-gray-400 text-sm mb-7">Enter your order ID or tracking number to see the latest delivery status.</p>

        <form method="GET" action="{{ route('track.order') }}" class="flex gap-3">
            <input
                type="text"
                name="order_id"
                value="{{ request('order_id') }}"
                placeholder="e.g. LW-2024-00183"
                class="flex-1 bg-[#12132a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500/50 transition">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-400 text-white font-semibold text-sm px-6 py-3 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/30">
                Track
            </button>
        </form>
    </div>

    {{-- RESULT --}}
    @if(request('order_id'))
    <div class="max-w-lg mx-auto">

        {{-- swap this block with a real DB lookup later --}}
        @php
            $found = request('order_id') === 'LW-2024-00183';
        @endphp

        @if($found)
            <h2 class="text-lg font-semibold text-white mb-1">Order #{{ request('order_id') }}</h2>
            <div class="w-9 h-0.5 bg-orange-500 rounded mb-5"></div>

            <div class="flex gap-3 items-center mb-8 flex-wrap">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20">
                    In Transit
                </span>
                <span class="text-gray-400 text-sm">J&T Express · JT1230045817PH</span>
            </div>

            {{-- TIMELINE --}}
            <div class="space-y-6">
                @foreach ([
                    ['done',    'Order Placed',             'Feb 20, 2025 · 10:24 AM'],
                    ['done',    'Payment Confirmed',         'Feb 20, 2025 · 10:31 AM'],
                    ['done',    'Order Packed & Dispatched', 'Feb 21, 2025 · 2:15 PM · Manila Hub'],
                    ['current', 'Out for Delivery',          'Feb 23, 2025 · 8:47 AM · Rider assigned'],
                    ['pending', 'Delivered',                 'Expected today by 7:00 PM'],
                ] as $tl)
                <div class="flex gap-4 items-start">
                    <div class="mt-1 shrink-0">
                        @if($tl[0] === 'done')
                            <div class="w-3.5 h-3.5 rounded-full bg-green-400"></div>
                        @elseif($tl[0] === 'current')
                            <div class="w-3.5 h-3.5 rounded-full bg-orange-500 ring-4 ring-orange-500/20 animate-pulse"></div>
                        @else
                            <div class="w-3.5 h-3.5 rounded-full bg-white/15"></div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold
                            {{ $tl[0] === 'current' ? 'text-orange-400' : ($tl[0] === 'done' ? 'text-white' : 'text-gray-500') }}">
                            {{ $tl[1] }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $tl[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        @else
            <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-8 text-center">
                <div class="text-4xl mb-4">🔍</div>
                <h3 class="text-white font-semibold mb-2">Order not found</h3>
                <p class="text-gray-400 text-sm">We couldn't find an order matching <span class="text-orange-400 font-medium">{{ request('order_id') }}</span>. Please double-check your order number or <a href="{{ route('contact') }}" class="text-orange-400 underline underline-offset-2">contact support</a>.</p>
            </div>
        @endif
    </div>
    @endif

    {{-- HELP CARDS --}}
    <div class="max-w-lg mx-auto mt-12">
        <div class="h-px bg-white/5 mb-10"></div>
        <h2 class="text-lg font-semibold text-white mb-1">Need help with your order?</h2>
        <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('contact') }}"
               class="bg-[#1c1e38] border border-white/5 rounded-2xl p-6 hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200">
                <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg mb-4">💬</div>
                <h3 class="text-white font-semibold text-sm mb-1">Contact Support</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Can't find your tracking info? Our team can look it up.</p>
            </a>
            <a href="{{ route('shipping.info') }}"
               class="bg-[#1c1e38] border border-white/5 rounded-2xl p-6 hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200">
                <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg mb-4">🚚</div>
                <h3 class="text-white font-semibold text-sm mb-1">Shipping Info</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Review estimated delivery windows and carrier info.</p>
            </a>
        </div>
    </div>

</section>

@endsection