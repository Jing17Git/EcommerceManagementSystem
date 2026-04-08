<x-admin-layout>
<x-slot name="header">Edit {{ ucfirst(str_replace('-', ' ', $page)) }} Content</x-slot>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Edit {{ ucfirst(str_replace('-', ' ', $page)) }} Content</h1>
        <a href="{{ route('admin.page-contents.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.page-contents.update', $page) }}">
        @csrf
        @method('PUT')

        @if($page === 'welcome')
            <!-- Hero Section -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Hero Banner</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Main Title</label>
                        <input type="text" name="contents[hero][title]" value="{{ $contents->get('hero')?->firstWhere('key', 'title')?->value ?? 'Welcome to ShopHub!' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Subtitle</label>
                        <textarea name="contents[hero][subtitle]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('hero')?->firstWhere('key', 'subtitle')?->value ?? 'Discover quality products from trusted sellers.' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Banner Features -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Banner Features (4 badges)</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 1</label>
                        <input type="text" name="contents[banner_features][feature1]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature1')?->value ?? 'Quality Guaranteed' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 2</label>
                        <input type="text" name="contents[banner_features][feature2]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature2')?->value ?? 'Secure Payment' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 3</label>
                        <input type="text" name="contents[banner_features][feature3]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature3')?->value ?? 'Fast Shipping' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 4</label>
                        <input type="text" name="contents[banner_features][feature4]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature4')?->value ?? '24/7 Support' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Why Choose Us Section</h3>
                <div class="space-y-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Section Title</label>
                        <input type="text" name="contents[why_choose][title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'title')?->value ?? 'Why Choose ShopHub?' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Feature 1 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 1</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature1_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature1_title')?->value ?? 'Trusted Sellers' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature1_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature1_desc')?->value ?? 'Every seller is verified to ensure authentic products and reliable service.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 2</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature2_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature2_title')?->value ?? 'Quality Guaranteed' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature2_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature2_desc')?->value ?? 'Each product is carefully curated to meet our quality standards.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 3</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature3_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature3_title')?->value ?? 'Fast Shipping' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature3_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature3_desc')?->value ?? 'Quick delivery across the Philippines and beyond.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 4</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature4_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature4_title')?->value ?? '24/7 Support' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature4_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature4_desc')?->value ?? 'We\'re here to help anytime you need assistance.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($page === 'buyer-dashboard')
            <!-- Dashboard Hero -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Dashboard Hero Banner</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Hero Title</label>
                        <input type="text" name="contents[hero][title]" value="{{ $contents->get('hero')?->firstWhere('key', 'title')?->value ?? 'Discover Amazing Products' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Hero Subtitle</label>
                        <textarea name="contents[hero][subtitle]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('hero')?->firstWhere('key', 'subtitle')?->value ?? 'Find quality products at great prices' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Call to Action Text</label>
                        <input type="text" name="contents[hero][cta_text]" value="{{ $contents->get('hero')?->firstWhere('key', 'cta_text')?->value ?? 'Shop Now' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
            </div>

            <!-- Banner Features -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Banner Features (4 badges)</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 1</label>
                        <input type="text" name="contents[banner_features][feature1]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature1')?->value ?? 'Quality Guaranteed' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 2</label>
                        <input type="text" name="contents[banner_features][feature2]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature2')?->value ?? 'Secure Payment' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 3</label>
                        <input type="text" name="contents[banner_features][feature3]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature3')?->value ?? 'Fast Shipping' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Feature 4</label>
                        <input type="text" name="contents[banner_features][feature4]" value="{{ $contents->get('banner_features')?->firstWhere('key', 'feature4')?->value ?? '24/7 Support' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Why Choose Us Section</h3>
                <div class="space-y-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Section Title</label>
                        <input type="text" name="contents[why_choose][title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'title')?->value ?? 'Why Choose ShopHub?' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Feature 1 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 1</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature1_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature1_title')?->value ?? 'Trusted Sellers' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature1_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature1_desc')?->value ?? 'Every seller is verified to ensure authentic products and reliable service.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 2</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature2_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature2_title')?->value ?? 'Quality Guaranteed' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature2_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature2_desc')?->value ?? 'Each product is carefully curated to meet our quality standards.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 3</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature3_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature3_title')?->value ?? 'Fast Shipping' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature3_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature3_desc')?->value ?? 'Quick delivery across the Philippines and beyond.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-3">Feature 4</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title</label>
                                <input type="text" name="contents[why_choose][feature4_title]" value="{{ $contents->get('why_choose')?->firstWhere('key', 'feature4_title')?->value ?? '24/7 Support' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea name="contents[why_choose][feature4_desc]" rows="2" class="w-full px-3 py-2 border rounded">{{ $contents->get('why_choose')?->firstWhere('key', 'feature4_desc')?->value ?? 'We\'re here to help anytime you need assistance.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($page === 'footer')
            <!-- Company Info -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Company Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Company Name</label>
                        <input type="text" name="contents[company][name]" value="{{ $contents->get('company')?->firstWhere('key', 'name')?->value ?? 'ShopHub' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tagline</label>
                        <input type="text" name="contents[company][tagline]" value="{{ $contents->get('company')?->firstWhere('key', 'tagline')?->value ?? 'Your Trusted Online Shop' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea name="contents[company][description]" rows="3" class="w-full px-3 py-2 border rounded">{{ $contents->get('company')?->firstWhere('key', 'description')?->value ?? 'Discover quality products from trusted sellers.' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Address</label>
                        <input type="text" name="contents[contact][address]" value="{{ $contents->get('contact')?->firstWhere('key', 'address')?->value ?? 'Philippines' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Phone</label>
                        <input type="text" name="contents[contact][phone]" value="{{ $contents->get('contact')?->firstWhere('key', 'phone')?->value ?? '+63 912 345 6789' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Business Hours</label>
                        <input type="text" name="contents[contact][hours]" value="{{ $contents->get('contact')?->firstWhere('key', 'hours')?->value ?? 'Mon - Sat: 9AM - 7PM' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="mb-8 p-4 border rounded">
                <h3 class="text-lg font-semibold mb-4">Social Media Links</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Facebook URL</label>
                        <input type="text" name="contents[social][facebook]" value="{{ $contents->get('social')?->firstWhere('key', 'facebook')?->value ?? '#' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Twitter URL</label>
                        <input type="text" name="contents[social][twitter]" value="{{ $contents->get('social')?->firstWhere('key', 'twitter')?->value ?? '#' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Instagram URL</label>
                        <input type="text" name="contents[social][instagram]" value="{{ $contents->get('social')?->firstWhere('key', 'instagram')?->value ?? '#' }}" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Changes</button>
        </div>
    </form>
</div>
</x-admin-layout>
