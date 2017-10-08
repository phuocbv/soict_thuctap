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
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css" type="text/css">
    <link rel="stylesheet" href="public/bootstrap/css/style.css" type="text/css">

    {{--cai them trinh soan thao--}}
    <link rel="stylesheet" href="public/bootstrap/editor/bootstrap.css" type="text/css">
    <script src="public/bootstrap/editor/jquery.js"></script>
    <script src="public/bootstrap/editor/bootstrap.js"></script>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet">
    <script src="public/bootstrap/editor/summernote.js"></script>

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

        .note-editing-area {
            min-height: 200px;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="font-family: arial">
    <div class="row" style="background-color: #001731;height:5px">
    </div>
    <div class="row" id="header">
        <div class="container">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="icon-header">
                @if($type=='student')
                    <a href="student-home">
                        <img src="public/img/icon-soict.png" class="img-responsive" alt="Image">
                    </a>
                @elseif($type=='lecture')
                    <a href="lecture-home">
                        <img src=public/img/icon-soict.png" class="img-responsive" alt="Image">
                    </a>
                @elseif($type=='company')
                    <a href="company-home">
                        <img src="public/img/icon-soict.png" class="img-responsive" alt="Image">
                    </a>
                @else
                    <a href="admin-home">
                        <img src="public/img/icon-soict.png" class="img-responsive" alt="Image">
                    </a>
                @endif
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="name-header">
                @if($type=='student')
                    <a href="student-home">
                        <span id="name-school">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                @elseif($type=='lecture')
                    <a href="lecture-home">
                        <span id="name-school">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                @elseif($type=='company')
                    <a href="company-home">
                        <span id="name-school">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                @else
                    <a href="admin-home">
                        <span id="name-school">
                            VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
                        </span></br>
                        <span id="name-project">
                            CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                        </span>
                    </a>
                @endif
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="row">
                    <span style="font-weight: normal;color:#FFFFFF">
                        @foreach($user as $u)
                            {{substr($u->name,0,20)}}
                        @endforeach
                        <a href="{{url('/')}}"
                           style="color:#FFFFFF; float: right;font-weight: normal">[Đăng xuất]
                        </a>
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
    {{--<div class="row">--}}
    {{--<nav class="navbar" style="background-color: #001731; height: 5px">--}}
    {{--</nav>--}}
    {{--</div>--}}
    <div class="row" style="background-color: #001731; height: 1px">

    </div>
    <div class="row" style="background-color: #FFFFFF; height: 20px">

    </div>
    <div class="row" style="background-color: #001731; min-height: 500px">
        <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="background-color: #DDDDDD; min-height: 500px">
            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                @if($type=='student')
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin chung</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            @foreach($user as $u)
                                <ul class="nav navbar-stacked user-menu">
                                    <li>
                                        <a href="user-student-home?user_id={{bcrypt($u->user_id)}}&type={{'student'}}"
                                           id="menu-home">Thông báo</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin cá nhân</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="student-profile" id="studentProfile">Xem thông tin cá nhân</a>
                                </li>
                                <li>
                                    <a href="student-change-pass" id="studentChangePass">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Khóa thực tập</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="register-intern" id="studentRegister">Đăng ký thực tập</a>
                                </li>
                                <li>
                                    <a href="course-join" id="courseJoin">Các khóa tham gia</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">
                                <a href="company-cooperation">Doanh nghiệp hợp tác</a>
                            </h3>
                        </div>
                    </div>
                @elseif($type=='lecture')
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin chung</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            @foreach($user as $u)
                                <ul class="nav navbar-stacked user-menu">
                                    <li>
                                        <a href="user-lecture-home?user_id={{bcrypt($u->user_id)}}&type={{'lecture'}}"
                                           id="menu-home">Thông báo</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin cá nhân</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="lecture-profile" id="lectureProfile">Xem thông tin cá nhân</a>
                                </li>
                                <li>
                                    <a href="lecture-change-pass" id="lectureChangePass">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Khóa thực tập</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="lecture-join" id="lecture-join">Các kỳ tham gia</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif($type=='company')
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin chung</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            @foreach($user as $u)
                                <ul class="nav navbar-stacked user-menu">
                                    <li>
                                        <a href="user-company-home?user_id={{bcrypt($u->user_id)}}&type={{'company'}}"
                                           id="menu-home">Thông báo</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin công ty</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="company-profile" id="companyProfile">Xem thông tin công ty</a>
                                </li>
                                <li>
                                    <a href="company-change-pass" id="companyChangePass">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Khóa thực tập</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="company-join" id="company-join">Các kỳ tham gia</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="company-register" id="companyRegister">Đăng ký tham gia</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif($type=='admin')
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin chung</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            @foreach($user as $u)
                                <ul class="nav navbar-stacked user-menu">
                                    <li>
                                        <a href="user-admin-home?user_id={{bcrypt($u->user_id)}}&type={{'admin'}}"
                                           id="menu-home">Thông báo</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">Thông tin cá nhân</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="admin-change-pass" id="adminChangePass">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">
                                <a href="#">Quản lý khóa thực tập</a>
                            </h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="list-course" id="list-course">Danh sách khóa thực tập</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="plan-learning" id="plan-learning">Kế hoạch học tập</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">
                                <a href="#">Quản lý người dùng</a>
                            </h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="list-user" id="list-user">Danh sách người dùng</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="add-users" id="add-user">Thêm người dùng</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default" style="margin-left: -15px;">
                        <div class="panel-heading">
                            <h3 class="panel-title name-notify">
                                Quản lý chung
                            </h3>
                        </div>
                        <div class="panel-body" style="padding: 0px">
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="manage-notify" id="manage-notify">Tin tức</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="img-banner" id="img-banner">Ảnh Banner</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="manage-function" id="manage-function">Quản lý chức năng</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-stacked user-menu">
                                <li>
                                    <a href="statistic-vote" id="statistic-vote">Thống kê đánh giá</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"
                 style="padding-left: 0px;padding-right: 0px;min-height: 100vh">
                @yield('content');
            </div>
        </div>
        <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1">
        </div>
    </div>
    <div class="row" id="footer">
        <span>
            &copy SOICT</br>
            địa chỉ: Phòng 504, nhà B1, Đại học Bách khoa Hà Nội</br>
            Điện thoại: (84-4) 3 8692463 | Fax: (84-4) 3 8692906
        </span>
        <a href="#" class="btn btn-info btn-lg go-top">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a>
    </div>
</div>
<!-- <a class="btn btn-default" href="login" role="button">dang nhap</a> -->
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
