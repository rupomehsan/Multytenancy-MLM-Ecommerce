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

                    <h4 class="card-title">Commission Records</h4>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Referrer</th>
                                    <th>Buyer</th>
                                    <th>Order ID</th>
                                    <th>Level</th>
                                    <th>Commission Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <strong>Rupom Ehsan</strong><br>
                                        <small class="text-muted">ID: 101</small>
                                    </td>
                                    <td>
                                        Nazmul Hasan<br>
                                        <small class="text-muted">ID: 205</small>
                                    </td>
                                    <td><span class="text-primary">#2345</span></td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>৳ 150.00</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>12 Jan, 2025</td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>
                                        <strong>Jahidul Islam</strong><br>
                                        <small class="text-muted">ID: 102</small>
                                    </td>
                                    <td>
                                        Tania Akter<br>
                                        <small class="text-muted">ID: 209</small>
                                    </td>
                                    <td><span class="text-primary">#2350</span></td>
                                    <td><span class="badge bg-success">Level 2</span></td>
                                    <td>৳ 75.00</td>
                                    <td><span class="badge bg-info">Approved</span></td>
                                    <td>11 Jan, 2025</td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>
                                        <strong>Shimul Hossain</strong><br>
                                        <small class="text-muted">ID: 115</small>
                                    </td>
                                    <td>
                                        Mahmudul Alam<br>
                                        <small class="text-muted">ID: 222</small>
                                    </td>
                                    <td><span class="text-primary">#2378</span></td>
                                    <td><span class="badge bg-warning">Level 3</span></td>
                                    <td>৳ 30.00</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>10 Jan, 2025</td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>
                                        <strong>Mithila Rahman</strong><br>
                                        <small class="text-muted">ID: 120</small>
                                    </td>
                                    <td>
                                        Arif Mahmud<br>
                                        <small class="text-muted">ID: 230</small>
                                    </td>
                                    <td><span class="text-primary">#2401</span></td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>৳ 160.00</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>09 Jan, 2025</td>
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
