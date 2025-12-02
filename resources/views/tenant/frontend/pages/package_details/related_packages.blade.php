@if($relatedPackages && $relatedPackages->count() > 0)
<div class="product__details--tab__inner">
    <div class="row">
        <div class="col-12 mb-4">
            <h4>Related Packages</h4>
            <p class="text-muted">You might also be interested in these package deals</p>
        </div>
    </div>
    
    <div class="row">
        @foreach($relatedPackages as $relatedPackage)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <!-- Package Image -->
                    <div class="position-relative">
                        @if($relatedPackage->image)
                            <img src="{{ asset('storage/' . $relatedPackage->image) }}" 
                                 alt="{{ $relatedPackage->name }}" 
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <svg class="text-muted" width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Package Badge -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                Package
                            </span>
                        </div>

                        <!-- Savings Badge -->
                        @php
                            $items = DB::table('package_product_items')
                                ->join('products', 'package_product_items.product_id', '=', 'products.id')
                                ->where('package_product_items.package_product_id', $relatedPackage->id)
                                ->get();
                            $totalIndividualPrice = $items->sum(function($item) { 
                                return ($item->discount_price > 0 ? $item->discount_price : $item->price) * $item->quantity; 
                            });
                            $packagePrice = $relatedPackage->discount_price > 0 ? $relatedPackage->discount_price : $relatedPackage->price;
                            $savings = $totalIndividualPrice - $packagePrice;
                            $savingsPercentage = $totalIndividualPrice > 0 ? round(($savings / $totalIndividualPrice) * 100) : 0;
                        @endphp
                        
                        @if($savingsPercentage > 0)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">
                                    Save {{ $savingsPercentage }}%
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Package Info -->
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $relatedPackage->name }}</h6>
                        
                        @if($relatedPackage->short_description)
                            <p class="card-text text-muted small mb-3">{{ Str::limit($relatedPackage->short_description, 80) }}</p>
                        @endif

                        <!-- Items Count -->
                        <div class="small text-muted mb-3">
                            <i class="fi fi-rr-box me-1"></i>
                            {{ $items->sum('quantity') }} items included
                        </div>

                        <!-- Pricing -->
                        <div class="mb-3 mt-auto">
                            <div class="d-flex align-items-center mb-1">
                                <span class="h6 text-primary mb-0">৳{{ number_format($packagePrice, 2) }}</span>
                                @if($savings > 0)
                                    <span class="small text-muted text-decoration-line-through ms-2">৳{{ number_format($totalIndividualPrice, 2) }}</span>
                                @endif
                            </div>
                            @if($savings > 0)
                                <p class="small text-success mb-0">You save ৳{{ number_format($savings, 2) }}</p>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('PackageDetails', $relatedPackage->slug) }}" 
                           class="btn btn-outline-primary btn-sm">
                            View Package
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- View More Button -->
    @if($relatedPackages->count() >= 3)
        <div class="text-center mt-4">
            <a href="{{ route('Packages') }}" class="btn btn-primary">
                <span>View All Packages</span>
                <i class="fi fi-rr-arrow-right ms-1"></i>
            </a>
        </div>
    @endif
</div>
@endif
