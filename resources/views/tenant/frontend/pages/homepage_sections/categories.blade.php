<!-- start category section -->
<section class="product__category--section">
    <div class="container-fluid">
        <div class="product__category--section-inner">
            <div class="row">
                <h2 class="section__heading--maintitle text-center">Featured Category</h2>
                <div class="product__category-wrapper">
                    @foreach ($featuredCategories as $featuredCategory)
                        @php
                            $featuredSubcategories = DB::table('subcategories')
                                ->where('category_id', $featuredCategory->id)
                                ->where('status', 1)
                                ->where('featured', 1)
                                ->get();
                        @endphp
                        <a href="{{ url('shop') }}?category={{ $featuredCategory->slug }}" class="single-category">
                            <figure class="product__category-container" style="text-align: center">
                                <div class="single-category-img">
                                    <img src="{{ url('tenant/frontend/frontend_assets') }}/img/product-load.gif"
                                        data-src="{{ url(env('ADMIN_URL') . '/' . $featuredCategory->icon) }}"
                                        alt="" class="lazy" />
                                </div>
                                <figcaption class="product__category-inner">
                                    <p>{{ $featuredCategory->name }}</p>
                                </figcaption>
                            </figure>
                        </a>

                        @if (count($featuredSubcategories))
                            @foreach ($featuredSubcategories as $featuredSubcategory)
                                <a href="{{ url('shop') }}?category={{ $featuredCategory->slug }}&subcategory_id={{ $featuredSubcategory->id }}"
                                    class="single-category">
                                    <figure class="product__category-container" style="text-align: center">
                                        <div class="single-category-img">
                                            <img src="{{ url('tenant/frontend/frontend_assets') }}/img/product-load.gif"
                                                data-src="{{ url(env('ADMIN_URL') . '/' . $featuredSubcategory->icon) }}"
                                                alt="" class="lazy" />
                                        </div>
                                        <figcaption class="product__category-inner">
                                            <p>{{ $featuredSubcategory->name }}</p>
                                        </figcaption>
                                    </figure>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Section -->
