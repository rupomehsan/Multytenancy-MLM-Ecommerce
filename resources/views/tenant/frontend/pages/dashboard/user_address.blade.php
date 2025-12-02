@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend/frontend_assets') }}/css/user-pannel.css" />
    <link href="{{ url('frontend_assets') }}/css/plugins/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        select.form-select {
            width: 100%;
            height: 48px;
            padding: 12px !important;
            line-height: 24px;
            font-size: 16px;
            font-weight: 500;
        }

        .select2-selection {
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }

        .select2 {
            width: 100% !important;
        }

        .select2 .selection {
            width: 100%;
        }

        .select2-selection {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 37px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        .select-style-2 .nice-select .list {
            max-height: 240px;
            overflow: scroll;
        }

        /* Toggle Switch Styles */
        .default-toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .default-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #28a745;
        }

        input:focus+.toggle-slider {
            box-shadow: 0 0 1px #28a745;
        }

        input:checked+.toggle-slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        .address-default-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #e9ecef;
            margin-top: 15px;
        }

        .default-label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
        }

        .address-card {
            position: relative;
        }

        .default-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
@endsection

@push('site-seo')
    @php
        // using shared $generalInfo provided by AppServiceProvider
    @endphp
    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif
@endpush

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.dashboard.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt=""
                            src="{{ url('tenant/frontend/frontend_assets') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('tenant.frontend.pages.dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="dashboard-address mgTop24">


                        <div class="dashboard-head-widget style-2" style="margin: 0">
                            <h5 class="dashboard-head-widget-title">Address</h5>
                            <div class="dashboard-head-widget-btn">
                                <button type="button"
                                    class="widget-show-btn theme-btn secondary-btn icon-right btn btn-primary">
                                    <i class="fi-rr-plus"></i> Add new address
                                </button>
                            </div>
                            <div class="add-new-address-widget">
                                <form action="{{ url('save/user/address') }}" method="post" class="add-new-address-form">
                                    @csrf
                                    <i class="close-icon fi-rr-cross-small"></i>
                                    <div class="form-group select-form">
                                        <label class="form-label" for="address_type">Address type</label>
                                        <select name="address_type" required="" id="address_type" class="form-select"
                                            required>
                                            <option value="">Select</option>
                                            <option value="Home">Home</option>
                                            <option value="Office">Office</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Address line</label>
                                        <input name="adress_line" placeholder="Address" style="font-weight: 500;"
                                            type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group select-form">
                                        @php
                                            $districts = DB::table('districts')->orderBy('name', 'asc')->get();
                                        @endphp
                                        <label class="form-label" for="city">Select District</label>
                                        <select name="shipping_district_id" id="shipping_district_id" data-toggle="select2"
                                            class="form-select" required>
                                            <option value="">Select</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group select-form">
                                        <label class="form-label" for="state">Select Thana/Upazila</label>
                                        <select name="shipping_thana_id" id="shipping_thana_id" data-toggle="select2"
                                            class="form-select" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Postal code</label>
                                        <input name="postal_code" placeholder="ex: 1000" style="font-weight: 500;"
                                            type="text" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <input type="checkbox" name="set_as_default" id="set_as_default" value="1">
                                            <label for="set_as_default" class="form-label" style="margin-bottom: 0;">Set as
                                                default address</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="add-new-address-form-btn theme-btn btn btn-primary">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="dashboard-address-widget">

                            @foreach ($addresses as $address)
                                {{-- for update purpose --}}
                                <input type="hidden" id="update_address_type_{{ $address->slug }}"
                                    value="{{ $address->address_type }}">
                                <input type="hidden" id="update_address_line_{{ $address->slug }}"
                                    value="{{ $address->address }}">
                                <input type="hidden" id="update_city_{{ $address->slug }}" value="{{ $address->city }}">
                                @php
                                    $districtInfo = DB::table('districts')->where('name', $address->city)->first();
                                @endphp
                                <input type="hidden" id="update_city_id_{{ $address->slug }}"
                                    value="{{ $districtInfo ? $districtInfo->id : '' }}">
                                <input type="hidden" id="update_state_{{ $address->slug }}"
                                    value="{{ $address->state }}">
                                <input type="hidden" id="update_post_code_{{ $address->slug }}"
                                    value="{{ $address->post_code }}">

                                <div class="address-card">
                                    @if ($address->is_default == 1)
                                        <div class="default-badge">Default</div>
                                    @endif
                                    <div class="address-card-head">
                                        <div class="address-card-head-title">
                                            <div class="address-card-head-icon">
                                                @if ($address->address_type == 'Home')
                                                    <img alt="#"
                                                        src="{{ url('tenant/frontend/frontend_assets') }}/assets/images/icons/home.svg">
                                                @else
                                                    <img alt="#"
                                                        src="{{ url('tenant/frontend/frontend_assets') }}/assets/images/icons/briefcase.svg">
                                                @endif
                                            </div>
                                            <h4>{{ $address->address_type }} Address</h4>
                                        </div>
                                        <div class="address-card-head-menu dropdown">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fi-rs-menu-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <a class="dropdown-item editAddress" href="javascript:void(0)"
                                                    data-toggle="tooltip" data-id="{{ $address->slug }}" title="Edit"
                                                    data-original-title="Edit">Edit Address</a>
                                                <a class="dropdown-item"
                                                    href="{{ url('remove/user/address') }}/{{ $address->slug }}">Remove
                                                    address</a>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="address-card-content-list">
                                        <li>
                                            <span>Address line</span><strong>{{ $address->address }}</strong>
                                        </li>
                                        <li><span>District/City</span><strong>{{ $address->city }}</strong></li>
                                        <li><span>Thana/Upazila</span><strong>{{ $address->state }}</strong></li>
                                        <li><span>Postal code</span><strong>{{ $address->post_code }}</strong></li>
                                    </ul>
                                    <div class="address-default-section">
                                        <span class="default-label">Set as Default Address</span>
                                        <label class="default-toggle">
                                            <input type="checkbox" class="default-checkbox"
                                                data-address-slug="{{ $address->slug }}"
                                                {{ $address->is_default == 1 ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Edit Address Modal -->
    <div class="edit-address-modal modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="edit-address-modal-haed modal-header">
                    <div class="edit-address-modal-title modal-title h4">
                        Edit Address
                    </div>
                    <div class="btn-close edit-address-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fi-rr-cross-small"></i>
                    </div>
                </div>
                <div class="edit-address-modal-body modal-body">
                    <form id="productForm2" class="edit-address-modal-form">
                        <input type="hidden" name="address_slug" id="address_slug">
                        {{-- <div class="form-group select-form">
                            <label class="form-label" for="edit_address_type">Address type</label>
                            <select name="edit_address_type" id="edit_address_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label class="form-label" for="edit_address_line">Address line</label>
                            <input type="text" name="edit_address_line" id="edit_address_line" class="form-control"
                                value="" required />
                        </div>
                        <div class="form-group select-form">
                            <label class="form-label" for="edit_district_id">Select District</label>
                            <select name="edit_district_id" id="edit_district_id" class="form-select" required>
                                <option value="">Select</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group select-form">
                            <label class="form-label" for="state">Select Thana/Upazila</label>
                            <select name="edit_shipping_thana_id" id="edit_shipping_thana_id" class="form-select"
                                required>
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="edit_postal_Code">Postal code</label>
                            <input name="edit_postal_Code" placeholder="ex: 1000" required="" type="text"
                                id="edit_postal_Code" class="form-control" value="" />
                        </div>
                        <button type="button" id="updateBtn" class="add-new-address-form-btn theme-btn btn btn-primary">
                            Update Address
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Address Modal -->
@endsection


@section('footer_js')
    <script src="{{ url('tenant/frontend/frontend_assets') }}/js/plugins/select2.min.js"></script>
    <script>
        $('[data-toggle="select2"]').select2();

        $('#shipping_district_id').on('change', function() {
            var district_id = this.value;
            $("#shipping_thana_id").html('');
            $.ajax({
                url: "{{ url('/district/wise/thana') }}",
                type: "POST",
                data: {
                    district_id: district_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#shipping_thana_id').html(
                        '<option data-display="Select One" value="">Select Thana</option>');
                    $.each(result.data, function(key, value) {
                        $("#shipping_thana_id").append('<option value="' + value.id + '">' +
                            value.name + '</option>');
                    });
                }
            });
        });

        $('#edit_district_id').on('change', function() {
            var district_id = this.value;
            $("#edit_shipping_thana_id").html('');
            $.ajax({
                url: "{{ url('/district/wise/thana') }}",
                type: "POST",
                data: {
                    district_id: district_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#edit_shipping_thana_id').html(
                        '<option data-display="Select One" value="">Select Thana</option>');
                    $.each(result.data, function(key, value) {
                        $("#edit_shipping_thana_id").append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });
        });


        $('body').on('click', '.editAddress', function() {
            var slug = $(this).data('id');
            $('#staticBackdrop').modal('show');
            $('#address_slug').val(slug);
            // $('#edit_address_type').val($("#update_address_type_"+slug).val());
            $('#edit_address_line').val($("#update_address_line_" + slug).val());
            $('#edit_postal_Code').val($("#update_post_code_" + slug).val());
            $("#edit_district_id option:contains('" + $("#update_city_" + slug).val() + "')").prop("selected",
                true);
            var district_id = $("#update_city_id_" + slug).val();
            $("#edit_shipping_thana_id").html('');
            $.ajax({
                url: "{{ url('/district/wise/thana') }}",
                type: "POST",
                data: {
                    district_id: district_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#edit_shipping_thana_id').html(
                        '<option data-display="Select One" value="">Select Thana</option>');
                    $.each(result.data, function(key, value) {
                        $("#edit_shipping_thana_id").append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                    $("#edit_shipping_thana_id option:contains('" + $("#update_state_" + slug).val() +
                        "')").prop("selected", true);
                }
            });

        });


        $('#updateBtn').click(function(e) {

            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1500;

            if ($('#edit_address_type').val() == '') {
                toastr.error("Address Type is Missing");
                return false;
            }
            if ($('#edit_address_line').val() == '') {
                toastr.error("Address Line is Missing");
                return false;
            }
            if ($('#edit_district_id').val() == '') {
                toastr.error("District is Missing");
                return false;
            }
            if ($('#edit_shipping_thana_id').val() == '') {
                toastr.error("Thana/Upazila is Missing");
                return false;
            }
            if ($('#edit_postal_Code').val() == '') {
                toastr.error("Post Code is Missing");
                return false;
            }

            e.preventDefault();
            $(this).html('Saving..');
            $.ajax({
                data: $('#productForm2').serialize(),
                url: "{{ url('update/user/address') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#updateBtn').html('Save');
                    $('#productForm2').trigger("reset");
                    $('#staticBackdrop').modal('hide');
                    toastr.success("Address Updated Successfully");
                    setTimeout(function() {
                        location.reload(true);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    toastr.warning("Something Went Wrong");
                    $('#saveBtn').html('Save');
                }
            });
        });


        $(document).ready(function() {
            $(".widget-show-btn").click(function() {
                $(".add-new-address-widget").toggleClass("active");
            });

            // Adding functionality to the close icon
            $(".add-new-address-widget .close-icon").click(function() {
                $(".add-new-address-widget").removeClass("active");
            });

            // Default address toggle functionality
            $('.default-checkbox').on('change', function() {
                var checkbox = $(this);
                var addressSlug = checkbox.data('address-slug');
                var isChecked = checkbox.is(':checked');

                // Disable all checkboxes during request
                $('.default-checkbox').prop('disabled', true);

                $.ajax({
                    url: "{{ url('toggle/default/address') }}",
                    type: "POST",
                    data: {
                        address_slug: addressSlug,
                        is_default: isChecked ? 1 : 0,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            // Reload page to update all default badges and checkboxes
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response.message || 'Something went wrong');
                            // Revert checkbox state
                            checkbox.prop('checked', !isChecked);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Failed to update default address');
                        // Revert checkbox state
                        checkbox.prop('checked', !isChecked);
                    },
                    complete: function() {
                        // Re-enable all checkboxes
                        $('.default-checkbox').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
