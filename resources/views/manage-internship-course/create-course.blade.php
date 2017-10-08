@extends('home-user.index')
@section('user-content')
    <style>
        .margin-row {
            margin-bottom: 15px;
        }

        label.error {
            color: #c0392b;
        }

        .yellow {
            background-color: yellow;
        }
    </style>
    @if(session()->has('errorEmptyTerm')&&session()->get('errorEmptyTerm')!="")
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorEmptyTerm')}}
        </div>
    @endif
    @if(session()->has('errorEmptyLecture')&&session()->get('errorEmptyLecture')!="")
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorEmptyLecture')}}
        </div>
    @endif
    @if(session()->has('errorCreateTime')&&session()->get('errorCreateTime')!="")
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorCreateTime')}}
        </div>
    @endif
    @if(session()->has('errorSameTerm')&&session()->get('errorSameTerm')!="")
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorSameTerm')}}
        </div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Tạo khóa thực tập mới</span>
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert" id="errorDate">
        <strong>Lỗi: </strong>Kỳ học đã diễn ra. Bạn không có quyền tạo khóa thực tập cho kỳ này.Vui lòng chọn khóa khác
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="create-course-form" method="POST" role="form" id="addCourse" onsubmit="return validateForm()">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row margin-row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <label>Chọn kỳ: </label>
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <select name="term" id="term" class="form-control">
                            <option value="">Chọn kỳ</option>
                            <option value="{{$year.'1'}}">Kỳ {{$year.'1'}}</option>
                            <option value="{{$year.'2'}}">Kỳ {{$year.'2'}}</option>
                            <option value="{{$year.'3'}}">Kỳ {{$year.'3'}}</option>
                        </select>
                    </div>
                </div>
                <div class="row margin-row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <label>Ngày bắt đầu: </label>
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <input type="date" name="startTerm" id="startTerm" class="form-control"
                               readonly="readonly">
                    </div>
                </div>
                <div class="row margin-row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <label>Ngày kết thúc:</label>
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <input type="date" name="finishTerm" id="finishTerm" class="form-control"
                               readonly="readonly">
                    </div>
                </div>
                <div class="row margin-row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <label>Chọn giáo viên</label>
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <label style="color:#c0392b" id="notLecture">chưa chọn giáo viên</label>

                        <div class="panel panel-default">
                            <div class="table-responsive" style="height: 200px;overflow-y: auto">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 2%">#</th>
                                        <th style="width: 25%">Tên</th>
                                        <th style="width: 30%">Bộ môn</th>
                                        <th style="width: 25%">Mail liên lạc</th>
                                        <th style="width: 18%">Điện thoại</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lecture as $l)
                                        <?php
                                        $myUser = \App\MyUser::where('id', '=', $l->user_id)->get();
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="choseLecture[]" id="" value="{{$l->id}}"
                                                       class="lecture">
                                            </td>
                                            <td>{{$l->name}}</td>
                                            <td>{{$l->address}}</td>
                                            @foreach($myUser as $mu)
                                                <td>{{$mu->email}}</td>
                                            @endforeach
                                            <td>{{$l->phone}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
    <script>
        $(function () {
            $('#list-course').addClass('menu-menu');
            $('a#list-course').css('color', '#000000');
            $('#errorDate').hide();
            $('#notLecture').hide();
            $('#term').change(function () {
                var term = $(this).val();
                $.get('get-time-term?term=' + term, function (data) {
                    var count = 0;
                    $.each(data, function (index, myTime) {
                        count++;
                        var getDate = new Date(myTime);
                        var date = getDate.toISOString().slice(0, 10);
                        if (count == 1) {
                            var start = new Date(date);
                            var nowDate = new Date();
                            var timeStart = start.getTime();
                            var nowDate = nowDate.getTime();
                            if (nowDate > timeStart) {
                                $('#errorDate').show();
                                $('#errorDate').val(1);
                            } else {
                                $('#errorDate').hide();
                                $('#errorDate').val(0);
                            }
                            $('#startTerm').val(date);
                        } else if (count == 2) {
                            $('#finishTerm').val(date);
                        }
                    });
                });
            });

            $('#addCourse').validate({
                rules: {
                    term: {
                        required: true,
                        remote: {
                            url: "check-course",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            }
                        }
                    }
                },
                messages: {
                    term: {
                        required: "vui lòng chọn kỳ thực tập",
                        remote: "khóa thực tập đã tồn tại"
                    }
                }
            });

        });
        $(".lecture").change(function () {
            if (this.checked) {
                $('#notLecture').hide();
                $(this).closest('tr').addClass('info');
                $(this).addClass('info');
            } else {
                $(this).closest('tr').removeClass('info');
            }
        });
        function validateForm() {
            var errorDate = parseInt($('#errorDate').val());
            var choseLecture = new Array();
            $('.lecture').each(function () {
                if (this.checked) {
                    choseLecture.push($(this).val());
                }
            });
            if (choseLecture.length > 0 && errorDate == 0) {
                return true;
            } else {
                if (choseLecture == 0) {
                    $('#notLecture').show();
                }
                return false;
            }

        }
    </script>
@endsection