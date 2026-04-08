@extends('layouts.admin')

@section('content')
<div class="max-w-2xl">
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-blue-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-8 py-4 rounded-3xl shadow-xl border border-white/50 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-plus text-xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-orange-700 bg-clip-text text-transparent">New Home Feature</h1>
                    <p class="text-lg text-gray-600 mt-1">Create a stunning card for "Why Choose ShopHub?" ✨</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 text-white px-8 py-4 rounded-2xl shadow-2xl transform rotate-1 -skew-x-3">
                <i class="fas fa-lightning-bolt mr-3"></i>
                Changes appear LIVE on homepage!
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-10">
            <form action="{{ route('admin.home-features.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Preview Card -->
                <div class="p-8 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-3xl border-2 border-dashed border-orange-200 text-center group hover:border-orange-400 transition-all">
                    <div class="flex items-center justify-center gap-4 mb-6 opacity-75 group-hover:opacity-100 transition">
                        <div id="preview-icon" class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-orange-200">
                            <i id="preview-icon-class" class="fas fa-store text-orange-600 text-2xl"></i>
                        </div>
                    </div>
                    <div id="preview-title" class="font-bold text-2xl text-gray-900 mb-3">Feature Title Here</div>
                    <p id="preview-description" class="text-lg text-gray-600 max-w-md mx-auto leading-relaxed">Your amazing feature description goes here...</p>
                    <div class="mt-6 inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-bold">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        Live Preview • Active
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">🎯 Feature Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl text-lg font-semibold focus:border-orange-400 focus:ring-4 focus:ring-orange-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md" placeholder="e.g. Trusted Sellers">
                        @error('title') <p class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">🔢 Position Order</label>
                        <input type="number" name="position" value="{{ old('position', 0) }}" min="0" 
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl text-lg font-mono focus:border-green-400 focus:ring-4 focus:ring-green-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">📝 Feature Description</label>
                    <textarea name="description" rows="5" required 
                              class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl text-lg leading-relaxed placeholder-gray-500 focus:border-purple-400 focus:ring-4 focus:ring-purple-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md resize-vertical" 
                              placeholder="Write a compelling 1-2 sentence description...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">🎨 Icon Class</label>
                        <input type="text" name="icon" value="{{ old('icon', 'fas fa-store') }}" placeholder="e.g. fas fa-store" required 
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl font-mono focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md"
                               oninput="updatePreviewIcon(this.value)">
                        <p class="text-xs text-gray-500 mt-2 font-mono">Font Awesome 6 Pro (fas fa-...)</p>
                        @error('icon') <p class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">🌈 Background</label>
                        <input type="text" name="bg_color" value="{{ old('bg_color', 'bg-orange-100') }}" placeholder="bg-orange-100" required 
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl font-mono focus:border-amber-400 focus:ring-4 focus:ring-amber-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md"
                               oninput="updatePreviewBg(this.value)">
                        <p class="text-xs text-gray-500 mt-2 font-mono">Tailwind bg class</p>
                        @error('bg_color') <p class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-rose-500 to-rose-600 text-white px-4 py-2 rounded-xl inline-block shadow-md w-fit">🎭 Icon Color</label>
                        <input type="text" name="icon_color" value="{{ old('icon_color', 'text-orange-600') }}" placeholder="text-orange-600" required 
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl font-mono focus:border-rose-400 focus:ring-4 focus:ring-rose-100/50 focus:outline-none transition-all shadow-sm hover:shadow-md"
                               oninput="updatePreviewColor(this.value)">
                        <p class="text-xs text-gray-500 mt-2 font-mono">Tailwind text class</p>
                        @error('icon_color') <p class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white py-5 px-8 rounded-2xl font-black text-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Create & Publish Live</span>
                    </button>
                    <a href="{{ route('admin.home-features.index') }}" class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 py-5 px-8 rounded-2xl font-bold text-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <script>
            function updatePreviewIcon(icon) {
                document.getElementById('preview-icon-class').className = icon + ' text-xl';
            }
            function updatePreviewBg(bg) {
                document.getElementById('preview-icon').className = 'w-16 h-16 ' + bg + ' rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-white/20';
            }
            function updatePreviewColor(color) {
                const iconEl = document.getElementById('preview-icon-class');
                const currentIcon = iconEl.className.replace(/text-[^ ]+/, '');
                iconEl.className = currentIcon + ' ' + color;
                document.getElementById('preview-title').className = 'font-bold text-2xl ' + color.replace('text-', 'text-') + ' mb-3';
            }
            // Live title & description preview
            document.querySelector('input[name="title"]').addEventListener('input', (e) => {
                document.getElementById('preview-title').textContent = e.target.value || 'Feature Title Here';
            });
            document.querySelector('textarea[name="description"]').addEventListener('input', (e) => {
                document.getElementById('preview-description').textContent = e.target.value || 'Your amazing feature description goes here...';
            });
        </script>
    </div>
</div>
@endsection

