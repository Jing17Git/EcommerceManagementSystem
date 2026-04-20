@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-blue-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-8 py-4 rounded-3xl shadow-xl border border-white/50 mb-6">
                <div class="w-12 h-12 {{ $homeFeature->bg_color }} rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="{{ $homeFeature->icon }} {{ $homeFeature->icon_color }} text-xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-orange-700 bg-clip-text text-transparent">Edit "{{ $homeFeature->title }}"</h1>
                    <p class="text-lg text-gray-600 mt-1">Polish your homepage feature ✨</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white px-8 py-4 rounded-2xl shadow-2xl">
                <i class="fas fa-magic mr-3"></i>
                Live preview updates instantly!
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-10">
            <form action="{{ route('admin.home-features.update', $homeFeature) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Live Preview Card -->
                <div class="p-8 bg-gradient-to-br from-{{ Str::before($homeFeature->bg_color, '-100') }}-50 to-yellow-50 rounded-3xl border-2 border-dashed border-{{ Str::before($homeFeature->bg_color, '-100') }}-200 text-center group hover:border-{{ Str::before($homeFeature->bg_color, '-100') }}-400 transition-all">
                    <div class="flex items-center justify-center gap-4 mb-6 opacity-90 group-hover:opacity-100 transition">
                        <div id="preview-icon" class="w-20 h-20 {{ $homeFeature->bg_color }} rounded-2xl flex items-center justify-center shadow-2xl ring-2 ring-white/30">
                            <i id="preview-icon-class" class="{{ $homeFeature->icon }} {{ $homeFeature->icon_color }} text-2xl"></i>
                        </div>
                    </div>
                    <div id="preview-title" class="font-bold text-2xl {{ Str::replace('text-', 'text-', $homeFeature->icon_color) }} mb-3">{{ $homeFeature->title }}</div>
                    <p id="preview-description" class="text-lg text-gray-600 max-w-lg mx-auto leading-relaxed">{{ $homeFeature->description }}</p>
                    <div class="mt-6 inline-flex items-center gap-2 {{ $homeFeature->bg_color }} {{ Str::replace('text-', '', $homeFeature->icon_color) }}-800 px-6 py-3 rounded-full text-sm font-bold shadow-lg ring-1 ring-white/30">
                        @if($homeFeature->is_active)
                            <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                            Live • Active on Homepage
                        @else
                            <div class="w-3 h-3 bg-yellow-500 rounded-full animate-ping"></div>
                            Draft Mode
                        @endif
                    </div>
                </div>

                <!-- Form Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                            <i class="fas fa-heading"></i> Feature Title
                        </label>
                        <input type="text" name="title" value="{{ old('title', $homeFeature->title) }}" required 
                               class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl text-xl font-bold placeholder-gray-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-100/70 shadow-lg hover:shadow-xl transition-all duration-300" oninput="livePreviewTitle(this.value)">
                        @error('title') <div class="mt-3 p-4 bg-red-50 border-l-4 border-red-400 rounded-xl shadow-sm"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i><span class="font-medium">{{ $message }}</span></div> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                            <i class="fas fa-sort-numeric-up"></i> Sort Order
                        </label>
                        <input type="number" name="position" value="{{ old('position', $homeFeature->position) }}" min="0" 
                               class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl text-xl font-mono tracking-wider focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100/70 shadow-lg hover:shadow-xl transition-all duration-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-violet-500 to-violet-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                        <i class="fas fa-align-left"></i> Description
                    </label>
                    <textarea name="description" rows="5" required 
                              class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl text-lg leading-8 placeholder-gray-400 focus:border-violet-400 focus:ring-4 focus:ring-violet-100/70 shadow-lg hover:shadow-xl transition-all duration-300 resize-vertical font-medium" 
                              placeholder="Write an engaging 1-2 sentence description...">{{ old('description', $homeFeature->description) }}</textarea>
                    @error('description') <div class="mt-3 p-4 bg-red-50 border-l-4 border-red-400 rounded-xl shadow-sm"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i><span class="font-medium">{{ $message }}</span></div> @enderror
                </div>

                <!-- Icon & Color Palette -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                            <i class="fab fa-font-awesome"></i> Icon Class
                        </label>
                        <div class="relative">
                            <input type="text" name="icon" value="{{ old('icon', $homeFeature->icon) }}" required 
                                   class="w-full px-6 py-5 pr-14 border-2 border-gray-200 rounded-2xl font-mono text-lg focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100/70 shadow-lg hover:shadow-xl transition-all duration-300"
                                   oninput="livePreviewIcon(this.value); updatePreviewColor(document.querySelector('input[name=icon_color]').value)"
                                   placeholder="e.g. fas fa-store">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <i class="{{ old('icon', $homeFeature->icon) }} text-gray-400 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-3 font-mono bg-gray-50 p-3 rounded-xl">Font Awesome 6 (fas fa-..., far fa-...)</p>
                        @error('icon') <div class="mt-3 p-4 bg-red-50 border-l-4 border-red-400 rounded-xl shadow-sm"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                            <i class="fas fa-palette"></i> Background Color
                        </label>
                        <input type="text" name="bg_color" value="{{ old('bg_color', $homeFeature->bg_color) }}" required 
                               class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl font-mono text-lg focus:border-amber-400 focus:ring-4 focus:ring-amber-100/70 shadow-lg hover:shadow-xl transition-all duration-300"
                               oninput="livePreviewBg(this.value)"
                               placeholder="e.g. bg-orange-100">
                        <div class="mt-3 grid grid-cols-6 gap-2">
                            <div class="w-10 h-10 bg-orange-100 border-2 border-orange-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-orange-100'; livePreviewBg('bg-orange-100')"></div>
                            <div class="w-10 h-10 bg-green-100 border-2 border-green-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-green-100'; livePreviewBg('bg-green-100')"></div>
                            <div class="w-10 h-10 bg-blue-100 border-2 border-blue-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-blue-100'; livePreviewBg('bg-blue-100')"></div>
                            <div class="w-10 h-10 bg-purple-100 border-2 border-purple-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-purple-100'; livePreviewBg('bg-purple-100')"></div>
                            <div class="w-10 h-10 bg-pink-100 border-2 border-pink-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-pink-100'; livePreviewBg('bg-pink-100')"></div>
                            <div class="w-10 h-10 bg-indigo-100 border-2 border-indigo-200 rounded-xl cursor-pointer hover:scale-110 transition hover:shadow-md" onclick="document.querySelector('[name=bg_color]').value='bg-indigo-100'; livePreviewBg('bg-indigo-100')"></div>
                        </div>
                        @error('bg_color') <div class="mt-3 p-4 bg-red-50 border-l-4 border-red-400 rounded-xl shadow-sm"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 bg-gradient-to-r from-rose-500 to-rose-600 text-white px-5 py-3 rounded-xl shadow-xl w-fit inline-flex items-center gap-2">
                            <i class="fas fa-eye-dropper"></i> Icon Color
                        </label>
                        <input type="text" name="icon_color" value="{{ old('icon_color', $homeFeature->icon_color) }}" required 
                               class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl font-mono text-lg focus:border-rose-400 focus:ring-4 focus:ring-rose-100/70 shadow-lg hover:shadow-xl transition-all duration-300"
                               oninput="livePreviewColor(this.value)"
                               placeholder="e.g. text-orange-600">
                        <div class="mt-3 grid grid-cols-6 gap-2">
                            <div class="w-10 h-10 bg-orange-600 text-white border-2 border-orange-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-orange-600'; livePreviewColor('text-orange-600')">
                                OR
                            </div>
                            <div class="w-10 h-10 bg-green-600 text-white border-2 border-green-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-green-600'; livePreviewColor('text-green-600')">
                                GR
                            </div>
                            <div class="w-10 h-10 bg-blue-600 text-white border-2 border-blue-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-blue-600'; livePreviewColor('text-blue-600')">
                                BL
                            </div>
                            <div class="w-10 h-10 bg-purple-600 text-white border-2 border-purple-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-purple-600'; livePreviewColor('text-purple-600')">
                                PU
                            </div>
                            <div class="w-10 h-10 bg-pink-600 text-white border-2 border-pink-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-pink-600'; livePreviewColor('text-pink-600')">
                                PK
                            </div>
                            <div class="w-10 h-10 bg-indigo-600 text-white border-2 border-indigo-200 rounded-xl cursor-pointer hover:scale-110 flex items-center justify-center font-bold text-xs transition hover:shadow-md" onclick="document.querySelector('[name=icon_color]').value='text-indigo-600'; livePreviewColor('text-indigo-600')">
                                IN
                            </div>
                        </div>
                        @error('icon_color') <div class="mt-3 p-4 bg-red-50 border-l-4 border-red-400 rounded-xl shadow-sm"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Status Toggle & CTA -->
                <div class="pt-8 border-t border-gray-100">
                    <div class="flex items-center gap-6 mb-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $homeFeature->is_active) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-orange-600"></div>
                            <span class="ml-3 text-sm font-bold text-gray-900">Live on Homepage</span>
                        </label>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-6 px-10 rounded-3xl font-black text-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-[1.03] transition-all duration-500 flex items-center justify-center gap-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>✨ Update & Go Live</span>
                        </button>
                        <a href="{{ route('admin.home-features.index') }}" class="flex-1 bg-gradient-to-r from-slate-100 to-slate-200 hover:from-slate-200 hover:to-slate-300 text-slate-800 py-6 px-10 rounded-3xl font-black text-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 flex items-center justify-center gap-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function livePreviewTitle(title) {
                document.getElementById('preview-title').textContent = title || '{{ $homeFeature->title }}';
            }
            function livePreviewDescription(desc) {
                document.getElementById('preview-description').textContent = desc || '{{ $homeFeature->description }}';
            }
            function livePreviewIcon(icon) {
                document.getElementById('preview-icon-class').className = icon + ' ' + document.querySelector('[name=icon_color]').value;
            }
            function livePreviewBg(bg) {
                const colorBase = bg.replace('bg-', '').replace('-100', '');
                document.getElementById('preview-icon').className = 'w-20 h-20 ' + bg + ' rounded-2xl flex items-center justify-center shadow-2xl ring-2 ring-white/30';
                document.querySelector('#preview-card').className = 'p-8 bg-gradient-to-br from-' + colorBase + '-50 to-yellow-50 rounded-3xl border-2 border-dashed border-' + colorBase + '-200 text-center group hover:border-' + colorBase + '-400 transition-all';
            }
            function livePreviewColor(color) {
                const iconEl = document.getElementById('preview-icon-class');
                iconEl.className = iconEl.className.replace(/text-[^ ]+/, '') + ' ' + color;
            }
            // Auto-bind inputs
            document.querySelectorAll('input, textarea').forEach(el => {
                el.addEventListener('input', function() {
                    if (this.name === 'title') livePreviewTitle(this.value);
                    if (this.name === 'description') livePreviewDescription(this.value);
                    if (this.name === 'icon') livePreviewIcon(this.value);
                    if (this.name === 'bg_color') livePreviewBg(this.value);
                    if (this.name === 'icon_color') livePreviewColor(this.value);
                });
            });
        </script>
    </div>
</div>
@endsection

