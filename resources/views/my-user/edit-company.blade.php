@extends('home-user.index')
@section('title')
    {{'chỉnh sửa thông tin người dùng'}}
@endsection
@section('user-content')
    <style type="text/css">
        .name-notify {
            font-weight: bold;
        }

        .heading-panel {
            padding-left: 15px;
            padding-top: 5px;
        }

        label.error {
            color: #c0392b;
            margin-bottom: 20px;
        }
    </style>
    @if(session()->has('updateSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateSuccess')}}</div>
    @endif
    @if(session()->has('errorUsername'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorUsername')}}
        </div>
    @endif
    @if(session()->has('errorUsername'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorUsername')}}
        </div>
    @endif
    @if(session()->has('errorName'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorName')}}
        </div>
    @endif
    @if(session()->has('errorLogo'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorLogo')}}
        </div>
    @endif
    @if(session()->has('errorValidate'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorValidate')}}
        </div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Quản lý người dùng</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="list-user" style="color: #333">
            <span class="company-register name-page-profile">Danh sách người dùng</span>
        </a>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="edit-company?id={{$companyID}}" style="color: #333">
            <span class="company-register name-page-profile">Chỉnh sửa thông tin</span>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($myUser as $mu)
                <?php
                $company = \App\Company::getCompany($mu->id);
                ?>
                <form action="edit-company-form" method="POST" role="form" id="editCompany"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="myUserID" id="myUserID" value="{{encrypt($mu->id)}}">

                    <div class="form-group">
                        @foreach($company as $c)
                            <span>Chỉnh sửa thông tin công ty:</span>
                            <span style="font-weight: bold">{{$c->name}}</span>
                            <br>
                            <label>Tên công ty</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$c->name}}"
                                   required="required">
                            <br>
                        @endforeach

                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$mu->email}}"
                               placeholder="nhập email" required="required">
                        <br>
                        <label>Tên đăng nhập</label>
                        <input type="email" name="username" id="username" class="form-control" value="{{$mu->email}}"
                               readonly="readonly" required="required">
                        <br>
                        @foreach($company as $c)
                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" value="{{$c->address}}">
                            <br>
                            <label for="">Ngày thành lập</label>
                            @if(date('Y',strtotime($c->birthday))!=1970&&date('Y',strtotime($c->birthday))!=-0001)
                                <input type="date" name="birthday" id="birthday" class="form-control"
                                       value="{{date("Y-m-d",strtotime($c->birthday))}}">
                            @else
                                <input type="date" name="birthday" id="birthday" class="form-control">
                            @endif
                            <label id="errorBirthday" style="color:#c0392b">Không đúng (Công ty chưa thành
                                lập)</label>
                            <br>
                            <label for="">Mail tuyển dụng</label>
                            <input type="email" class="form-control" name="emailHR" value="{{$c->hr_mail}}">
                            <br>
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" id="inputPhone" class="form-control"
                                   value="{{$c->hr_phone}}">
                            <br>
                            <label for="">Logo</label>
                            <input type="file" name="logo" id="logoFile" style="width: 100%"
                                   accept="image/*">
                            <label>Mô tả ngắn gọn</label>
                            <textarea name="description" id="description" class="form-control"
                                      style="width: 100%;overflow: hidden; min-height: 100px"
                                      onkeyup="textArea(this)">{{$c->description}}
                            </textarea>
                            <br>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary" name="addOne">Chỉnh sửa</button>
                </form>
            @endforeach
        </div>
    </div>
    <script>
        function textArea(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
        var myUserID = $('#myUserID').val();
        $('#editCompany').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "check-email-edit",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "myUserID": myUserID
                        }
                    }
                },
                name: {
                    required: true,
                    remote: {
                        url: "check-name-edit",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "myUserID": myUserID
                        }
                    }
                },
                emailHR: {
                    email: true
                }
            },
            messages: {
                email: {
                    required: "vui lòng nhập email",
                    email: "không đúng định dạng email",
                    remote: "email đã tồn tại"
                },
                name: {
                    required: "vui lòng nhập tên công ty",
                    remote: "tên đã tồn tại"
                },
                emailHR: {
                    email: "Không đúng định dạng email"
                }
            }
        });
        $('#errorBirthday').hide();
        $('#birthday').change(function () {
            var data = $(this).val();
            var birthday = new Date(data);
            var currentDate = new Date();
            var timeBirthday = birthday.getTime();
            var timeCurrentDate = currentDate.getTime();
            if (timeCurrentDate - timeBirthday < 0) {
                $('#errorBirthday').show();
            } else {
                $('#errorBirthday').hide();
            }
        });
        $('#email').keyup(function () {
            var email = $(this).val();
            $('#username').val(email);
        });
    </script>
@endsection