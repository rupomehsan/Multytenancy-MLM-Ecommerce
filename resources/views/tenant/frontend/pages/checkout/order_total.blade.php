<div class="cart-order-summary-main">
    <ul class="cart-order-summary-main-list">
        @php $subTotal = 0 @endphp
        @foreach ((array) session('cart') as $id => $details)
            @php $subTotal += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'] @endphp
        @endforeach
        <li>Sub total <span>{{ number_format($subTotal, 2) }} BDT</span></li>

        @php
            $originalDiscount = session('discount') ? session('discount') : 0;
            $originalSubtotal = session('original_subtotal') ? session('original_subtotal') : $subTotal;
            $couponType = session('coupon_type') ? session('coupon_type') : null;
            $minimumOrderAmount = session('coupon_minimum_order_amount') ? session('coupon_minimum_order_amount') : 0;
            
            // Check if current subtotal meets minimum order requirement
            $meetsMinimumOrder = $subTotal >= $minimumOrderAmount;
            
            if ($meetsMinimumOrder && $originalDiscount > 0) {
                if ($couponType == 1) {
                    // Fixed amount coupon - just use the original discount amount
                    $discount = $originalDiscount;
                    $discountPercentageDisplay =
                        $originalDiscount > 0 && $subTotal > 0
                            ? number_format(($originalDiscount / $subTotal) * 100, 2)
                            : 0;
                } else {
                    // Percentage coupon - calculate dynamic discount amount with fixed percentage
                    $discountPercentage =
                        $originalDiscount > 0 && $originalSubtotal > 0 ? ($originalDiscount / $originalSubtotal) * 100 : 0;
                    $discount = $discountPercentage > 0 ? ($subTotal * $discountPercentage) / 100 : 0;
                    $discountPercentageDisplay = number_format($discountPercentage, 2);
                }
            } else {
                // No discount if minimum order not met or no original discount
                $discount = 0;
                $discountPercentageDisplay = 0;
            }
        @endphp
        
        @if ($originalDiscount > 0)
            @if (!$meetsMinimumOrder)
                <li class="text-warning">
                     <li>Discount <span><b>(Inactive)</b> 0.00 BDT</span></li>
                </li>
            @elseif ($couponType == 1)
                <li>Discount <span><b>(-fixed)</b> {{ number_format($discount, 2) }} BDT</span></li>
            @else
                <li>Discount <span><b>(-{{ $discountPercentageDisplay }}%)</b> {{ number_format($discount, 2) }} BDT</span></li>
            @endif
        @endif
        <li>VAT/TAX <span><b>(0%)</b> 0.00 BDT</span></li>

        @php
            $deliveryCost = session('delivery_cost') ? session('delivery_cost') : 0;
        @endphp
        <li>Delivery cost <span>{{ number_format($deliveryCost, 2) }} BDT</span></li>

        <li class="total-price">
            Total<span>{{ number_format($subTotal - $discount + $deliveryCost, 2) }} BDT</span>
        </li>
    </ul>
</div>
