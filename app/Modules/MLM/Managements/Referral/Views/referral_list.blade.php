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

                    <h4 class="card-title">Referral Users List</h4>

                    <div class="table-responsive mt-3">

                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>User ID</th>
                                    <th>Phone</th>
                                    <th>Level</th>
                                    <th>Total Orders</th>
                                    <th>Total Spent</th>
                                    <th>Joined Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                {{-- Row 1 --}}
                                <tr>
                                    <td>1</td>
                                    <td><strong>Riyad Khan</strong></td>
                                    <td>105</td>
                                    <td>01745-000111</td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>12</td>
                                    <td>৳ 15,500</td>
                                    <td>05 Jan, 2025</td>
                                </tr>

                                {{-- Row 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td><strong>Mahin Ahmed</strong></td>
                                    <td>118</td>
                                    <td>01854-445566</td>
                                    <td><span class="badge bg-success">Level 2</span></td>
                                    <td>7</td>
                                    <td>৳ 7,800</td>
                                    <td>03 Jan, 2025</td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr>
                                    <td>3</td>
                                    <td><strong>Sumaiya Rahman</strong></td>
                                    <td>132</td>
                                    <td>01978-112233</td>
                                    <td><span class="badge bg-warning">Level 3</span></td>
                                    <td>4</td>
                                    <td>৳ 3,250</td>
                                    <td>28 Dec, 2024</td>
                                </tr>

                                {{-- Row 4 --}}
                                <tr>
                                    <td>4</td>
                                    <td><strong>Shakib Hasan</strong></td>
                                    <td>140</td>
                                    <td>01700-998877</td>
                                    <td><span class="badge bg-primary">Level 1</span></td>
                                    <td>10</td>
                                    <td>৳ 11,950</td>
                                    <td>27 Dec, 2024</td>
                                </tr>

                                {{-- Row 5 --}}
                                <tr>
                                    <td>5</td>
                                    <td><strong>Rubina Akter</strong></td>
                                    <td>142</td>
                                    <td>01922-334455</td>
                                    <td><span class="badge bg-success">Level 2</span></td>
                                    <td>6</td>
                                    <td>৳ 6,400</td>
                                    <td>25 Dec, 2024</td>
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
