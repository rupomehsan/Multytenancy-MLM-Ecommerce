@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Wallet Summary Report</h3>
            <small class="text-muted">Overview of user wallets</small>
        </div>

        <style>
            .gradient-title {
                background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
                color: #fff;
                padding: 10px;
                border-radius: 6px
            }

            .chart-placeholder {
                height: 220px;
                background: #f8f9fa;
                border: 1px dashed #dee2e6;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6c757d
            }
        </style>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Total Wallet Balance</div>
                    <h3>৳ 120,000</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Total Credited</div>
                    <h3>৳ 150,000</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Total Debited</div>
                    <h3>৳ 30,000</h3>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title gradient-title">Wallet Distribution</h5>
                <div class="chart-placeholder mt-3">Pie chart placeholder</div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Wallet History</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Balance After</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>john@example.com</td>
                                <td>Credit</td>
                                <td>৳ 500</td>
                                <td>৳ 4,200</td>
                                <td>2025-11-30</td>
                            </tr>
                            <tr>
                                <td>alice@example.com</td>
                                <td>Debit</td>
                                <td>৳ 1,000</td>
                                <td>৳ 2,400</td>
                                <td>2025-11-25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
