@extends('tenant.admin.layouts.app')

@section('title')
    Order Logs - Activity Timeline
@endsection

@section('header_css')
    <link href="{{ asset('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }} " rel="stylesheet">

    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .badge {
            padding: 5px 10px;
            font-size: 11px;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .info-item {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
            min-width: 150px;
            display: inline-block;
        }

        .info-value {
            color: #6c757d;
        }

        .metadata-block {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Order Logs - Activity Timeline</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/view/orders') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Order Logs</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-history me-2"></i> Order Activity Logs
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="order-logs-table"
                                    class="table table-bordered table-striped dt-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Order No</th>
                                            <th width="12%">Activity Type</th>
                                            <th width="10%">Source</th>
                                            <th width="10%">Performed By</th>
                                            <th width="20%">Activity</th>
                                            <th width="18%">Description</th>
                                            <th width="10%">Date & Time</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Log Details Modal -->
    <div class="modal fade" id="logDetailsModal" tabindex="-1" role="dialog" aria-labelledby="logDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel">
                        <i class="fas fa-info-circle me-2"></i> Log Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="logDetailsContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ asset('tenant/admin/dataTable/js/jquery.validate.js') }} "></script>
    <script src="{{ asset('tenant/admin/dataTable/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }} "></script>


    <script type="text/javascript">
        $(document).ready(function() {
            console.log('Initializing DataTable...');

            // Initialize DataTable
            var table = $('#order-logs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('view/orders/log') }}",
                    type: "GET",
                    error: function(xhr, error, code) {
                        console.log('DataTables AJAX Error:', xhr, error, code);
                        alert('Error loading data: ' + xhr.responseText);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_no',
                        name: 'o.order_no'
                    },
                    {
                        data: 'activity_type',
                        name: 'ol.activity_type'
                    },
                    {
                        data: 'action_source',
                        name: 'ol.action_source'
                    },
                    {
                        data: 'performed_by_name',
                        name: 'u.name'
                    },
                    {
                        data: 'title',
                        name: 'ol.title'
                    },
                    {
                        data: 'description',
                        name: 'ol.description'
                    },
                    {
                        data: 'created_at',
                        name: 'ol.created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [7, 'desc']
                ], // Order by created_at descending
                pageLength: 25,
                responsive: true,
                language: {
                    emptyTable: "No order logs available",
                    zeroRecords: "No matching order logs found"
                },
                initComplete: function(settings, json) {
                    console.log('DataTable initialized successfully');
                    console.log('Data received:', json);
                }
            });

            console.log('DataTable object:', table);

            // View Details Button Click
            $('#order-logs-table').on('click', '.view-details-btn', function() {
                var logId = $(this).data('id');

                // Show modal
                $('#logDetailsModal').modal('show');

                // Load log details via AJAX
                $.ajax({
                    url: "{{ url('view/order/log/details') }}/" + logId,
                    type: 'GET',
                    success: function(response) {
                        $('#logDetailsContent').html(response);
                    },
                    error: function() {
                        $('#logDetailsContent').html(
                            '<div class="alert alert-danger">Failed to load log details.</div>'
                        );
                    }
                });
            });

            // Tooltip initialization
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
