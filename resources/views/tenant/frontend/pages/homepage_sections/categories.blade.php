<!-- start category section -->
<section class="product__category--section">
    <div class="container-fluid">
        <div class="product__category--section-inner">
            <div class="row">
                <h2 class="section__heading--maintitle text-center">{{ __('home.featured_category') }}</h2>
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
                                    <img src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                        data-src="{{ $featuredCategory->icon ? url($featuredCategory->icon) : 'https://via.placeholder.com/400x300/e91e63/ffffff?text=' . urlencode($featuredCategory->name) }}"
                                        alt="{{ $featuredCategory->name }}" class="lazy"
                                        onerror="this.src='https://via.placeholder.com/400x300/e91e63/ffffff?text={{ urlencode($featuredCategory->name) }}'" />
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
                                            <img src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                                data-src="{{ $featuredSubcategory->icon ? url($featuredSubcategory->icon) : 'https://via.placeholder.com/400x300/e91e63/ffffff?text=' . urlencode($featuredSubcategory->name) }}"
                                                alt="{{ $featuredSubcategory->name }}" class="lazy"
                                                onerror="this.src='https://via.placeholder.com/400x300/e91e63/ffffff?text={{ urlencode($featuredSubcategory->name) }}'" />
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
