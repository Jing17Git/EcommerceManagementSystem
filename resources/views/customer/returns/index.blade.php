@extends('layouts.app')

@section('title', 'Returns & Refunds')

@section('content')

{{-- HERO --}}
<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">
        Returns & Refunds
    </span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Easy Returns,<br>Hassle-Free</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">
        We stand behind every product we sell. If something isn't right, we'll make it right.
    </p>
</section>

<section class="px-6 md:px-14 py-12">

    {{-- POLICY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-14">
        @foreach ([
            ['📦', '7-Day Return Window',  'Return eligible items within 7 days of receiving your order, no questions asked.'],
            ['💰', 'Full Refunds',         'Receive a full refund to your original payment method or opt for store credit.'],
            ['🔄', 'Free Item Swap',       'Exchange damaged or incorrect items at no additional cost to you.'],
        ] as $card)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">{{ $card[0] }}</div>
            <h3 class="text-white font-semibold mb-2">{{ $card[1] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed">{{ $card[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- FAQ ACCORDION --}}
    <h2 class="text-lg font-semibold text-white mb-1">Return Eligibility</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>

    <div class="space-y-3 mb-14" x-data="{ open: null }">
        @foreach ([
            ['✅ What can be returned?',
             'Items that are unused, in their original packaging with tags still attached can be returned within 7 days of delivery. Defective, damaged upon arrival, or incorrect items are always eligible.'],
            ['❌ What cannot be returned?',
             'Perishable goods, personal care/hygiene products, custom or personalized orders, and items marked as "Final Sale" are not eligible. Gift cards are also non-refundable.'],
            ['How long does a refund take?',
             'Once we receive and inspect your return, we\'ll process the refund within 3–5 business days. GCash and Maya refunds are typically faster (1–2 days). Credit card refunds may take 5–10 business days.'],
            ['Who pays for return shipping?',
             'If the return is due to our error (wrong item, defect), we cover all return shipping costs. For change-of-mind returns, a ₱80 return shipping fee will be deducted from your refund.'],
        ] as $i => $faq)
        <div class="bg-[#1c1e38] border border-white/5 rounded-xl overflow-hidden">
            <button
                class="w-full flex justify-between items-center px-6 py-5 text-left text-sm font-medium transition hover:bg-orange-500/5"
                :class="open === {{ $i }} ? 'text-orange-400' : 'text-white'"
                @click="open = open === {{ $i }} ? null : {{ $i }}">
                <span>{{ $faq[0] }}</span>
                <svg class="w-4 h-4 shrink-0 ml-4 text-gray-400 transition-transform duration-300"
                     :class="open === {{ $i }} ? 'rotate-180 text-orange-400' : ''"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open === {{ $i }}"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-cloak>
                <p class="px-6 pb-5 text-sm text-gray-400 leading-relaxed">{{ $faq[1] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- STEPS --}}
    <h2 class="text-lg font-semibold text-white mb-1">How to Start a Return</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-8"></div>

    <div class="relative">
        <div class="absolute left-[18px] top-10 bottom-10 w-0.5 bg-orange-500/15 rounded"></div>

        @foreach ([
            ['1', 'Contact Support',       'Email us at support@localworks.ph or use the Contact Us form with your order number and reason for return.'],
            ['2', 'Receive Return Label',  'We\'ll send you a prepaid return shipping label (for eligible cases) within 24 hours of your request.'],
            ['3', 'Pack & Ship',           'Pack the item securely in its original packaging, attach the label, and drop it off at the nearest courier branch.'],
            ['4', 'Refund Processed',      'Once we receive and inspect the item, your refund will be credited within 3–5 business days.'],
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

</section>

@endsection