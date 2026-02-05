
<!-- Main Content Container -->
<div class="container-fluid mb-3">
    <div class="row g-4">
        <div class="col-lg-12">
            <section class="hero__bg--section">
                <div class="hero__bg--inner">
                    <div class="hero__slider--activation swiper">
                        <div class="swiper-wrapper">
                            @foreach ($sliders as $slider)
                                <div class="swiper-slide">
                                    <div class="hero__bg--items home__bg">
                                        <a href="{{ $slider->link }}" class="hero__bg--items__inner d-block">
                                            <img src="{{ url( $slider->image) }}" alt="banner"
                                                class="img-fluid w-100" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper__nav--btn-2 swiper-button-prev"></div>
                        <div class="swiper__nav--btn-2 swiper-button-next"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
