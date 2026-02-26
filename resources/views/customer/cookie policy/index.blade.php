@extends('layouts.app')

@section('title', 'Cookie Policy')

@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Legal</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Cookie Policy</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Last updated: January 1, 2025</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-4xl mx-auto">
    <div class="bg-[#1c1e38] border border-orange-500/20 rounded-2xl p-6 mb-10 flex gap-4">
        <div class="text-2xl">🍪</div>
        <div>
            <h3 class="text-white font-semibold mb-1">What are cookies?</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Cookies are small text files stored on your device when you visit a website. They help us remember your preferences and improve your experience on Local Works.</p>
        </div>
    </div>

    {{-- COOKIE TYPES TABLE --}}
    <h2 class="text-lg font-semibold text-white mb-4">Types of Cookies We Use</h2>
    <div class="bg-[#1c1e38] border border-white/5 rounded-2xl overflow-hidden mb-10">

        <div class="grid grid-cols-3 bg-orange-500/8 border-b border-white/5 px-6 py-3">
            <span class="text-xs font-semibold text-orange-400 uppercase tracking-widest">Type</span>
            <span class="text-xs font-semibold text-orange-400 uppercase tracking-widest">Purpose</span>
            <span class="text-xs font-semibold text-orange-400 uppercase tracking-widest">Duration</span>
        </div>

        @foreach ([
            ['Essential',     'Required for the website to function. Cannot be disabled.',                           'Session',   'green'],
            ['Functional',    'Remember your preferences such as language and login status.',                        '1 year',    'blue'],
            ['Analytics',     'Help us understand how visitors interact with our website.',                          '2 years',   'purple'],
            ['Marketing',     'Used to deliver relevant advertisements and track campaign effectiveness.',           '90 days',   'orange'],
        ] as $row)
        <div class="grid grid-cols-3 border-b border-white/5 last:border-0 items-center">
            <div class="px-6 py-4">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $row[3] === 'green'  ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                    {{ $row[3] === 'blue'   ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                    {{ $row[3] === 'purple' ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : '' }}
                    {{ $row[3] === 'orange' ? 'bg-orange-500/10 text-orange-400 border border-orange-500/20' : '' }}">
                    {{ $row[0] }}
                </span>
            </div>
            <div class="px-6 py-4 text-sm text-gray-400">{{ $row[1] }}</div>
            <div class="px-6 py-4 text-sm text-gray-300">{{ $row[2] }}</div>
        </div>
        @endforeach

    </div>

    @foreach ([
        ['1. How We Use Cookies', 'We use cookies to keep you logged in between visits, remember items in your shopping cart, save your language and currency preferences, analyze which pages are most popular, and measure the effectiveness of our marketing campaigns.'],
        ['2. Third-Party Cookies', 'Some cookies on our site are set by third-party services we use, including Google Analytics for website traffic analysis, payment processors (GCash, Maya) for secure transactions, and social media platforms for sharing features. These third parties have their own privacy policies governing the use of their cookies.'],
        ['3. Managing Cookies', 'You can control and manage cookies through your browser settings. Most browsers allow you to view, delete, and block cookies. Please note that disabling essential cookies may prevent certain parts of our website from functioning correctly, such as the shopping cart and login features.'],
        ['4. Browser Cookie Settings', 'To manage cookies, visit your browser\'s settings or help page. For Chrome: Settings → Privacy and Security → Cookies. For Firefox: Options → Privacy & Security → Cookies. For Safari: Preferences → Privacy → Cookies. For Edge: Settings → Cookies and Site Permissions.'],
        ['5. Updates to This Policy', 'We may update this Cookie Policy periodically to reflect changes in our practices or for operational, legal, or regulatory reasons. Please revisit this page regularly to stay informed about our use of cookies.'],
    ] as $i => [$title, $body])
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-3">
            <span class="w-7 h-7 bg-orange-500/15 text-orange-400 rounded-lg flex items-center justify-center text-xs font-bold border border-orange-500/20">{{ $i + 1 }}</span>
            {{ $title }}
        </h2>
        <p class="text-gray-400 text-sm leading-relaxed pl-10">{{ $body }}</p>
    </div>
    @endforeach

    <div class="border-t border-white/5 pt-8 mt-4">
        <p class="text-gray-400 text-sm">Questions about cookies? <a href="{{ route('contact') }}" class="text-orange-400 hover:underline">Contact us</a> at support@localworks.ph</p>
    </div>

</section>

@endsection