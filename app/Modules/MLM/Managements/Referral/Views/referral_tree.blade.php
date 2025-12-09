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
    <style>
        .tree-container {
            padding: 25px;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            padding-left: 0;
            display: flex;
            justify-content: center;
        }

        .tree li {
            list-style-type: none;
            margin: 0 25px;
            text-align: center;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #cbd5e0;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #cbd5e0;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 1px solid #cbd5e0;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree li div {
            padding: 10px 20px;
            display: inline-block;
            background: #17263A;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            min-width: 170px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .level-tag {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            opacity: 0.75;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Referral Tree (3 Level Structure)</h4>

            <div class="tree-container">

                <div class="tree">
                    <ul>
                        <li>
                            <div>
                                <strong>Main User</strong>
                                <span class="level-tag">Root</span>
                            </div>

                            <ul>

                                {{-- LEVEL 1 USERS --}}
                                <li>
                                    <div>
                                        <strong>Shakib Hasan</strong>
                                        <span class="level-tag">Level 1</span>
                                    </div>

                                    <ul>

                                        {{-- LEVEL 2 under Shakib --}}
                                        <li>
                                            <div>
                                                <strong>Mahin Ahmed</strong>
                                                <span class="level-tag">Level 2</span>
                                            </div>

                                            <ul>

                                                {{-- LEVEL 3 under Mahin --}}
                                                <li>
                                                    <div>
                                                        <strong>Riyad Khan</strong>
                                                        <span class="level-tag">Level 3</span>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div>
                                                        <strong>Rubina Akter</strong>
                                                        <span class="level-tag">Level 3</span>
                                                    </div>
                                                </li>

                                            </ul>
                                        </li>

                                        {{-- Second Level 2 --}}
                                        <li>
                                            <div>
                                                <strong>Sumaiya Rahman</strong>
                                                <span class="level-tag">Level 2</span>
                                            </div>
                                        </li>

                                    </ul>
                                </li>

                                {{-- Second Level 1 --}}
                                <li>
                                    <div>
                                        <strong>Mithila Rahman</strong>
                                        <span class="level-tag">Level 1</span>
                                    </div>

                                    <ul>

                                        <li>
                                            <div>
                                                <strong>Arif Mahmud</strong>
                                                <span class="level-tag">Level 2</span>
                                            </div>

                                            <ul>

                                                <li>
                                                    <div>
                                                        <strong>Jannat Toma</strong>
                                                        <span class="level-tag">Level 3</span>
                                                    </div>
                                                </li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
@endsection


@section('footer_js')
@endsection
