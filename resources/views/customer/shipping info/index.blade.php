@extends('layouts.app')

@section('title', 'Shipping Info')

@section('content')

{{-- HERO --}}
<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">
        Shipping Info
    </span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Delivery &<br>Shipping Details</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">
        Learn about our delivery options, estimated timelines, and shipping rates across the Philippines.
    </p>
</section>

<section class="px-6 md:px-14 py-12">

    {{-- RATES TABLE --}}
    <h2 class="text-lg font-semibold text-white mb-1">Shipping Rates & Timelines</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>

    <div class="bg-[#1c1e38] border border-white/5 rounded-2xl overflow-hidden mb-14">

        <div class="grid grid-cols-2 bg-orange-500/8 border-b border-white/5 px-6 py-3">
            <span class="text-xs font-semibold text-orange-400 uppercase tracking-widest">Location</span>
            <span class="text-xs font-semibold text-orange-400 uppercase tracking-widest">Estimated Delivery & Rate</span>
        </div>

        @foreach ([
            ['Metro Manila',        '1–3 business days', '₱80 flat rate',   'green'],
            ['Luzon (Provincial)',  '3–5 business days', '₱120–₱160',       'orange'],
            ['Visayas',             '4–6 business days', '₱150–₱200',       'orange'],
            ['Mindanao',            '5–7 business days', '₱160–₱220',       'orange'],
            ['Free Shipping',       'All qualifying orders', 'Orders above ₱1,500', 'green'],
        ] as $row)
        <div class="grid grid-cols-2 border-b border-white/5 last:border-0">
            <div class="px-6 py-4 text-sm text-gray-300 bg-orange-500/3 border-r border-white/5">{{ $row[0] }}</div>
            <div class="px-6 py-4 text-sm text-white flex items-center gap-3 flex-wrap">
                {{ $row[1] }}
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full
                    {{ $row[3] === 'green'
                        ? 'bg-green-500/10 text-green-400 border border-green-500/20'
                        : 'bg-orange-500/10 text-orange-400 border border-orange-500/20' }}">
                    {{ $row[2] }}
                </span>
            </div>
        </div>
        @endforeach

    </div>

    {{-- STEPS --}}
    <h2 class="text-lg font-semibold text-white mb-1">How We Ship</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-8"></div>

    <div class="relative mb-14">
        {{-- vertical line --}}
        <div class="absolute left-[18px] top-10 bottom-10 w-0.5 bg-orange-500/15 rounded"></div>

        @foreach ([
            ['1', 'Order Confirmation',     'Once your payment is verified, you\'ll receive an email confirmation with your order number within 30 minutes.'],
            ['2', 'Packing & Processing',   'Your items are carefully packed and quality-checked. Processing takes 1–2 business days.'],
            ['3', 'Handover to Courier',    'We work with J&T Express, LBC, and Ninja Van. A tracking number will be sent to your email once dispatched.'],
            ['4', 'Delivery to Your Door',  'Your package arrives within the estimated window. If no one is home, the courier will attempt redelivery the next day.'],
        ] as $step)
        <div class="flex gap-5 mb-8 last:mb-0 relative">
            <div class="w-9 h-9 min-w-9 bg-orange-500/10 border-2 border-orange-500/30 rounded-full flex items-center justify-center text-orange-400 font-bold text-sm z-10">
                {{ $step[0] }}
            </div>
            <div class="pt-1">
                <h4 class="text-white font-semibold text-sm mb-1">{{ $step[1] }}</h4>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $step[2] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- NOTES --}}
    <h2 class="text-lg font-semibold text-white mb-1">Important Notes</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ([
            ['📅', 'Cut-off Time',          'Orders placed before 12:00 PM are processed the same day. After 12PM, they\'re processed the next business day.'],
            ['🏝️', 'Island Deliveries',     'Remote island addresses may require 2–3 extra days and additional fees. We\'ll notify you if this applies.'],
            ['🌧️', 'Delays & Disruptions',  'Delivery may be delayed during typhoons, holidays, or high-volume periods. We appreciate your patience.'],
        ] as $note)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">{{ $note[0] }}</div>
            <h3 class="text-white font-semibold mb-2">{{ $note[1] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed">{{ $note[2] }}</p>
        </div>
        @endforeach
    </div>

</section>

@endsection