@extends('tenant.admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Activity Log Report</h3>
            <small class="text-muted">Referral & commission activity timeline</small>
        </div>

        <style>
            .timeline-item {
                padding: 12px;
                border-left: 3px solid #dee2e6;
                margin-left: 12px;
                margin-bottom: 12px
            }

            .gradient-title {
                background: linear-gradient(90deg, #8e2de2, #4a00e0);
                color: #fff;
                padding: 8px;
                border-radius: 6px
            }
        </style>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title gradient-title">Activity Log</h5>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between">
                                    <strong>john@example.com</strong>
                                    <small class="text-muted">2025-11-30</small>
                                </div>
                                <div class="text-muted">Referral joined: mike@example.com joined under john@example.com
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="d-flex justify-content-between">
                                    <strong>alice@example.com</strong>
                                    <small class="text-muted">2025-11-25</small>
                                </div>
                                <div class="text-muted">Commission credited: ৳ 300 for level 2</div>
                            </div>

                            <div class="timeline-item">
                                <div class="d-flex justify-content-between">
                                    <strong>mike@example.com</strong>
                                    <small class="text-muted">2025-10-10</small>
                                </div>
                                <div class="text-muted">Withdrawal initiated: ৳ 500</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card p-3">
                                <h6 class="mb-2">Filters</h6>
                                <input class="form-control form-control-sm mb-2" placeholder="User email" />
                                <select class="form-select form-select-sm mb-2">
                                    <option>All Activity</option>
                                    <option>Referral</option>
                                    <option>Commission</option>
                                </select>
                                <button class="btn btn-sm btn-primary">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
