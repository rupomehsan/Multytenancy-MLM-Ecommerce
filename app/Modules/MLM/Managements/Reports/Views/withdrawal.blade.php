@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Withdrawal Report</h3>
            <small class="text-muted">All withdrawal requests</small>
        </div>

        <style>
            .gradient-title {
                background: linear-gradient(90deg, #ff416c, #ff4b2b);
                color: #fff;
                padding: 10px;
                border-radius: 6px
            }
        </style>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Withdrawal Requests</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>john@example.com</td>
                                <td>৳ 1,200</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                <td>2025-11-29</td>
                            </tr>
                            <tr>
                                <td>alice@example.com</td>
                                <td>৳ 2,000</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>2025-11-15</td>
                            </tr>
                            <tr>
                                <td>mike@example.com</td>
                                <td>৳ 500</td>
                                <td><span class="badge bg-danger">Rejected</span></td>
                                <td>2025-10-10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
