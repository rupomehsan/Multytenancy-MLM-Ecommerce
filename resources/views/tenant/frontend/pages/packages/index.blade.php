@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}
    <title>Package Products - {{ $generalInfo->company_name ?? 'TPMart' }}</title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
        {{-- using shared $generalInfo provided by AppServiceProvider --}}
        padding: 1.5rem;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        }

        .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        border-color: #667eea;
        }

        .package-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
        }

        .package-savings {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        margin-top: 1rem;
        }

        .view-package-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
        margin-top: 1rem;
        }

        .view-package-btn:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        </style>
    @endsection

    @section('content')
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white">Package Products</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items">
                                    <a class="text-white" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="breadcrumb__content--menu__items">
                                    <span class="text-white">Package Products</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start packages section -->
        <section class="section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section__heading text-center mb-40">
                            <h2 class="section__heading--maintitle">All Package Products</h2>
                            <p class="section__heading--desc">
                                Discover our carefully curated package deals with amazing savings
                            </p>
                        </div>
                    </div>
                </div>

                @if ($packages->count() > 0)
                    <div class="package-grid">
                        @foreach ($packages as $package)
                            @php
                                // Calculate package savings
                                $packageItems = DB::table('package_product_items')
                                    ->join('products', 'package_product_items.product_id', '=', 'products.id')
                                    ->where('package_product_items.package_product_id', $package->id)
                                    ->get();

                                $totalIndividualValue = $packageItems->sum(function ($item) {
                                    return ($item->discount_price > 0 ? $item->discount_price : $item->price) *
                                        $item->quantity;
                                });

                                $packagePrice =
                                    $package->discount_price > 0 ? $package->discount_price : $package->price;
                                $savings = $totalIndividualValue - $packagePrice;
                                $savingsPercentage =
                                    $totalIndividualValue > 0 ? round(($savings / $totalIndividualValue) * 100) : 0;
                            @endphp

                            <div class="package-card">
                                <div class="package-badge">
                                    📦 Package Deal
                                </div>

                                <div class="text-center mb-3">
                                    @if ($package->image)
                                        <img src="{{  $package->image }}" alt="{{ $package->name }}"
                                            style="max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div
                                            style="width: 150px; height: 150px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fi fi-rr-cube" style="font-size: 3rem; color: #94a3b8;"></i>
                                        </div>
                                    @endif
                                </div>

                                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: #1f2937;">
                                    {{ $package->name }}
                                </h3>

                                @if ($package->short_description)
                                    <p style="color: #6b7280; margin-bottom: 1rem; font-size: 0.9rem;">
                                        {{ Str::limit($package->short_description, 100) }}
                                    </p>
                                @endif

                                <div style="margin-bottom: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <span style="font-size: 1.5rem; font-weight: 700; color: #667eea;">
                                            ৳{{ number_format($packagePrice, 2) }}
                                        </span>
                                        @if ($package->discount_price > 0)
                                            <span style="font-size: 1rem; color: #9ca3af; text-decoration: line-through;">
                                                ৳{{ number_format($package->price, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <div style="font-size: 0.9rem; color: #6b7280;">
                                        <i class="fi fi-rr-box" style="margin-right: 0.25rem;"></i>
                                        {{ $packageItems->sum('quantity') }} items included
                                    </div>

                                    @if ($savings > 0)
                                        <div class="package-savings">
                                            💰 Save ৳{{ number_format($savings, 2) }} ({{ $savingsPercentage }}% off)
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ url('package/details') }}/{{ $package->slug }}" class="view-package-btn">
                                    View Package Details
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($packages->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="pagination__area">
                                    {{ $packages->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <div style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;">
                            📦
                        </div>
                        <h3 style="color: #6b7280; margin-bottom: 0.5rem;">No packages available</h3>
                        <p style="color: #9ca3af;">Check back later for amazing package deals!</p>

                        <a href="{{ url('shop') }}" class="view-package-btn" style="margin-top: 2rem;">
                            Browse All Products
                        </a>
                    </div>
                @endif
            </div>
        </section>
        <!-- End packages section -->
    @endsection
