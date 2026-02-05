<div class="single__widget widget__bg">
    <h2 class="widget__title h3">{{ __('home.featured_products') }}</h2>
    <ul class="widget__form--check">
        @foreach ($flags as $flag)
            <li class="widget__form--check__list">
                <label class="widget__form--check__label" for="check{{$flag->slug}}">{{ $flag->name }}</label>
                <input class="widget__form--check__input" value="{{ $flag->id }}" name="filter_flag_id[]" @if(isset($flagId) && in_array($flag->id, explode(",", $flagId))) checked @endif id="check{{$flag->slug}}" type="checkbox" onchange="filterProducts()"/>
                <span class="widget__form--checkmark"></span>
            </li>
        @endforeach
    </ul>
</div>
