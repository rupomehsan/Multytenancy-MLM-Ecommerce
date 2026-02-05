@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/lightbox.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <style>
        .video-title-link {
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
            display: block;
        }

        .video-title-link:hover {
            color: #007bff;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            background: #000;
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .card-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 0;
            line-height: 1.4;
        }

        .video-gallery-container {
            min-height: 400px;
        }
    </style>
@endsection

@section('content')
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container-fluid">

            <div class="row video-gallery-container">
                @forelse ($video_galleries as $video)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Video Embed with Responsive Container -->
                            <div class="card-body p-0">
                                <div class="video-container" data-video-id="{{ $video->id }}">
                                    {!! $video->source !!}
                                </div>
                            </div>
                            <!-- Video Title -->
                            <div class="card-footer bg-white text-center">
                                @php
                                    // Extract video URL for popup (supports YouTube and Vimeo)
                                    $embedUrl = '#';
                                    
                                    // Check for YouTube
                                    if (preg_match('/src=["\']([^"\']*youtube\.com\/embed\/[^"\'?&=]+)/', $video->source, $matches)) {
                                        $embedUrl = $matches[1];
                                    }
                                    // Check for Vimeo
                                    elseif (preg_match('/src=["\']([^"\']*player\.vimeo\.com\/video\/[^"\'?&=]+)/', $video->source, $matches)) {
                                        $embedUrl = $matches[1];
                                    }
                                @endphp
                                <a href="{{ $embedUrl }}" class="video_popup video-title-link" title="{{ $video->title }}">
                                    <h5 class="card-title mb-0">{{ Str::limit($video->title, 50) }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-video-slash fa-3x mb-3"></i>
                            <h4>No videos available</h4>
                            <p>Check back later for new video content.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

        <!-- Centered Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            {{ $video_galleries->links() }}
        </div>
    </section>
@endsection


@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/lightbox.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


    <script></script>

    <script></script>

    <script>
        $(document).ready(function() {
            // Fix all iframes in video containers to be responsive
            $('.video-container').each(function() {
                var $container = $(this);
                var $iframe = $container.find('iframe');
                
                if ($iframe.length > 0) {
                    // Remove fixed width/height attributes
                    $iframe.removeAttr('width').removeAttr('height');
                    // Ensure iframe has proper attributes
                    $iframe.attr({
                        'frameborder': '0',
                        'allowfullscreen': 'allowfullscreen',
                        'allow': 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
                    });
                    
                    console.log('Video fixed for container:', $container.data('video-id'));
                } else {
                    console.warn('No iframe found in container:', $container.data('video-id'));
                    // Add placeholder if no iframe found
                    $container.html('<div class="alert alert-warning text-center m-3">Video source not available</div>');
                }
            });
            
            // Initialize Magnific Popup for videos
            $('.video_popup').magnificPopup({
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">'+
                            '<div class="mfp-close"></div>'+
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                            '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: 'embed/',
                            src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                        },
                        vimeo: {
                            index: 'vimeo.com/',
                            id: 'video/',
                            src: 'https://player.vimeo.com/video/%id%?autoplay=1'
                        }
                    },
                    srcAction: 'iframe_src'
                },
                callbacks: {
                    open: function() {
                        console.log('Video popup opened');
                    },
                    close: function() {
                        console.log('Video popup closed');
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
