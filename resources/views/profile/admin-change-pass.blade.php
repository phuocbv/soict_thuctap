@extends('home-user.index')
@section('title')
    {{'Đổi mật khẩu'}}
@endsection
@section('user-content')
    <style>
        .input {
            height: 50px;
            margin-bottom: 10px;
        }

        .tile-login {
            font-weight: bold;
            text-align: center;
            font-size: 16px;
        }

        label.error {
            color: #c0392b;
        }
    </style>
    @if(session()->has('changePasswordSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('changePasswordSuccess')}}</div>
    @endif
    @if(session()->has('changePasswordError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('changePasswordError')}}
        </div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Thông tin cá nhân</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="admin-change-pass" style="color: #333">
            <span class="name-page-profile">Đổi mật khẩu</span>
        </a>
    </div>
    <div class="panel panel-default" style="min-height: 600px">
        <div class="panel-body">
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-3">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default" style="background-color: #ECECEC;">
                    <div class="panel-heading" style="height: 50px">
                        <h3 class="panel-title tile-login">Đổi mật khẩu</h3>
                    </div>
                    <div class="panel-body">
                        <form action="admin-change-pass-form" method="POST" role="form" id="student">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control input"
                                       required="required"
                                       placeholder="Nhập mật khẩu cũ">
                                <input type="password" name="password" id="password" class="form-control input"
                                       required="required"
                                       placeholder="Nhập mật khẩu mới">
                                <input type="password" name="confirmPassword" id="confirmPassword"
                                       class="form-control input"
                                       required="required" placeholder="Nhập lại mật khẩu mới">
                            </div>
                            <button type="submit" class="btn btn-primary form-control input">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-3">
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#adminChangePass').addClass('menu-menu');
            $('a#adminChangePass').css('color', '#000000');
            $('#student').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirmPassword: {
                        required: true,
                        equalTo: "#password"
                    },
                    oldPassword: {
                        required: true,
                        remote: {
                            url: "admin-check-pass",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            }
                        }
                    }
                },
                messages: {
                    password: {
                        required: "vui lòng nhập mật khẩu mới",
                        minlength: "mật khẩu ít nhất là 6 ký tự"
                    },
                    confirmPassword: {
                        required: "",
                        equalTo: "mật khẩu không khớp"
                    },
                    oldPassword: {
                        required: "vui lòng nhập mật khẩu cũ",
                        remote: "mật khẩu cũ không đúng"
                    }
                }
            });
        });
    </script>
@endsection