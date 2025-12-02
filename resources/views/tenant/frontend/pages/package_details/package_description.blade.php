@if($package->description)
    <div class="product__details--tab__inner">
        {!! $package->description !!}
    </div>
@else
    <div class="product__details--tab__inner">
        <div class="text-center py-4">
            <div class="mb-3">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-muted">No description available for this package.</p>
        </div>
    </div>
@endif

{{-- Package Features section removed as features field doesn't exist in database --}}
{{-- If you want to add features, you'll need to add a 'features' column to the products table --}}
