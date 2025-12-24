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
    Referral Activity Log
@endsection

@section('page_heading')
    Referral Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Referral Activity Log</h4>

                    <div class="table-responsive mt-3">
                        <table id="referralActivityTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User</th>
                                    <th>Referrer</th>
                                    <th>Level</th>
                                    <th>Order</th>
                                    <th>Commission</th>
                                    <th>Activity Type</th>
                                    <th>Date</th>
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
            console.log('Initializing Referral Activity Log DataTable...');

            var table = $('#referralActivityTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.referral.activity.log') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'user',
                        name: 'buyer.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'referrer',
                        name: 'referrer.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'level_badge',
                        name: 'ral.level',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'order_link',
                        name: 'ral.order_id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'commission_earned',
                        name: 'ral.commission_amount',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'activity_type',
                        name: 'ral.status',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'activity_date',
                        name: 'ral.created_at',
                        orderable: true,
                        searchable: false
                    }
                ],
                order: [
                    [6, 'desc']
                ],
                pageLength: 25,
                language: {
                    emptyTable: "No referral activity found",
                    zeroRecords: "No matching referral activity found"
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
