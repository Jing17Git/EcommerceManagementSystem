<x-admin-layout>
<x-slot name="header">Add Category</x-slot>

<style>
  /* ── Page header ── */
  .cat-ph {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .cat-ph h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 .2rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .cat-ph p {
    font-size: .9rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  /* ── Back button ── */
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem 1rem;
    background: #f3f4f6;
    color: #374151;
    font-size: .875rem;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: background .15s, transform .1s;
    white-space: nowrap;
  }
  .btn-back:hover { background: #e5e7eb; transform: translateX(-2px); }

  /* ── Card ── */
  .form-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
    max-width: 580px;
  }

  .form-card-head {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: .75rem;
  }
  .form-card-icon {
    width: 36px; height: 36px;
    background: #ede9fe;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
  }
  .form-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .form-card-sub {
    font-size: .8rem;
    color: #9ca3af;
    margin: .1rem 0 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  .form-card-body { padding: 1.5rem; }

  /* ── Fields ── */
  .f-group { margin-bottom: 1.15rem; }
  .f-group:last-of-type { margin-bottom: 0; }

  .f-label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .4rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
    text-transform: uppercase;
    letter-spacing: .04em;
  }
  .f-required { color: #ef4444; }
  .f-optional { color: #d1d5db; font-weight: 400; text-transform: none; letter-spacing: 0; }

  .f-input, .f-textarea, .f-select {
    width: 100%;
    padding: .6rem .9rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: .9rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: #111827;
    background: #f9fafb;
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    -webkit-appearance: none;
  }
  .f-input::placeholder, .f-textarea::placeholder { color: #d1d5db; }
  .f-input:focus, .f-textarea:focus, .f-select:focus {
    border-color: #4f46e5;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
  }
  .f-textarea { resize: vertical; min-height: 90px; line-height: 1.6; }
  .f-hint {
    font-size: .75rem;
    color: #9ca3af;
    margin-top: .3rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  /* slug field */
  .f-slug-wrap { position: relative; }
  .f-slug-prefix {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    font-family: 'Courier New', monospace;
    font-size: .82rem;
    color: #d1d5db;
    pointer-events: none;
  }
  .f-input.slug {
    font-family: 'Courier New', monospace;
    font-size: .85rem;
    color: #4f46e5;
    padding-left: 1.6rem;
  }

  /* divider */
  .f-divider { height: 1px; background: #f3f4f6; margin: 1.25rem 0; }

  /* ── Footer ── */
  .form-card-foot {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .6rem;
    padding: 1rem 1.5rem;
    border-top: 1px solid #f3f4f6;
    background: #fafafa;
  }
  .btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: .5rem 1.1rem;
    background: #f3f4f6;
    color: #6b7280;
    font-size: .875rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-family: 'Segoe UI', system-ui, sans-serif;
    text-decoration: none;
    transition: background .15s;
  }
  .btn-cancel:hover { background: #e5e7eb; }
  .btn-save {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem 1.25rem;
    background: #4f46e5;
    color: #fff;
    font-size: .875rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: background .15s, transform .1s;
    box-shadow: 0 2px 6px rgba(79,70,229,.3);
  }
  .btn-save:hover  { background: #4338ca; transform: translateY(-1px); }
  .btn-save:active { transform: translateY(0); }

  /* ── Validation errors ── */
  .f-error {
    font-size: .78rem;
    color: #ef4444;
    margin-top: .35rem;
    display: flex;
    align-items: center;
    gap: .25rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .f-input.err, .f-textarea.err, .f-select.err {
    border-color: #fca5a5;
    background: #fff5f5;
  }
</style>

{{-- Page Header --}}
<div class="cat-ph">
  <div>
    <h1>Add Category</h1>
    <p>Create a new store category</p>
  </div>
  <a href="{{ route('admin.categories.index') }}" class="btn-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path d="M19 12H5M12 5l-7 7 7 7"/>
    </svg>
    Back to Categories
  </a>
</div>

{{-- Form Card --}}
<div class="form-card">

  <div class="form-card-head">
    <div class="form-card-icon">📂</div>
    <div>
      <p class="form-card-title">Category Details</p>
      <p class="form-card-sub">Fill in the information below</p>
    </div>
  </div>

  <form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div class="form-card-body">

      {{-- Name --}}
      <div class="f-group">
        <label class="f-label" for="name">
          Name <span class="f-required">*</span>
        </label>
        <input
          class="f-input @error('name') err @enderror"
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          placeholder="e.g. Electronics"
          required
          autofocus
          oninput="autoSlug(this.value)"
        >
        @error('name')
          <div class="f-error">
            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      {{-- Slug --}}
      <div class="f-group">
        <label class="f-label" for="slug">Slug</label>
        <div class="f-slug-wrap">
          <span class="f-slug-prefix">/</span>
          <input
            class="f-input slug @error('slug') err @enderror"
            type="text"
            id="slug"
            name="slug"
            value="{{ old('slug') }}"
            placeholder="auto-generated"
          >
        </div>
        <div class="f-hint">Auto-filled from the name — you can edit it manually.</div>
        @error('slug')
          <div class="f-error">
            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="f-divider"></div>

      {{-- Description --}}
      <div class="f-group">
        <label class="f-label" for="description">
          Description <span class="f-optional">(optional)</span>
        </label>
        <textarea
          class="f-textarea @error('description') err @enderror"
          id="description"
          name="description"
          placeholder="Brief description of this category..."
        >{{ old('description') }}</textarea>
        @error('description')
          <div class="f-error">
            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="f-divider"></div>

      {{-- Status --}}
      <div class="f-group">
        <label class="f-label" for="is_active">Status</label>
        <select class="f-select @error('is_active') err @enderror" id="is_active" name="is_active">
          <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>✅ Active</option>
          <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>⏸ Inactive</option>
        </select>
        <div class="f-hint">Active categories are visible in the store.</div>
      </div>

    </div>

    <div class="form-card-foot">
      <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-save">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M20 6L9 17l-5-5"/>
        </svg>
        Save Category
      </button>
    </div>

  </form>
</div>

<script>
  let slugEdited = {{ old('slug') ? 'true' : 'false' }};
  const slugEl = document.getElementById('slug');

  function autoSlug(val) {
    if (slugEdited) return;
    slugEl.value = val.toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }

  slugEl.addEventListener('input', () => { slugEdited = true; });
</script>

</x-admin-layout>