@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Top Earners Report</h3>
            <small class="text-muted">Top performing users by income</small>
        </div>

        <style>
            .rank-card {
                border-radius: 8px;
                padding: 18px
            }

            .gradient-title {
                background: linear-gradient(90deg, #4b6cb7, #182848);
                color: #fff;
                padding: 8px;
                border-radius: 6px
            }
        </style>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card rank-card text-center">
                    <div class="badge bg-primary mb-2">#1</div>
                    <h5 class="mb-0">john@example.com</h5>
                    <small class="text-muted">Total: ৳ 8,400 • Levels: 5</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rank-card text-center">
                    <div class="badge bg-secondary mb-2">#2</div>
                    <h5 class="mb-0">alice@example.com</h5>
                    <small class="text-muted">Total: ৳ 6,200 • Levels: 4</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rank-card text-center">
                    <div class="badge bg-warning mb-2">#3</div>
                    <h5 class="mb-0">mike@example.com</h5>
                    <small class="text-muted">Total: ৳ 4,900 • Levels: 3</small>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Top Earners Table</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>User</th>
                                <th>Total Income</th>
                                <th>Level Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>john@example.com</td>
                                <td>৳ 8,400</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>alice@example.com</td>
                                <td>৳ 6,200</td>
                                <td>4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
