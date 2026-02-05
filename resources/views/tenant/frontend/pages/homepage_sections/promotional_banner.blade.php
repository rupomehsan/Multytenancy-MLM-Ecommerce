@php
    $promotionalBanner = DB::table('promotional_banners')->first();
@endphp

<section class="deals__banner--section section--padding pt-0">
    <div class="container-fluid">
        <div class="deals__banner--inner banner__bg"
            style="
            @if(!empty($promotionalBanner->background_image))
                background-image: url('{{$promotionalBanner->background_image}}');
            @endif">
            <div class="row row-cols-1 align-items-center">
                <div class="col">
                    <div class="deals__banner--content position__relative">
                        <span class="deals__banner--content__subtitle text__secondary"
                            style="color: {{ $promotionalBanner->heading_color ?? '' }}">
                            {{ $promotionalBanner->heading ?? '' }}
                        </span>
                        <h2 class="deals__banner--content__maintitle"
                            style="color: {{ $promotionalBanner->title_color ?? '' }}">
                            {{ $promotionalBanner->title ?? '' }}
                        </h2>
                        <p class="deals__banner--content__desc"
                            style="width: 50%; color: {{ $promotionalBanner->description_color ?? '' }}">
                            {{ $promotionalBanner->description ?? '' }}
                        </p>
                        <div class="deals__banner--countdown d-flex" id="countdown-timer" >
                            @php
                                $style = 'color: ' . ($promotionalBanner->time_font_color ?? '') . '; background-color: ' . ($promotionalBanner->time_bg_color ?? '');
                            @endphp
                            <div class="countdown__item" style="{{ $style }}">
                                <span class="countdown__number" id="days">0</span>
                                <p class="countdown__text" style="{{ $style }}">days</p>
                            </div>
                            <div class="countdown__item" style="{{ $style }}">
                                <span class="countdown__number" id="hours">0</span>
                                <p class="countdown__text" style="{{ $style }}">hrs</p>
                            </div>
                            <div class="countdown__item" style="{{ $style }}">
                                <span class="countdown__number" id="minutes">0</span>
                                <p class="countdown__text" style="{{ $style }}">mins</p>
                            </div>
                            <div class="countdown__item" style="{{ $style }}">
                                <span class="countdown__number" id="seconds">0</span>
                                <p class="countdown__text" style="{{ $style }}">secs</p>
                            </div>
                        </div>
                        <a class="primary__btn"
                            style="color: {{ $promotionalBanner->btn_text_color ?? '' }}; background-color: {{ $promotionalBanner->btn_bg_color ?? '' }}"
                            href="{{ $promotionalBanner->url ?? '#'}}">
                            {{ $promotionalBanner->btn_text ?? '' }}
                            <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2"
                                height="12.2" viewBox="0 0 6.2 6.2">

                                <path
                                    d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z"
                                    transform="translate(-4 -4)" fill="currentColor"></path>
                            </svg>
                        </a>
                        <br>
                        <div class="banner__bideo--play">
                            <a class="banner__bideo--play__icon glightbox"
                                href="{{ $promotionalBanner->video_url ?? '#' }}" data-gallery="video">
                                <svg id="play" xmlns="http://www.w3.org/2000/svg" width="40.302" height="40.302"
                                    viewBox="0 0 46.302 46.302">
                                    <g id="Group_193" data-name="Group 193" transform="translate(0 0)">
                                        <path id="Path_116" data-name="Path 116"
                                            d="M39.521,6.781a23.151,23.151,0,0,0-32.74,32.74,23.151,23.151,0,0,0,32.74-32.74ZM23.151,44.457A21.306,21.306,0,1,1,44.457,23.151,21.33,21.33,0,0,1,23.151,44.457Z"
                                            fill="currentColor"></path>
                                        <g id="Group_188" data-name="Group 188" transform="translate(15.588 11.19)">
                                            <g id="Group_187" data-name="Group 187">
                                                <path id="Path_117" data-name="Path 117"
                                                    d="M190.3,133.213l-13.256-8.964a3,3,0,0,0-4.674,2.482v17.929a2.994,2.994,0,0,0,4.674,2.481l13.256-8.964a3,3,0,0,0,0-4.963Zm-1.033,3.435-13.256,8.964a1.151,1.151,0,0,1-1.8-.953V126.73a1.134,1.134,0,0,1,.611-1.017,1.134,1.134,0,0,1,1.185.063l13.256,8.964a1.151,1.151,0,0,1,0,1.907Z"
                                                    transform="translate(-172.366 -123.734)" fill="currentColor"></path>
                                            </g>
                                        </g>
                                        <g id="Group_190" data-name="Group 190" transform="translate(28.593 5.401)">
                                            <g id="Group_189" data-name="Group 189">
                                                <path id="Path_118" data-name="Path 118"
                                                    d="M328.31,70.492a18.965,18.965,0,0,0-10.886-10.708.922.922,0,1,0-.653,1.725,17.117,17.117,0,0,1,9.825,9.664.922.922,0,1,0,1.714-.682Z"
                                                    transform="translate(-316.174 -59.724)" fill="currentColor"></path>
                                            </g>
                                        </g>
                                        <g id="Group_192" data-name="Group 192" transform="translate(22.228 4.243)">
                                            <g id="Group_191" data-name="Group 191">
                                                <path id="Path_119" data-name="Path 119"
                                                    d="M249.922,47.187a19.08,19.08,0,0,0-3.2-.27.922.922,0,0,0,0,1.845,17.245,17.245,0,0,1,2.889.243.922.922,0,1,0,.31-1.818Z"
                                                    transform="translate(-245.801 -46.917)" fill="currentColor"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="visually-hidden">Video Play</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the dynamic start and end dates passed from Blade
        const startDate = new Date(@json($promotionalBanner->started_at ?? '2022-09-30T00:00:00')).getTime();
        const endDate = new Date(@json($promotionalBanner->end_at ?? '2022-10-01T00:00:00')).getTime();

        function updateCountdown() {
            const now = new Date().getTime();

            // If the countdown has not started yet
            if (now < startDate) {
                document.getElementById('countdown-timer').innerHTML = `
                    <div class="countdown__not-started">
                        <p style="font-size: 1.5rem; color: #ff6f61; text-align: center; {{ $style }}">
                            Countdown Not Started Yet
                        </p>
                    </div>
                `;
                return;
            }

            // Calculate remaining time
            const distance = endDate - now;

            // If the countdown has expired
            if (distance < 0) {
                document.getElementById('countdown-timer').innerHTML = `
                    <div class="countdown__expired">
                        <p style="font-size: 1.5rem; color: #ff0000; text-align: center; {{ $style }}">
                            Countdown has expired.
                        </p>
                    </div>
                `;
                return;
            }

            // Calculate days, hours, minutes, and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update the countdown timer elements
            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        }

        // Initial countdown update and set interval to update every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>