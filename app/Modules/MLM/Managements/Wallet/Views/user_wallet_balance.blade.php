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
    User Wallet Balances
@endsection

@section('page_heading')
    Wallet Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Wallet Balances</h4>

                    <div class="table-responsive mt-3">
                        <table id="walletBalanceTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Wallet Balance</th>
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
            console.log('Initializing User Wallet Balance DataTable...');

            var table = $('#walletBalanceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.user.wallet.balance') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'user',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'phone_number',
                        name: 'phone',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'wallet_balance_formatted',
                        name: 'wallet_balance',
                        orderable: true,
                        searchable: false
                    }
                ],
                order: [
                    [2, 'desc']
                ], // Sort by wallet balance descending
                pageLength: 25,
                language: {
                    emptyTable: "No customers with wallet balances found",
                    zeroRecords: "No matching customers found"
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
