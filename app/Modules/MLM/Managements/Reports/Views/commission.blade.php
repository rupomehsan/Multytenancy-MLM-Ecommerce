@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Commission Report</h3>
            <small class="text-muted">Commissions earned by users</small>
        </div>

        <style>
            .gradient-title {
                background: linear-gradient(90deg, #11998e, #38ef7d);
                color: #fff;
                padding: 10px;
                border-radius: 6px
            }

            .chart-placeholder {
                height: 260px;
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
                    <div class="gradient-title mb-2">Total Commission</div>
                    <h3>৳ 45,000</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Pending Commission</div>
                    <h3>৳ 5,500</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Paid Commission</div>
                    <h3>৳ 39,500</h3>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title gradient-title">Commission Chart</h5>
                <div class="chart-placeholder mt-3">Bar chart placeholder</div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Commission Table</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Level</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>john@example.com</td>
                                <td>1</td>
                                <td>৳ 500</td>
                                <td>2025-11-30</td>
                            </tr>
                            <tr>
                                <td>alice@example.com</td>
                                <td>2</td>
                                <td>৳ 300</td>
                                <td>2025-11-25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
