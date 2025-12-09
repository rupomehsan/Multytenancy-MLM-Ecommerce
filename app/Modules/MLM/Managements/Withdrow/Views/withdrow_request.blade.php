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
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Withdrawal Requests</h4>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">

                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>User ID</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Payment Details</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                {{-- Row 1 --}}
                                <tr>
                                    <td>1</td>
                                    <td><strong>Rupom Ehsan</strong></td>
                                    <td>101</td>
                                    <td>৳ 500</td>
                                    <td>bKash</td>
                                    <td>01745-000111</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>12 Jan, 2025</td>
                                    <td>
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </td>
                                </tr>

                                {{-- Row 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td><strong>Shakib Hasan</strong></td>
                                    <td>102</td>
                                    <td>৳ 300</td>
                                    <td>Nagad</td>
                                    <td>01844-558877</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>10 Jan, 2025</td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                    </td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr>
                                    <td>3</td>
                                    <td><strong>Mahin Ahmed</strong></td>
                                    <td>120</td>
                                    <td>৳ 450</td>
                                    <td>Bank</td>
                                    <td>Brac Bank • A/C: 556677</td>
                                    <td><span class="badge bg-danger">Rejected</span></td>
                                    <td>09 Jan, 2025</td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" disabled>No Action</button>
                                    </td>
                                </tr>

                                {{-- Row 4 --}}
                                <tr>
                                    <td>4</td>
                                    <td><strong>Sumaiya Rahman</strong></td>
                                    <td>125</td>
                                    <td>৳ 700</td>
                                    <td>bKash</td>
                                    <td>01788-334466</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>08 Jan, 2025</td>
                                    <td>
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </td>
                                </tr>

                                {{-- Row 5 --}}
                                <tr>
                                    <td>5</td>
                                    <td><strong>Rubina Akter</strong></td>
                                    <td>142</td>
                                    <td>৳ 200</td>
                                    <td>Nagad</td>
                                    <td>01912-556677</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>06 Jan, 2025</td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection


@section('footer_js')
@endsection
