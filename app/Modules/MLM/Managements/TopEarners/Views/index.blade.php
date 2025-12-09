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
            <h4 class="card-title mb-4">Top Earners</h4>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Total Earnings (BDT)</th>
                            <th>Level 1 Earn</th>
                            <th>Level 2 Earn</th>
                            <th>Level 3 Earn</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rafi Ahmed</td>
                            <td>rafi@example.com</td>
                            <td>25,000</td>
                            <td>15,000</td>
                            <td>7,000</td>
                            <td>3,000</td>
                            <td>2024-11-22</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Ayesha Khan</td>
                            <td>ayesha@example.com</td>
                            <td>21,500</td>
                            <td>12,000</td>
                            <td>6,000</td>
                            <td>3,500</td>
                            <td>2024-12-10</td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Mehedi Hassan</td>
                            <td>mehedi@example.com</td>
                            <td>18,200</td>
                            <td>10,000</td>
                            <td>5,000</td>
                            <td>3,200</td>
                            <td>2024-12-01</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
@endsection
