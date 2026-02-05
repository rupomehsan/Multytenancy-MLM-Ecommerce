<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_no }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
            background-color: #f5f5f5;
            color: #333;
        }

        .invoice-container {
            max-width: 210mm;
            margin: 20px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .company-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .company-logo img {
            max-height: 60px;
            max-width: 120px;
            object-fit: contain;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 0;
            line-height: 1.2;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-number {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .invoice-number strong {
            color: #333;
            font-weight: 600;
        }

        .invoice-info-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .shipping-info,
        .order-info {
            width: 48%;
            display: flex;
            flex-direction: column;
        }

        .info-title {
            font-size: 13px;
            font-weight: bold;
            color: #555;
            margin: 0 0 8px 0;
            padding: 0;
            text-transform: uppercase;
            line-height: 1;
        }

        .info-content {
            font-size: 13px;
            line-height: 1.6;
            color: #555;
            margin: 0;
            padding: 0;
        }

        .info-content strong {
            color: #333;
            display: inline-block;
            min-width: 140px;
        }

        .info-content p {
            margin: 0 0 5px 0;
            padding: 0;
        }

        .info-content p:first-child {
            margin-top: 0;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .order-table thead {
            background: #f8f9fa;
        }

        .order-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        .order-table th.text-center {
            text-align: center;
        }

        .order-table th.text-right {
            text-align: right;
        }

        .order-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
            color: #555;
            vertical-align: top;
        }

        .order-table td.text-center {
            text-align: center;
        }

        .order-table td.text-right {
            text-align: right;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .editable-qty,
        .editable-price {
            width: 80px;
            padding: 5px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 12px;
        }

        .editable-qty:focus,
        .editable-price:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
        }

        @media print {
            .editable-qty,
            .editable-price {
                border: none;
                padding: 0;
            }
        }

        .order-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-dispatch {
            background: #cce5ff;
            color: #004085;
        }

        .status-intransit {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-delivered {
            background: #d4edda;
            color: #155724;
        }

        .status-return {
            background: #e2e3e5;
            color: #383d41;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .billing-address {
            width: 48%;
        }

        .order-summary {
            width: 48%;
            text-align: right;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 15px;
        }

        .summary-row strong {
            color: #333;
        }

        .total-row {
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .action-buttons {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px dashed #dee2e6;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-print:hover {
            background: #0056b3;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                margin: 0;
                padding: 0;
                background: white;
                font-size: 11px;
            }

            .invoice-container {
                max-width: 100%;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .invoice-header {
                margin-bottom: 15px;
                padding-bottom: 10px;
            }

            .company-name {
                font-size: 16px;
            }

            .invoice-title {
                font-size: 20px;
            }

            .invoice-number {
                font-size: 12px;
            }

            .company-logo img {
                max-height: 50px;
                max-width: 100px;
            }

            .invoice-info-section {
                margin-bottom: 15px;
                align-items: flex-start;
            }

            .shipping-info,
            .order-info {
                margin: 0 !important;
                padding: 0 !important;
            }

            .info-title {
                margin: 0 0 6px 0 !important;
                padding: 0 !important;
                font-size: 12px;
            }

            .info-content {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 11px;
            }

            .info-content p {
                margin: 0 0 4px 0 !important;
                padding: 0 !important;
            }

            .info-content p:first-child {
                margin-top: 0 !important;
            }

            .order-table {
                margin: 15px 0;
                font-size: 11px;
            }

            .order-table th {
                padding: 8px 6px;
                font-size: 11px;
            }

            .order-table td {
                padding: 8px 6px;
                font-size: 10px;
            }

            .product-image {
                width: 40px;
                height: 40px;
            }

            .order-footer {
                margin-top: 15px;
            }

            .summary-row {
                padding: 5px 0;
                font-size: 12px;
            }

            .total-row {
                padding-top: 10px;
                font-size: 14px;
            }

            .action-buttons {
                display: none !important;
            }

            .order-status {
                padding: 2px 8px;
                font-size: 10px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .invoice-container {
                padding: 20px;
            }

            .invoice-header {
                flex-direction: row;
                text-align: center;
            }

            .company-name,
            .invoice-title {
                text-align: center;
                margin: 10px 0;
            }

            .invoice-info-section,
            .order-footer {
                flex-direction: row;
            }

            .shipping-info,
            .order-info,
            .billing-address,
            .order-summary {
                width: 100%;
                margin-bottom: 20px;
            }

            .order-summary {
                text-align: left;
            }

            .product-image {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>

<body>
    @php
    use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

    $statusClasses = [
    Order::STATUS_PENDING => 'status-pending',
    Order::STATUS_APPROVED => 'status-approved',
    Order::STATUS_DISPATCH => 'status-dispatch',
    Order::STATUS_INTRANSIT => 'status-intransit',
    Order::STATUS_CANCELLED => 'status-cancelled',
    Order::STATUS_DELIVERED => 'status-delivered',
    Order::STATUS_RETURN => 'status-return',
    ];

    $statusLabels = [
    Order::STATUS_PENDING => 'Pending',
    Order::STATUS_APPROVED => 'Approved',
    Order::STATUS_DISPATCH => 'Dispatch',
    Order::STATUS_INTRANSIT => 'Intransit',
    Order::STATUS_CANCELLED => 'Cancelled',
    Order::STATUS_DELIVERED => 'Delivered',
    Order::STATUS_RETURN => 'Return',
    ];
    @endphp

    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="company-info">
                @if($generalInfo && $generalInfo->logo)
                <div class="company-logo">
                    <img src="{{ url($generalInfo->logo) }}" alt="Company Logo">
                </div>
                @endif
                <h4 class="company-name">{{ $generalInfo->company_name ?? 'Company Name' }}</h4>
            </div>

            <div class="invoice-info">
                <h4 class="invoice-title">Invoice</h4>
                <p class="invoice-number"><strong>#{{ $order->order_no }}</strong></p>
            </div>
        </div>

        <!-- Invoice Info Section -->
        <div class="invoice-info-section">
            <!-- Shipping Info -->
            <div class="shipping-info">
                <h6 class="info-title">Shipping Info:</h6>
                <div class="info-content">
                    <p><strong>Name:</strong> {{ $order->username }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    @if($order->user_email)<p><strong>Email:</strong> {{ $order->user_email }}</p>@endif
                    <p><strong>Street:</strong> {{ $order->shipping_address }}</p>
                    @if($order->shipping_thana)<p><strong>Thana:</strong> {{ $order->shipping_thana }}</p>@endif
                    <p><strong>District:</strong> {{ $order->shipping_city }}</p>
                    @if($order->shipping_post_code)<p><strong>Postal code:</strong> {{ $order->shipping_post_code }}, Bangladesh</p>@endif
                </div>
            </div>

            <!-- Order Info -->
            <div class="order-info">
                <h6 class="info-title" style="text-align: right;">Order Info:</h6>
                <div class="info-content" style="text-align: right;">
                    <p><strong>Order NO:</strong> #{{ $order->order_no }}</p>
                    <p><strong>Tran. ID:</strong> #{{ $order->trx_id ?? 'N/A' }}</p>
                    <p><strong>Order Date:</strong> {{ date('jS F, Y', strtotime($order->order_date)) }}</p>
                    <p><strong>Order Status:</strong>
                        <span class="order-status {{ $statusClasses[$order->order_status] ?? 'status-pending' }}">
                            {{ $statusLabels[$order->order_status] ?? 'Unknown' }}
                        </span>
                    </p>
                    <p><strong>Delivery Method:</strong>
                        @if($order->delivery_method == 1)
                        Home Delivery
                        @else
                        Store Pickup
                        @endif
                    </p>
                    <p><strong>Payment Method:</strong>
                        @if ($order->payment_method == Order::PAYMENT_COD)
                        Cash On Delivery
                        @elseif ($order->payment_method == Order::PAYMENT_BKASH)
                        bKash
                        @elseif ($order->payment_method == Order::PAYMENT_NAGAD)
                        Nagad
                        @elseif ($order->payment_method == Order::PAYMENT_SSL_COMMERZ)
                        SSLCommerze
                        @else
                        N/A
                        @endif
                    </p>
                    <p><strong>Payment Status:</strong>
                        @if ($order->payment_method == Order::PAYMENT_COD)
                        @if ($order->order_status == Order::STATUS_DELIVERED)
                        <span style="color: #28a745; font-weight: 600;">Paid</span>
                        @else
                        <span style="color: #dc3545; font-weight: 600;">Unpaid</span>
                        @endif
                        @else
                        @if ($order->payment_status == Order::PAYMENT_STATUS_PAID)
                        <span style="color: #28a745; font-weight: 600;">Paid</span>
                        @else
                        <span style="color: #dc3545; font-weight: 600;">Unpaid</span>
                        @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items Table -->
        <table class="order-table">
            <thead>
                <tr>
                    <th style="width: 60px;" class="text-center">SL</th>
                    <th style="width: 80px;">Image</th>
                    <th>Item</th>
                    <th class="text-center">Variant</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Unit Cost</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @php $sl = 1; @endphp
                @foreach($orderItems as $index => $item)
                @php
                    // Determine which image to display (variant image takes priority)
                    $displayImage = $item->variant_image && !empty($item->variant_image) 
                        ? $item->variant_image 
                        : $item->product_image;
                @endphp
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>
                    <td>
                        @if($displayImage)
                        <img src="{{ url($displayImage) }}" alt="{{ $item->name }}" class="product-image">
                        @else
                        <img src="{{ asset('uploads/no-image.png') }}" alt="No Image" class="product-image">
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if(isset($item->product_code) && $item->product_code)
                        <br><small style="color: #666;">Code: {{ $item->product_code }}</small>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(isset($item->color_name) && $item->color_name)
                        Color: {{ $item->color_name }}
                        @endif
                        @if(isset($item->size_name) && $item->size_name)
                        @if(isset($item->color_name) && $item->color_name) | @endif
                        Size: {{ $item->size_name }}
                        @endif
                        @if(!isset($item->color_name) && !isset($item->size_name))
                        —
                        @endif
                    </td>
                    <td class="text-center">
                        <input type="number" 
                               class="editable-qty" 
                               data-index="{{ $index }}" 
                               value="{{ $item->qty }}" 
                               min="1" 
                               onchange="updateTotal({{ $index }})">
                        {{ $item->unit_name ?? 'pcs' }}
                    </td>
                    <td class="text-center">
                        ৳ <input type="number" 
                               class="editable-price" 
                               data-index="{{ $index }}" 
                               value="{{ $item->product_price }}" 
                               min="0" 
                               step="0.01" 
                               onchange="updateTotal({{ $index }})">
                    </td>
                    <td class="text-right" id="item-total-{{ $index }}">৳ {{ number_format($item->product_price * $item->qty, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Order Footer -->
        <div class="order-footer">
            <!-- Billing Address -->
            <div class="billing-address">
                <h6 class="info-title">Billing Address:</h6>
                <div class="info-content">
                    {{ $order->shipping_address }},
                    @if($order->shipping_thana){{ $order->shipping_thana }},@endif
                    {{ $order->shipping_city }} @if($order->shipping_post_code){{ $order->shipping_post_code }},@endif
                    Bangladesh
                </div>

                @if($order->order_note)
                <div style="margin-top: 20px;">
                    <h6 class="info-title">Order Note:</h6>
                    <p style="font-size: 14px; color: #555;">{{ $order->order_note }}</p>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-row">
                    <span><strong>Sub-total:</strong></span>
                    <span>৳ {{ number_format($order->sub_total, 2) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row">
                    <span><strong>Discount:</strong></span>
                    <span>৳ {{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                @if($order->vat > 0 || $order->tax > 0)
                <div class="summary-row">
                    <span><strong>VAT/TAX:</strong></span>
                    <span>৳ {{ number_format($order->vat + $order->tax, 2) }}</span>
                </div>
                @endif
                @if($order->delivery_fee > 0)
                <div class="summary-row">
                    <span><strong>Delivery Charge:</strong></span>
                    <span>৳ {{ number_format($order->delivery_fee, 2) }}</span>
                </div>
                @endif
                <div class="summary-row total-row">
                    <span><strong>Total Order Amount:</strong></span>
                    <span>৳ {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-print">
                <i class="fa fa-print"></i> Print Invoice
            </button>
            <a href="{{ url('order/details/' . $order->slug) }}" class="btn btn-back">
                <i class="fa fa-arrow-left"></i> Back to Order
            </a>
        </div>
    </div>

    <script>
        // Store original discount and fees
        const originalDiscount = {{ $order->discount }};
        const originalVat = {{ $order->vat + $order->tax }};
        const originalDeliveryFee = {{ $order->delivery_fee }};

        // Update item total and recalculate order totals
        function updateTotal(index) {
            const qtyInput = document.querySelector(`.editable-qty[data-index="${index}"]`);
            const priceInput = document.querySelector(`.editable-price[data-index="${index}"]`);
            const itemTotalCell = document.getElementById(`item-total-${index}`);

            if (!qtyInput || !priceInput || !itemTotalCell) return;

            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const itemTotal = qty * price;

            // Update item total
            itemTotalCell.textContent = '৳ ' + formatNumber(itemTotal);

            // Recalculate order totals
            recalculateOrderTotal();
        }

        // Recalculate entire order total
        function recalculateOrderTotal() {
            let subtotal = 0;

            // Sum all item totals
            const qtyInputs = document.querySelectorAll('.editable-qty');
            qtyInputs.forEach((qtyInput) => {
                const index = qtyInput.getAttribute('data-index');
                const priceInput = document.querySelector(`.editable-price[data-index="${index}"]`);
                
                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                subtotal += qty * price;
            });

            // Update subtotal
            const subtotalElement = document.querySelector('.summary-row:nth-child(1) span:last-child');
            if (subtotalElement) {
                subtotalElement.textContent = '৳ ' + formatNumber(subtotal);
            }

            // Calculate total
            const total = subtotal - originalDiscount + originalVat + originalDeliveryFee;

            // Update grand total
            const totalElement = document.querySelector('.total-row span:last-child');
            if (totalElement) {
                totalElement.textContent = '৳ ' + formatNumber(total);
            }
        }

        // Format number with 2 decimals and thousand separators
        function formatNumber(num) {
            return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Add keyboard shortcut for printing
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
            });
        });
    </script>
</body>

</html>