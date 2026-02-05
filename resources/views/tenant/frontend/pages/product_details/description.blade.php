<section class="product__details--tab__section section--padding">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <ul class="product__details--tab d-flex mb-30">
                    <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">
                        {{ __('home.description') }}
                    </li>
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">
                        {{ __('home.product_reviews') }}
                    </li>
                    @if($product->specification != '')
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#information">
                        {{ __('home.specification') }}
                    </li>
                    @endif
                    @if($product->warrenty_policy != '')
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#custom">
                        {{ __('home.warranty_policy') }}
                    </li>
                    @endif
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#question">
                        {{ __('home.question_answer') }}
                    </li>
                </ul>
                <div class="product__details--tab__inner border-radius-10">
                    <div class="tab_content">
                        <div id="description" class="tab_pane active show">
                            {!! $product->description !!}
                        </div>

                        <div id="reviews" class="tab_pane">
                            <div class="product__reviews">

                                <div id="writereview" class="reviews__comment--reply__area">
                                    <form action="{{url('submit/product/review')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="review_product_id" value="{{$product->id}}">
                                        <h3 class="reviews__comment--reply__title mb-15">
                                            {{ __('home.add_review') }}
                                        </h3>

                                        <div class="row">
                                            <div class="col-12 mb-10">
                                                <textarea class="reviews__comment--reply__textarea" name="review" placeholder="{{ __('home.your_comments') }}" required></textarea>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-15">
                                                <label>
                                                    <select name="rarting" class="reviews__comment--reply__input" required style="background: transparent; height: 40px;">
                                                        <option value="">{{ __('home.select_rating') }}</option>
                                                        <option value="1">★</option>
                                                        <option value="2">★★</option>
                                                        <option value="3">★★★</option>
                                                        <option value="4">★★★★</option>
                                                        <option value="5">★★★★★</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-15 text-right">
                                                <button class="reviews__comment--btn text-white primary__btn" data-hover="Submit" type="submit">
                                                    {{ __('home.submit') }}
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="product__reviews--header" style="margin-top: 20px">
                                    <h2 class="product__reviews--header__title h3 mb-20">
                                        {{ __('home.customer_reviews') }}
                                    </h2>
                                    <div class="reviews__ratting d-flex align-items-center mb-3">
                                        @if($totalReviews > 0)
                                            @for ($i=1;$i<=round($averageRating);$i++)
                                            <i class="fi fi-ss-star" style="color: var(--yellow-color); margin-right: 2px; font-size: 18px;"></i>
                                            @endfor
                                            @for ($i=1;$i<=5-round($averageRating);$i++)
                                            <i class="fi fi-rs-star" style="color: var(--border-color); margin-right: 2px; font-size: 18px;"></i>
                                            @endfor
                                            <span class="reviews__summary--caption" style="margin-left: 8px;">
                                                <strong>{{ number_format($averageRating, 1) }}</strong> {{ __('home.based_on_reviews') }} <strong>{{$totalReviews}}</strong> {{ __('home.reviews') }}
                                            </span>
                                        @else
                                            <span class="reviews__summary--caption text-muted">{{ __('home.no_reviews_yet') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="reviews__comment--area">
                                    @if(count($productReviews) > 0)
                                        @foreach ($productReviews as $productReview)
                                        <div class="reviews__comment--list d-flex" style="padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 16px; background: #fff;">
                                            <div class="reviews__comment--thumb" style="width: 55px; flex-shrink: 0;">
                                                @if($productReview->user_image)
                                                <img src="{{url(env('ADMIN_URL').'/'.$productReview->user_image)}}" alt="comment-thumb" style="height: 55px; width: 55px; border-radius: 100%; object-fit: cover; border: 2px solid #e5e7eb;"/>
                                                @else
                                                <div style="height: 55px; width: 55px; border-radius: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
                                                    {{substr($productReview->username ?? 'A', 0, 1)}}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="reviews__comment--content" style="flex-grow: 1; margin-left: 16px;">
                                                <div class="reviews__comment--top d-flex justify-content-between" style="margin-bottom: 8px;">
                                                    <div class="reviews__comment--top__left">
                                                        <h3 class="reviews__comment--content__title h4" style="margin-bottom: 4px; font-size: 16px; font-weight: 600;">
                                                            {{$productReview->username ?? 'Anonymous'}}
                                                        </h3>
                                                        <div style="margin-bottom: 4px;">
                                                            @for ($i=1;$i<=round($productReview->rating);$i++)
                                                            <i class="fi fi-ss-star" style="color: #fbbf24; margin-right: 2px; font-size: 16px;"></i>
                                                            @endfor
                                                            @for ($i=1;$i<=5-round($productReview->rating);$i++)
                                                            <i class="fi fi-rs-star" style="color: #d1d5db; margin-right: 2px; font-size: 16px;"></i>
                                                            @endfor
                                                            <span style="color: #6b7280; font-size: 14px; margin-left: 4px;">({{$productReview->rating}}/5)</span>
                                                        </div>
                                                    </div>
                                                    <span class="reviews__comment--content__date" style="color: #9ca3af; font-size: 13px;">{{date("M d, Y", strtotime($productReview->created_at))}}</span>
                                                </div>
                                                <p class="reviews__comment--content__desc" style="color: #374151; line-height: 1.6; margin-bottom: 0;">
                                                    {{$productReview->review}}
                                                </p>
                                            </div>
                                        </div>

                                        @if($productReview->reply)
                                        <div class="reviews__comment--list margin__left d-flex" style="margin-left: 60px; padding: 16px; border-left: 3px solid #667eea; background: #f9fafb; border-radius: 8px; margin-bottom: 16px;">
                                            <div class="reviews__comment--thumb" style="width: 50px; flex-shrink: 0;">
                                                @php
                                                    $logo = DB::table('general_infos')->where('id', 1)->select('logo', 'fav_icon')->first();
                                                @endphp
                                                @if($logo && $logo->fav_icon)
                                                <img src="{{url(env('ADMIN_URL').'/'.$logo->fav_icon)}}" alt="comment-thumb" style="height: 50px; width: 50px; border-radius: 100%; object-fit: cover;"/>
                                                @elseif($logo && $logo->logo)
                                                <img src="{{url(env('ADMIN_URL').'/'.$logo->logo)}}" alt="comment-thumb" style="height: 50px; width: 50px; border-radius: 100%; object-fit: cover;"/>
                                                @else
                                                <div style="height: 50px; width: 50px; border-radius: 100%; background: #667eea; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fi fi-rr-shield-check" style="color: white; font-size: 20px;"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="reviews__comment--content" style="flex-grow: 1; margin-left: 12px;">
                                                <div class="reviews__comment--top d-flex justify-content-between" style="margin-bottom: 8px;">
                                                    <div class="reviews__comment--top__left">
                                                        <h3 class="reviews__comment--content__title h4" style="margin-bottom: 2px; font-size: 15px; font-weight: 600; color: #667eea;">
                                                            {{env('APP_NAME')}} <span style="font-size: 12px; color: #6b7280; font-weight: normal;">(Seller)</span>
                                                        </h3>
                                                        <small style="color: #9ca3af; font-style: italic; font-size: 12px;">Reply</small>
                                                    </div>
                                                </div>
                                                <p class="reviews__comment--content__desc" style="color: #374151; line-height: 1.6; margin-bottom: 0; font-size: 14px;">
                                                    {{$productReview->reply}}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    
                                    <div class="mt-3">
                                        {{ $productReviews->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5" style="background: #f9fafb; border-radius: 8px; padding: 40px 20px;">
                                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                            <i class="fi fi-rr-comment-alt" style="font-size: 36px; color: white;"></i>
                                        </div>
                                        <h5 style="color: #6b7280; margin-bottom: 8px;">{{ __('home.no_reviews_yet') }}</h5>
                                        <p style="color: #9ca3af; font-size: 14px;">Be the first to review this product!</p>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>

                        @if($product->specification != '')
                        <div id="information" class="tab_pane">
                            {!! $product->specification !!}
                        </div>
                        @endif
                        @if($product->warrenty_policy != '')
                        <div id="custom" class="tab_pane">
                            {!! $product->warrenty_policy !!}
                        </div>
                        @endif

                        <div id="question" class="tab_pane">
                            <div class="product__reviews">

                                <div id="writereview" class="reviews__comment--reply__area">
                                    <form action="{{url('submit/product-question')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="question_product_id" value="{{$product->id}}">
                                        <h3 class="reviews__comment--reply__title mb-15">
                                            {{ __('home.ask_question') }}
                                        </h3>

                                        <div class="row">
                                            <div class="col-12 mb-10">
                                                <textarea class="reviews__comment--reply__textarea" name="question" placeholder="{{ __('home.your_questions') }}" required></textarea>
                                            </div>
                                        
                                            <div class="col-lg-12 col-md-12 mb-15 text-right">
                                                <button class="reviews__comment--btn text-white primary__btn" data-hover="{{ __('home.submit') }}" type="submit">
                                                    {{ __('home.submit') }}
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="product__reviews--header" style="margin-top: 20px">
                                    <h2 class="product__reviews--header__title h3 mb-20">
                                        {{ __('home.all_questions') }}
                                    </h2>
                                </div>
               
                                <div class="reviews__comment--area">
                                    @foreach ($productQuestions as $productQuestion)
                                        <div class="reviews__comment--list d-flex">
                                            <div class="reviews__comment--content">
                                                <div class="reviews__comment--top d-flex justify-content-between">
                                                    <div class="reviews__comment--top__left">
                                                        <h3 class="reviews__comment--content__title h4">
                                                            {{$productQuestion->full_name ?? 'Anonymous'}}
                                                        </h3>
    
                                                    </div>
                                                    <span class="reviews__comment--content__date">{{date("F d, Y", strtotime($productQuestion->created_at))}}</span>
                                                </div>
                                                <p class="reviews__comment--content__desc">
                                                    {{$productQuestion->question}}
                                                </p>
                                            </div>
                                        </div>

                                        @if($productQuestion->answer)
                                            <div class="reviews__comment--list margin__left d-flex">
                                                <div class="reviews__comment--content">
                                                    <div class="reviews__comment--top d-flex justify-content-between" style="margin-bottom: 0px">
                                                        <div class="reviews__comment--top__left">
                                                            <h3 class="reviews__comment--content__title h4" style="margin-bottom: 0px">
                                                                {{env('APP_NAME')}}
                                                            </h3>
                                                            <small style="color: gray; font-style: italic;">{{date("F d, Y", strtotime($productQuestion->updated_at))}}</small>
                                                        </div>
                                                    </div>
                                                    <p class="reviews__comment--content__desc">
                                                        {{$productQuestion->answer ?? 'No Answer Yet'}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
