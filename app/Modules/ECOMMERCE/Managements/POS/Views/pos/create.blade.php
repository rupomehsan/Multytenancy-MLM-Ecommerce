@extends('tenant.admin.layouts.app')

@section('page_title')
    Orders
@endsection
@section('page_heading')
    Edit Order
@endsection

@section('header_css')
    <link href="{{ asset('tenant/admin/assets') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('tenant/admin/assets') }}/css/pos.css" rel="stylesheet" type="text/css" />
    <style>
        /* Select2 Invalid State Styling */
        .select2-container.is-invalid .select2-selection,
        .select2-container.is-invalid .select2-selection--single,
        .select2-container--default.is-invalid .select2-selection,
        .select2-container--default.is-invalid .select2-selection--single,
        span.select2-container.is-invalid+.select2-container .select2-selection {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .select2-container.is-invalid .select2-selection:focus,
        .select2-container--default.is-invalid .select2-selection:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        /* Modern POS Layout */
        .pos-modern-container {
            display: flex;
            gap: 15px;
            height: calc(100vh - 200px);
            padding-bottom: 20px;
        }

        /* Left Panel - Cart & Checkout */
        .pos-left-cart {
            flex: 0 0 50%;
            display: flex;
            flex-direction: column;
            gap: 12px;
            overflow-y: auto;
            padding-right: 8px;
            max-height: calc(100vh - 200px);
        }

        /* Scrollbar styling for left panel */
        .pos-left-cart::-webkit-scrollbar {
            width: 6px;
        }

        .pos-left-cart::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .pos-left-cart::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 3px;
        }

        .pos-left-cart::-webkit-scrollbar-thumb:hover {
            background: #5568d3;
        }

        /* Right Panel - Products */
        .pos-right-products {
            flex: 0 0 50%;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            max-height: calc(100vh - 200px);
        }

        /* Modern Cards */
        .pos-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .pos-card-header {
            padding: 12px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        .pos-card-body {
            padding: 14px 16px;
        }

        .pos-card:last-child {
            margin-bottom: 0;
        }

        /* Product Filters */
        .pos-filters {
            padding: 18px 20px;
            background: white;
            border-bottom: 2px solid #e9ecef;
        }

        /* Product Grid */
        .pos-products-grid {
            flex: 1;
            padding: 16px;
            padding-bottom: 24px;
            overflow-y: auto;
            background: #f8f9fa;
            max-height: calc(100vh - 280px);
        }

        /* Scrollbar styling for products grid */
        .pos-products-grid::-webkit-scrollbar {
            width: 6px;
        }

        .pos-products-grid::-webkit-scrollbar-track {
            background: #e9ecef;
            border-radius: 3px;
        }

        .pos-products-grid::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 3px;
        }

        .pos-products-grid::-webkit-scrollbar-thumb:hover {
            background: #5568d3;
        }

        .pos-products-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px;
            padding-bottom: 8px;
        }

        /* Product Card */
        .pos-product-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            border: 2px solid transparent;
        }

        .pos-product-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .pos-product-image-wrapper {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .pos-product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pos-qty-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #dc3545;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.4);
        }

        .pos-product-info {
            padding: 12px;
            text-align: center;
        }

        .pos-product-name {
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 36px;
        }

        .pos-product-price {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
        }

        /* Cart Styles */
        .pos-customer-row {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .pos-customer-select {
            flex: 1;
        }

        .pos-customer-select select {
            width: 100%;
        }

        .pos-due-badge {
            font-size: 12px;
            color: #dc3545;
            font-weight: 600;
            margin-top: 4px;
        }

        .pos-action-btns {
            display: flex;
            gap: 6px;
        }

        .pos-action-btn {
            width: 38px;
            height: 38px;
            border-radius: 6px;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pos-action-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .pos-action-btn.btn-primary {
            background: #667eea;
        }

        .pos-action-btn.btn-info {
            background: #17a2b8;
        }

        .pos-action-btn.btn-secondary {
            background: #6c757d;
        }

        /* Cart Table */
        .pos-cart-wrapper {
            max-height: 280px;
            overflow-y: auto;
            margin-bottom: 0;
        }

        .pos-cart-wrapper::-webkit-scrollbar {
            width: 5px;
        }

        .pos-cart-wrapper::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .pos-cart-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .pos-cart-table {
            width: 100%;
            font-size: 12px;
        }

        .pos-cart-table th {
            background: #f8f9fa;
            padding: 8px 4px;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .pos-cart-table td {
            padding: 8px 4px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        /* Totals Section */
        .pos-totals {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
        }

        .pos-totals table {
            width: 100%;
            margin: 0;
        }

        .pos-totals td {
            padding: 6px 0;
            font-size: 13px;
        }

        .pos-totals tr:last-child td {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
            padding-top: 12px;
            border-top: 2px solid #dee2e6;
        }

        /* Coupon Input */
        .pos-coupon-row {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .pos-coupon-input {
            flex: 1;
            height: 38px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0 12px;
        }

        .pos-coupon-btn {
            height: 38px;
            padding: 0 20px;
            border-radius: 6px;
            border: none;
            background: #28a745;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pos-coupon-btn:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        /* Action Buttons */
        .pos-action-buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 16px;
        }

        .pos-main-btn {
            height: 50px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .pos-main-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .pos-btn-hold {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .pos-btn-multiple {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .pos-btn-cash {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .pos-btn-payall {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Delivery & Address Sections */
        .pos-delivery-section {
            padding: 0;
            background: transparent;
        }

        .pos-delivery-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        /* Modern Delivery Method Cards */
        .delivery-method-card {
            position: relative;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
        }

        .delivery-method-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .delivery-method-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .delivery-method-card:hover::before {
            transform: scaleY(1);
        }

        .delivery-method-card.active {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
        }

        .delivery-method-card.active::before {
            transform: scaleY(1);
        }

        .delivery-method-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .delivery-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .delivery-method-card.active .delivery-icon-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .delivery-icon-wrapper i {
            color: #667eea;
            transition: all 0.3s ease;
        }

        .delivery-method-card.active .delivery-icon-wrapper i {
            color: white;
        }

        .delivery-content {
            flex: 1;
        }

        .delivery-title {
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }

        .delivery-method-card.active .delivery-title {
            color: #667eea;
        }

        .delivery-description {
            font-size: 12px;
            color: #718096;
            margin: 0;
        }

        .delivery-check {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .delivery-method-card.active .delivery-check {
            background: #667eea;
            border-color: #667eea;
        }

        .delivery-check i {
            font-size: 12px;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .delivery-method-card.active .delivery-check i {
            opacity: 1;
        }

        .pos-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pos-section-title i {
            color: #667eea;
        }

        /* Order Note Textarea Enhancement */
        textarea.form-control:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1) !important;
        }

        /* Confirm Order Button Enhancement */
        #confirmOrderBtn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        #confirmOrderBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

        #confirmOrderBtn:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .pos-products-row {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }

        @media (max-width: 1200px) {
            .pos-modern-container {
                flex-direction: column;
                height: auto;
                max-height: none;
            }

            .pos-left-cart {
                flex: none;
                max-height: none;
            }

            .pos-right-products {
                max-height: 600px;
            }

            .pos-products-row {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .pos-action-buttons {
                grid-template-columns: repeat(2, 1fr);
            }

            .pos-products-row {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
    </style>
@endsection

@section('content')
    <div class="pos-modern-container ">
        <!-- Left Panel: Cart & Checkout -->
        <div class="pos-left-cart ">
            <form action="{{ route('PosPlaceOrder') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Customer Selection Card -->
                <div class="pos-card">
                    <div class="pos-card-body">
                        <div class="pos-customer-row">
                            <div class="pos-customer-select">
                                <select class="form-control" name="customer_id" onchange="getSavedAddress(this.value)"
                                    data-toggle="select2">
                                    <option value="">🚶 Walk-in Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} (@if ($customer->email)
                                                {{ $customer->email }}@else{{ $customer->phone }}
                                            @endif)</option>
                                    @endforeach
                                </select>
                                {{-- <div class="pos-due-badge">Previous Due: -0.00</div> --}}
                            </div>
                            <div class="pos-action-btns">
                                {{-- <a href="{{ route('ViewAllInvoices') }}" class="pos-action-btn btn-primary"
                                    title="Invoices">
                                    <i class="fa fa-print"></i>
                                </a> --}}
                                {{-- <button type="button" class="pos-action-btn btn-info" data-toggle="modal"
                                    data-target="#exampleModal" title="New Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                                <button type="button" class="pos-action-btn btn-secondary" data-toggle="modal"
                                    data-target="#exampleModal2" title="New Address">
                                    <i class="fa fa-truck"></i>
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Items Card -->
                <div class="pos-card">
                    <div class="pos-card-body" style="padding: 0;">
                        <div class="pos-cart-wrapper">
                            <table class="pos-cart-table">
                                <thead>
                                    <tr>
                                        <th style="width: 6%;">SL</th>
                                        <th style="width: 12%;">Image</th>
                                        <th style="width: 25%;">Product</th>
                                        <th style="width: 12%;">Price</th>
                                        <th style="width: 12%;">QTY</th>
                                        <th style="width: 13%;">Disc</th>
                                        <th style="width: 14%;">Subtotal</th>
                                        <th style="width: 6%;">✕</th>
                                    </tr>
                                </thead>
                                <tbody class="cart_items">
                                    @include('pos.cart_items')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Totals & Coupon Card -->
                <div class="pos-card">
                    <div class="pos-card-body">
                        {{-- <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="sendMessage">
                            <label class="custom-control-label" for="sendMessage">Send Message to Customer</label>
                            <a href="#" class="float-right text-primary" style="font-size: 13px;"><i
                                    class="fa fa-file-alt mr-1"></i>T&C</a>
                        </div> --}}

                        <div class="pos-totals mt-3">
                            <table class="cart_calculation">
                                @include('pos.cart_calculation')
                            </table>
                        </div>

                        {{-- <div class="pos-coupon-row">
                            <input type="text" id="coupon_code" value="{{ session('coupon') }}" class="pos-coupon-input"
                                placeholder="🎟️ Enter Coupon Code" onkeyup="autoRemoveCouponIfEmpty(this)" />
                            <button type="button" class="pos-coupon-btn" onclick="applyCoupon()">Apply</button>
                        </div> --}}

                        {{-- <div class="pos-action-buttons">
                            <button type="button" class="pos-main-btn pos-btn-hold">
                                <i class="fa fa-pause-circle"></i> Hold
                            </button>
                            <button type="button" class="pos-main-btn pos-btn-multiple">
                                <i class="fa fa-copy"></i> Multiple
                            </button>
                            <button type="button" class="pos-main-btn pos-btn-cash">
                                <i class="fa fa-money-bill-wave"></i> Cash
                            </button>
                            <button type="button" class="pos-main-btn pos-btn-payall">
                                <i class="fa fa-credit-card"></i> Pay All
                            </button>
                        </div> --}}
                    </div>
                </div>

                <!-- Delivery & Address Card -->
                <div class="pos-card">
                    <div class="pos-card-body">
                        <div class="pos-delivery-section">
                            <div class="pos-section-title">
                                <i class="fas fa-shipping-fast"></i>
                                Delivery Method
                            </div>
                            <div class="pos-delivery-options">
                                <!-- Home Delivery Card -->
                                <label class="delivery-method-card" for="home_delivery" id="home_delivery_card">
                                    <input type="radio" id="home_delivery" name="delivery_method"
                                        onchange="changeOfDeliveryMetod(1)" value="1"
                                        @if (old('delivery_method') == '1') checked @endif />
                                    <div class="delivery-icon-wrapper">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="delivery-content">
                                        <div class="delivery-title">Home Delivery</div>
                                        <p class="delivery-description">Deliver to customer address</p>
                                    </div>
                                    <div class="delivery-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </label>

                                <!-- Store Pickup Card -->
                                <label class="delivery-method-card" for="store_pickup" id="store_pickup_card">
                                    <input type="radio" id="store_pickup" name="delivery_method"
                                        onchange="changeOfDeliveryMetod(2)" value="2"
                                        @if (old('delivery_method') == '2' || is_null(old('delivery_method'))) checked @endif />
                                    <div class="delivery-icon-wrapper">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="delivery-content">
                                        <div class="delivery-title">Store Pickup</div>
                                        <p class="delivery-description">Customer picks up from store</p>
                                    </div>
                                    <div class="delivery-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="saved_address mt-3">
                            {{-- render saved address here based on customer selection --}}
                        </div>

                        <div class="shipping-address-table mt-3">
                            <div class="shipping-section">
                                <div class="section-title">
                                    <i class="fa fa-truck mr-1"></i>
                                    <span id="shipping-tab-text">Shipping</span>
                                </div>
                                <div class="pt-3">
                                    @include('pos.shipping_form')
                                </div>
                            </div>

                            <div class="billing-section mt-3">
                                <div class="section-title">
                                    <i class="fa fa-file-invoice mr-1"></i>
                                    Billing
                                </div>
                                <div class="pt-3">
                                    @include('pos.billing_form')
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="pos-section-title">
                                <i class="fas fa-sticky-note"></i>
                                Order Note
                            </div>
                            <textarea class="form-control" name="special_note" rows="2"
                                placeholder="Add special instructions or notes for this order..."
                                style="border-radius: 8px; border: 2px solid #e2e8f0; transition: border-color 0.3s;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-3"
                            style="height: 45px; font-weight: 600;" id="confirmOrderBtn">
                            <i class="fa fa-check-circle mr-2"></i>Confirm Order
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Panel: Products -->
        <div class="pos-right-products">
            <!-- Product Filters -->
            <div class="pos-filters">
                @include('pos.product_search_form')
            </div>

            <!-- Products Grid -->
            <div class="pos-products-grid">
                <div class="pos-products-row live_search">
                    {{-- Live search results will be rendered here --}}
                    @include('pos.live_search_products')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('pos.customer_create_modal')

    <!-- Modal -->
    @include('pos.customer_address_modal')

    <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="productVariantForm" name="productVariantForm" class="form-horizontal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="variantModalLabel">Select Product Varinat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="flag_slug" id="flag_slug">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" id="variant_product_name" readonly>
                            <input type="hidden" class="form-control" id="variant_product_id">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Select Color</label>
                                    <select class="form-control" onchange="checkVariant()" id="variant_color_id">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Select Size</label>
                                    <select class="form-control" onchange="checkVariant()" id="variant_size_id">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Product Price</label>
                                    <input type="text" class="form-control" id="variant_price" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="text" class="form-control" id="variant_stock" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="purchase_product_warehouse_id"
                                        id="purchase_product_warehouse_id">
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="purchase_product_warehouse_room_id"
                                        id="purchase_product_warehouse_room_id">
                                        <option value="">Select Warehouse Room</option>
                                        @foreach ($warehouse_rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="purchase_product_warehouse_room_cartoon_id"
                                        id="purchase_product_warehouse_room_cartoon_id">
                                        <option value="">Select Room Cartoon</option>
                                        @foreach ($room_cartoons as $cartoon)
                                            <option value="{{ $cartoon->id }}">{{ $cartoon->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}







                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="variantAddToCart()"
                            class="btn btn-primary variant_modal_footer_btn">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ asset('tenant/admin/assets') }}/plugins/select2/select2.min.js"></script>
    <script>
        $('[data-toggle="select2"]').select2();

        // Apply invalid styling to Select2 elements after initialization
        $('select.is-invalid[data-toggle="select2"]').each(function() {
            var $select = $(this);
            var $container = $select.next('.select2-container');
            if ($container.length) {
                $container.addClass('is-invalid');
                $container.find('.select2-selection').addClass('is-invalid');
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global variable for dynamic coupon price tracking
        var couponPrice = {{ session('pos_discount', 0) }};

        // Handle delivery method card selection
        $(document).ready(function() {
            // Add click handler for delivery method cards
            $('.delivery-method-card').on('click', function() {
                $('.delivery-method-card').removeClass('active');
                $(this).addClass('active');
                // Check the radio and trigger change to run existing onchange logic
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            // Handle initial state if a radio is checked: apply active class and trigger change
            var $checked = $('input[name="delivery_method"]:checked');
            if ($checked.length) {
                $checked.closest('.delivery-method-card').addClass('active');
                // trigger change to run existing logic (hide/show fields)
                $checked.trigger('change');
            }
        });

        function changeOfDeliveryMetod(value) {

            // Update card visual states
            $('.delivery-method-card').removeClass('active');
            if (value == 1) {
                $('#home_delivery_card').addClass('active');
            } else if (value == 2) {
                $('#store_pickup_card').addClass('active');
            }

            var formData = new FormData();
            formData.append("delivery_method", value);
            formData.append("shipping_district_id", $("#shipping_district_id").val());

            // Handle UI changes based on delivery method
            if (value == 2) { // Store Pickup
                // Hide saved address section
                $('.saved_address').hide();

                // Hide billing section entirely for pickup (billing not required)
                $('.billing-section').hide();

                // Update shipping label to "Customer Details"
                $('#shipping-tab-text').text('Customer Details');

                // Hide specific shipping fields - keep only name, phone, email, customer type, and outlet
                $('#shipping_address').closest('tr').hide();
                $('#shipping_district_id').closest('tr').hide();
                $('#shipping_thana_id').closest('tr').hide();
                $('#shipping_postal_code').closest('tr').hide();
                $('#reference_code').closest('tr').hide();
                // Hide outlet selection for store pickup (not needed)
                $('#outlet_id').closest('tr').hide();

            } else { // Home Delivery (value == 1)
                // Show saved address section
                $('.saved_address').show();

                // Show billing section
                $('.billing-section').show();

                // Restore shipping label
                $('#shipping-tab-text').text('Shipping');

                // Show all shipping fields
                $('#shipping_address').closest('tr').show();
                $('#shipping_district_id').closest('tr').show();
                $('#shipping_thana_id').closest('tr').show();
                $('#shipping_postal_code').closest('tr').show();
                $('#reference_code').closest('tr').show();
                // Show outlet selection for home delivery
                $('#outlet_id').closest('tr').show();
            }

            $.ajax({
                data: formData,
                url: "{{ route('ChangeDeliveryMethod') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.cart_calculation').html(data.cart_calculation);
                    // Sync coupon price with current session value if still applied
                    if ($("#coupon_code").val().trim() !== '') {
                        // Coupon is still applied, keep the current couponPrice value
                        // Don't reset it here
                    } else {
                        // No coupon applied, reset to 0
                        couponPrice = 0;
                    }
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }

        function applySavedAddress(slug) {
            // Store currently selected delivery method before making changes
            var selectedDeliveryMethod = $('input[name="delivery_method"]:checked').val();

            // fetching the values
            var name = $("#saved_address_name_" + slug).val();
            var phone = $("#saved_address_phone_" + slug).val();
            var address = $("#saved_address_line_" + slug).val();
            var district = $("#saved_address_district_" + slug).val();
            var upazila = $("#saved_address_upazila_" + slug).val();
            var post_code = $("#saved_address_post_code_" + slug).val();

            // setting the values
            $("#shipping_name").val(name);
            $("#shipping_phone").val(phone);
            $("#shipping_address").val(address);
            $("#shipping_district_id option:contains('" + district + "')").prop("selected", true).change();
            setTimeout(function() {
                $("#shipping_thana_id option:contains('" + upazila + "')").prop("selected", true).change();

                // Restore the delivery method selection after thana is updated
                if (selectedDeliveryMethod) {
                    $('input[name="delivery_method"][value="' + selectedDeliveryMethod + '"]').prop('checked',
                        true);
                    // Reapply the delivery method UI changes
                    changeOfDeliveryMetod(selectedDeliveryMethod);
                }
            }, 1000);
            $("#shipping_postal_code").val(post_code);

            // Also restore delivery method immediately in case the timeout doesn't work
            if (selectedDeliveryMethod) {
                setTimeout(function() {
                    $('input[name="delivery_method"][value="' + selectedDeliveryMethod + '"]').prop('checked',
                        true);
                    changeOfDeliveryMetod(selectedDeliveryMethod);
                }, 1200);
            }
        }

        function sameShippingBilling() {

            if ($("#flexCheckChecked").prop('checked') == true) {
                var shppingName = $("#shipping_name").val();
                var shppingPhone = $("#shipping_phone").val();
                var shppingAdress = $("#shipping_address").val();
                var shppingDistrict = $("#shipping_district_id").val();
                var shippingThana = $("#shipping_thana_id").val();
                var shppingPostalCode = $("#shipping_postal_code").val();

                if (shppingName == '' || shppingName == null) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Write Shipping Customer Name");
                    $("#flexCheckChecked").prop("checked", false);
                    return false;
                }
                if (shppingPhone == '' || shppingPhone == null) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Write Shipping Customer Phone");
                    $("#flexCheckChecked").prop("checked", false);
                    return false;
                }
                if (shppingAdress == '' || shppingAdress == null) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Write Shipping Address");
                    $("#flexCheckChecked").prop("checked", false);
                    return false;
                }
                if (!shppingDistrict || shppingDistrict == "" || shppingDistrict == null) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Select Shipping District");
                    $("#flexCheckChecked").prop("checked", false);
                    return false;
                }
                if (shippingThana == '' || shippingThana == null) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Select Shipping Thana");
                    $("#flexCheckChecked").prop("checked", false);
                    return false;
                }

                $("#billing_name").val(shppingName);
                $("#billing_phone").val(shppingPhone);
                $("#billing_address").val(shppingAdress);
                $("#billing_district_id").val(shppingDistrict).change();
                $("#billing_postal_code").val(shppingPostalCode);

                var district_id = shppingDistrict;
                $("#billing_thana_id").html('');

                $.ajax({
                    url: "{{ route('DistrictWiseThana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#billing_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>');
                        $.each(result.data, function(key, value) {
                            $("#billing_thana_id").append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        $("#billing_thana_id").val(shippingThana).change();
                        $(".order-review-summary").html(result.checkoutTotalAmount);
                    }
                });

            } else {
                $("#billing_name").val('');
                $("#billing_phone").val('');
                $("#billing_address").val('');
                $("#billing_district_id").val('').change();
                $("#billing_thana_id").html('');
                $('#billing_thana_id').html('<option data-display="Select One" value="">Select Thana</option>');
                $("#billing_postal_code").val('');
            }

        }

        // If the checkbox was checked from previous submission, apply copy on load
        $(document).ready(function() {
            if ($('#flexCheckChecked').prop('checked')) {
                sameShippingBilling();
            }
        });

        function getSavedAddress(user_id) {
            $.get("{{ route('GetSavedAddress', '') }}" + '/' + user_id, function(data) {
                $('.saved_address').html(data.saved_address);
                $('#shipping_name').val(data.user_info.name);
                $('#shipping_phone').val(data.user_info.phone);
                $('#shipping_email').val(data.user_info.email);

                $('#billing_name').val(data.user_info.name);
                $('#billing_phone').val(data.user_info.phone);
            })
        }

        function liveSearchProduct() {

            var productName = $("#search_keyword").val();
            var productCategoryId = $("#product_category_id").val();
            var productBrandId = $("#product_brand_id").val();

            var formData = new FormData();
            formData.append("product_name", productName);
            formData.append("category_id", productCategoryId);
            formData.append("brand_id", productBrandId);

            $.ajax({
                data: formData,
                url: "{{ route('ProductLiveSearch') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.live_search').html(data.searchResults);
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });
        }

        function showVariant(product_id) {

            var formData = new FormData();
            formData.append("product_id", product_id);

            $.ajax({
                data: formData,
                url: "{{ route('GetProductVariantsPos') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('#productVariantForm').trigger("reset");
                    $('#variantModal').modal('show');
                    $("#variant_product_name").val(data.product.name + ' (' + data.product.code + ')');
                    $("#variant_product_id").val(data.product.id);

                    // colors
                    $('#variant_color_id').html('<option value="">--Select Color--</option>');
                    $.each(data.colors, function(key, value) {
                        $("#variant_color_id").append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });

                    // size
                    $('#variant_size_id').html('<option value="">--Select Size--</option>');
                    $.each(data.sizes, function(key, value) {
                        $("#variant_size_id").append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }

        function checkVariant() {

            var formData = new FormData();
            formData.append("product_id", $("#variant_product_id").val());
            formData.append("color_id", $("#variant_color_id").val());
            formData.append("size_id", $("#variant_size_id").val());

            $.ajax({
                data: formData,
                url: "{{ route('CheckProductVariant') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (Number(data.price) > 0 && Number(data.stock) > 0) {
                        $("#variant_price").val(Number(data.price));
                        $("#variant_stock").val(Number(data.stock));
                        console.log(data);
                        $(".variant_modal_footer_btn").css('display', 'inline-block')
                    } else {
                        $("#variant_price").val(Number(0));
                        $("#variant_stock").val(Number(0));
                        $(".variant_modal_footer_btn").css('display', 'none')
                    }

                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }

        function variantAddToCart() {
            var variant_product_id = $("#variant_product_id").val();
            var variant_color_id = $("#variant_color_id").val();
            var variant_size_id = $("#variant_size_id").val();

            // Ensure color and size are selected
            if (variant_color_id === '' || variant_color_id === null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1500;
                toastr.error('Please select a color.');
                return;
            }

            if (variant_size_id === '' || variant_size_id === null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1500;
                toastr.error('Please select a size.');
                return;
            }

            var purchase_product_warehouse_id = $("#purchase_product_warehouse_id").val();
            var purchase_product_warehouse_room_id = $("#purchase_product_warehouse_room_id").val();
            var purchase_product_warehouse_room_cartoon_id = $("#purchase_product_warehouse_room_cartoon_id").val();

            if (purchase_product_warehouse_id == '') {
                purchase_product_warehouse_id = 0;
            }
            if (purchase_product_warehouse_room_id == '') {
                purchase_product_warehouse_room_id = 0;
            }
            if (purchase_product_warehouse_room_cartoon_id == '') {
                purchase_product_warehouse_room_cartoon_id = 0;
            }

            addToCart(variant_product_id, variant_color_id, variant_size_id, purchase_product_warehouse_id,
                purchase_product_warehouse_room_id, purchase_product_warehouse_room_cartoon_id);
            $('#variantModal').modal('hide');
        }

        function addToCart(product_id, color_id, size_id, purchase_product_warehouse_id, purchase_product_warehouse_room_id,
            purchase_product_warehouse_room_cartoon_id) {

            // Ensure all parameters have default values (0) if undefined
            product_id = product_id || 0;
            color_id = color_id || 0;
            size_id = size_id || 0;
            purchase_product_warehouse_id = purchase_product_warehouse_id || 0;
            purchase_product_warehouse_room_id = purchase_product_warehouse_room_id || 0;
            purchase_product_warehouse_room_cartoon_id = purchase_product_warehouse_room_cartoon_id || 0;

            var formData = new FormData();
            formData.append("product_id", product_id);
            formData.append("color_id", color_id);
            formData.append("size_id", size_id);

            formData.append("purchase_product_warehouse_id", purchase_product_warehouse_id);
            formData.append("purchase_product_warehouse_room_id", purchase_product_warehouse_room_id);
            formData.append("purchase_product_warehouse_room_cartoon_id", purchase_product_warehouse_room_cartoon_id);

            $.ajax({
                data: formData,
                url: "{{ url('admin/add/to/cart') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1500;
                    toastr.success('Item added to cart');
                    $('.cart_items').html(data.rendered_cart);
                    $('.cart_calculation').html(data.cart_calculation);
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }

        function applyCoupon() {
            var couponCode = $("#coupon_code").val().trim();
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.options.timeOut = 1000;

            if (couponCode === '') {
                // Remove coupon from cart if input is empty
                $.ajax({
                    url: "{{ route('RemoveCoupon') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success("Coupon removed from cart.");
                            $('.cart_calculation').html(data.cart_calculation);
                            // Update global coupon price variable
                            couponPrice = 0;
                        }
                    },
                    error: function() {
                        toastr.error("Failed to remove coupon.");
                    }
                });
                return;
            }

            var formData = new FormData();
            formData.append("coupon_code", couponCode);
            $.ajax({
                data: formData,
                url: "{{ route('ApplyCoupon') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                        $('.cart_calculation').html(data.cart_calculation);
                        $("input[name='delivery_method']").prop("checked", false);
                        // Update global coupon price variable from the response
                        if (data.coupon_discount) {
                            couponPrice = parseFloat(data.coupon_discount);
                        }
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }



        $(document).ready(function() {

            // Initialize delivery method UI state
            var selectedDeliveryMethod = $('input[name="delivery_method"]:checked').val();
            if (selectedDeliveryMethod == 2) {
                // If store pickup is already selected, apply the UI changes
                changeOfDeliveryMetod(2);
            }

            $('#shipping_district_id').on('change', function() {
                var district_id = this.value;
                $("#shipping_thana_id").html('');
                $.ajax({
                    url: "{{ route('DistrictWiseThana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#shipping_thana_id').html(
                            '<option data-display="Select One" value="">Select One</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#shipping_thana_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('.cart_calculation').html(result.cart_calculation);
                        $("input[name='delivery_method']").prop("checked", false);
                        // Sync coupon price with current session value if still applied
                        if ($("#coupon_code").val().trim() !== '') {
                            // Coupon is still applied, keep the current couponPrice value
                            // Don't reset it here
                        } else {
                            // No coupon applied, reset to 0
                            couponPrice = 0;
                        }
                    }
                });
            });

            $('#billing_district_id').on('change', function() {
                var district_id = this.value;
                $("#billing_thana_id").html('');
                $.ajax({
                    url: "{{ route('DistrictWiseThana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#billing_thana_id').html(
                            '<option data-display="Select One" value="">Select One</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#billing_thana_id").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });

            $('#customer_address_district_id').on('change', function() {
                var district_id = this.value;
                $("#customer_address_thana_id").html('');
                $.ajax({
                    url: "{{ route('DistrictWiseThanaByName') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#customer_address_thana_id').html(
                            '<option data-display="Select One" value="">Select One</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#customer_address_thana_id").append('<option value="' +
                                value.name +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });

        // Handle customer creation form submission
        $('#customerCreateForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.invalid-feedback').hide();
            $('.form-control').removeClass('is-invalid');

            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Creating...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Success - close modal and refresh customer dropdown
                    $('#exampleModal').modal('hide');
                    $('#customerCreateForm')[0].reset();
                    toastr.success('New Customer Created Successfully!');

                    // Optionally refresh the page or reload customer dropdown
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.siblings('.invalid-feedback').text(messages[0]).show();
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Check if there are validation errors for customer creation and reopen modal
        @if ($errors->any())
            @if (old('customer_name') || old('customer_phone') || old('customer_email') || old('password'))
                $('#exampleModal').modal('show');
            @endif
        @endif


        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('PosPlaceOrder') }}"]');
            const confirmBtn = document.getElementById('confirmOrderBtn');
            if (form && confirmBtn) {
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to place this order?')) {
                            confirmBtn.disabled = true;
                            confirmBtn.innerHTML = 'Processing...';
                            form.dataset.confirmed = 'true';
                            form.submit();
                        }
                    } else {
                        confirmBtn.disabled = true;
                        confirmBtn.innerHTML = 'Processing...';
                    }
                });
            }
        });


        // Handle customer address creation form submission
        $('#exampleModal2 form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            // Clear previous errors
            form.find('.invalid-feedback').hide();
            form.find('.form-control, .btn-check, select').removeClass('is-invalid');

            var submitBtn = form.find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#exampleModal2').modal('hide');
                    form[0].reset();
                    toastr.success('Address added successfully!');
                    // Optionally refresh address/customer dropdown here
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            var input = form.find('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            // For radio buttons
                            if (input.attr('type') === 'radio') {
                                input.closest('.form-group').find('.invalid-feedback').text(
                                    messages[0]).show();
                            } else {
                                input.siblings('.invalid-feedback').text(messages[0]).show();
                            }
                        });
                        // Reopen modal if closed
                        $('#exampleModal2').modal('show');
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Show server-side validation errors for shipping and billing address fields
        @if ($errors->any())
            $(function() {
                var errorMap = @json($errors->toArray());
                $.each(errorMap, function(field, messages) {
                    var input = $('[name="' + field + '"]');
                    if (input.length) {
                        input.addClass('is-invalid');
                        input.closest('td, .form-group').find('.invalid-feedback').text(messages[0]).show();
                    }
                });
            });
        @endif

        function autoRemoveCouponIfEmpty(input) {
            var couponCode = input.value.trim();
            if (couponCode === '') {
                $.ajax({
                    url: "{{ route('RemoveCoupon') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success("Coupon removed from cart.");
                            $('.cart_calculation').html(data.cart_calculation);
                            // Update global coupon price variable
                            couponPrice = 0;
                        }
                    },
                    error: function() {
                        toastr.error("Failed to remove coupon.");
                    }
                });
            }
        }
    </script>

    <!-- On successful order, open invoice in new tab and clear form -->
    @if (session('invoice_url'))
        <script>
            // Open invoice immediately when page loads
            const invoiceUrl = "{{ session('invoice_url') }}";
            console.log('Opening invoice URL:', invoiceUrl);

            // Open invoice in new tab immediately
            // Try to open invoice in new tab immediately
            let win = window.open(invoiceUrl, '_blank');
            if (!win || win.closed || typeof win.closed == 'undefined') {
                // If blocked, try to open on user interaction
                function openOnUserAction() {
                    let win2 = window.open(invoiceUrl, '_blank');
                    if (win2) {
                        win2.focus();
                        document.removeEventListener('click', openOnUserAction);
                        document.removeEventListener('keydown', openOnUserAction);
                    }
                }
                document.addEventListener('click', openOnUserAction);
                document.addEventListener('keydown', openOnUserAction);
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Show success message
                toastr.success('Order placed successfully! Invoice opened in new tab.', 'Success');

                // Clear form
                const form = document.querySelector('form[action="{{ route('PosPlaceOrder') }}"]');
                if (form) {
                    form.reset();
                    // Also reset Select2 dropdowns
                    $('[data-toggle="select2"]').val(null).trigger('change');
                }
                const confirmBtn = document.getElementById('confirmOrderBtn');
                if (confirmBtn) {
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = 'Confirm Order';
                }
                // Reset global coupon price after successful order
                couponPrice = 0;
            });
        </script>
    @endif
@endsection
