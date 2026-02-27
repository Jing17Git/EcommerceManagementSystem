<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 24px; }
        .container { max-width: 760px; margin: 0 auto; }
        .row { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; }
        .title { font-size: 24px; font-weight: 700; margin: 0 0 6px; }
        .sub { color: #555; font-size: 13px; }
        .card { border: 1px solid #111; border-radius: 8px; padding: 14px; margin-top: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #111; padding: 8px; font-size: 13px; text-align: left; }
        th { background: #f3f3f3; }
        .text-right { text-align: right; }
        .actions { margin-top: 16px; display: flex; gap: 10px; }
        .btn { border: 1px solid #111; background: #fff; color: #111; padding: 8px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 13px; }
        @media print {
            .actions { display: none; }
            body { margin: 0; }
            .container { max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div>
            <h1 class="title">Order Receipt</h1>
            <div class="sub">Order #: {{ $order->order_number }}</div>
            <div class="sub">Date: {{ $order->created_at->format('M d, Y h:i A') }}</div>
        </div>
        <div class="text-right">
            <div><strong>Seller:</strong> {{ $order->seller?->store_name ?: $order->seller?->name }}</div>
            <div class="sub">{{ $order->seller?->store_email ?: $order->seller?->email }}</div>
        </div>
    </div>

    <div class="card">
        <div><strong>Buyer:</strong> {{ $order->user?->name }}</div>
        <div class="sub">{{ $order->user?->email }}</div>
        <div class="sub" style="margin-top: 8px;"><strong>Shipping Address:</strong> {{ $order->shipping_address ?: 'N/A' }}</div>
        <div class="sub"><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
        <div class="sub"><strong>Payment:</strong> {{ ucfirst($order->payment?->status ?? 'unpaid') }}</div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th class="text-right">Unit Price</th>
            <th class="text-right">Line Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-right">PHP {{ number_format((float)$item->unit_price, 2) }}</td>
                <td class="text-right">PHP {{ number_format((float)$item->line_total, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No line items found.</td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3" class="text-right">Total</th>
            <th class="text-right">PHP {{ number_format((float)$order->total_amount, 2) }}</th>
        </tr>
        </tfoot>
    </table>

    <div class="actions">
        <button class="btn" onclick="window.print()">Print Receipt</button>
        <a class="btn" href="{{ route('seller.orders') }}">Back to Orders</a>
    </div>
</div>
</body>
</html>
