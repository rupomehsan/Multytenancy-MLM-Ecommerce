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
    <h1>Well come to referral activity log</h1>
@endsection

@section('footer_js')
@endsection
