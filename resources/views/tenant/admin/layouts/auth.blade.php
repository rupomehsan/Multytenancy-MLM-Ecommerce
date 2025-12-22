<!DOCTYPE html>
<html lang="en">

{{-- $generalInfo is provided globally by AppServiceProvider to all views --}}

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    @if (
        $generalInfo &&
            $generalInfo->fav_icon != '' &&
            $generalInfo->fav_icon != null &&
            file_exists(public_path($generalInfo->fav_icon)))
        <link rel="shortcut icon" href="{{ url($generalInfo->fav_icon) }}">
    @else
        <link rel="shortcut icon" href="{{ url('tenant/admin/assets') }}/images/favicon.ico">
    @endif

    <!-- App css -->
    <link href="{{ url('tenant/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/theme.min.css" rel="stylesheet" type="text/css" />

    @yield('header_css')

</head>

<body>

    <div
        style="background: #3D7EAA; background: -webkit-linear-gradient(to right, #FFE47A, #3D7EAA); background: linear-gradient(to right, #FFE47A, #3D7EAA);">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">


                            @yield('content')



                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->

        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- jQuery  -->
    <script src="{{ url('tenant/admin/assets') }}/js/jquery.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/metismenu.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/waves.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/simplebar.min.js"></script>

    <!-- App js -->
    <script src="{{ url('tenant/admin/assets') }}/js/theme.js"></script>

</body>

</html>
