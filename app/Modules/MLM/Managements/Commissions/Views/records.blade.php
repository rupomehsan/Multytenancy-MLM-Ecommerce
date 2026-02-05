@extends('tenant.admin.layouts.app')

@section('header_css')
    <link href="{{ asset('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }
    </style>
@endsection

@section('page_title')
    Commission Records
@endsection

@section('page_heading')
    MLM Commission Records
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Commission Records</h4>

                    <div class="table-responsive mt-3">
                        <table id="commission-records-table"
                            class="table table-bordered table-striped dt-responsive nowrap w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Referrer</th>
                                    <th width="20%">Buyer</th>
                                    <th width="10%">Order ID</th>
                                    <th width="10%">Level</th>
                                    <th width="12%">Commission</th>
                                    <th width="12%">Status</th>
                                    <th width="11%">Date</th>
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
@endsection


@section('footer_js')
    <script src="{{ asset('tenant/admin/dataTable/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('tenant/admin/dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            console.log('Initializing Commission Records DataTable...');

            // Initialize DataTable
            var table = $('#commission-records-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.commissions.record') }}",
                    type: "GET",
                    error: function(xhr, error, code) {
                        console.log('DataTables AJAX Error:', xhr, error, code);
                        alert('Error loading commission records: ' + xhr.responseText);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'referrer_name',
                        name: 'referrer.name'
                    },
                    {
                        data: 'buyer_name',
                        name: 'buyer.name'
                    },
                    {
                        data: 'order_no',
                        name: 'o.order_no'
                    },
                    {
                        data: 'level',
                        name: 'mc.level'
                    },
                    {
                        data: 'commission_amount',
                        name: 'mc.commission_amount'
                    },
                    {
                        data: 'status',
                        name: 'mc.status'
                    },
                    {
                        data: 'created_at',
                        name: 'mc.created_at'
                    },
                ],
                order: [
                    [7, 'desc']
                ], // Order by created_at descending
                pageLength: 25,
                responsive: true,
                language: {
                    emptyTable: "No commission records available",
                    zeroRecords: "No matching commission records found"
                },
                initComplete: function(settings, json) {
                    console.log('Commission Records DataTable initialized successfully');
                    console.log('Data received:', json);
                }
            });

            console.log('DataTable object:', table);
        });
    </script>
@endsection
