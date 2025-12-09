@extends('tenant.admin.layouts.app')

@section('header_css')
    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }

        .graph_card {
            position: relative
        }

        .graph_card i {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 18px;
            height: 35px;
            width: 35px;
            line-height: 33px;
            text-align: center;
            border-radius: 50%;
            font-weight: 300;

            /* animation-name: rotate;
                                                                    animation-duration: 5s;
                                                                    animation-iteration-count: infinite;
                                                                    animation-timing-function: linear;
                                                                */

        }

        /* @keyframes rotate{
                                                                    from{ transform: rotate(-360deg); }
                                                                    to{ transform: rotate(360deg); }
                                                                } */
    </style>
@endsection

@section('page_title')
    Dashboard
@endsection

@section('page_heading')
    Overview
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Withdraw History</h4>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover">
                    <thead style="background:#17263A; color:white;">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Account Details</th>
                            <th>Status</th>
                            <th>Requested At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rakib Hasan</td>
                            <td>৳ 1500</td>
                            <td>Bank Transfer</td>
                            <td>DBBL — 122334455</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>2025-12-01</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Shakil Ahmed</td>
                            <td>৳ 1000</td>
                            <td>bKash</td>
                            <td>017XXXXXXXX</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>2025-12-02</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Tamim Khan</td>
                            <td>৳ 800</td>
                            <td>Nagad</td>
                            <td>018XXXXXXXX</td>
                            <td><span class="badge bg-danger">Rejected</span></td>
                            <td>2025-12-03</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('footer_js')
@endsection
