@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <style>
        .pagination {
            justify-content: center;
            align-items: center;
        }
        
        /* Delivered Products List */
        .delivered-products-section {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 24px;
            border-radius: 12px 12px 0 0;
            margin: -24px -24px 24px -24px;
        }
        
        .section-header h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        
        .product-list-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        
        .product-list-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .product-image-container {
            flex-shrink: 0;
        }
        
        .product-image-container img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .product-info {
            flex-grow: 1;
        }
        
        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .product-meta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: #6b7280;
        }
        
        .meta-item i {
            color: #667eea;
        }
        
        .btn-write-review {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-write-review:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .empty-state-icon i {
            font-size: 36px;
            color: white;
        }
        
        .empty-state h5 {
            color: #6b7280;
            font-size: 18px;
            margin-bottom: 8px;
        }
        
        .empty-state p {
            color: #9ca3af;
            font-size: 14px;
        }
        
        /* Review Modal */
        .review-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        .review-modal.active {
            display: flex;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 24px;
            border-radius: 16px 16px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        
        .btn-close-modal {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-close-modal:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-product-info {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 24px;
        }
        
        .modal-product-info img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .modal-product-details h6 {
            margin: 0 0 4px 0;
            font-size: 16px;
            color: #1f2937;
        }
        
        .modal-product-details p {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .rating-options {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }
        
        .rating-option {
            position: relative;
        }
        
        .rating-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .rating-label {
            display: block;
            padding: 12px 8px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 24px;
        }
        
        .rating-label .rating-text {
            display: block;
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .rating-option input[type="radio"]:checked + .rating-label {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        }
        
        .rating-label:hover {
            border-color: #667eea;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .char-counter {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .product-list-item {
                flex-direction: column;
                text-align: center;
            }
            
            .product-meta {
                justify-content: center;
            }
            
            .rating-options {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .modal-content {
                width: 95%;
            }
        }
    </style>
@endsection

@push('site-seo')
    @php
        // using shared $generalInfo provided by AppServiceProvider
    @endphp
    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif
@endpush

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.customer_panel.layouts.partials.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('tenant/frontend') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('tenant.frontend.pages.customer_panel.layouts.partials.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <!-- Delivered Products Section -->
                    <div class="delivered-products-section mt-2">
                        <div class="section-header">
                            <h5><i class="fi-rr-box-open"></i> {{ __('customer.delivered_products') }}</h5>
                        </div>

                        @if (count($deliveredProducts) > 0)
                            @foreach ($deliveredProducts as $product)
                                <div class="product-list-item">
                                    <div class="product-image-container">
                                        <img src="{{ url($product->product_image) }}" alt="{{ $product->product_name }}">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-name">{{ $product->product_name }}</h6>
                                        <div class="product-meta">
                                            <span class="meta-item">
                                                <i class="fi-rr-document"></i>
                                                {{ __('customer.order_number') }}: <strong>{{ $product->order_no }}</strong>
                                            </span>
                                            <span class="meta-item">
                                                <i class="fi-rr-calendar"></i>
                                                {{ __('customer.delivered_on') }}: {{ date('M d, Y', strtotime($product->delivered_date)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <button class="btn-write-review" onclick="openReviewModal({{ $product->product_id }}, '{{ addslashes($product->product_name) }}', '{{ url($product->product_image) }}', '{{ $product->order_no }}')">
                                        <i class="fi-rr-edit"></i>
                                        {{ __('customer.write_review') }}
                                    </button>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                {{ $deliveredProducts->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fi-rr-box-open"></i>
                                </div>
                                <h5>{{ __('customer.no_delivered_products') }}</h5>
                                <p>{{ __('customer.no_delivered_products') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Review Modal -->
                    <div class="review-modal" id="reviewModal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5><i class="fi-rr-edit"></i> {{ __('customer.write_review') }}</h5>
                                <button class="btn-close-modal" onclick="closeReviewModal()">
                                    <i class="fi-rr-cross"></i>
                                </button>
                            </div>
                            <form action="{{ url('submit/review/from/panel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" id="modal_product_id">
                                <div class="modal-body">
                                    <div class="modal-product-info">
                                        <img id="modal_product_image" src="" alt="">
                                        <div class="modal-product-details">
                                            <h6 id="modal_product_name"></h6>
                                            <p><i class="fi-rr-document"></i> {{ __('customer.order_number') }}: <span id="modal_order_no"></span></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ __('customer.rating') }} *</label>
                                        <div class="rating-options">
                                            <div class="rating-option">
                                                <input type="radio" name="rating" value="1" id="rating1" required>
                                                <label for="rating1" class="rating-label">
                                                    ★
                                                    <span class="rating-text">{{ __('customer.very_bad') }}</span>
                                                </label>
                                            </div>
                                            <div class="rating-option">
                                                <input type="radio" name="rating" value="2" id="rating2">
                                                <label for="rating2" class="rating-label">
                                                    ★★
                                                    <span class="rating-text">{{ __('customer.poor') }}</span>
                                                </label>
                                            </div>
                                            <div class="rating-option">
                                                <input type="radio" name="rating" value="3" id="rating3">
                                                <label for="rating3" class="rating-label">
                                                    ★★★
                                                    <span class="rating-text">{{ __('customer.average') }}</span>
                                                </label>
                                            </div>
                                            <div class="rating-option">
                                                <input type="radio" name="rating" value="4" id="rating4">
                                                <label for="rating4" class="rating-label">
                                                    ★★★★
                                                    <span class="rating-text">{{ __('customer.great') }}</span>
                                                </label>
                                            </div>
                                            <div class="rating-option">
                                                <input type="radio" name="rating" value="5" id="rating5">
                                                <label for="rating5" class="rating-label">
                                                    ★★★★★
                                                    <span class="rating-text">{{ __('customer.excellent') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ __('customer.review_text') }} *</label>
                                        <textarea name="review_text" class="form-control" rows="5" maxlength="500" 
                                            placeholder="{{ __('customer.share_your_experience') }}" 
                                            required
                                            oninput="updateCharCounter(this)"></textarea>
                                        <div class="char-counter">
                                            <span id="charCount">0</span> / 500
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-submit">
                                        <i class="fi-rr-paper-plane"></i>
                                        {{ __('customer.submit_review') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dashboard-product-review mgTop24 mb-4">
                        <div class="dashboard-head-widget style-2" style="margin-bottom: 32px">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.product_reviews') }}</h5>
                        </div>
                        <div class="product-review-card-inner">

                            @if (count($productReviews) > 0)
                                @foreach ($productReviews as $productReview)
                                    <div class="single-product-review-card">
                                        <div class="product-review-card-info">
                                            <div class="product-review-card-img">
                                                <img alt=""
                                                    src="{{ url( $productReview->image) }}">
                                            </div>
                                            <h6>{{ $productReview->name }}</h6>
                                        </div>
                                        <div class="product-review-main text-center">
                                            <ul class="product-review-list">
                                                @for ($i = 1; $i <= $productReview->rating; $i++)
                                                    <li>
                                                        <img src="{{ url('tenant/frontend') }}/assets/images/icons/star.svg"
                                                            alt="#">
                                                    </li>
                                                @endfor
                                                @for ($i = 1; $i <= 5 - $productReview->rating; $i++)
                                                    <li>
                                                        <img src="{{ url('tenant/frontend') }}/assets/images/icons/star-light.svg"
                                                            alt="#">
                                                    </li>
                                                @endfor
                                            </ul>
                                            @if ($productReview->rating == 5)
                                                <span>Excellent</span>
                                            @elseif($productReview->rating == 4)
                                                <span>Great</span>
                                            @elseif($productReview->rating == 3)
                                                <span>Average</span>
                                            @elseif($productReview->rating = 2)
                                                <span>Poor</span>
                                            @else
                                                <span>Very Bad</span>
                                            @endif
                                        </div>
                                        <div class="product-review-text">
                                            <p>
                                                {{ $productReview->review }}
                                            </p>
                                            @if ($productReview->status == 0)
                                                <p class="text-info">Review Status: Pending</p>
                                            @else
                                                <p class="text-success">Review Status: Published</p>
                                            @endif
                                        </div>
                                        <div class="product-review-buttons-group">
                                            <button type="button"
                                                class="my-button product-review-btn edit-btn d-inline-block"
                                                data-widget-id="widget{{ $productReview->id }}"><i
                                                    class="fi-ss-pencil"></i></button>
                                            <a href="{{ url('delete/product/review') }}/{{ $productReview->id }}"
                                                class="product-review-btn delete-btn d-inline-block"><i
                                                    class="fi-ss-trash"></i></a>
                                        </div>

                                        <!-- Product Review Edit Form -->
                                        <style>
                                            .product-review-edit-from .nice-select {
                                                line-height: 45px !important;
                                            }
                                        </style>
                                        <div id="widget{{ $productReview->id }}"
                                            class="widget-box product-review-edit-widget" style="display: none">
                                            <form action="{{ url('update/product/review') }}" method="post"
                                                class="product-review-edit-from">
                                                @csrf
                                                <input type="hidden" name="product_review_id"
                                                    value="{{ $productReview->id }}">
                                                <div class="product-review-text">
                                                    <label class="form-label">Review Rating</label>
                                                    <select name="review_rating" required>
                                                        <option value="">Select One</option>
                                                        <option value="1"
                                                            @if ($productReview->rating == 1) selected @endif>★ Very Bad
                                                        </option>
                                                        <option value="2"
                                                            @if ($productReview->rating == 2) selected @endif>★★ Poor
                                                        </option>
                                                        <option value="3"
                                                            @if ($productReview->rating == 3) selected @endif>★★★ Average
                                                        </option>
                                                        <option value="4"
                                                            @if ($productReview->rating == 4) selected @endif>★★★★ Great
                                                        </option>
                                                        <option value="5"
                                                            @if ($productReview->rating == 5) selected @endif>★★★★★
                                                            Excellent</option>
                                                    </select>
                                                </div>
                                                <div class="product-review-text">
                                                    <label class="form-label">Review text</label>
                                                    <textarea name="review_text" class="form-control" required>{{ $productReview->review }}</textarea>
                                                </div>
                                                <div class="product-review-edit-widget-btn">
                                                    <button type="button" class="theme-btn secondary-btn btn btn-primary"
                                                        onclick="hideWidget({{ $productReview->id }})">Discard</button>
                                                    <button type="submit" class="theme-btn btn btn-primary">Update
                                                        review</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <h5 class="text-center">No Review Found</h5>
                            @endif


                        </div>
                    </div>

                    {{ $productReviews->links() }}

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script type="text/javascript">
        // Open review modal
        function openReviewModal(productId, productName, productImage, orderNo) {
            document.getElementById('modal_product_id').value = productId;
            document.getElementById('modal_product_name').textContent = productName;
            document.getElementById('modal_product_image').src = productImage;
            document.getElementById('modal_order_no').textContent = orderNo;
            
            // Reset form
            document.querySelector('#reviewModal form').reset();
            document.getElementById('charCount').textContent = '0';
            
            // Show modal
            document.getElementById('reviewModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close review modal
        function closeReviewModal() {
            document.getElementById('reviewModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Update character counter
        function updateCharCounter(textarea) {
            const count = textarea.value.length;
            document.getElementById('charCount').textContent = count;
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeReviewModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });

        // Old product review edit functions
        document.addEventListener("DOMContentLoaded", function() {
            var buttons = document.querySelectorAll(".my-button");
            var widgets = document.querySelectorAll(".widget-box");

            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    widgets.forEach(function(widget) {
                        widget.style.display = "none";
                    });

                    var widgetId = button.getAttribute("data-widget-id");
                    var targetWidget = document.getElementById(widgetId);

                    if (
                        targetWidget.style.display === "none" ||
                        targetWidget.style.display === ""
                    ) {
                        targetWidget.style.display = "block";
                    } else {
                        targetWidget.style.display = "none";
                    }
                });
            });
        });

        function hideWidget(id) {
            $("#widget" + id).css('display', 'none');
        }
    </script>
@endsection
