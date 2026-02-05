@php $subTotal = 0 @endphp
@foreach ((array) session('cart') as $id => $details)
    @php $subTotal += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'] @endphp
@endforeach
@php
    $minimumOrderAmount = session('coupon_minimum_order_amount') ? session('coupon_minimum_order_amount') : 0;
    // Check if current subtotal meets minimum order requirement
    $meetsMinimumOrder = $subTotal >= $minimumOrderAmount;
    // Show warning when there's an active coupon with minimum order requirements
    $showMinimumOrderWarning = session('coupon') && $minimumOrderAmount > 0;
    
    // Debug information (remove in production)
    /*
    echo "<!-- Debug Coupon Info: 
        SubTotal: {$subTotal}
        MinimumOrderAmount: {$minimumOrderAmount}
        MeetsMinimumOrder: " . ($meetsMinimumOrder ? 'YES' : 'NO') . "
        ShowMinimumOrderWarning: " . ($showMinimumOrderWarning ? 'YES' : 'NO') . "
        CouponSession: " . session('coupon') . "
    -->";
    */
@endphp

<div class="checkout-order-review-coupon-box">
    <p class="m-0 checkout-order-review-coupon-box-title">
        {{ __('checkout.have_coupon') }}
    </p>
    <div class="cart-single-coupon-form">
        <div class="cart-single-coupon-input">
            <input type="text" placeholder="{{ __('checkout.enter_coupon') }}" name="coupon_code" style="padding-left: 10px;"
                @if (session('coupon')) value="{{ session('coupon') }}" @endif id="coupon_code" />
            <div class="cart-coupon-form-btn">
                <button type="button" onclick="applyCoupon()" class="theme-btn hover">
                    {{ __('checkout.apply_coupon') }}
                </button>
            </div>
        </div>
        @if ($showMinimumOrderWarning)
             <small class="mt-2 d-block {{ $meetsMinimumOrder ? 'text-success' : 'text-warning' }}" id="coupon-minimum-warning">
                @if ($meetsMinimumOrder)
                    {{ __('checkout.minimum_order_met') }} ({{ number_format($minimumOrderAmount, 2) }} BDT)
                @else
                    {{ __('checkout.minimum_order_required') }} {{ number_format($minimumOrderAmount, 2) }} BDT ({{ __('checkout.current') }}: {{ number_format($subTotal, 2) }} BDT)
                @endif
            </small>
        @endif
    </div>
</div>
