{{-- Debug: Banner data 
  Banner exists: {{ isset($banner) ? 'Yes' : 'No' }}
  Has image: {{ isset($banner) && $banner->image ? 'Yes (' . $banner->image . ')' : 'No' }}
--}}
@if(isset($banner) && $banner->image)
<section class="banner__section section--padding pt-0 my-5">
  <div class="container-fluid">
    <div class="row row-cols-1">
      <div class="col">
        <div class="banner__section--inner position__relative">
          <a class="banner__items--thumbnail display-block overflow-hidden" href="{{ $banner->link ?? '#' }}">
            <img class="banner__items--thumbnail__img banner__img--height__md display-block"
              src="{{ url($banner->image) }}" alt="banner-img" class="lazy">
            @if($banner->sub_title || $banner->title || $banner->description || $banner->btn_text)
            <div class="banner__content--style2" style="width: 90%; text-align: {{ $banner->text_position ?? 'left' }}">
              @if($banner->sub_title)
              <p class="text-white">
                {{ $banner->sub_title }}
              </p>
              @endif
              @if($banner->title)
              <h2 class="banner__content--style2__title text-white">
                {{ $banner->title }}
              </h2>
              @endif
              @if($banner->description)
              <p class="banner__content--style2__desc" 
                @if ($banner->text_position == 'right')
                  style="width: 50%; margin-left: auto;"
                @endif>
                {{ $banner->description }}
              </p>
              @endif
              @if($banner->btn_text && $banner->btn_link)
              <a href="{{ $banner->btn_link }}" class="primary__btn mt-4">{{ $banner->btn_text }}
                <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2"
                  viewBox="0 0 6.2 6.2">
                  <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z"
                    transform="translate(-4 -4)" fill="currentColor"></path>
                </svg>
              </a>
              @endif
            </div>
            @endif
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endif