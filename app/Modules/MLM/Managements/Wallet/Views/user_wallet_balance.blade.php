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

                    <h4 class="card-title">User Wallet Balances</h4>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">

                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>User ID</th>
                                    <th>Phone</th>
                                    <th>Total Wallet Balance</th>
                                    <th>Pending Withdrawal</th>
                                    <th>Last Transaction</th>
                                </tr>
                            </thead>

                            <tbody>

                                {{-- Row 1 --}}
                                <tr>
                                    <td>1</td>
                                    <td><strong>Rupom Ehsan</strong></td>
                                    <td>101</td>
                                    <td>01745-000111</td>
                                    <td>৳ 4,500</td>
                                    <td>৳ 500</td>
                                    <td>12 Jan, 2025</td>
                                </tr>

                                {{-- Row 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td><strong>Shakib Hasan</strong></td>
                                    <td>102</td>
                                    <td>01844-558877</td>
                                    <td>৳ 3,900</td>
                                    <td>৳ 0</td>
                                    <td>11 Jan, 2025</td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr>
                                    <td>3</td>
                                    <td><strong>Mahin Ahmed</strong></td>
                                    <td>120</td>
                                    <td>01955-447799</td>
                                    <td>৳ 1,250</td>
                                    <td>৳ 0</td>
                                    <td>10 Jan, 2025</td>
                                </tr>

                                {{-- Row 4 --}}
                                <tr>
                                    <td>4</td>
                                    <td><strong>Sumaiya Rahman</strong></td>
                                    <td>125</td>
                                    <td>01788-334466</td>
                                    <td>৳ 2,100</td>
                                    <td>৳ 300</td>
                                    <td>09 Jan, 2025</td>
                                </tr>

                                {{-- Row 5 --}}
                                <tr>
                                    <td>5</td>
                                    <td><strong>Rubina Akter</strong></td>
                                    <td>142</td>
                                    <td>01912-556677</td>
                                    <td>৳ 850</td>
                                    <td>৳ 0</td>
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
