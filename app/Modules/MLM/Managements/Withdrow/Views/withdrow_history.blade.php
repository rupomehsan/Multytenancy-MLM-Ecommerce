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
    Withdrawal History
@endsection

@section('page_heading')
    Withdrawal Management
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Withdraw History</h4>

            <div class="table-responsive mt-3">
                <table id="withdrawHistoryTable" class="table table-bordered table-hover">
                    <thead style="background:#17263A; color:white;">
                        <tr>
                            <th>User Name</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Account Details</th>
                            <th>Status</th>
                            <th>Requested At</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ url('tenant/admin/dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing Withdrawal History DataTable...');

            var table = $('#withdrawHistoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.withdraw.history') }}",
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
                        data: 'account_details',
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
                        data: 'requested_at',
                        name: 'wr.created_at',
                        orderable: true,
                        searchable: false
                    }
                ],
                order: [
                    [5, 'desc']
                ], // Sort by requested date
                pageLength: 25,
                language: {
                    emptyTable: "No withdrawal history found",
                    zeroRecords: "No matching withdrawals found"
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
