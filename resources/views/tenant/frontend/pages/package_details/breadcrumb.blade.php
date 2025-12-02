<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white">{{ $package->name }}</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items">
                            <a class="text-white" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="breadcrumb__content--menu__items">
                            <a class="text-white" href="{{ route('Packages') }}">Packages</a>
                        </li>
                        <li class="breadcrumb__content--menu__items">
                            <span class="text-white">{{ $package->name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->
