<section class="product__details--tab__section section--padding">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <ul class="product__details--tab d-flex mb-30">
                    <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">
                        Description
                    </li>
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">
                        Product Reviews
                    </li>
                    @if($product->specification != '')
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#information">
                        Specification
                    </li>
                    @endif
                    @if($product->warrenty_policy != '')
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#custom">
                        Warrenty Policy
                    </li>
                    @endif
                    <li class="product__details--tab__list" data-toggle="tab" data-target="#question">
                        Question/Answer
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
                                            Add a review
                                        </h3>

                                        <div class="row">
                                            <div class="col-12 mb-10">
                                                <textarea class="reviews__comment--reply__textarea" name="review" placeholder="Your Comments...." required></textarea>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-15">
                                                <label>
                                                    <select name="rarting" class="reviews__comment--reply__input" required style="background: transparent; height: 40px;">
                                                        <option value="">Select Rating</option>
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
                                                    SUBMIT
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="product__reviews--header" style="margin-top: 20px">
                                    <h2 class="product__reviews--header__title h3 mb-20">
                                        Customer Reviews
                                    </h2>
                                    <div class="reviews__ratting d-flex align-items-center">
                                        @for ($i=1;$i<=round($averageRating);$i++)
                                        <i class="fi fi-ss-star" style="color: var(--yellow-color); margin-right: 2px"></i>
                                        @endfor
                                        @for ($i=1;$i<=5-round($averageRating);$i++)
                                        <i class="fi fi-rs-star" style="color: var(--border-color); margin-right: 2px"></i>
                                        @endfor
                                        <span class="reviews__summary--caption">Based on {{$totalReviews}} reviews</span>
                                    </div>
                                </div>
                                <div class="reviews__comment--area">
                                    @foreach ($productReviews as $productReview)
                                        <div class="reviews__comment--list d-flex">
                                            <div class="reviews__comment--thumb" style="width: 55px;">
                                                @if($productReview->user_image)
                                                <img src="{{url(env('ADMIN_URL').'/'.$productReview->user_image)}}" alt="comment-thumb" style="height: 55px; width: 55px; border-radius: 100%; object-fit: cover;"/>
                                                @endif
                                            </div>
                                            <div class="reviews__comment--content">
                                                <div class="reviews__comment--top d-flex justify-content-between">
                                                    <div class="reviews__comment--top__left">
                                                        <h3 class="reviews__comment--content__title h4">
                                                            {{$productReview->username ?? 'Anonymous'}}
                                                        </h3>
                                                        @for ($i=1;$i<=round($productReview->rating);$i++)
                                                        <i class="fi fi-ss-star" style="color: var(--yellow-color); margin-right: 2px"></i>
                                                        @endfor
                                                        @for ($i=1;$i<=5-round($productReview->rating);$i++)
                                                        <i class="fi fi-rs-star" style="color: var(--border-color); margin-right: 2px"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="reviews__comment--content__date">{{date("F d, Y", strtotime($productReview->created_at))}}</span>
                                                </div>
                                                <p class="reviews__comment--content__desc">
                                                    {{$productReview->review}}
                                                </p>
                                            </div>
                                        </div>

                                        @if($productReview->reply)
                                        <div class="reviews__comment--list margin__left d-flex">
                                            <div class="reviews__comment--thumb" style="width: 55px;">
                                                @php
                                                    $logo = DB::table('general_infos')->where('id', 1)->select('logo', 'fav_icon')->first();
                                                @endphp
                                                @if($logo && $logo->fav_icon)
                                                <img src="{{url(env('ADMIN_URL').'/'.$logo->fav_icon)}}" alt="comment-thumb" style="height: 55px; width: 55px; border-radius: 100%; object-fit: cover;"/>
                                                @elseif($logo && $logo->logo)
                                                <img src="{{url(env('ADMIN_URL').'/'.$logo->logo)}}" alt="comment-thumb" style="height: 55px; width: 55px; border-radius: 100%; object-fit: cover;"/>
                                                @else

                                                @endif
                                            </div>
                                            <div class="reviews__comment--content">
                                                <div class="reviews__comment--top d-flex justify-content-between" style="margin-bottom: 0px">
                                                    <div class="reviews__comment--top__left">
                                                        <h3 class="reviews__comment--content__title h4" style="margin-bottom: 0px">
                                                            {{env('APP_NAME')}}
                                                        </h3>
                                                        <small style="color: gray; font-style: italic;">Replied on 2023-02-12</small>
                                                    </div>
                                                </div>
                                                <p class="reviews__comment--content__desc">
                                                    {{$productReview->reply}}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
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
                                            Ask a Question
                                        </h3>

                                        <div class="row">
                                            <div class="col-12 mb-10">
                                                <textarea class="reviews__comment--reply__textarea" name="question" placeholder="Your Questions...." required></textarea>
                                            </div>
                                        
                                            <div class="col-lg-12 col-md-12 mb-15 text-right">
                                                <button class="reviews__comment--btn text-white primary__btn" data-hover="Submit" type="submit">
                                                    SUBMIT
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="product__reviews--header" style="margin-top: 20px">
                                    <h2 class="product__reviews--header__title h3 mb-20">
                                        All Questions
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
