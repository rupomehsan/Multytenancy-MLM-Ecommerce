<div class="tab_content">
    <div id="product_grid" class="tab_pane active show">
        <div class="product__section--inner product__grid--inner">
            <div class="row">
                <div class="col-12">
                    @if ($products->total() > 0)
                        <div class="product__section-inner style-2">

                            @foreach ($products as $product)
                                @include('tenant.frontend.pages.homepage_sections.single_product')
                            @endforeach

                        </div>
                    @else
                        <h5
                            style="text-align: center; padding: 15px; background: #F8F8F8; border-radius: 4px; font-weight: 600; font-size: 18px;">
                            Sorry! No Products Found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($products->total() > 12)
    <div class="pagination__area bg__gray--color">
        <nav class="pagination justify-content-center">
            {{ $products->links() }}
        </nav>
    </div>
@endif
