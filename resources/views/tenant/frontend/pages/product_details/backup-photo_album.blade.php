@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/lightbox.min.css">
@endsection

@section('content')
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container">
            <div class="row .my_filter">

            </div>
            <div class="row row-cols-lg-2 row-cols-md-2">
                @foreach ($images as $imageData)
                    <div class="col-md-3 mb-4 text-center">
                        <!-- Lightbox link on image -->
                        <a href="{{ env('ADMIN_URL') . '/uploads/productImages/' . $imageData['image'] }}"
                            data-lightbox="product_gallery">
                            <img class="product__media--preview__items--img lazy img-fluid p-2 border rounded"
                                src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $imageData['image'] }}"
                                alt="{{ $imageData['product_name'] }}" />
                        </a>
                        <!-- Product details link on title -->
                        <a href="{{ url('product/details') }}/{{ $imageData['product_slug'] }}"
                            class="d-block mt-2 text-decoration-none text-dark">
                            <strong>{{ $imageData['product_name'] }}</strong>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Centered Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            {{ $images->links() }}
        </div>
    </section>
@endsection

@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/lightbox.min.js"></script>

    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>
@endsection
