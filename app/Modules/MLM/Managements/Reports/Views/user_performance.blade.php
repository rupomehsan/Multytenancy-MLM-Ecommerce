@extends('tenant.admin.layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">User Performance Report</h3>
            <small class="text-muted">Performance summary per user</small>
        </div>

        <style>
            .gradient-title {
                background: linear-gradient(90deg, #ff6a00, #ee0979);
                color: #fff;
                padding: 10px;
                border-radius: 6px
            }
        </style>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Total Referrals</div>
                    <h3>320</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Total Earnings</div>
                    <h3>৳ 12,800</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <div class="gradient-title mb-2">Active Downline</div>
                    <h3>187</h3>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title gradient-title mb-0">Monthly Performance</h5>
                </div>
                <div class="d-flex gap-2">
                    <input class="form-control form-control-sm" placeholder="Search by email or username" />
                    <button class="btn btn-sm btn-primary">Search</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>User</th>
                                <th>Referrals</th>
                                <th>Earnings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-11</td>
                                <td>john@example.com</td>
                                <td>12</td>
                                <td>৳ 600</td>
                            </tr>
                            <tr>
                                <td>2025-10</td>
                                <td>alice@example.com</td>
                                <td>8</td>
                                <td>৳ 420</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
