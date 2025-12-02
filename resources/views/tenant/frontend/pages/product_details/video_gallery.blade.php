@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/lightbox.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <style>
        .video-title-link {
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .video-title-link:hover {
            color: #007bff;
            transform: scale(1.05);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection

@section('content')
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container-fluid">

            <div class="row">
                @foreach ($video_galleries as $video)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Video Embed -->
                            <div class="card-body p-2">
                                <!-- Directly display the iframe as stored -->
                                {!! $video->source !!}
                            </div>
                            <!-- Video Title -->
                            <div class="card-footer bg-white text-center">
                                @php
                                    // Extracting the video ID from the iframe source
                                    preg_match(
                                        '/src="https:\/\/www\.youtube\.com\/embed\/([^"?&=]+)/',
                                        $video->source,
                                        $matches,
                                    );
                                    $videoId = $matches[1] ?? null;
                                    $embedUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : '#';
                                @endphp
                                <a href="{{ $embedUrl }}" class="video_popup">
                                    <h5 class="card-title mb-0">{{ $video->title }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Centered Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            {{ $video_galleries->links() }}
        </div>
    </section>
@endsection


@section('footer_js')
    <script src="{{ url('tenant/frontend/frontend_assets') }}/js/jquery.zoom.js"></script>
    <script src="{{ url('tenant/frontend/frontend_assets') }}/js/lightbox.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


    <script></script>

    <script></script>

    <script>
        $(document).ready(function() {
            $('.video_popup').magnificPopup({
                type: 'iframe',
                iframe: {
                    patterns: {
                        youtube: {
                            index: 'youtube.com/', // Check if the URL contains youtube.com
                            id: 'embed/', // Find the video ID after /embed/
                            src: 'https://www.youtube.com/embed/%id%' // Format the URL to embed
                        },
                        // dailymotion: {

                        //     index: 'dailymotion.com',

                        //     id: function(url) {
                        //         var m = url.match(
                        //             /^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/
                        //             );
                        //         if (m !== null) {
                        //             if (m[4] !== undefined) {

                        //                 return m[4];
                        //             }
                        //             return m[2];
                        //         }
                        //         return null;
                        //     },

                        //     src: 'https://www.dailymotion.com/embed/video/%id%'

                        // }
                    }
                }


            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.header__menu--items').hover(
                function() {
                    $(this).children('.header__sub--menu').stop(true, true).fadeIn(200);
                },
                function() {
                    $(this).children('.header__sub--menu').stop(true, true).fadeOut(200);
                }
            );
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.header__menu--items').hover(function() {
                $(this).children('.header__sub--menu').stop(true, true).fadeIn(200);
            }, function() {
                $(this).children('.header__sub--menu').stop(true, true).fadeOut(200);
            });
        });
    </script>


    <script>
        document.getElementById('sortOrder').addEventListener('change', function() {
            var selectedValue = this.value; // Get the selected value (desc or asc)
            var url = new URL(window.location.href); // Get the current URL
            url.searchParams.set('sort', selectedValue); // Set the 'sort' parameter in the URL

            window.location.href = url; // Reload the page with the new 'sort' parameter
        });
    </script>
@endsection
