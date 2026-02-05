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
    Wallet Transactions
@endsection

@section('page_heading')
    Wallet Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Wallet Transaction History</h4>

                    <div class="table-responsive mt-3">
                        <table id="walletTransactionTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User</th>
                                    <th>User ID</th>
                                    <th>Type</th>
                                    <th>Source</th>
                                    <th>Amount</th>
                                    <th>Balance After</th>
                                    <th>Reference</th>
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
            console.log('Initializing Wallet Transaction DataTable...');

            var table = $('#walletTransactionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.wallet.transaction') }}",
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
                        data: 'user_id',
                        name: 'wt.user_id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'source',
                        name: 'wt.transaction_type',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'wt.amount',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'balance_after',
                        name: 'wt.balance_after',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'reference',
                        name: 'wt.description',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'wt.created_at',
                        orderable: true,
                        searchable: false
                    }
                ],
                order: [
                    [7, 'desc']
                ],
                pageLength: 25,
                language: {
                    emptyTable: "No wallet transactions found",
                    zeroRecords: "No matching transactions found"
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
