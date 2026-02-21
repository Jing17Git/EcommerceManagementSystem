<x-admin-layout>
<x-slot name="header">Products</x-slot>

<style>
  /* ── Page header ── */
  .pro-ph {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .pro-ph h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 .2rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .pro-ph p {
    font-size: .9rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  /* ── Add button ── */
  .btn-primary {
    display: inline-block;
    padding: .55rem 1.25rem;
    background: #4f46e5;
    color: #fff;
    font-size: .875rem;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: background .15s, transform .1s;
    white-space: nowrap;
  }
  .btn-primary:hover  { background: #4338ca; transform: translateY(-1px); }
  .btn-primary:active { transform: translateY(0); }

  /* ── Card ── */
  .pro-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
  }
  .pro-card-body { padding: 1.5rem; }

  /* ── Table ── */
  .pro-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .9rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .pro-table thead {
    background: #f8f9fb;
    border-bottom: 2px solid #e5e7eb;
  }
  .pro-table th {
    padding: .75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    font-size: .72rem;
    letter-spacing: .05em;
    white-space: nowrap;
  }
  .pro-table td {
    padding: .75rem 1rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }
  .pro-table tbody tr:last-child td { border-bottom: none; }
  .pro-table tbody tr:hover { background: #fafafa; }

  /* ── Product image ── */
  .pro-img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    display: block;
  }

  /* ── Product name ── */
  .pro-name {
    font-weight: 600;
    color: #111827;
  }
  .pro-name-sub {
    font-size: .78rem;
    color: #9ca3af;
    margin-top: .1rem;
  }

  /* ── Category pill ── */
  .cat-pill {
    display: inline-block;
    font-size: .78rem;
    background: #f3f4f6;
    color: #6b7280;
    padding: .2em .65em;
    border-radius: 5px;
  }

  /* ── Price ── */
  .price {
    font-weight: 700;
    color: #111827;
  }

  /* ── Stock ── */
  .stock-ok  { color: #065f46; font-weight: 600; }
  .stock-low { color: #b45309; font-weight: 600; }
  .stock-out { color: #991b1b; font-weight: 600; }

  /* ── Status badges ── */
  .badge {
    display: inline-block;
    padding: .25em .75em;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
  }
  .badge-success { background: #d1fae5; color: #065f46; }
  .badge-danger  { background: #fee2e2; color: #991b1b; }

  /* ── Action buttons ── */
  .pro-actions {
    display: flex;
    gap: .4rem;
    align-items: center;
    flex-wrap: wrap;
  }
  .btn-action {
    display: inline-block;
    padding: .3rem .75rem;
    border-radius: 6px;
    font-size: .8rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    line-height: 1.6;
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: opacity .15s, transform .1s;
  }
  .btn-action:hover  { opacity: .85; transform: translateY(-1px); }
  .btn-action:active { transform: translateY(0); }
  .btn-edit   { background: #e0e7ff; color: #3730a3; }
  .btn-delete { background: #fee2e2; color: #991b1b; }

  /* ── Pagination ── */
  .pro-pagination { margin-top: 1.25rem; }

  /* ── Empty state ── */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .empty-icon  { font-size: 3rem; margin-bottom: .75rem; }
  .empty-title { font-size: 1.15rem; font-weight: 700; color: #374151; margin-bottom: .4rem; }
  .empty-desc  { font-size: .9rem; }
</style>

{{-- Page Header --}}
<div class="pro-ph">
  <div>
    <h1>Products</h1>
    <p>Manage your store products</p>
  </div>
  <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Add Product</a>
</div>

{{-- Main Card --}}
<div class="pro-card">
  <div class="pro-card-body">

    @if($products->count() > 0)

      <div style="overflow-x:auto;">
        <table class="pro-table">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
            <tr>
              <td>
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="pro-img">
              </td>
              <td>
                <div class="pro-name">{{ $product->name }}</div>
              </td>
              <td>
                @if($product->category?->name)
                  <span class="cat-pill">{{ $product->category->name }}</span>
                @else
                  <span style="color:#d1d5db;">—</span>
                @endif
              </td>
              <td><span class="price">₱{{ number_format($product->price, 2) }}</span></td>
              <td>
                @if($product->stock === 0)
                  <span class="stock-out">Out of stock</span>
                @elseif($product->stock <= 5)
                  <span class="stock-low">{{ $product->stock }} low</span>
                @else
                  <span class="stock-ok">{{ $product->stock }}</span>
                @endif
              </td>
              <td>
                @if($product->is_active)
                  <span class="badge badge-success">Active</span>
                @else
                  <span class="badge badge-danger">Inactive</span>
                @endif
              </td>
              <td>
                <div class="pro-actions">
                  <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit">Edit</a>
                  <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="pro-pagination">
        {{ $products->links() }}
      </div>

    @else

      <div class="empty-state">
        <div class="empty-icon">📦</div>
        <div class="empty-title">No Products Yet</div>
        <div class="empty-desc">Products will appear here once you add them to your store.</div>
      </div>

    @endif

  </div>
</div>

</x-admin-layout>