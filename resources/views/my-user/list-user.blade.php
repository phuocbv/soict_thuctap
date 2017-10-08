@extends('home-user.index')
@section('title')
    {{'Danh sách người dùng'}}
@endsection
@section('user-content')
    <style>
        .name-summary {
            color: #FFFFFF;
            font-weight: bold;
            font-size: large;
        }
    </style>
    @if(session()->has('deleteSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteSuccess')}}</div>
    @endif
    @if(session()->has('insertSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('insertSuccess')}}</div>
    @endif
    @if(session()->has('insertWarning'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>OK! </strong><br>
            <strong>Trùng username:</strong>{{session()->get('loopUserName')}}<br>
            <strong>Trùng Email: </strong>{{session()->get('loopEmail')}}<br>
            <strong>Trùng tên công ty: </strong>{{session()->get('loopNameCompany')}}
        </div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Quản lý người dùng</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="list-user" style="color: #333">
            <span class="company-register name-page-profile">Danh sách người dùng</span>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab"
                                                              data-toggle="tab">Tổng hợp</a></li>
                    <li role="presentation"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">Sinh
                            viên</a>
                    </li>
                    <li role="presentation"><a href="#lecture" aria-controls="lecture" role="tab" data-toggle="tab">Giảng
                            viên</a>
                    </li>
                    <li role="presentation"><a href="#company" aria-controls="company" role="tab" data-toggle="tab">Công
                            ty</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="margin-top: 15px">
                    <div role="tabpanel" class="tab-pane fade in active" id="summary">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #489F48;border-color:#489F48;text-align: center">
                                    <span class="name-summary">{{count($student2)}}</span></br>
                                    <span class="name-summary">Sinh viên</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #C63531;border-color:#C63531;text-align: center">
                                    <span class="name-summary">{{count($lecture)}}</span></br>
                                    <span class="name-summary">Giảng viên</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #286091;border-color:#286091;text-align: center">
                                    <span class="name-summary">{{count($company)}}</span></br>
                                    <span class="name-summary">Công ty</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="student">
                        <div class="table-responsive">
                            <table id="table-student" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="min-width: 68px">Username</th>
                                    <th style="min-width: 113px">Họ và tên</th>
                                    <th>Email</th>
                                    <th style="min-width: 49px">Chi tiết</th>
                                    <th style="min-width: 67px">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student as $s)
                                    <tr>
                                        <?php
                                        $userStudent = \App\MyUser::getUserFollowID($s->user_id);
                                        ?>
                                        @foreach($userStudent as $us)
                                            <td>{{$us->user_name}}</td>
                                        @endforeach
                                        <td>{{$s->name}}</td>
                                        @foreach($userStudent as $us)
                                            <td>{{$us->email}}</td>
                                        @endforeach
                                        <td>
                                            <a href="#" data-toggle="modal"
                                               data-target="#{{$s->id}}{{'detail-student'}}">
                                                <span class="">Chi tiết</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit-student?id={{encrypt($s->id)}}"
                                                   class="btn btn-success btn-sm">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <?php
                                                $studentInCourse = \App\StudentInternShipCourse::getSIC($s->id);
                                                $timeNow = strtotime(date('Y-m-d'));
                                                $countCheck = 0;
                                                $studentQue = \App\StudentTmp::getStudent($s->msv, 0);
                                                ?>
                                                @foreach($studentInCourse as $sic)
                                                    <?php
                                                    $InCourse = \App\InternShipCourse::getInCourse($sic->internship_course_id);
                                                    ?>
                                                    @foreach($InCourse as $ic)
                                                        <?php
                                                        $startRegister = strtotime(date('Y-m-d', strtotime($ic->start_register)));
                                                        $finishCourse = strtotime(date('Y-m-d', strtotime($ic->to_date)));
                                                        if ($timeNow >= $startRegister && $timeNow <= $finishCourse) {
                                                            $countCheck++;
                                                        }
                                                        ?>
                                                    @endforeach
                                                @endforeach
                                                @if($countCheck==0&&count($studentQue)==0)
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                       data-target="#{{$s->id}}{{"deleteStudent"}}">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @else
                                                    <a href="#" class="btn btn-danger btn-sm no-delete"
                                                       data-toggle="modal"
                                                       data-target="#">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="lecture">
                        <div class="table-responsive">
                            <table id="table-lecture" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="min-width: 130px">Username</th>
                                    <th style="min-width: 93px">Họ và tên</th>
                                    <th style="min-width: 130px">Email</th>
                                    <th style="min-width: 49px">Chi tiết</th>
                                    <th style="min-width: 67px">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lecture as $l)
                                    <tr>
                                        <?php
                                        $userLecture = \App\MyUser::getUserFollowID($l->user_id);
                                        ?>
                                        @foreach($userLecture as $ul)
                                            <td>{{$ul->user_name}}</td>
                                        @endforeach
                                        <td>{{$l->name}}</td>
                                        @foreach($userLecture as $ul)
                                            <td>{{$ul->email}}</td>
                                        @endforeach
                                        <td>
                                            <a href="#" data-toggle="modal"
                                               data-target="#{{$l->id}}{{'detail-lecture'}}">
                                                <span class="">Chi tiết</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit-lecture?id={{encrypt($l->id)}}"
                                                   class="btn btn-success btn-sm">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <?php
                                                $timeNow = strtotime(date('Y-m-d'));
                                                $lectureInCourse = \App\LectureInternShipCourse::getLectureInCourseFLID($l->id);
                                                $countCheckLecture = 0;
                                                ?>
                                                @foreach($lectureInCourse as $lic)
                                                    <?php
                                                    $InCourseLec = \App\InternShipCourse::getInCourse($lic->internship_course_id);
                                                    ?>
                                                    @foreach($InCourseLec as $icl)
                                                        <?php
                                                        $startRegister = strtotime(date('Y-m-d', strtotime($icl->start_register)));
                                                        $finishCourse = strtotime(date('Y-m-d', strtotime($icl->to_date)));
                                                        if ($timeNow >= $startRegister && $timeNow <= $finishCourse) {
                                                            $countCheckLecture++;
                                                        }
                                                        ?>
                                                    @endforeach
                                                @endforeach
                                                @if($countCheckLecture==0)
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                       data-target="#{{$l->id}}{{'deleteLecture'}}">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @else
                                                    <a href="#" class="btn btn-danger btn-sm no-delete-lecture"
                                                       data-toggle="modal"
                                                       data-target="#">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="company">
                        <div class="table-responsive">
                            <table id="table-company" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="min-width: 155px">Username</th>
                                    <th>Tên công ty</th>
                                    <th style="min-width: 150px">Mail hỗ trợ</th>
                                    <th style="min-width: 49px">Chi tiết</th>
                                    <th style="min-width: 67px">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($company as $c)
                                    <tr>
                                        <?php
                                        $userCompany = \App\MyUser::getUserFollowID($c->user_id);
                                        ?>
                                        @foreach($userCompany as $uc)
                                            <td>{{$uc->user_name}}</td>
                                        @endforeach
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->hr_mail}}</td>
                                        <td>
                                            <a href="#" data-toggle="modal"
                                               data-target="#{{$c->id}}{{'detail-company'}}">
                                                <span class="">Chi tiết</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit-company?id={{encrypt($c->id)}}"
                                                   class="btn btn-success btn-sm">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <?php
                                                $timeNow = strtotime(date('Y-m-d'));
                                                $companyInCourse = \App\CompanyInternShipCourse::getCompanyInCourseFCID($c->id);
                                                $countCheckCompany = 0;
                                                ?>
                                                @foreach($companyInCourse as $cic)
                                                    <?php
                                                    $inCourseCom = \App\InternShipCourse::getInCourse($cic->internship_course_id);
                                                    ?>
                                                    @foreach($inCourseCom as $icc)
                                                        <?php
                                                        $startRegister = strtotime(date('Y-m-d', strtotime($icc->start_register)));
                                                        $finishCourse = strtotime(date('Y-m-d', strtotime($icc->to_date)));
                                                        if ($timeNow >= $startRegister && $timeNow <= $finishCourse) {
                                                            $countCheckCompany++;
                                                        }
                                                        ?>
                                                    @endforeach
                                                @endforeach
                                                @if($countCheckCompany==0)
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                       data-target="#{{$c->id}}{{'deleteCompany'}}">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @else
                                                    <a href="#" class="btn btn-danger btn-sm no-delete-company"
                                                       data-toggle="modal"
                                                       data-target="#">
                                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($student as $s)
        <?php
        $studentUser = \App\MyUser::getUserFollowUserID($s->user_id);
        ?>
        {{--modal hien thi thong tin sinh vien --}}
        <div class="modal fade" id="{{$s->id}}{{"detail-student"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thông tin
                            chi
                            tiết sinh viên {{$s->name}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <div class="table-responsive" style="margin-top: -16px">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <td style="width: 25%">Mã sinh viên:</td>
                                            <td>
                                                {{$s->msv}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Họ và tên:</td>
                                            <td>{{$s->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày sinh</td>
                                            <td>
                                                @if(date('Y',strtotime($s->birthday))!=1970&&date('Y',strtotime($s->birthday))!=-0001)
                                                    {{date('d/m/Y',strtotime($s->birthday))}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Khóa:</td>
                                            <td>{{$s->grade}}</td>
                                        </tr>
                                        <tr>
                                            <td>Hệ đào tạo:</td>
                                            <td>
                                                {{$s->program_university}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>
                                                @foreach($studentUser as $su)
                                                    {{$su->email}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Điện thoại</td>
                                            <td>{{$s->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tiếng anh</td>
                                            <td>{{$s->english}}</td>
                                        </tr>
                                        <tr>
                                            <td>Kỹ năng lập trình</td>
                                            <td>{{$s->programing_skill}}</td>
                                        </tr>
                                        <tr>
                                            <td>Kỹ năng lập trình tốt nhất</td>
                                            <td>{{$s->programing_skill_best}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal sinh vien--}}

        {{--modal xoa sinh vien--}}
        <div class="modal fade" id="{{$s->id}}{{"deleteStudent"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa sinh viên {{$s->name}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-student-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="studentID" value="{{encrypt($s->id)}}">
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
    @foreach($company as $c)
        {{--modal hien thi thong tin cong ty --}}
        <div class="modal fade" id="{{$c->id}}{{"detail-company"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thông tin
                            chi
                            tiết công ty {{$c->name}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <div class="table-responsive" style="margin-top: -16px">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td style="width: 25%">Tên công ty:</td>
                                            <td>{{$c->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày thành lập:</td>
                                            <td>
                                                @if(date('Y',strtotime($c->birthday))!=1970 &&date('Y',strtotime($c->birthday))!=-0001)
                                                    {{date('d-m-Y',strtotime($c->birthday))}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Địa chỉ:</td>
                                            <td>{{$c->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mail hỗ trợ:</td>
                                            <td>{{$c->hr_mail}}</td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại hỗ trợ:</td>
                                            <td>{{$c->hr_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mô tả ngắn gọn:</td>
                                            <td>
                                                {!! nl2br(e(trim($c->description))) !!}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--modal xóa công ty--}}
        <div class="modal fade" id="{{$c->id}}{{"deleteCompany"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa công ty {{$c->name}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-company-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="companyID" value="{{encrypt($c->id)}}">
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
        </div>{{--ket thuc modal xoa công ty--}}

    @endforeach{{--ket thuc modal cong ty--}}
    @foreach($lecture as $l)
        <div class="modal fade" id="{{$l->id}}{{"detail-lecture"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thông tin
                            chi
                            tiết giảng viên {{$l->name}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <div class="table-responsive" style="margin-top: -16px">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <td>Tên giảng viên</td>
                                            <td>
                                                {{$l->name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngày sinh</td>
                                            <td>
                                                @if(date('Y',strtotime($l->birthday))!=1970 &&date('Y',strtotime($l->birthday))!=-0001)
                                                    {{date('d/m/Y',strtotime($l->birthday))}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bộ môn</td>
                                            <td>
                                                {{$l->address}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trình độ</td>
                                            <td>
                                                {{$l->qualification}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Điện thoại</td>
                                            <td>{{$l->phone}}</td>
                                        </tr>
                                        <?php
                                        $myUser = \App\MyUser::getUserFollowID($l->user_id);
                                        ?>
                                        @foreach($myUser as $mu)
                                            <tr>
                                                <td>Email</td>
                                                <td>{{$mu->email}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$l->id}}{{"deleteLecture"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa giảng viên {{$l->name}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-lecture-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="lectureID" value="{{encrypt($l->id)}}">
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
            $('#list-user').addClass('menu-menu');
            $('a#list-user').css('color', '#000000');
            $('#table-student').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3},
                    {"orderable": false, "targets": 4},

                ],
            });
            $('#table-lecture').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('#table-company').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
        });
        $('.no-delete').click(function () {
            alert('hiện tại sinh viên đang tham gia thực tập nên không xóa được sinh viên này khỏi hệ thống');
        });
        $('.no-delete-lecture').click(function () {
            alert('hiện tại giảng viên đang tham gia phụ trách thực tập nên không xóa được giảng viên khỏi hệ thống');
        });
        $('.no-delete-company').click(function () {
            alert('hiện tại công ty đang tham gia thực tập nên không xóa được công ty khỏi hệ thống');
        });

        //        function validateStudent($studentID) {
        //            return false;
        //        }
        //
        //        function userNameStudentChange($studentID) {
        //            alert('aksdjk');
        //            window.console.log($studentID);
        //        }

    </script>
@endsection