@extends('home-user.index')
@section('title')
    {{'Danh sách khóa thực tập'}}
@endsection
@section('user-content')
    <style>
        .pagination {
            margin-top: 0px;
            margin-bottom: -6px;
        }
    </style>
    @if(session()->has('errorNotPlan'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorNotPlan')}}
        </div>
    @endif
    @if(session()->has('createSuccessCourse'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('createSuccessCourse')}}</div>
    @endif
    @if(session()->has('errorUpdateTime'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorUpdateTime')}}
        </div>
    @endif
    @if(session()->has('successUpdateTime'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('successUpdateTime')}}</div>
    @endif
    @if(session()->has('assignSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('assignSuccess')}}</div>
    @endif
    @if(session()->has('deleteSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteSuccess')}}</div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-8 col-sm-9 col-md-10 col-lg-11">
            <span class="name-page-profile">Quản lý khóa thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="list-course" style="color: #333">
                <span class="company-register name-page-profile">Danh sách khóa thực tập</span>
            </a>
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <a href="create-course" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus-sign"></span> tạo
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive" style="margin-top: 15px">
            <table id="myTable" class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 23px">Kỳ</th>
                    <th style="min-width: 146px">Trạng thái thực tập</th>
                    <th style="min-width: 163px">Trạng thái phân công</th>
                    <th style="min-width: 143px">Trạng thái đăng ký</th>
                    <th style="min-width: 55px">Chi tiết</th>
                    <th style="min-width: 163px">Thao tác</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th style="min-width: 23px">Kỳ</th>
                    <th style="min-width: 146px">Trạng thái thực tập</th>
                    <th style="min-width: 163px">Trạng thái phân công</th>
                    <th style="min-width: 143px">Trạng thái đăng ký</th>
                    <th style="min-width: 55px">Chi tiết</th>
                    <th style="min-width: 163px">Thao tác</th>
                </tr>
                </tfoot>
                <tbody>
                <?php
                $timeCurrent = strtotime(date('Y-m-d'));
                ?>
                @foreach($course as $c)
                    <tr>
                        <td>{{$c->course_term}}</td>
                        @if($timeCurrent<strtotime($c->from_date))
                            <td>chưa bắt đầu</td>
                        @elseif(strtotime($c->from_date)<$timeCurrent&&$timeCurrent<strtotime($c->to_date))
                            <td>Đang diễn ra</td>
                        @elseif($timeCurrent>strtotime($c->to_date))
                            <td>kết thúc</td>
                        @endif
                        <td>{{$c->status}}</td>
                        <?php
                        $checkStartRegister = (int)date('Y', strtotime($c->start_register));
                        ?>
                        @if($checkStartRegister==1970)
                            <td>chưa mở</td>
                        @else
                            @if($timeCurrent<strtotime($c->start_register))
                                <td>chưa mở</td>
                            @elseif(strtotime($c->start_register)<=$timeCurrent&&$timeCurrent<=strtotime($c->finish_register))
                                <td>đăng ký</td>
                            @elseif($timeCurrent>strtotime($c->finish_register))
                                <td>kết thúc</td>
                            @endif
                        @endif
                        <td>
                            <a href="course-detail?id={{$c->id}}">Chi tiết</a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php
                                $yearFinishRegister = (int)date('Y', strtotime($c->finish_register));
                                $yearStartRegister = (int)date('Y', strtotime($c->start_register));
                                ?>
                                @if($yearFinishRegister==1970)
                                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                       data-target="#{{$c->id}}{{"edit"}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                @else
                                    @if($timeCurrent<strtotime($c->from_date))
                                        @if($c->status=='chưa phân công')
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                               data-target="#{{$c->id}}{{"edit"}}">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-success btn-sm error-edit-assign">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="#" class="btn btn-success btn-sm error-edit-time">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    @endif
                                @endif
                                <?php
                                $studentInCourse = \App\StudentInternShipCourse::getSICFCourseID($c->id);
                                $companyInCourse = \App\CompanyInternShipCourse::getCompanyInternShipCourse($c->id);
                                ?>
                                @if($yearStartRegister==1970)
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                       data-target="#{{$c->id}}{{'deleteCourse'}}">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                    </a>
                                @else
                                    @if($timeCurrent<strtotime(date('Y-m-d',strtotime($c->start_register))))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                           data-target="#{{$c->id}}{{'deleteCourse'}}">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </a>
                                    @elseif($timeCurrent>strtotime(date('Y-m-d',strtotime($c->to_date))))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                           data-target="#{{$c->id}}{{'deleteCourse'}}">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-sm error-remove-time">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </a>
                                    @endif
                                @endif
                                @if($yearFinishRegister==1970)
                                    <a href="" class="btn btn-primary btn-sm error-assign-create">
                                        <span>Phân công</span>
                                    </a>
                                @else
                                    @if($timeCurrent > strtotime(date('Y-m-d',strtotime($c->finish_register)))
                                    && $timeCurrent < strtotime(date('Y-m-d',strtotime($c->to_date))))
                                        <a href="#" class="btn btn-primary btn-sm"
                                           data-toggle="modal"
                                           data-target="#{{$c->id}}{{"assign"}}">
                                            <span>Phân công</span>
                                        </a>
                                    @else
                                        @if($timeCurrent>strtotime(date('Y-m-d',strtotime($c->from_date))))
                                            <a href=""
                                               class="btn btn-primary btn-sm error-assign-finish">
                                                <span>Phân công</span>
                                            </a>
                                        @elseif($timeCurrent<=strtotime(date('Y-m-d',strtotime($c->finish_register)))
                                        &&$timeCurrent>=strtotime(date('Y-m-d',strtotime($c->start_register))))
                                            <a href=""
                                               class="btn btn-primary btn-sm error-assign-run">
                                                <span>Phân công</span>
                                            </a>
                                        @elseif($timeCurrent<strtotime(date('Y-m-d',strtotime($c->start_register))))
                                            <a href=""
                                               class="btn btn-primary btn-sm error-open">
                                                <span>Phân công</span>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @foreach($course as $c)
        <div class="modal fade" id="{{$c->id}}{{"edit"}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Mở đăng ký</h4>
                    </div>
                    <div class="modal-body">
                        <form action="update-time-register" method="POST" role="form" id="{{$c->id}}" name="{{$c->id}}"
                              onsubmit="return validateForm({{$c->id}})">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="courseID" id="courseID" value="{{encrypt($c->id)}}">
                            <input type="hidden" name="fromTru2" class="fromTru2{{$c->id}}"
                                   value="{{date('Y-m-d',strtotime(date('Y-m-d',strtotime($c->from_date))." -4 day"))}}">

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <label>Bắt đầu:</label>
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <label style="color:#c0392b" class="errorStart{{$c->id}}" hidden="hidden">Phải lớn
                                        hơn hoặc bằng
                                        ngày hiện
                                        tại</label>
                                    <input type="date" name="startRegister" class="form-control startRegister{{$c->id}}"
                                           value="{{date('Y-m-d',strtotime($c->start_register))}}"
                                           onchange="startChange({{$c->id}})">
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <label>Kết thúc:</label>
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <label style="color:#c0392b" class="errorFinish1{{$c->id}}" hidden="hidden">Phải lớn
                                        hơn ngày bắt
                                        đầu đăng
                                        ký</label>
                                    <label style="color:#c0392b" class="errorFinish2{{$c->id}}" hidden="hidden">Phải
                                        trước ngày bắt đầu thực tập 2 ngày</label>
                                    <input type="date" name="finishRegister"
                                           class="form-control finishRegister{{$c->id}}"
                                           value="{{date('Y-m-d',strtotime($c->finish_register))}}"
                                           onchange="finishChange({{$c->id}})">
                                </div>
                            </div>
                            <div style="text-align: center;margin-top: 15px">
                                <button type="submit" class="btn btn-primary">lưu
                                    lại
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$c->id}}{{"assign"}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Phân công thực tập cho
                            kỳ {{$c->course_term}}</h4>
                    </div>
                    <div class="modal-body">
                        <?php
                        $companyInCourse = \App\CompanyInternShipCourse::getCompanyInCourse($c->id);
                        $lectureInCourse = \App\LectureInternShipCourse::getLectureInCourse($c->id);
                        $allLecture = \App\Lecture::all();
                        $lecture = array();
                        //lay danh sach giang vien chua tham gia khoa này
                        foreach ($allLecture as $al) {
                            $count = 0;
                            foreach ($lectureInCourse as $lic) {
                                if ($al->id == $lic->lecture_id) {
                                    $count++;
                                }
                            }
                            if ($count == 0) {
                                $lecture[] = $al;
                            }
                        }
                        ?>
                        <span style="font-size: 16px">Hiện tại có: {{count($companyInCourse)}}
                            doanh nghiệp, {{count($lectureInCourse)}}
                            giảng viên tham gia</span>

                        <form action="assign-form" method="POST" role="form" id="{{$c->id}}{{"assign"}}"
                              name="{{$c->id}}{{"assign"}}"
                              onsubmit="return validateFormAssign({{$c->id}})" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="courseID" id="courseID" value="{{encrypt($c->id)}}">
                            <div class="form-group">
                                <span style="font-size: 16px">Chọn file sinh viên: </span>
                                <span><input type="file" name="file" id="file{{$c->id}}"
                                             style="display: inline" required="required"
                                             accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"></span>
                            </div>
                            <br>
                            <span style="font-size: 16px">Chọn thêm giáo viên: </span>

                            <div class="panel panel-default">
                                <div class="table-responsive" style="height: 200px;overflow-y: auto">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>Bộ môn</th>
                                            <th>Mail liên lạc</th>
                                            <th>Điện thoại</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lecture as $l)
                                            <?php
                                            $myUser = \App\MyUser::where('id', '=', $l->user_id)->get();
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="choseLecture[]" id=""
                                                           value="{{$l->id}}"
                                                           class="lecture{{$c->id}}">
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
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Phân công
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$c->id}}{{"deleteCourse"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa khóa thực tập {{$c->name}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-course-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseID" value="{{encrypt($c->id)}}">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            style="min-width: 70px">Không
                                    </button>
                                    <button type="submit" class="btn btn-danger" style="min-width: 70px">Có</button>
                                </form>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal xoa sinh vien--}}

    @endforeach
    <script>
        $(function () {
            $('#list-course').addClass('menu-menu');
            $('a#list-course').css('color', '#000000');
            $('#myTable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3},
                    {"orderable": false, "targets": 4},
                    {"orderable": false, "targets": 5},
                ],
            });
            $('.error-edit-assign').click(function () {
                alert('Đã phân công, không được phép sửa');
            });
            $('.error-edit-time').click(function () {
                alert('Khóa đã bắt đầu, không được phép sửa');
            });
            $('.error-remove-time').click(function () {
                alert('hiện tại khóa thực tập đang diễn ra, bạn không xóa được khóa này khỏi hệ thống');
            });
            $('.exist-company').click(function () {
                alert('Đã có công ty đăng ký, bạn không xóa được khóa này khỏi hệ thống');
            });
            $('.error-assign-create').click(function () {
                alert('Chưa đăng ký, không được phép phân công');
            });
            $('.error-assign-finish').click(function () {
                alert('Hết thời gian phân công, không được phép phân công');
            });
            $('.error-assign-assign').click(function () {
                alert('Đã phân công');
            });
            $('.error-assign-run').click(function () {
                alert('Đang đăng ký, không được phép phân công');
            });
            $('.error-open').click(function () {
                alert('Chưa mở đăng ký, không phải lúc phân công');
            });
        });
        function validateForm(courseID) {
            var startRegisterDate = new Date($("." + "startRegister" + courseID, "#" + courseID).val());
            var finishRegisterDate = new Date($("." + "finishRegister" + courseID, "#" + courseID).val());
            var fromTru2Date = new Date($("." + "fromTru2" + courseID, "#" + courseID).val());
            var currentDate = new Date();

            var strStart = startRegisterDate.getFullYear() + '-' + (startRegisterDate.getMonth() + 1) + '-' + startRegisterDate.getDate();
            var strFinish = finishRegisterDate.getFullYear() + '-' + (finishRegisterDate.getMonth() + 1) + '-' + finishRegisterDate.getDate();
            var strFromTru2 = fromTru2Date.getFullYear() + '-' + (fromTru2Date.getMonth() + 1) + '-' + fromTru2Date.getDate();
            var current = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate();

            var start = new Date(strStart);
            var finish = new Date(strFinish);
            var from = new Date(strFromTru2);
            var cu = new Date(current);
            if (start.getTime() >= cu.getTime() &&
                    start.getTime() < finish.getTime()
                    && finish.getTime() <= from.getTime()) {
                return true;
            } else {
                if (start.getTime() < cu.getTime()) {
                    $("." + "errorStart" + courseID, "#" + courseID).show();
                } else {
                    $("." + "errorStart" + courseID, "#" + courseID).hide();
                }
                if (finish.getTime() < start.getTime()) {
                    $("." + "errorFinish1" + courseID, "#" + courseID).show();
                } else {
                    $("." + "errorFinish1" + courseID, "#" + courseID).hide();
                }
                if (from.getTime() < finish.getTime()) {
                    $("." + "errorFinish2" + courseID, "#" + courseID).show();
                } else {
                    $("." + "errorFinish2" + courseID, "#" + courseID).hide();
                }
                return false;
            }
        }
        function startChange(courseID) {
            var startRegisterDate = new Date($("." + "startRegister" + courseID, "#" + courseID).val());
            var currentDate = new Date();

            var strStart = startRegisterDate.getFullYear() + '-' + (startRegisterDate.getMonth() + 1) + '-' + startRegisterDate.getDate();
            var current = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate();

            var start = new Date(strStart);
            var cu = new Date(current);

            if (start.getTime() < cu.getTime()) {
                $("." + "errorStart" + courseID, "#" + courseID).show();
            } else {
                $("." + "errorStart" + courseID, "#" + courseID).hide();
            }
        }
        function finishChange(courseID) {
            var startRegisterDate = new Date($("." + "startRegister" + courseID, "#" + courseID).val());
            var finishRegisterDate = new Date($("." + "finishRegister" + courseID, "#" + courseID).val());
            var fromTru2Date = new Date($("." + "fromTru2" + courseID, "#" + courseID).val());

            var strStart = startRegisterDate.getFullYear() + '-' + (startRegisterDate.getMonth() + 1) + '-' + startRegisterDate.getDate();
            var strFinish = finishRegisterDate.getFullYear() + '-' + (finishRegisterDate.getMonth() + 1) + '-' + finishRegisterDate.getDate();
            var strFromTru2 = fromTru2Date.getFullYear() + '-' + (fromTru2Date.getMonth() + 1) + '-' + fromTru2Date.getDate();

            var start = new Date(strStart);
            var finish = new Date(strFinish);
            var from = new Date(strFromTru2);

            if (finish.getTime() <= start.getTime()) {
                $("." + "errorFinish1" + courseID, "#" + courseID).show();
            } else {
                $("." + "errorFinish1" + courseID, "#" + courseID).hide();
            }
            if (from.getTime() < finish.getTime()) {
                $("." + "errorFinish2" + courseID, "#" + courseID).show();
            } else {
                $("." + "errorFinish2" + courseID, "#" + courseID).hide();
            }
        }
    </script>
@endsection