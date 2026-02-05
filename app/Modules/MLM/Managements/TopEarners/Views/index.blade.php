@extends('tenant.admin.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }

        .user-info {
            line-height: 1.4;
        }

        .user-info .text-muted {
            font-size: 12px;
        }

        .rank-badge {
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: white;
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0, #808080);
            color: white;
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #8B4513);
            color: white;
        }
    </style>
@endsection

@section('page_title')
    Top Earners
@endsection

@section('page_heading')
    MLM Leaderboard
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">
                <i class="fas fa-trophy text-warning"></i> Top Earners Leaderboard
            </h4>

            <div class="table-responsive">
                <table id="topEarnersTable" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Rank</th>
                            <th>User</th>
                            <th class="text-center">Total Earnings</th>
                            <th class="text-center">Level 1</th>
                            <th class="text-center">Level 2</th>
                            <th class="text-center">Level 3</th>
                            <th class="text-center">Referrals</th>
                            <th class="text-center">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ url('tenant/admin/dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing Top Earners DataTable...');

            var table = $('#topEarnersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.top.earners') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'rank',
                        name: 'rank',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var rankClass = '';
                            if (data == 1) rankClass = 'rank-1';
                            else if (data == 2) rankClass = 'rank-2';
                            else if (data == 3) rankClass = 'rank-3';

                            if (rankClass) {
                                return '<div class="text-center"><span class="rank-badge ' +
                                    rankClass + '">' + data + '</span></div>';
                            }
                            return '<div class="text-center"><strong>' + data + '</strong></div>';
                        }
                    },
                    {
                        data: 'user_info',
                        name: 'u.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'total_earnings',
                        name: 'wb.total_earned',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'level_1_earn',
                        name: 'level_1_earnings',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'level_2_earn',
                        name: 'level_2_earnings',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'level_3_earn',
                        name: 'level_3_earnings',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'referrals',
                        name: 'direct_referrals',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'join_date',
                        name: 'u.created_at',
                        orderable: true,
                        searchable: false
                    }
                ],
                order: [
                    [2, 'desc']
                ], // Sort by total earnings
                pageLength: 25,
                language: {
                    emptyTable: "No earners found",
                    zeroRecords: "No matching earners found"
                },
                drawCallback: function(settings) {
                    // Add trophy icons to top 3 ranks
                    $('#topEarnersTable tbody tr').each(function(index) {
                        if (index < 3) {
                            $(this).addClass('table-warning');
                        }
                    });
                }
            });

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
