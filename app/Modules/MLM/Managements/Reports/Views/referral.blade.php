@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Referral Report</h3>
            <small class="text-muted">Overview of direct & indirect referrals</small>
        </div>

        <style>
            .gradient-title {
                background: linear-gradient(90deg, #6a11cb, #2575fc);
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
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="gradient-title mb-2">Total Referrals</div>
                    <h2 class="mb-0">1,234</h2>
                    <small class="text-muted">Direct + Indirect</small>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card p-3">
                    <div class="d-flex gap-2">
                        <input class="form-control form-control-sm" type="date" />
                        <input class="form-control form-control-sm" type="date" />
                        <select class="form-select form-select-sm">
                            <option>All Levels</option>
                            <option>Level 1</option>
                            <option>Level 2</option>
                        </select>
                        <select class="form-select form-select-sm">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                        <button class="btn btn-primary btn-sm">Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Referral List</h5>
                <div class="table-responsive">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Referred By</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>john@example.com</td>
                                <td>alice@example.com</td>
                                <td>1</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2025-11-30</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>mike@example.com</td>
                                <td>john@example.com</td>
                                <td>2</td>
                                <td><span class="badge bg-secondary">Inactive</span></td>
                                <td>2025-10-20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
