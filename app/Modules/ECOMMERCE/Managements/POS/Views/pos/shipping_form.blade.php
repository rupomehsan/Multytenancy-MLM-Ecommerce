<div class="table-responsive">
    <table class="table mb-0">
        <tbody>
            <tr>
                <th style="width: 30%; line-height: 36px;">Full Name<span class="text-danger">*</span></th>
                <td>
                    <input type="text" name="shipping_name" id="shipping_name"
                        class="form-control {{ $errors->has('shipping_name') ? 'is-invalid' : '' }}"
                        placeholder="Full Name" value="{{ old('shipping_name') }}"
                        aria-invalid="{{ $errors->has('shipping_name') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_name') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Customer Phone<span class="text-danger">*</span></th>
                <td>
                    <input type="text" name="shipping_phone" id="shipping_phone"
                        class="form-control {{ $errors->has('shipping_phone') ? 'is-invalid' : '' }}"
                        placeholder="Phone No" value="{{ old('shipping_phone') }}"
                        aria-invalid="{{ $errors->has('shipping_phone') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_phone') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Customer Email</th>
                <td>
                    <input type="email" name="shipping_email" id="shipping_email"
                        class="form-control {{ $errors->has('shipping_email') ? 'is-invalid' : '' }}"
                        placeholder="Email" value="{{ old('shipping_email') }}"
                        aria-invalid="{{ $errors->has('shipping_email') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_email') }}</strong></div>
                </td>
            </tr>

            <tr>
                <th style="width: 30%; line-height: 36px;">Customer Address <span class="text-danger">*</span></th>
                <td>
                    <input type="text" name="shipping_address" id="shipping_address"
                        class="form-control {{ $errors->has('shipping_address') ? 'is-invalid' : '' }}"
                        placeholder="Street No/House No/Area" value="{{ old('shipping_address') }}"
                        aria-invalid="{{ $errors->has('shipping_address') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_address') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Shipping City <span class="text-danger">*</span></th>
                <td>
                    <select class="form-control {{ $errors->has('shipping_district_id') ? 'is-invalid' : '' }}"
                        name="shipping_district_id" id="shipping_district_id" data-toggle="select2"
                        aria-invalid="{{ $errors->has('shipping_district_id') ? 'true' : 'false' }}">
                        <option value="">Select One</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ old('shipping_district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_district_id') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Sub-District/State <span class="text-danger">*</span></th>
                <td>
                    <select name="shipping_thana_id" data-toggle="select2" id="shipping_thana_id"
                        class="form-control {{ $errors->has('shipping_thana_id') ? 'is-invalid' : '' }}"
                        aria-invalid="{{ $errors->has('shipping_thana_id') ? 'true' : 'false' }}">
                        <option value="">Select One</option>
                        @if (old('shipping_thana_id') && !empty(old('shipping_thana_id')))
                            <option value="{{ old('shipping_thana_id') }}" selected>
                                {{ old('shipping_thana_name', 'Selected') }}</option>
                        @endif
                    </select>
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_thana_id') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Post Code</th>
                <td>
                    <input type="text" name="shipping_postal_code" id="shipping_postal_code"
                        class="form-control {{ $errors->has('shipping_postal_code') ? 'is-invalid' : '' }}"
                        placeholder="Post Code" value="{{ old('shipping_postal_code') }}"
                        aria-invalid="{{ $errors->has('shipping_postal_code') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('shipping_postal_code') }}</strong></div>
                </td>
            </tr>

            <tr>
                <th style="width: 30%; line-height: 36px;">Reference Code</th>
                <td>
                    <input type="text" name="reference_code" id="reference_code"
                        class="form-control {{ $errors->has('reference_code') ? 'is-invalid' : '' }}"
                        placeholder="Reference Code" value="{{ old('reference_code') }}"
                        aria-invalid="{{ $errors->has('reference_code') ? 'true' : 'false' }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('reference_code') }}</strong></div>
                </td>
            </tr>

            {{-- <tr>
                <th style="width: 30%; line-height: 36px;">Warehouse</th>
                <td>
                    <select class="form-control" name="purchase_product_warehouse_id" id="purchase_product_warehouse_id" >
                        <option value="">Select One</option>
                        @foreach ($warehouses as $warehouse)
                        <option value="{{$warehouse->id}}">{{$warehouse->title}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th style="width: 30%; line-height: 36px;">Warehouse Room</th>
                <td>
                    <select class="form-control" name="purchase_product_warehouse_room_id" id="purchase_product_warehouse_room_id"  >
                        <option value="">Select One</option>
                        @foreach ($warehouse_rooms as $room)
                        <option value="{{$room->id}}">{{$room->title}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th style="width: 30%; line-height: 36px;">Warehouse Room Cartoon</th>
                <td>
                    <select class="form-control" name="purchase_product_warehouse_room_cartoon_id" id="purchase_product_warehouse_room_cartoon_id" >
                        <option value="">Select One</option>
                        @foreach ($room_cartoons as $cartoon)
                        <option value="{{$cartoon->id}}">{{$cartoon->title}}</option>
                        @endforeach
                    </select>
                </td>
            </tr> --}}

            <tr>
                <th style="width: 30%; line-height: 36px;">Customer Source Type</th>
                <td>
                    <select class="form-control {{ $errors->has('customer_source_type_id') ? 'is-invalid' : '' }}"
                        name="customer_source_type_id" id="customer_source_type_id"
                        aria-invalid="{{ $errors->has('customer_source_type_id') ? 'true' : 'false' }}">
                        <option value="">Select One</option>
                        @foreach ($customer_source_types as $customer_source_type)
                            <option value="{{ $customer_source_type->id }}"
                                {{ old('customer_source_type_id') == $customer_source_type->id ? 'selected' : '' }}>
                                {{ $customer_source_type->title }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th style="width: 30%; line-height: 36px;">Outlet</th>
                <td>
                    <select class="form-control {{ $errors->has('outlet_id') ? 'is-invalid' : '' }}" name="outlet_id"
                        id="outlet_id" aria-invalid="{{ $errors->has('outlet_id') ? 'true' : 'false' }}">
                        <option value="">Select One</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}"
                                {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->title }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"><strong>{{ $errors->first('outlet_id') }}</strong></div>
                </td>
            </tr>


        </tbody>
    </table>
</div>

@push('styles')
    <style>
        /* Make Select2 selection show Bootstrap invalid styles */
        .select2-container--default .select2-selection.is-invalid,
        .select2-container--default .select2-selection--single.is-invalid,
        .select2-container.is-invalid .select2-selection,
        .select2-container.is-invalid .select2-selection--single {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .25) !important;
        }

        /* Ensure invalid feedback is visible */
        .is-invalid~.invalid-feedback {
            display: block !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function($) {
            function applyInvalidStyleToSelect2() {
                try {
                    var selects = ['#shipping_district_id', '#shipping_thana_id', '#customer_source_type_id',
                        '#outlet_id'
                    ];
                    selects.forEach(function(sel) {
                        var $sel = $(sel);
                        if (!$sel.length) return;
                        if ($sel.hasClass('is-invalid')) {
                            // Method 1: Use Select2 data
                            var s2data = $sel.data('select2');
                            if (s2data && s2data.$container) {
                                s2data.$container.addClass('is-invalid');
                                s2data.$container.find('.select2-selection').addClass('is-invalid');
                            } else {
                                // Method 2: Find sibling or next Select2 container
                                var $s2Container = $sel.next('.select2-container');
                                if (!$s2Container.length) $s2Container = $sel.siblings('.select2-container')
                                    .first();
                                if ($s2Container.length) {
                                    $s2Container.addClass('is-invalid');
                                    $s2Container.find('.select2-selection').addClass('is-invalid');
                                }
                            }
                        }
                    });
                } catch (e) {
                    console.error('Select2 invalid style error:', e);
                }
            }

            $(document).ready(function() {
                // Run immediately
                applyInvalidStyleToSelect2();

                // Run after a short delay to ensure Select2 is initialized
                setTimeout(applyInvalidStyleToSelect2, 100);
                setTimeout(applyInvalidStyleToSelect2, 500);
            });
        })(jQuery);
    </script>
@endpush
