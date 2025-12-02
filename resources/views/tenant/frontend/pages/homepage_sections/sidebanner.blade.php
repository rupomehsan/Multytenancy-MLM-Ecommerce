<!-- start category section -->
<section class="category_sidebanner mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="parent">
                @foreach ($sidebarBanners as $banner)
                    <section class="banner__section section--padding pt-0 ">
                        <div class="banner__section--inner position__relative">
                            <a class="banner__items--thumbnail display-block overflow-hidden"
                                href="{{ $banner->banner_link ?? '' }}">
                                @if ($banner->banner_img)
                                    <img class="banner__items--thumbnail__img banner__img--height__md display-block"
                                        src="{{ url(env('ADMIN_URL') . '/' . $banner->banner_img) }}" alt="banner-img"
                                        class="lazy">
                                @endif
                                <div class="banner__content--style2">
                                    <span class="">
                                        {{ ucfirst($banner->title ?? '') }}
                                    </span>
                                    @if (isset($banner->button_title) && $banner->button_title != '')
                                        <a href="{{ $banner->button_url ?? '' }}"
                                            class="primary__btn">{{ $banner->button_title ?? '' }}
                                            <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg"
                                                width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                                <path
                                                    d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z"
                                                    transform="translate(-4 -4)" fill="currentColor"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Category Section -->
