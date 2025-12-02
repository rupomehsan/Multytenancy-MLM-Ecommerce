<section class="product__section product__section--style3 section--padding">
    <div class="container product3__section--container">
        <div class="section__heading text-center mb-50">
            <h2 class="section__heading--maintitle">You may also like</h2>
        </div>
        <div class="product__section--inner product__swiper--column4__activation swiper" style="padding-bottom: 2px">
            <div class="swiper-wrapper">

                @foreach ($mayLikedProducts as $product)
                    <div class="swiper-slide">
                        @include('tenant.frontend.pages.homepage_sections.single_product')
                    </div>
                @endforeach

            </div>
            <div class="swiper__nav--btn swiper-button-next"></div>
            <div class="swiper__nav--btn swiper-button-prev"></div>
        </div>
    </div>
</section>
