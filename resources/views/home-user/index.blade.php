<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('') }}bootstrap/css/bootstrap-theme.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <!-- javascript and jquery external -->
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/validate/jquery-2.0.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/validate/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/js/script.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap/datetime/datepicker.min.css') }}" type="text/css">
    <script src="{{ asset('bootstrap/datetime/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/datetime/en-gb.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/datetime/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/datetime/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap/table-data/dataTables.bootstrap.min.css') }}" type="text/css">
    <script src="{{ asset('bootstrap/table-data/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/table-data/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/chart/Chart.min.js') }}" type="text/javascript"></script>


    {{--<link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.css" type="text/css">--}}
    {{--<link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css" type="text/css">--}}
    {{--<link rel="stylesheet" href="public/bootstrap/css/style.css" type="text/css">--}}
    {{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">--}}
    {{--<!-- javascript and jquery external -->--}}
    {{--<script src="public/bootstrap/js/jquery.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/js/bootstrap.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/js/jquery-1.11.2.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/validate/jquery-2.0.0.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/validate/jquery.validate.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/js/script.js" type="text/javascript"></script>--}}
    {{--<link rel="stylesheet" href="public/bootstrap/datetime/datepicker.min.css" type="text/css">--}}
    {{--<script src="public/bootstrap/datetime/moment.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/datetime/en-gb.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/datetime/bootstrap.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/datetime/bootstrap-datetimepicker.min.js" type="text/javascript"></script>--}}
    {{--<link rel="stylesheet" href="public/bootstrap/table-data/dataTables.bootstrap.min.css" type="text/css">--}}
    {{--<script src="public/bootstrap/table-data/jquery.dataTables.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/table-data/dataTables.bootstrap.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/chart/Chart.min.js" type="text/javascript"></script>--}}

    <style type="text/css" media="screen">
        .user-menu a {
            color: #000000;
        }

        .name-notify {
            font-weight: bold;
        }

        .name-notify a {
            color: #000000;
        }

        .name-notify a {
            text-decoration: none;
        }

        .menu-menu {
            background-color: #EEEEEE;
            font-weight: bold;
        }

        .go-top {
            position: fixed;
            bottom: 2em;
            right: 2em;
            display: none;
        }

        #name-school-xs, #name-project-xs {
            float: left;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="font-family:Arial">
    <div class="row" style="background-color: #001731;height:5px">
    </div>
    <div class="row" id="header">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
            <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" id="icon-header">
                    <a href="{{ route('home') }}">
                        <img src="{{ url('img/icon-soict.png') }}" class="img-responsive" alt="Image">
                    </a>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 hidden-xs hidden-sm hidden-md" id="name-header">
                    <a href="{{ route('home') }}">
                        <span id="name-school">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                </div>
                <div class="col-xs-8 col-sm-7 col-md-7 col-lg-8 visible-xs visible-sm visible-md"
                     style="margin-left: -30px">
                    <a href="{{ route('home') }}">
                        <span id="name-school-xs">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project-xs">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                </div>
                <div class="col-xs-3 col-sm-4 col-md-4 col-lg-3" style="margin-left: 30px">
                    <div class="row">
                    <span style="font-weight: normal;color:#FFFFFF;float: right">
                        @if (Auth::check())
                            @php
                                $name = ($type == config('settings.role.social')) ?
                                    Auth::user()->user_name : $user->name;
                            @endphp
                            {{ substr($name, 0, 30) }}
                            <a href="{{ url('logout') }}"
                               style="color:#FFFFFF; float: right;font-weight: normal">[Đăng xuất]
                            </a>
                        @endif
                    </span>
                    </div>
                    <div class="row" style="font-weight: normal;float: right;color:#FFFFFF">
                        <?php
                        $nowDate = date('Y-m-d');
                        $nowMonth = (int)date('m', strtotime($nowDate));
                        $year = 0;
                        $course = "";
                        if ($nowMonth >= 8 && $nowMonth <= 12) {
                            $year = (int)date('Y', strtotime($nowDate));
                            $course = $year . '1';
                        } else {
                            $year = (int)date('Y', strtotime($nowDate)) - 1;
                            if ($nowMonth >= 1 && $nowMonth <= 5) {
                                $course = $year . '2';
                            } else if ($nowMonth >= 6 && $nowMonth <= 7) {
                                $course = $year . '3';
                            }
                        }
                        ?>
                        <span>Học kỳ {{$course}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

        </div>
    </div>
    {{--<div class="row">--}}
    {{--<nav class="navbar" style="background-color: #001731; height: 5px">--}}
    {{--</nav>--}}
    {{--</div>--}}
    <div class="row" style="background-color: #001731; height: 1px">

    </div>
    <div class="row" style="background-color: #FFFFFF; height: 20px">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 hidden-xs" style="background-color: #001731; height: 20px">

        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="height: 20px">

        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 hidden-xs" style="background-color: #001731; height: 20px">

        </div>
    </div>
    <div class="row" style="background-color: #001731;">
        <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="background-color: #DDDDDD;">
            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                @if ($type == config('settings.role.student'))
                    @include('elements.menu.menu-student')
                @elseif ($type == config('settings.role.lecture'))
                    @include('elements.menu.menu-lecture')
                @elseif ($type == config('settings.role.company'))
                    @include('elements.menu.menu-company')
                @elseif ($type == config('settings.role.admin'))
                    @include('elements.menu.menu-admin')
                @else
                    @include('elements.menu.menu-social')
                @endif
            </div>
            <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"
                 style="padding-left: 0px;padding-right: 0px;min-height: 100vh">
                @yield('user-content')
            </div>
        </div>
        <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1">
        </div>
    </div>
    <div class="row" id="footer">
        <span>
            &copy SOICT</br>
            Địa chỉ: Phòng 504, nhà B1, Đại học Bách khoa Hà Nội</br>
            Điện thoại: (84-4) 3 8692463 | Fax: (84-4) 3 8692906
        </span>
        <a href="#" class="btn btn-info btn-lg go-top">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        // Show or hide the sticky footer button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('.go-top').fadeIn(500);
            } else {
                $('.go-top').fadeOut(100);
            }
        });

        // Animate the scroll to top
        $('.go-top').click(function (event) {
            event.preventDefault();

            $('html, body').animate({scrollTop: 0}, 800);
        })
    });
</script>
</html>
