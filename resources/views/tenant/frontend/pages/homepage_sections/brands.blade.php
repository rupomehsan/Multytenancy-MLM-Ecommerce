<!-- start category section -->
{{-- @dd($featuredBrands) --}}
<section class="product__category--section">
    <div class="container-fluid">
        <div class="product__category--section-inner">
            <div class="row">
                <h2 class="section__heading--maintitle text-center">Featured Brands</h2>
                <div class="product__category-wrapper">
                    @foreach ($featuredBrands as $brands)
                        <a href="{{ url('shop') }}?brand={{ $brands->id }}" class="single-category">
                            <figure class="product__category-container" style="text-align: center">
                                <div class="single-category-img">
                                    <img src="{{ url('tenant/frontend/frontend_assets') }}/img/product-load.gif"
                                        data-src="{{ url(env('ADMIN_URL') . '/' . $brands->logo) }}" alt=""
                                        class="lazy" />
                                </div>
                                <figcaption class="product__category-inner">
                                    <p>{{ $brands->name }}</p>
                                </figcaption>
                            </figure>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Section -->
