@extends('tenant.admin.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }}">
    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }

        .user-info {
            line-height: 1.4;
        }

        .user-info .text-muted {
            font-size: 12px;
        }
    </style>
@endsection

@section('page_title')
    Withdrawal Requests
@endsection

@section('page_heading')
    Withdrawal Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Withdrawal Requests</h4>

                    <div class="table-responsive mt-3">
                        <table id="withdrawRequestTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User</th>
                                    <th>User ID</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Payment Details</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ url('tenant/admin/dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing Withdrawal Request DataTable...');

            var table = $('#withdrawRequestTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.user.withdraw.request') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'user',
                        name: 'u.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user_id_badge',
                        name: 'wr.user_id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'amount_formatted',
                        name: 'wr.amount',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'payment_method_badge',
                        name: 'wr.payment_method',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'payment_info',
                        name: 'wr.payment_details',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status_badge',
                        name: 'wr.status',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'request_date',
                        name: 'wr.created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [6, 'desc']
                ], // Sort by request date
                pageLength: 25,
                language: {
                    emptyTable: "No withdrawal requests found",
                    zeroRecords: "No matching requests found"
                }
            });

            // Approve button handler
            $(document).on('click', '.approve-btn', function() {
                var requestId = $(this).data('id');
                if (confirm('Are you sure you want to approve this withdrawal request?')) {
                    // TODO: Implement approve AJAX call
                    console.log('Approve request:', requestId);
                    alert('Approve functionality to be implemented');
                }
            });

            // Reject button handler
            $(document).on('click', '.reject-btn', function() {
                var requestId = $(this).data('id');
                if (confirm('Are you sure you want to reject this withdrawal request?')) {
                    // TODO: Implement reject AJAX call
                    console.log('Reject request:', requestId);
                    alert('Reject functionality to be implemented');
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
