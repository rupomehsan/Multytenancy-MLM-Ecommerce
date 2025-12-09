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

                    <h4 class="card-title">Recent Referral Activity Log</h4>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Referrer</th>
                                    <th>Level</th>
                                    <th>Order ID</th>
                                    <th>Commission Earned</th>
                                    <th>Activity Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                {{-- Row 1 --}}
                                <tr>
                                    <td>1</td>
                                    <td><strong>Riyad Khan</strong></td>
                                    <td>Shakib Hasan</td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>#2345</td>
                                    <td>৳ 150</td>
                                    <td><span class="badge bg-success">Commission Earned</span></td>
                                    <td>12 Jan, 2025</td>
                                </tr>

                                {{-- Row 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td><strong>Mahin Ahmed</strong></td>
                                    <td>Sumaiya Rahman</td>
                                    <td><span class="badge bg-success">Level 2</span></td>
                                    <td>#2350</td>
                                    <td>৳ 75</td>
                                    <td><span class="badge bg-info">New Referral Joined</span></td>
                                    <td>11 Jan, 2025</td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr>
                                    <td>3</td>
                                    <td><strong>Rubina Akter</strong></td>
                                    <td>Mithila Rahman</td>
                                    <td><span class="badge bg-warning">Level 3</span></td>
                                    <td>#2360</td>
                                    <td>৳ 30</td>
                                    <td><span class="badge bg-success">Commission Earned</span></td>
                                    <td>10 Jan, 2025</td>
                                </tr>

                                {{-- Row 4 --}}
                                <tr>
                                    <td>4</td>
                                    <td><strong>Shakib Hasan</strong></td>
                                    <td>Rupom Ehsan</td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>#2375</td>
                                    <td>৳ 160</td>
                                    <td><span class="badge bg-info">New Referral Joined</span></td>
                                    <td>09 Jan, 2025</td>
                                </tr>

                                {{-- Row 5 --}}
                                <tr>
                                    <td>5</td>
                                    <td><strong>Sumaiya Rahman</strong></td>
                                    <td>Shakib Hasan</td>
                                    <td><span class="badge bg-success">Level 2</span></td>
                                    <td>#2381</td>
                                    <td>৳ 80</td>
                                    <td><span class="badge bg-success">Commission Earned</span></td>
                                    <td>08 Jan, 2025</td>
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
