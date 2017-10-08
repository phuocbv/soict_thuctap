<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/style.css') }}" type="text/css">

    <!-- javascript and jquery external -->
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>

    <script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/js/jquery-1.11.2.min.js" type="text/javascript"></script>

    {{--table-data--}}
    <link rel="stylesheet" href="{{ asset('bootstrap/table-data/dataTables.bootstrap.min.css') }}" type="text/css">
    <script src="{{ asset('bootstrap/table-data/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/table-data/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css" type="text/css">
    {{--<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}" type="text/css">--}}
    <link rel="stylesheet" href="public/bootstrap/css/style.css" type="text/css">

    <!-- javascript and jquery external -->
    <script src="public/bootstrap/js/jquery.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/js/bootstrap.js" type="text/javascript"></script>

    {{--<script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>--}}
    {{--<script src="public/bootstrap/js/jquery-1.11.2.min.js" type="text/javascript"></script>--}}

    {{--table-data--}}
    <link rel="stylesheet" href="public/bootstrap/table-data/dataTables.bootstrap.min.css" type="text/css">
    <script src="public/bootstrap/table-data/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/table-data/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <style type="text/css" media="screen">
        #menu a:hover {
            background-color: #253C65;
            color: #FFFFFF;
        }

        #menu a {
            color: #bdc3c7;
        }

        .menu-menu {
            background-color: #253C65;
            color: #FFFFFF;
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
<div class="container-fluid" style="font-family: arial;">
    <div class="row" style="background-color: #001731;height:5px">
    </div>
    <div class="row" id="header">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
            <div class="row" style="">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" id="icon-header">
                    <a href="{{ url('/')}}">
                        <img src="public/img/icon-soict.png" class="img-responsive" alt="Image">
                    </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 hidden-xs hidden-sm hidden-md" id="name-header">
                    <a href="{{ url('/')}}">
                    <span id="name-school">
                    VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                    </span></br>
                    <span id="name-project">
                        CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                    </span>
                    </a>
                </div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 visible-xs visible-sm visible-md"
                     style="margin-left: -30px">
                    <a href="{{ url('/')}}">
                    <span id="name-school-xs">
                    VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                    </span></br>
                    <span id="name-project-xs">
                        CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                    </span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-left: 30px">
                    <div class="row">
                        @if (Auth::check())
                            {{substr($user->name,0,30)}}
                            <a href="{{url('/')}}"
                               style="color:#FFFFFF; float: right;font-weight: normal">[Đăng xuất]
                            </a>
                        @else
                            <a href="login"
                               style="color:#FFFFFF; float: right; padding-top: 5px; font-weight: normal">Đăng nhập</a>
                        @endif
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
    <div class="row" style="background-color: #001731; height: 2px">
    </div>
    <div class="row" style="background-color: #FFFFFF; height: 3px">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 hidden-xs" style="background-color: #001731; height: 3px">

        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="height: 3px">

        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 hidden-xs" style="background-color: #001731; height: 3px">

        </div>
    </div>
    <div class="row" style="background-color: #001731">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
            <div class="row" id="slide">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <?php
                    $i = -1;
                    $j = -1;
                    $img = \App\ImageBanner::getImgDisplay(1);
                    ?>
                    @if(count($img)==0)
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">

                            <div class="item active">
                                <img src="public/img/slide1.jpg"
                                     alt="Thành lập viện công nghệ thông tin và truyền thông"
                                     class="img-fluid" style="max-height: 400px;width: 100%">

                                <div class="carousel-caption">
                                    Thành lập viện công nghệ thông tin và truyền thông
                                </div>
                            </div>
                            <div class="item">
                                <img src="public/img/anh9.jpg"
                                     alt="Sinh viên Bách Khoa"
                                     class="img-fluid" style="max-height: 400px;width: 100%">

                                <div class="carousel-caption">
                                    Sinh viên Bách Khoa
                                </div>
                            </div>
                        </div>
                    @else
                        <ol class="carousel-indicators">
                            @foreach($img as $im)
                                <?php
                                $i++;
                                ?>
                                @if($i==0)
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                @else
                                    <li data-target="#carousel-example-generic" data-slide-to="{{++$i}}}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @foreach($img as $im)
                                <?php
                                $j++;
                                ?>
                                @if($j==0)
                                    <div class="item active">
                                        <img src="{{ 'public/' . $im->url }}"
                                             alt="{{$im->name_display}}"
                                             class="img-fluid" style="max-height: 400px;width: 100%">

                                        <div class="carousel-caption">
                                            {{$im->name_display}}
                                        </div>
                                    </div>
                                @else
                                    <div class="item">
                                        <img src="{{ 'public/' . $im->url }}"
                                             alt="{{$im->name_display}}"
                                             class="img-fluid" style="max-height: 400px;width: 100%">

                                        <div class="carousel-caption">
                                            {{$im->name_display}}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @endif
                                <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>
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
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
             style="background-color: #DDDDDD;min-height: 100vh;">
            @yield('home-content')
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
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


