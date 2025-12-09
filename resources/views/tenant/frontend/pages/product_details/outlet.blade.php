@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/lightbox.min.css">

    <!-- Add Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <style>
        .video-container iframe {
            width: 100%;
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin: 0 auto;
        }
    </style>
    <!-- Add Slick Carousel JS -->
@endsection

@section('content')
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center mb-3 my_nav_dropdown_row">
                <div class="col-md-12">
                    <div class="row">
                        @foreach ($outlets as $outlet)
                            @php
                                $images = json_decode($outlet->image, true);
                                $firstImage = $images[0] ?? 'default.jpg'; // Default image if none exists
                            @endphp

                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                                    <div class="outlet-image-slider">

                                        <!-- Loop through images and add them to the slider -->
                                        @foreach ($images as $image)
                                            <div class="slider-item">
                                                <img src="{{ asset(env('ADMIN_URL') . '/' . $image) }}" class="card-img-top"
                                                    alt="{{ $outlet->title }}"
                                                    style="border-top-left-radius: 15px; border-top-right-radius: 15px; height: 200px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                        @if ($outlet->video_link)
                                            <div class="slider-item">
                                                <div class="video-container">
                                                    {!! $outlet->video_link !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-body">
                                        <!-- Title with bold and glamorous effect -->
                                        <h5 class="card-title"
                                            style="font-weight: bold; font-size: 20px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);">
                                            {{ $outlet->title }}</h5>

                                        <!-- Address -->
                                        <p class="card-text"><strong>Address:</strong> {{ $outlet->address }}</p>

                                        <!-- Opening Time -->
                                        <p class="card-text"><strong>Opening:</strong> {{ $outlet->opening }}</p>

                                        <!-- Display Contact Numbers if they exist -->
                                        @if ($outlet->contact_number_1)
                                            <p class="card-text"><strong>Contact 1:</strong> {{ $outlet->contact_number_1 }}
                                            </p>
                                        @endif

                                        @if ($outlet->contact_number_2)
                                            <p class="card-text"><strong>Contact 2:</strong> {{ $outlet->contact_number_2 }}
                                            </p>
                                        @endif

                                        @if ($outlet->contact_number_3)
                                            <p class="card-text"><strong>Contact 3:</strong> {{ $outlet->contact_number_3 }}
                                            </p>
                                        @endif

                                        <!-- Get Directions Button -->
                                        <a href="{{ $outlet->map }}" target="_blank" class="btn btn-primary"
                                            style="border-radius: 10px; font-size: 16px;">Get Direction</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- Centered Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            {{ $outlets->appends(request()->query())->links() }}
        </div>
    </section>
@endsection


@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/lightbox.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('.outlet-image-slider').slick({
                slidesToShow: 1, 
                slidesToScroll: 1, 
                arrows: true, // Show arrows for navigation
                dots: true, // Show dots for navigation
                autoplay: true, // Enable auto-play
                autoplaySpeed: 3000, // 3 seconds per image
                fade: true, // Enable fade transition between images
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('.outlet-image-slider').each(function() {
                $(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    fade: true,
                });
            });
        });
    </script>
@endsection
