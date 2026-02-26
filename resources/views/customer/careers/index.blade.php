@extends('layouts.app')
@section('title', 'Careers')
@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Careers</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Join our team &<br>make a difference</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Help us empower Filipino artisans. We're looking for passionate people who believe in the power of local communities.</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-5xl mx-auto">

    {{-- PERKS --}}
    <h2 class="text-lg font-semibold text-white mb-1">Why work at Local Works?</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-14">
        @foreach ([
            ['🏠', 'Remote First',      'Work from anywhere in the Philippines.'],
            ['📚', 'Learning Budget',   '₱20,000 annual learning & development budget.'],
            ['🏥', 'Health Coverage',   'HMO coverage for you and one dependent.'],
            ['🎉', 'Team Events',       'Quarterly team retreats and monthly socials.'],
        ] as $p)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-6 text-center hover:border-orange-500/30 transition">
            <div class="text-3xl mb-3">{{ $p[0] }}</div>
            <h4 class="text-white font-semibold text-sm mb-1">{{ $p[1] }}</h4>
            <p class="text-gray-400 text-xs leading-relaxed">{{ $p[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- OPEN ROLES --}}
    <h2 class="text-lg font-semibold text-white mb-1">Open Positions</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="space-y-4 mb-14">
        @foreach ([
            ['Full Stack Developer',         'Engineering',  'Remote', 'Full-time'],
            ['Product Designer (UI/UX)',      'Design',       'Remote', 'Full-time'],
            ['Seller Growth Manager',         'Operations',   'Manila', 'Full-time'],
            ['Social Media Content Creator',  'Marketing',    'Remote', 'Part-time'],
            ['Customer Support Specialist',   'Support',      'Manila', 'Full-time'],
        ] as $job)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-orange-500/30 transition group cursor-pointer">
            <div>
                <h3 class="text-white font-semibold group-hover:text-orange-400 transition">{{ $job[0] }}</h3>
                <div class="flex gap-2 mt-2 flex-wrap">
                    <span class="text-xs px-2.5 py-1 rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20">{{ $job[1] }}</span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ $job[2] }}</span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/20">{{ $job[3] }}</span>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="shrink-0 bg-orange-500 hover:bg-orange-400 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
                Apply Now
            </a>
        </div>
        @endforeach
    </div>

    {{-- NO ROLE --}}
    <div class="bg-gradient-to-r from-orange-500/20 to-orange-600/10 border border-orange-500/25 rounded-2xl p-10 text-center">
        <div class="text-4xl mb-4">📩</div>
        <h3 class="text-white font-bold text-xl mb-3">Don't see a role that fits?</h3>
        <p class="text-gray-400 text-sm mb-6 max-w-md mx-auto">We're always looking for talented people. Send us your CV and tell us how you'd like to contribute to Local Works.</p>
        <a href="{{ route('contact') }}" class="inline-block bg-orange-500 hover:bg-orange-400 text-white font-semibold px-8 py-3 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/30">
            Send Open Application
        </a>
    </div>

</section>
@endsection