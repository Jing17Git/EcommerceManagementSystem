<footer class="bg-[#1a1a2e] mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">{{ \App\Models\PageContent::get('footer', 'company', 'name', 'ShopHub') }}</h1>
                        <p class="text-xs text-gray-400">{{ \App\Models\PageContent::get('footer', 'company', 'tagline', 'Your Trusted Online Shop') }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-300 mb-4">{{ \App\Models\PageContent::get('footer', 'company', 'description', 'Discover quality products from trusted sellers. Every purchase comes with our satisfaction guarantee.') }}</p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">{{ \App\Models\PageContent::get('footer', 'quick_links', 'title', 'Quick Links') }}</h4>
                <ul class="space-y-2">
                    @php
                        $quickLink1Text = \App\Models\PageContent::get('footer', 'quick_links', 'link1_text', 'About Us');
                        $quickLink1Url = \App\Models\PageContent::get('footer', 'quick_links', 'link1_url', '/about');
                        $quickLink2Text = \App\Models\PageContent::get('footer', 'quick_links', 'link2_text', 'Shop Now');
                        $quickLink2Url = \App\Models\PageContent::get('footer', 'quick_links', 'link2_url', '/shop');
                        $quickLink3Text = \App\Models\PageContent::get('footer', 'quick_links', 'link3_text', 'Sell on ShopHub');
                        $quickLink3Url = \App\Models\PageContent::get('footer', 'quick_links', 'link3_url', '/sell');
                    @endphp
                    @if($quickLink1Text)
                        <li><a href="{{ $quickLink1Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $quickLink1Text }}</a></li>
                    @endif
                    @if($quickLink2Text)
                        <li><a href="{{ $quickLink2Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $quickLink2Text }}</a></li>
                    @endif
                    @if($quickLink3Text)
                        <li><a href="{{ $quickLink3Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $quickLink3Text }}</a></li>
                    @endif
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">{{ \App\Models\PageContent::get('footer', 'customer_service', 'title', 'Customer Service') }}</h4>
                <ul class="space-y-2">
                    @php
                        $csLink1Text = \App\Models\PageContent::get('footer', 'customer_service', 'link1_text', 'Help Center');
                        $csLink1Url = \App\Models\PageContent::get('footer', 'customer_service', 'link1_url', '/help-center');
                        $csLink2Text = \App\Models\PageContent::get('footer', 'customer_service', 'link2_text', 'Contact Us');
                        $csLink2Url = \App\Models\PageContent::get('footer', 'customer_service', 'link2_url', '/contact');
                        $csLink3Text = \App\Models\PageContent::get('footer', 'customer_service', 'link3_text', 'Shipping Info');
                        $csLink3Url = \App\Models\PageContent::get('footer', 'customer_service', 'link3_url', '/shipping-info');
                        $csLink4Text = \App\Models\PageContent::get('footer', 'customer_service', 'link4_text', 'Returns & Refunds');
                        $csLink4Url = \App\Models\PageContent::get('footer', 'customer_service', 'link4_url', '/returns');
                        $csLink5Text = \App\Models\PageContent::get('footer', 'customer_service', 'link5_text', 'Track Order');
                        $csLink5Url = \App\Models\PageContent::get('footer', 'customer_service', 'link5_url', '/track-order');
                    @endphp
                    @if($csLink1Text)
                        <li><a href="{{ $csLink1Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $csLink1Text }}</a></li>
                    @endif
                    @if($csLink2Text)
                        <li><a href="{{ $csLink2Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $csLink2Text }}</a></li>
                    @endif
                    @if($csLink3Text)
                        <li><a href="{{ $csLink3Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $csLink3Text }}</a></li>
                    @endif
                    @if($csLink4Text)
                        <li><a href="{{ $csLink4Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $csLink4Text }}</a></li>
                    @endif
                    @if($csLink5Text)
                        <li><a href="{{ $csLink5Url }}" class="text-sm text-gray-300 hover:text-orange-400 transition">{{ $csLink5Text }}</a></li>
                    @endif
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">{{ \App\Models\PageContent::get('footer', 'contact', 'title', 'Contact Us') }}</h4>
                <ul class="space-y-3">
                    @php
                        $address = \App\Models\PageContent::get('footer', 'contact', 'address', 'Philippines');
                        $phone = \App\Models\PageContent::get('footer', 'contact', 'phone', '+63 912 345 6789');
                        $hours = \App\Models\PageContent::get('footer', 'contact', 'hours', 'Mon - Sat: 9AM - 7PM');
                    @endphp
                    @if($address)
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-orange-500 mt-1"></i>
                            <span class="text-sm text-gray-300">{{ $address }}</span>
                        </li>
                    @endif
                    @if($phone)
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-orange-500"></i>
                            <span class="text-sm text-gray-300">{{ $phone }}</span>
                        </li>
                    @endif
                    @if($hours)
                        <li class="flex items-center gap-3">
                            <i class="fas fa-clock text-orange-500"></i>
                            <span class="text-sm text-gray-300">{{ $hours }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            @php
                $companyName = \App\Models\PageContent::get('footer', 'company', 'name', 'ShopHub');
                $copyrightText = \App\Models\PageContent::get('footer', 'copyright', 'text', '© {year} {company}. All rights reserved.');
                $copyrightText = str_replace('{year}', date('Y'), $copyrightText);
                $copyrightText = str_replace('{company}', $companyName, $copyrightText);
            @endphp
            <p class="text-sm text-gray-400">{{ $copyrightText }}</p>
            <div class="flex items-center gap-6">
                @php
                    $legalLink1Text = \App\Models\PageContent::get('footer', 'legal', 'link1_text', 'Privacy Policy');
                    $legalLink1Url = \App\Models\PageContent::get('footer', 'legal', 'link1_url', '/privacy-policy');
                    $legalLink2Text = \App\Models\PageContent::get('footer', 'legal', 'link2_text', 'Terms of Service');
                    $legalLink2Url = \App\Models\PageContent::get('footer', 'legal', 'link2_url', '/terms-of-service');
                    $legalLink3Text = \App\Models\PageContent::get('footer', 'legal', 'link3_text', 'Cookie Policy');
                    $legalLink3Url = \App\Models\PageContent::get('footer', 'legal', 'link3_url', '/cookie-policy');
                @endphp
                @if($legalLink1Text)
                    <a href="{{ $legalLink1Url }}" class="text-sm text-gray-400 hover:text-orange-400 transition">{{ $legalLink1Text }}</a>
                @endif
                @if($legalLink2Text)
                    <a href="{{ $legalLink2Url }}" class="text-sm text-gray-400 hover:text-orange-400 transition">{{ $legalLink2Text }}</a>
                @endif
                @if($legalLink3Text)
                    <a href="{{ $legalLink3Url }}" class="text-sm text-gray-400 hover:text-orange-400 transition">{{ $legalLink3Text }}</a>
                @endif
            </div>
        </div>
    </div>
</footer>
