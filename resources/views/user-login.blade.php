<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Đăng nhập</title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/style.css') }}" type="text/css">

    <!-- javascript and jquery external -->
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="public/bootstrap/css/style.css" type="text/css">

    <!-- javascript and jquery external -->
    <script src="public/bootstrap/js/jquery.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <style type="text/css" media="screen">
        .login {
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
        }

        .name-school {
            font-size: 20px;
            font-weight: bold;
            color: #FFFFFF;
        }

        .name-project {
            font-size: 30px;
            font-weight: bold;
            color: #FFFFFF;
        }

        .tile-login {
            font-weight: bold;
            text-align: center;
            font-size: 20px;
        }

        .input {
            height: 50px;
            margin-bottom: 10px;
        }

        .body-login {
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="font-family: arial">
    <div class="row" id="header">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;margin-bottom: 20px">
                <span class="name-school">
                    VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</br>
                </span>
                <span class="name-project">
                    CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP
                </span>
        </div>
    </div>
    <div class="row login">
        <div class="panel panel-default" style="background-color: #ECECEC;">
            <div class="panel-heading" style="height: 50px">
                <h3 class="panel-title tile-login">Đăng nhập</h3>
            </div>
            <div class="panel-body body-login">
                <form action="login" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input type="text" name="email" class="form-control input" required="required"
                               placeholder="Nhập tên đăng nhập">
                        <input type="password" name="password" id="inputPassword" class="form-control input"
                               required="required" placeholder="Nhập mật khẩu">
                        @if(isset($error))
                            <label style="color:#c0392b">{{$error}}</label>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary form-control" style="background: #001731; border-color: #001731">Đăng nhập</button>
                </form>
                <div style="margin-top: 20px">
                    <a class="btn btn-primary col-md-12" href="{{ route('provider.redirect', ['provider' => 'facebook']) }}">Đăng nhập bằng Facebook</a>
                </div>
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Quên mật khẩu?</a></br>
                <a class="btn btn-link" href="{{ url('/') }}">Trở lại trang chủ?</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>