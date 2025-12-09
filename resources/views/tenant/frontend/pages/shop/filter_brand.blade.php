<div class="single__widget widget__bg">
    <h2 class="widget__title h3">Brands</h2>
    <ul class="widget__form--check">
        @foreach ($brands as $brand)
            <li class="widget__form--check__list" style="display: inline-block;">
                <label class="widget__form--check__label" for="check{{ $brand->slug }}">
                    @if ($brand->logo)
                        <img class="widget__categories--sub__menu--img lazy"
                            src="{{ url('tenant/frontend') }}/img/product-load.gif"
                            data-src="{{ url(env('ADMIN_URL') . '/' . $brand->logo) }}" alt="" />
                    @endif
                    {{ $brand->name }}
                </label>

                <input class="widget__form--check__input" value="{{ $brand->id }}" name="filter_brand_id[]"
                    @if (isset($brandId) && in_array($brand->id, explode(',', $brandId))) checked 
                    @elseif (isset($brandParam) && $brand->id == $brandParam) checked @endif
                    id="check{{ $brand->slug }}" type="checkbox" onchange="filterProducts()" />
                <span class="widget__form--checkmark"></span>
            </li>
        @endforeach
    </ul>
</div>
