@foreach ($products as $product)
    @include('tenant.frontend.pages.homepage_sections.single_product', ['product' => $product])
@endforeach
