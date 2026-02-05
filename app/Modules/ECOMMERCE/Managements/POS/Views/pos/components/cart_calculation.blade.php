<tr>
    <td style="padding: 6px 0;">
        <span style="color: #6c757d; font-weight: 500;">Quantity:</span>
    </td>
    <td style="padding: 6px 0; text-align: right;">
        <strong>
            @php
                $totalQty = 0;
                if (session('cart') && count(session('cart')) > 0) {
                    foreach (session('cart') as $cartIndex => $details) {
                        $totalQty += $details['quantity'];
                    }
                }
            @endphp
            {{ $totalQty }}
        </strong>
    </td>
</tr>
<tr>
    <td style="padding: 6px 0;">
        <span style="color: #6c757d; font-weight: 500;">Total Amount:</span>
    </td>
    <td style="padding: 6px 0; text-align: right;">
        @php
            // Compute gross subtotal and total item-level discounts separately
            $subtotalGross = 0;
            $itemDiscountTotal = 0;
            if (session('cart') && count(session('cart')) > 0) {
                foreach (session('cart') as $cartIndex => $details) {
                    $subtotalGross += $details['price'] * $details['quantity'];
                    if (!empty($details['discount_price'])) {
                        $itemDiscountTotal += $details['discount_price'];
                    }
                }
            }
        @endphp
        <strong>৳ {{ number_format($subtotalGross, 2) }}</strong>
        <input type="hidden" name="subtotal_gross" id="subtotal_gross" value="{{ $subtotalGross }}">
        <input type="hidden" name="item_discount_total" id="item_discount_total" value="{{ $itemDiscountTotal }}">
    </td>
</tr>
<tr>
    <td style="padding: 6px 0;">
        <span style="color: #6c757d; font-weight: 500;">Item Discounts:</span>
    </td>
    <td style="padding: 6px 0; text-align: right;">
        <strong>৳ {{ number_format($itemDiscountTotal, 2) }}</strong>
    </td>
</tr>
<tr>
    <td style="padding: 6px 0;">
        <span style="color: #6c757d; font-weight: 500;">Shipping:</span>
    </td>
    <td style="padding: 6px 0; text-align: right;">
        @php
            // Shipping charge to apply (do not mutate subtotal variables here)
            $shippingCharge = session('shipping_charge', 0);
        @endphp
        <strong>৳ <input type="number" class="text-center shipping-charge-input"
                style="width: 60px; border: 1px solid #dee2e6; border-radius: 4px; padding: 2px 4px; font-weight: 600;"
                data-original-value="{{ $shippingCharge }}" onblur="updateShippingChargeOnBlur(this)"
                onkeydown="handleShippingKeydown(event, this)" oninput="handleShippingInput(this)"
                value="{{ $shippingCharge }}" min="0" id="shipping_charge" name="shipping_charge"
                onwheel="this.blur()" /></strong>
    </td>
</tr>
<tr>
    <td style="padding: 6px 0;">
        <span style="color: #6c757d; font-weight: 500;">Discount:</span>
    </td>
    <td style="padding: 6px 0; text-align: right;">
        @php
            // Order-level discounts (pos_discount + discount)
            $posDiscount = session('pos_discount', 0);
            $orderDiscount = session('discount', 0);
            // Compute grand total = gross + shipping - (item discounts + order discounts)
            $grandTotal = $subtotalGross + $shippingCharge - ($itemDiscountTotal + $posDiscount + $orderDiscount);
            $grandTotal = max(0, $grandTotal);
        @endphp
        <strong>৳ <input type="number" class="text-center order-discount-input"
                style="width: 60px; border: 1px solid #dee2e6; border-radius: 4px; padding: 2px 4px; font-weight: 600;"
                data-original-value="{{ $orderDiscount }}" onblur="updateOrderDiscountOnBlur(this)"
                onkeydown="handleOrderDiscountKeydown(event, this)" oninput="handleOrderDiscountInput(this)"
                value="{{ $orderDiscount }}" min="0" id="discount" name="discount"
                onwheel="this.blur()" /></strong>
        <input type="hidden" id="pos_discount" value="{{ $posDiscount }}">
    </td>
</tr>
<tr>
    <td style="padding: 12px 0 6px 0; border-top: 2px solid #dee2e6;">
        <span style="color: #2d3748; font-weight: 700; font-size: 15px;">Grand Total:</span>
    </td>
    <td style="padding: 12px 0 6px 0; text-align: right; border-top: 2px solid #dee2e6;">
        <strong id="total_cart_calculation" style="color: #667eea; font-size: 18px; font-weight: 700;">৳
            {{ number_format($grandTotal, 2) }}</strong>
        <input type="hidden" name="total" id="total" value="{{ $grandTotal }}">
    </td>
</tr>

<script>
    // Add CSS styles for visual feedback
    if (typeof jQuery !== 'undefined' && typeof $ !== 'undefined') {
        // Check if styles are already added to prevent duplicates
        if (!document.getElementById('pos-cart-styles')) {
            $('<style id="pos-cart-styles">')
                .prop('type', 'text/css')
                .html(`
                    .shipping-charge-input.pending-update, .order-discount-input.pending-update {
                        border: 2px solid #ffc107;
                        background-color: #fff3cd;
                    }
                    .shipping-charge-input.updating, .order-discount-input.updating {
                        border: 2px solid #007bff;
                        background-color: #e3f2fd;
                    }
                    /* Hide number input arrows */
                    input[type=number]::-webkit-inner-spin-button, 
                    input[type=number]::-webkit-outer-spin-button { 
                        -webkit-appearance: none; 
                        margin: 0; 
                    }
                    input[type=number] {
                        -moz-appearance: textfield;
                    }
                `)
                .appendTo('head');
        }
    }

    // Improved Shipping Charge handling
    function handleShippingInput(inputElem) {
        inputElem.classList.add('pending-update');
        inputElem.classList.remove('updating');

        let value = parseFloat(inputElem.value);
        if (inputElem.value !== '' && (isNaN(value) || value < 0)) {
            inputElem.style.borderColor = '#dc3545';
            inputElem.style.backgroundColor = '#f8d7da';
        } else {
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';
        }
    }

    function handleShippingKeydown(event, inputElem) {
        if (event.key === 'Enter') {
            event.preventDefault();
            inputElem.blur();
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            let originalValue = inputElem.getAttribute('data-original-value');
            inputElem.value = originalValue;
            inputElem.classList.remove('pending-update');
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';
            inputElem.blur();
            return;
        }
    }

    function updateShippingChargeOnBlur(inputElem) {
        let value = parseFloat(inputElem.value) || 0;
        let originalValue = parseFloat(inputElem.getAttribute('data-original-value')) || 0;

        if (inputElem.value === '') {
            value = 0;
            inputElem.value = 0;
        }

        if (isNaN(value) || value < 0) {
            inputElem.value = originalValue;
            inputElem.classList.remove('pending-update');
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;
            toastr.warning('Shipping charge must be 0 or greater. Restored to previous value.');
            return;
        }

        if (value === originalValue) {
            inputElem.classList.remove('pending-update');
            return;
        }

        inputElem.classList.remove('pending-update');
        inputElem.classList.add('updating');
        inputElem.disabled = true;

        updateOrderTotalAmount().then(() => {
            inputElem.setAttribute('data-original-value', value);
            inputElem.classList.remove('updating');
            inputElem.disabled = false;

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1000;
            toastr.success('Shipping charge updated successfully!');
        }).catch(() => {
            inputElem.value = originalValue;
            inputElem.classList.remove('updating');
            inputElem.disabled = false;

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;
            toastr.error('Failed to update shipping charge. Please try again.');
        });
    }

    // Improved Order Discount handling
    function handleOrderDiscountInput(inputElem) {
        inputElem.classList.add('pending-update');
        inputElem.classList.remove('updating');

        let discount = parseFloat(inputElem.value) || 0;
        var subtotalGross = parseFloat($("#subtotal_gross").val()) || 0;
        var itemDiscountTotal = parseFloat($("#item_discount_total").val()) || 0;
        var maxApplicable = Math.max(0, subtotalGross - itemDiscountTotal);

        if (inputElem.value !== '' && (isNaN(discount) || discount < 0 || discount > maxApplicable)) {
            inputElem.style.borderColor = '#dc3545';
            inputElem.style.backgroundColor = '#f8d7da';
        } else {
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';
        }
    }

    function handleOrderDiscountKeydown(event, inputElem) {
        if (event.key === 'Enter') {
            event.preventDefault();
            inputElem.blur();
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            let originalValue = inputElem.getAttribute('data-original-value');
            inputElem.value = originalValue;
            inputElem.classList.remove('pending-update');
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';
            inputElem.blur();
            return;
        }
    }

    function updateOrderDiscountOnBlur(inputElem) {
        let discount = parseFloat(inputElem.value) || 0;
        let originalValue = parseFloat(inputElem.getAttribute('data-original-value')) || 0;
        var subtotalGross = parseFloat($("#subtotal_gross").val()) || 0;
        var itemDiscountTotal = parseFloat($("#item_discount_total").val()) || 0;
        var maxApplicable = Math.max(0, subtotalGross - itemDiscountTotal);

        if (inputElem.value === '') {
            discount = 0;
            inputElem.value = 0;
        }

        if (isNaN(discount) || discount < 0) {
            inputElem.value = originalValue;
            inputElem.classList.remove('pending-update');
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;
            toastr.warning('Discount must be 0 or greater. Restored to previous value.');
            return;
        }

        if (discount > maxApplicable) {
            inputElem.value = originalValue;
            inputElem.classList.remove('pending-update');
            inputElem.style.borderColor = '';
            inputElem.style.backgroundColor = '';

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;
            toastr.error('Discount cannot be greater than subtotal (৳' + maxApplicable.toFixed(2) + ')!');
            return;
        }

        if (discount === originalValue) {
            inputElem.classList.remove('pending-update');
            return;
        }

        inputElem.classList.remove('pending-update');
        inputElem.classList.add('updating');
        inputElem.disabled = true;

        updateOrderTotalAmount().then(() => {
            inputElem.setAttribute('data-original-value', discount);
            inputElem.classList.remove('updating');
            inputElem.disabled = false;

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1000;
            toastr.success('Order discount updated successfully!');
        }).catch(() => {
            inputElem.value = originalValue;
            inputElem.classList.remove('updating');
            inputElem.disabled = false;

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;
            toastr.error('Failed to update order discount. Please try again.');
        });
    }

    // Improved main calculation function
    function updateOrderTotalAmount() {
        return new Promise((resolve, reject) => {
            var shippingCharge = parseFloat($("#shipping_charge").val()) || 0;
            var discount = parseFloat($("#discount").val()) || 0;
            var subtotalGross = parseFloat($("#subtotal_gross").val()) || 0;
            var itemDiscountTotal = parseFloat($("#item_discount_total").val()) || 0;
            var posDiscount = parseFloat($("#pos_discount").val()) || 0;

            var maxApplicable = Math.max(0, subtotalGross - itemDiscountTotal);
            if (discount > maxApplicable) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 2000;
                toastr.error("Discount cannot be greater than Order Amount");
                reject(new Error("Discount too high"));
                return;
            }

            var globalCouponPrice = (typeof couponPrice !== 'undefined') ? couponPrice : 0;

            var newPrice = (subtotalGross + shippingCharge) - (itemDiscountTotal + discount + posDiscount + globalCouponPrice);
            newPrice = Math.max(0, newPrice);

            var formattedPrice = '৳ ' + newPrice.toLocaleString("en-BD", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            var totalPriceDiv = document.getElementById("total_cart_calculation");
            if (totalPriceDiv) {
                totalPriceDiv.innerText = formattedPrice;
            }

            var totalInput = document.getElementById('total');
            if (totalInput) {
                totalInput.value = newPrice.toFixed(2);
            }

            var updateTotalUrl =
                "{{ route('UpdateOrderTotal', ['shipping_charge' => 'SHIPPING_PLACEHOLDER', 'discount' => 'DISCOUNT_PLACEHOLDER']) }}";
            updateTotalUrl = updateTotalUrl.replace('SHIPPING_PLACEHOLDER', encodeURIComponent(shippingCharge))
                .replace('DISCOUNT_PLACEHOLDER', encodeURIComponent(discount));

            $.get(updateTotalUrl)
                .done(function(data) {
                    resolve(data);
                })
                .fail(function(xhr, status, error) {
                    console.error('Failed to update order total:', error);
                    reject(new Error("AJAX request failed"));
                });
        });
    }

    // Legacy support for old calls
    function updateOrderTotalAmountLegacy() {
        updateOrderTotalAmount().catch(function(error) {
            console.error('Order total update failed:', error);
        });
    }
</script>
