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
    Referral Users List
@endsection

@section('page_heading')
    Referral Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Referral Users List</h4>

                    <div class="table-responsive mt-3">
                        <table id="referralListTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User Name</th>
                                    <th>User ID</th>
                                    <th>Phone</th>
                                    <th>Level 1</th>
                                    <th>Level 2</th>
                                    <th>Level 3</th>
                                    <th>Total Referrals</th>
                                    <th>Total Orders</th>
                                    <th>Total Spent</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
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
            console.log('Initializing Referral List DataTable...');

            var table = $('#referralListTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.referral.lists') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'user_info',
                        name: 'u.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user_id',
                        name: 'u.id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'phone',
                        name: 'u.phone',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'level_1',
                        name: 'level_1_count',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'level_2',
                        name: 'level_2_count',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'level_3',
                        name: 'level_3_count',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'total_referrals',
                        name: 'total_referrals',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'total_orders',
                        name: 'total_orders',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'total_spent',
                        name: 'total_spent',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'joined_date',
                        name: 'u.created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [6, 'desc']
                ],
                pageLength: 25,
                language: {
                    emptyTable: "No referral users found",
                    zeroRecords: "No matching referral users found"
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
