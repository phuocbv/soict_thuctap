@extends('home-user.index')
@section('title')
    {{'Thêm người dùng'}}
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
    <div class="panel panel-default">
        <div class="heading-panel">
            <h3 class="panel-title name-notify">Thêm người dùng</h3>
            @if(session()->has('addOneError'))
                <div class="alert alert-danger myLabel" role="alert">{{session()->get('addOneError')}}</div>
            @endif
            @if(session()->has('extensionError'))
                <div class="alert alert-danger myLabel" role="alert">{{session()->get('extensionError')}}</div>
            @endif
            @if(session()->has('rowError'))
                <div class="alert alert-danger myLabel" role="alert">{{session()->get('rowError')}}</div>
            @endif
            @if(session()->has('formError'))
                <div class="alert alert-danger myLabel" role="alert">{{session()->get('formError')}}</div>
            @endif

        </div>
        <div class="panel-body">
            <div class="panel panel-default" style="margin-bottom: 0px">
                <div class="panel-body">
                    <form action="form-add-users-many" method="POST" role="form" id="userMany"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="">Chọn file</label>
                            <input type="file" name="excelFile" id="excelFile" style="width: 100%"
                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                        </div>
                        <button type="submit" class="btn btn-primary" name="addMany">Thêm</button>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="form-add-users-one" method="POST" role="form" id="userOne">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="">Loại người dùng</label>
                            <select name="type" id="type" class="form-control" required="required">
                                <option value="" selected="selected">Loại người dùng</option>
                                <option value="student">Sinh viên</option>
                                <option value="lecture">Giảng viên</option>
                                <option value="company">Doanh nghiệp</option>
                            </select>
                            <br>
                            {{--đoạn này hiển thị nhập thông tin khi cho type="student"--}}
                            <div id="studentInput">
                                <label>Mã sinh viên</label>
                                <input type="number" name="msv" id="msv" class="form-control" step="1"
                                       required="required" placeholder="nhập mã sinh viên">
                                <br>
                            </div>
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" value=""
                                   placeholder="nhập email" readonly="readonly">
                            <input type="email" name="emailStudent" id="emailStudent" class="form-control" value=""
                                   required="required" placeholder="nhập email" readonly="readonly">
                            <input type="email" name="emailLecture" id="emailLecture" class="form-control" value=""
                                   required="required" placeholder="nhập email">
                            <input type="email" name="emailCompany" id="emailCompany" class="form-control" value=""
                                   required="required" placeholder="nhập email">
                            <br>
                            <label for="">Tên đăng nhập</label>
                            <input type="text" name="userName" id="userName" class="form-control"
                                   readonly="readonly" placeholder="nhập tên đăng nhập">
                            <input type="text" name="studentUserName" id="studentUserName"
                                   class="form-control" readonly="readonly" placeholder="Nhập mã sinh viên">
                            <input type="text" name="lectureUserName" id="lectureUserName"
                                   class="form-control" readonly="readonly" placeholder="Nhập email giảng viên">
                            <input type="text" name="companyUserName" id="companyUserName"
                                   class="form-control" readonly="readonly" placeholder="nhập email công ty">
                            <br>

                            <div id="studentInput2" hidden="hidden">
                                <label>Khóa đào tạo</label>
                                <input type="number" name="grade" id="grade" class="form-control" step="1"
                                       required="required" placeholder="Nhập khóa học">
                                <br>
                                <label>Chương trình đào tạo</label>
                                <select name="programingUniversity" id="programingUniversity" class="form-control"
                                        required="required">
                                    <option value="" selected="selected">Chương trình đào tạo</option>
                                    <?php
                                    $programing = \App\MyFunction::learningPrograming();
                                    ?>
                                    @foreach($programing as $p)
                                        <option value="{{$p->name}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                                <br>
                            </div>
                            <label for="">Mật khẩu</label>
                            <input type="password" name="password" id="password" required="required"
                                   class="form-control" placeholder="nhập mật khẩu">
                            <br>
                            <label for="">Nhập lại Mật khẩu</label>
                            <input type="password" name="rePassword" id="rePassword" required="required"
                                   class="form-control" placeholder="nhập lại mật khẩu">
                            <br>
                            <label id="labelFullName">Họ và Tên</label>
                            <input type="text" name="fullName" id="fullName" class="form-control" value=""
                                   required="required" placeholder="họ và tên">
                            <br id="brFullName">
                            {{--kết thúc đoạn nhập này--}}
                            {{--đoạn nhập nếu type="lecture"--}}
                            <div id="lectureInput">
                                <label>Trình độ</label>
                                <select name="qualification" id="qualification" class="form-control"
                                        required="required">
                                    <option value="" selected="selected">Trình độ</option>
                                    <option value="Ths">Thạc sỹ</option>
                                    <option value="TS">TS</option>
                                    <option value="PGS.TS">PGS.TS</option>
                                    <option value="GS">GS</option>
                                </select>
                                <br>
                                <label>Bộ môn</label>
                                <select name="address" id="address" class="form-control" required="required">
                                    <option value="" selected="selected">Bộ môn</option>
                                    <?php
                                    $academy = \App\MyFunction::academy();
                                    ?>
                                    @foreach($academy as $a)
                                        <option value="{{$a->name}}">{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--kết thúc đoạn nhập nếu type="lecture"--}}
                            {{--đoạn nhập nếu type="company"--}}
                            <div id="companyInput">
                                <label>Tên công ty</label>
                                <input type="text" name="nameCompany" id="nameCompany" class="form-control"
                                       required="required" placeholder="Nhập tên công ty">
                                <br>
                                <label>Giảng viên phụ trách</label>
                                <select name="lectureId" required class="form-control">
                                    <option value="">Chọn giảng viên</option>
                                    @foreach($listLecture as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addOne">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#userMany').validate({
                rules: {
                    excelFile: {
                        required: true,
                    }
                },
                messages: {
                    excelFile: {
                        required: "vui lòng chọn file",
                    }
                }
            });
            $('#userOne').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6
                    },
                    rePassword: {
                        required: true,
                        equalTo: "#password"
                    },
                    emailLecture: {
                        required: true,
                        email: true,
                        remote: {
                            url: "check-email-lecture",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        }
                    },
                    emailCompany: {
                        required: true,
                        email: true,
                        remote: {
                            url: "check-email-company",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        }
                    },
                    fullName: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    msv: {
                        required: true,
                        remote: {
                            url: "check-username",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        }
                    },
                    grade: {
                        required: true
                    },
                    programingUniversity: {
                        required: true
                    },
                    qualification: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    nameCompany: {
                        required: true,
                        remote: {
                            url: "check-name-company",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        }
                    },
                    lectureId: {
                        required: true
                    }
                },
                messages: {
                    password: {
                        required: "vui lòng nhập mật khẩu",
                        minlength: "mật khẩu ít nhất là 6 ký tự"
                    },
                    rePassword: {
                        required: "",
                        equalTo: "mật khẩu không khớp"
                    },
                    emailLecture: {
                        required: "vui lòng nhập email",
                        email: "không đúng định dạng email",
                        remote: "email đã tồn tại"
                    },
                    emailCompany: {
                        required: "vui lòng nhập email",
                        email: "không đúng định dạng email",
                        remote: "email đã tồn tại"
                    },
                    fullName: {
                        required: "Vui lòng nhập họ và tên"
                    },
                    type: {
                        required: "Vui lòng chọn loại người dùng"
                    },
                    msv: {
                        required: "vui lòng nhập msv",
                        remote: "mã sinh viên đã tồn tại"
                    },
                    grade: {
                        required: "vui lòng nhập khóa đào tạo"
                    },
                    programingUniversity: {
                        required: "vui lòng chọn hệ đào tạo"
                    },
                    qualification: {
                        required: "vui lòng chọn trình độ"
                    },
                    address: {
                        required: "vui lòng chọn bộ môn"
                    },
                    nameCompany: {
                        remote: "Tên công ty đã tồn tại",
                        required: "vui lòng nhập tên công ty"
                    },
                    lectureId: {
                        required: 'Chưa chọn giảng viên'
                    }
                }
            });
            $('#studentUserName').hide();
            $('#lectureUserName').hide();
            $('#companyUserName').hide();

            $('#studentInput').hide();
            $('#lectureInput').hide();
            $('#companyInput').hide();

            $('#emailStudent').hide();
            $('#emailLecture').hide();
            $('#emailCompany').hide();

            $('#type').change(function () {
                var type = $(this).val();
                if (type == 'student') {
                    $('#studentUserName').show();
                    $('#lectureUserName').hide();
                    $('#companyUserName').hide();
                    $('#userName').hide();

                    $('#studentInput').show();
                    $('#lectureInput').hide();
                    $('#companyInput').hide();

                    $('#labelFullName').show();
                    $('#fullName').show();
                    $('#brFullName').show();

                    $('#emailStudent').show();
                    $('#emailLecture').hide();
                    $('#emailCompany').hide();
                    $('#email').hide();
                    $('#studentInput2').show();
                } else if (type == 'lecture') {
                    $('#studentUserName').hide();
                    $('#lectureUserName').show();
                    $('#companyUserName').hide();
                    $('#userName').hide();

                    $('#studentInput').hide();
                    $('#lectureInput').show();
                    $('#companyInput').hide();

                    $('#labelFullName').show();
                    $('#fullName').show();
                    $('#brFullName').show();

                    $('#emailStudent').hide();
                    $('#emailLecture').show();
                    $('#emailCompany').hide();
                    $('#email').hide();
                    $('#studentInput2').hide();
                } else if (type == 'company') {
                    $('#studentUserName').hide();
                    $('#lectureUserName').hide();
                    $('#companyUserName').show();
                    $('#userName').hide();

                    $('#studentInput').hide();
                    $('#lectureInput').hide();
                    $('#companyInput').show();

                    $('#labelFullName').hide();
                    $('#fullName').hide();
                    $('#brFullName').hide();

                    $('#emailStudent').hide();
                    $('#emailLecture').hide();
                    $('#emailCompany').show();
                    $('#email').hide();
                    $('#studentInput2').hide();
                }
            });
            $('#emailLecture').keyup(function () {
                var email = $(this).val();
                $('#lectureUserName').val(email);
            });
            $('#emailCompany').keyup(function () {
                var email = $(this).val();
                $('#companyUserName').val(email);
            });
            $('#msv').keyup(function () {
                var msv = $(this).val();
                $('#studentUserName').val(msv);
                var emailStudent = $(this).val() + "@student.hust.edu.vn";
                $('#emailStudent').val(emailStudent);
            });
            $('#add-user').addClass('menu-menu');
            $('a#add-user').css('color', '#000000');
        });
    </script>
@endsection