@extends('tenant.admin.layouts.app')

@section('page_title')
    Orders
@endsection
@section('page_heading')
    Orders Details
@endsection
@section('header_css')
    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }

            .badge {
                border: none !important;
                box-shadow: none !important;
            }
        }

        table tbody tr td {
            padding: 5px 10px !important
        }

        table thead tr th {
            padding: 5px 10px !important
        }

        address {
            font-size: 15px;
        }

        address h6 {
            font-size: 15px;
        }

        .order_details_text p {
            font-size: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card" id="printableArea">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-left">
                            <h4 class="m-0">{{ optional($generalInfo)->company_name ?? '' }}</h4>
                        </div>
                        <div class="col text-center">
                            @if (file_exists(public_path(optional($generalInfo)->logo_dark ?? '')) && optional($generalInfo)->logo_dark)
                                <img src="{{ url(optional($generalInfo)->logo_dark ?? '') }}" alt="" height="50">
                            @endif
                        </div>
                        <div class="col text-right">
                            <h4 class="m-0">Invoice</h4>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-6">

                            @if ($shippingInfo)
                                <h6 class="font-weight-bold">Shipping Info :</h6>
                                <address class="line-h-24">
                                    <b>Name : {{ $shippingInfo->full_name }}</b><br>
                                    Phone : {{ $shippingInfo->phone }}<br>
                                    Email : {{ $shippingInfo->email }}<br>
                                    Street : {{ $shippingInfo->address }}<br>
                                    @if ($shippingInfo->thana)
                                        Thana : {{ $shippingInfo->thana }}<br>
                                    @endif
                                    District : {{ $shippingInfo->city }}<br>
                                    Postal code : {{ $shippingInfo->post_code }}, {{ $shippingInfo->country }}<br>
                                </address>
                            @endif

                        </div><!-- end col -->
                        <div class="col-6">
                            <div class="mt-3 float-right order_details_text">
                                <p class="mb-1"><strong>Order NO: </strong> #{{ $order->order_no }}</p>
                                <p class="mb-1"><strong>Tran. ID: </strong> #{{ $order->trx_id }}</p>
                                <p class="mb-1"><strong>Order Date: </strong>
                                    {{ date('jS F, Y', strtotime($order->order_date)) }}</p>
                                <p class="mb-1"><strong>Order Status: </strong>
                                    {!! $order->orderStatusBadge !!}
                                </p>
                                <p class="mb-1"><strong>Delivery Method: </strong>
                                    {!! $deliveryMethodBadge !!}
                                </p>
                                <p class="mb-1"><strong>Payment Method: </strong>
                                    {!! $paymentMethodBadge !!}
                                </p>
                                <p class="mb-1"><strong>Payment Status: </strong>
                                    {!! $paymentStatusBadge !!}
                                </p>
                                @if ($order->reference_code)
                                    <p class="mb-1"><strong>Reference: </strong>
                                        {{-- @php
                                    if($order->payment_status == 0){
                                    echo '<span class="badge badge-soft-warning"
                                        style="padding: 2px 10px !important;">Unpaid</span>';
                                    } elseif($order->payment_status == 1) {
                                    echo '<span class="badge badge-soft-success"
                                        style="padding: 2px 10px !important;">Paid</span>';
                                    } else {
                                    echo '<span class="badge badge-soft-danger"
                                        style="padding: 2px 10px !important;">Failed</span>';
                                    }
                                    @endphp --}}
                                        <span class="badge badge-soft-success"
                                            style="padding: 2px 10px !important;">{{ $order->reference_code }}</span>
                                    </p>
                                @endif
                                @if ($order->customer_src_type_id)
                                    <p class="m-b-10"><strong>Customer Source Type: </strong>
                                        {{-- @php
                                    if($order->payment_status == 0){
                                    echo '<span class="badge badge-soft-warning"
                                        style="padding: 2px 10px !important;">Unpaid</span>';
                                    } elseif($order->payment_status == 1) {
                                    echo '<span class="badge badge-soft-success"
                                        style="padding: 2px 10px !important;">Paid</span>';
                                    } else {
                                    echo '<span class="badge badge-soft-danger"
                                        style="padding: 2px 10px !important;">Failed</span>';
                                    }
                                    @endphp --}}
                                        <span class="badge badge-soft-success"
                                            style="padding: 2px 10px !important;">{{ $order->customerSourceType->title }}</span>
                                    </p>
                                @endif
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 60px;">SL</th>
                                            <th>Item</th>
                                            <th class="text-center">Variant</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Cost</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 1;
                                        @endphp
                                        @foreach ($orderDetails as $details)
                                            <tr>
                                                <td class="text-center">{{ $sl++ }}</td>
                                                <td>
                                                    @if ($details->is_package == 1)
                                                        <span class="badge badge-soft-info">Package</span>
                                                    @else
                                                        <span class="badge badge-soft-success">Product</span>
                                                    @endif
                                                    <b>{{ $details->product_name }}</b>
                                                    <br />
                                                    Category : {{ $details->category_name }},
                                                    Warehouse : {{ $details->warehouse_title }},
                                                    Room : {{ $details->warehouse_room_title }},
                                                    Cartoon: {{ $details->warehouse_room_cartoon_title }}
                                                </td>
                                                <td class="text-center">
                                                    @if (isset($details->color_name))
                                                        Color: {{ $details->color_name }} |
                                                    @endif
                                                    @if (isset($details->storage_info))
                                                        Storage: {{ $details->storage_info }} |
                                                    @endif
                                                    @if (isset($details->sim_name))
                                                        SIM: {{ $details->sim_name }}
                                                    @endif
                                                    @if (isset($details->size_name))
                                                        Size: {{ $details->size_name }}
                                                    @endif

                                                    <br>
                                                    @if (isset($details->region_name))
                                                        Region: {{ $details->region_name }} |
                                                    @endif
                                                    @if (isset($details->warranty_name))
                                                        Warranty: {{ $details->warranty_name }} |
                                                    @endif
                                                    @if (isset($details->device_condition_name))
                                                        Condition: {{ $details->device_condition_name }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $details->qty }} {{ $details->unit_name }}</td>
                                                <td class="text-center">৳ {{ number_format($details->unit_price, 2) }}</td>
                                                <td class="text-right">৳ {{ number_format($details->total_price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="clearfix pt-3">
                                <h6 class="text-muted">Billing Address:</h6>
                                @if ($billingAddress)
                                    <address class="line-h-24">
                                        {{ $billingAddress->address }},
                                        @if ($shippingInfo->thana)
                                            {{ $shippingInfo->thana }}<br>
                                        @endif
                                        {{ $billingAddress->city }} {{ $billingAddress->post_code }},
                                        {{ $billingAddress->country }}<br>
                                    </address>
                                @endif
                            </div>

                            @if ($userInfo)
                                <div class="clearfix pt-2">
                                    <h6 class="text-muted">User Account Info:</h6>
                                    <address class="line-h-24">
                                        {{ $userInfo->name }}<br>
                                        @if ($userInfo->email)
                                            {{ $userInfo->email }}<br>
                                        @endif
                                        @if ($userInfo->phone)
                                            {{ $userInfo->phone }}<br>
                                        @endif
                                        @if ($userInfo->address)
                                            {{ $userInfo->address }}
                                        @endif
                                    </address>
                                </div>
                            @endif

                            @if ($order->order_note)
                                <div class="clearfix pt-2">
                                    <h6 class="text-muted">Order note by Customer:</h6>
                                    <p>
                                        {{ $order->order_note }}
                                    </p>
                                </div>
                            @endif

                        </div>
                        <div class="col-6 text-right">
                            <div class="float-right">
                                <p><b>Sub-total :</b> ৳ {{ number_format($order->sub_total, 2) }}</p>
                                <p><b>Discount @if ($order->coupon_code)
                                            ({{ $order->coupon_code }})
                                        @endif:</b> ৳
                                    {{ number_format($order->discount, 2) }}
                                </p>
                                <p><b>VAT/TAX :</b> ৳ {{ number_format($order->vat + $order->tax, 2) }}</p>
                                <p><b>Delivery Charge :</b> ৳ {{ number_format($order->delivery_fee, 2) }}</p>
                                <h3><b>Total Order Amount :</b> ৳ {{ number_format($order->total, 2) }}</h3>
                            </div>
                            <div class="clearfix"></div>

                            <div class="hidden-print mt-4 mb-4">
                                <div class="text-right">
                                    <a href="javascript:void(0);" onclick="printPageArea('printableArea')"
                                        class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i>
                                        Print Invoice</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-3">
                <form action="{{ url('order/info/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group" style="margin-bottom: 0px">
                                <label style="margin-bottom: .2rem; font-weight: 500;">Special Note For Order (Visible by
                                    Admin Only) :</label>
                                <textarea name="order_remarks" class="form-control" style="height: 149px !important;"
                                    placeholder="Special Note By Admin">{{ $order->order_remarks }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" style="margin-bottom: .5rem;">
                                <label style="margin-bottom: .2rem; font-weight: 500;">Est. Delivery Date :</label>
                                <input type="date" class="form-control" name="estimated_dd"
                                    value="{{ $order->estimated_dd }}" required>
                            </div>

                            <div class="form-group" style="margin-bottom: .5rem;">
                                <label style="margin-bottom: .2rem; font-weight: 500;">Order Status :</label>
                                <select name="order_status" class="form-control" required>
                                    <option value="">Change Status</option>
                                    @foreach ($orderStatuses as $statusValue => $statusName)
                                        @php
                                            $isAvailable = array_key_exists($statusValue, $availableStatuses);
                                        @endphp
                                        <option value="{{ $statusValue }}"
                                            @if ($order->order_status == $statusValue) selected @endif
                                            @if (!$isAvailable) disabled @endif>
                                            {{ $statusName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="delivery-man-group" style="display: none;">
                                <label style="margin-bottom: .2rem; font-weight: 500;">Delivery Man :</label>
                                <select name="delivery_man_id" class="form-control">
                                    <option value="">Select Delivery Man</option>
                                    @foreach ($delivery_man as $deliveryMan)
                                        <option value="{{ $deliveryMan->id }}"
                                            @if ($order->orderDeliveryMen?->delivery_man_id == $deliveryMan->id) selected @endif>
                                            {{ $deliveryMan->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success rounded w-100 mt-1">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>

        </div> <!-- end col -->
    </div>
@endsection

@section('footer_js')
    <script>
        function printPageArea(areaID) {
            var printContent = document.getElementById(areaID).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
    <script>
        const ORDER_STATUS_DISPATCH = {{ $statusConstants['STATUS_DISPATCH'] }};
        const ORDER_STATUS_INTRANSIT = {{ $statusConstants['STATUS_INTRANSIT'] }};
        const ORDER_STATUS_CANCELLED = {{ $statusConstants['STATUS_CANCELLED'] }};
        const ORDER_STATUS_DELIVERED = {{ $statusConstants['STATUS_DELIVERED'] }};
        const ORDER_STATUS_RETURN = {{ $statusConstants['STATUS_RETURN'] }};
        document.querySelector('select[name="order_status"]').addEventListener('change', function() {
            const deliveryManGroup = document.getElementById('delivery-man-group');
            const deliveryManSelect = document.querySelector('select[name="delivery_man_id"]');

            if (this.value == ORDER_STATUS_DISPATCH) {
                deliveryManGroup.style.display = 'block';
                deliveryManSelect.required = true;
            } else {
                deliveryManGroup.style.display = 'none';
                deliveryManSelect.required = false;
            }
        });

        // Show delivery man field on page load if status is already dispatch
        document.addEventListener('DOMContentLoaded', function() {
            const orderStatus = document.querySelector('select[name="order_status"]').value;
            const deliveryManGroup = document.getElementById('delivery-man-group');
            const deliveryManSelect = document.querySelector('select[name="delivery_man_id"]');

            if (orderStatus == ORDER_STATUS_DISPATCH || orderStatus == ORDER_STATUS_INTRANSIT ||
                orderStatus == ORDER_STATUS_DELIVERED || orderStatus == ORDER_STATUS_RETURN) {
                deliveryManGroup.style.display = 'block';

                // Make required only for dispatch status
                if (orderStatus == ORDER_STATUS_DISPATCH) {
                    deliveryManSelect.required = true;
                }

                // Disable select for status 3 (Intransit), 5 (Delivered), or 6 (Return)
                if (orderStatus == ORDER_STATUS_INTRANSIT || orderStatus == ORDER_STATUS_DELIVERED ||
                    orderStatus == ORDER_STATUS_RETURN) {
                    deliveryManSelect.disabled = true;
                }
            }
        });
    </script>
@endsection
