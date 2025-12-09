@php
    $socialShare = Share::page(url()->current(), env('APP_NAME'))
        ->facebook()
        ->twitter()
        ->linkedin(env('APP_NAME'))
        ->whatsapp()
        ->getRawLinks();
@endphp

<div class="quickview__social d-flex align-items-center mb-15">
    <label class="quickview__social--title">Social Share:</label>
    <ul class="quickview__social--wrapper mt-0 d-flex">
        <li class="quickview__social--list">
            <a class="quickview__social--icon" target="_blank" href="{{ $socialShare['facebook'] }}"
                style="background: #3B5998">
                <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524" viewBox="0 0 7.667 16.524">
                    <path data-name="Path 237"
                        d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z"
                        transform="translate(-960.13 -345.407)" fill="currentColor" />
                </svg>
                <span class="visually-hidden">Facebook</span>
            </a>
        </li>
        <li class="quickview__social--list">
            <a class="quickview__social--icon" target="_blank" href="{{ $socialShare['twitter'] }}"
                style="background: #1DA1F2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.489" height="13.384" viewBox="0 0 16.489 13.384">
                    <path data-name="Path 303"
                        d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z"
                        transform="translate(-951.23 -1140.849)" fill="currentColor" />
                </svg>
                <span class="visually-hidden">Twitter</span>
            </a>
        </li>
        <li class="quickview__social--list">
            <a class="quickview__social--icon" target="_blank" href="{{ $socialShare['whatsapp'] }}"
                style="background: #25D366">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="16" height="16" x="0" y="0" viewBox="0 0 512 512"
                    style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path
                            d="M256.064 0h-.128C114.784 0 0 114.816 0 256c0 56 18.048 107.904 48.736 150.048l-31.904 95.104 98.4-31.456C155.712 496.512 204 512 256.064 512 397.216 512 512 397.152 512 256S397.216 0 256.064 0zm148.96 361.504c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.616-127.456-112.576-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016.16 8.576.288 7.52.32 11.296.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744-3.776 4.352-7.36 7.68-11.136 12.352-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z"
                            fill="currentColor"></path>
                    </g>
                </svg>
                <span class="visually-hidden">Whatsapp</span>
            </a>
        </li>
        <li class="quickview__social--list">
            <a class="quickview__social--icon" target="_blank" href="{{ $socialShare['linkedin'] }}"
                style="background: #0a66c2">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="16" height="16" x="0" y="0" viewBox="0 0 100 100"
                    style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path
                            d="M90 90V60.7c0-14.4-3.1-25.4-19.9-25.4-8.1 0-13.5 4.4-15.7 8.6h-.2v-7.3H38.3V90h16.6V63.5c0-7 1.3-13.7 9.9-13.7 8.5 0 8.6 7.9 8.6 14.1v26H90zM11.3 36.6h16.6V90H11.3zM19.6 10c-5.3 0-9.6 4.3-9.6 9.6s4.3 9.7 9.6 9.7 9.6-4.4 9.6-9.7-4.3-9.6-9.6-9.6z"
                            fill="currentColor"></path>
                    </g>
                </svg>
                <span class="visually-hidden">Linkedin</span>
            </a>
        </li>
    </ul>
</div>

<div class="guarantee__safe--checkout">
    <img class="guarantee__safe--checkout__img" src="{{ url('tenant/frontend') }}/img/secure-payment.svg" alt=""
        style="width: 30%" />
</div>
