@extends('home-user.index')
@section('user-content')
    <style>
        .name-summary {
            color: #FFFFFF;
            font-weight: bold;
            font-size: large;
        }

        .align-assign {
            text-align: center;
        }

        .student-assign {
            font-size: 13px;
            background-color: #EEEEEE;
        }

        .student-result {
            font-size: 13px;
        }

        #student-assign, #student-not-assign, #student-danger-assign, #student-result, #lecture-assess, #timekeeping {
            background-color: #FFFFFF;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Quản lý khóa thực tập</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="list-course" style="color: #333">
            <span class="company-register name-page-profile">Danh sách khóa thực tập</span>
        </a>
        <span class="glyphicon glyphicon-menu-right small"></span>
        @foreach($course as $c)
            <a href="?id={{$c->id}}" style="color: #333">
                <span class="company-register name-page-profile">{{$c->course_term}}</span>
            </a>
        @endforeach
    </div>
    @if(session()->has('errorAddition'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorAddition')}}
        </div>
    @endif
    @if(session()->has('errorStopJoinLecture'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong></strong>{{session()->get('errorStopJoinLecture')}}
        </div>
    @endif
    @if(session()->has('stop-intern'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('stop-intern')}}</div>
    @endif
    @if(session()->has('stopJoinLecture'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('stopJoinLecture')}}</div>
    @endif
    @if(session()->has('replaceSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('replaceSuccess')}}</div>
    @endif
    @if(session()->has('change-company'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('change-company')}}</div>
    @endif
    @if(session()->has('assignAdditionSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('assignAdditionSuccess')}}</div>
    @endif
    <div class="panel panel-default" style="font-family: Arial">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @foreach($course as $c)
                        <span><label>Ngày bắt đầu: </label> {{date('d-m-Y',strtotime($c->from_date))}}</span><br>
                        <?php
                        $yearStartRegister = date('Y', strtotime($c->start_register))
                        ?>
                        @if($yearStartRegister==1970)
                            <span><label>Thời gian bắt đầu đăng ký: </label></span><br>
                        @else
                            <span><label>Ngày bắt đầu đăng
                                    ký:</label> {{date('d-m-Y',strtotime($c->start_register))}}</span>
                            <br>
                        @endif
                    @endforeach
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @foreach($course as $c)
                        <span><label>Ngày kết thúc:</label> {{date('d-m-Y',strtotime($c->to_date))}}</span><br>
                        <?php
                        $yearStartRegister = date('Y', strtotime($c->start_register))
                        ?>
                        @if($yearStartRegister==1970)
                            <span><label>Thời gian kết thúc đăng ký: </label></span>
                        @else
                            <span><label>Ngày kết thúc đăng
                                    ký:</label> {{date('d-m-Y',strtotime($c->finish_register))}}</span>
                        @endif
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
            </div>
            <hr style="margin-top: 0px;margin-bottom: 0px;margin-left: -15px;margin-right: -15px">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs " role="tablist" style="margin-left: -15px;margin-right: -15px">
                    <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab"
                                                              data-toggle="tab">Tổng hợp</a></li>
                    <li role="presentation"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">Sinh
                            viên tham gia</a>
                    </li>
                    <li role="presentation"><a href="#lecture" aria-controls="lecture" role="tab" data-toggle="tab">Giảng
                            viên tham gia</a>
                    </li>
                    <li role="presentation"><a href="#company" aria-controls="company" role="tab" data-toggle="tab">Công
                            ty tham gia</a>
                    </li>
                    <li role="presentation"><a href="#assign" aria-controls="assign" role="tab" data-toggle="tab">Phân
                            công</a>
                    </li>
                    <li role="presentation"><a href="#result" aria-controls="result" role="tab" data-toggle="tab">Kết
                            quả</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="margin-top: 20px">
                    <div role="tabpanel" class="tab-pane active" id="summary">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #489F48;border-color:#489F48;text-align: center">

                                    <span class="name-summary">{{count($studentInCourse)}}</span></br>
                                    <span class="name-summary">Sinh viên</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #C63531;border-color:#C63531;text-align: center">
                                    <span class="name-summary">{{count($lectureInCourse)}}</span></br>
                                    <span class="name-summary">Giảng viên</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body"
                                     style="background-color: #286091;border-color:#286091;text-align: center">
                                    <span class="name-summary">{{count($companyInCourse)}}</span></br>
                                    <span class="name-summary">Công ty</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('manage-internship-course.tab-student-join')
                    @include('manage-internship-course.tab-lecture-join')
                    <div role="tabpanel" class="tab-pane" id="company">
                        <div class="table-responsive">
                            <table id="table-company" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="min-width: 82px">Tên công ty</th>
                                    <th style="min-width: 240px">Địa chỉ</th>
                                    <th style="min-width: 104px">Ngày thành lập</th>
                                    <th style="min-width: 150px">Mail hỗ trợ</th>
                                    <th style="min-width: 100px">Điện thoại</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="min-width: 82px">Tên công ty</th>
                                    <th style="min-width: 240px">Địa chỉ</th>
                                    <th style="min-width: 104px">Ngày thành lập</th>
                                    <th style="min-width: 150px">Mail hỗ trợ</th>
                                    <th style="min-width: 100px">Điện thoại</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($arrCompany as $ac)
                                    <tr>
                                        <td>{{$ac->name}}</td>
                                        <td>{{$ac->address}}</td>
                                        <td>
                                            @if(date('Y',strtotime($ac->birthday))!=1970 &&date('Y',strtotime($ac->birthday))!=-0001)
                                                {{date('d/m/Y',strtotime($ac->birthday))}}
                                            @endif
                                        </td>
                                        <td>{{$ac->hr_mail}}</td>
                                        <td>{{$ac->hr_phone}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="assign">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title name-page-profile align-assign">Danh sách sinh viên đã phân
                                    công</h3>
                            </div>
                            <div class="table-responsive student-assign">
                                <table id="student-assign" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Môn học</th>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 97px">Tên sinh viên</th>
                                        <th style="min-width: 32px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                        <th style="width: 66px">phân công</th>
                                        <th style="min-width: 133px">Giảng viên phụ trách</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Môn học</th>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 97px">Tên sinh viên</th>
                                        <th style="min-width: 32px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                        <th style="width: 66px">phân công</th>
                                        <th style="min-width: 133px">Giảng viên phụ trách</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach($arrAssign as $aa)
                                        <?php
                                        $i++;
                                        ?>
                                        @foreach($aa as $asub)
                                            <?php
                                            $student = \App\Student::getStudentFollowID($asub->student_id);
                                            $company = \App\Company::getCompanyFollowID($asub->company_id);
                                            $lecture = \App\Lecture::getLectureFollowID($asub->lecture_id);
                                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($asub->student_id, $asub->internship_course_id);
                                            ?>
                                            @if($i%2==0)
                                                <tr>
                                            @else
                                                <tr style="background-color: #ecf0f1">
                                                    @endif
                                                    <td>
                                                        @foreach($studentInCourse as $sic)
                                                            {{$sic->subject}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->msv}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->name}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->grade}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->program_university}}
                                                        @endforeach
                                                    </td>

                                                    <td style="width: 66px">
                                                        @foreach($company as $c)
                                                            {{$c->name}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($lecture as $l)
                                                            {{$l->name}}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title name-page-profile align-assign">Danh sách sinh chưa phân công (do
                                    hết
                                    chỗ)</h3>
                            </div>
                            <div class="table-responsive student-assign">
                                <table id="student-not-assign" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 90px">Tên sinh viên</th>
                                        <th style="min-width: 33px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                        <th style="min-width: 100px">Phân công</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 90px">Tên sinh viên</th>
                                        <th style="min-width: 33px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                        <th style="min-width: 100px">Phân công</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($arrStudentQue as $asq)
                                        <?php
                                        $student = \App\Student::getStudentFMSV($asq->msv);
                                        ?>
                                        @foreach($student as $s)
                                            <tr>
                                                <td>{{$s->msv}}</td>
                                                <td>{{$s->name}}</td>
                                                <td>{{$s->grade}}</td>
                                                <td>
                                                    {{$s->program_university}}
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                                       data-target="#{{$s->id}}{{"studentQue"}}">
                                                        <span>Phân công</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <span style="font-weight: bold;font-size: large"></span>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title name-page-profile align-assign">Danh sách sinh viên không được
                                    tham gia (do chưa đăng ký học tập)</h3>
                            </div>
                            <div class="table-responsive student-assign">
                                <table id="student-danger-assign" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 95px">Tên sinh viên</th>
                                        <th style="min-width: 32px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="min-width: 79px">Mã sinh viên</th>
                                        <th style="min-width: 95px">Tên sinh viên</th>
                                        <th style="min-width: 32px">Khóa</th>
                                        <th style="min-width: 84px">Chương trình</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($arrStudentDanger as $asd)
                                        <?php
                                        $student = \App\Student::getStudentFMSV($asd->msv);
                                        ?>
                                        @foreach($student as $s)
                                            <tr>
                                                <td>{{$s->msv}}</td>
                                                <td>{{$s->name}}</td>
                                                <td>{{$s->grade}}</td>
                                                <td>
                                                    {{$s->program_university}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="result" style="">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title name-page-profile align-assign">Bảng kết quả sinh viên</h3>
                            </div>
                            <div class="table-responsive student-assign">
                                <table id="student-result" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" name="selectAll" class="selectAll"></th>
                                        <th>Môn học</th>
                                        <th style="min-width: 64px">Mã sinh viên</th>
                                        <th style="min-width: 80px">Tên sinh viên</th>
                                        <th style="min-width: 100px">phân công</th>
                                        <th style="min-width: 97px">Giảng viên phụ trách</th>
                                        <th style="min-width: 40px">Báo cáo</th>
                                        <th style="min-width: 45px">
                                            <span>Nhận xét</span><br>
                                            <span>(Công ty)</span>
                                        </th>
                                        <th style="min-width: 50px">
                                            <span>Điểm</span><br>
                                            <span>(Giảng viên)</span>
                                        </th>
                                        <th style="min-width: 39px">
                                            <span>Điểm</span><br>
                                            <span>(Công ty)</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <a href="#" id="print-many-report">
                                                <span class="glyphicon glyphicon-print"></span>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" id="print-many-company-assess">
                                                <span class="glyphicon glyphicon-print"></span>
                                            </a>
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach($arrAssign as $aa)
                                        <?php
                                        $i++;
                                        ?>
                                        @foreach($aa as $asub)
                                            <?php
                                            $student = \App\Student::getStudentFollowID($asub->student_id);
                                            $company = \App\Company::getCompanyFollowID($asub->company_id);
                                            $lecture = \App\Lecture::getLectureFollowID($asub->lecture_id);
                                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($asub->student_id, $asub->internship_course_id);
                                            $companyAssess = \App\CompanyAssess::getCompanyAssess($asub->id);
                                            ?>
                                            @if($i%2==0)
                                                <tr>
                                            @else
                                                <tr style="background-color: #ecf0f1">
                                                    @endif
                                                    <td>
                                                        @foreach($studentInCourse as $sic)
                                                            <input type="checkbox" name="select[]" id="" class="select"
                                                                   value="{{$sic->id}}">
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($studentInCourse as $sic)
                                                            {{$sic->subject}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->msv}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($student as $s)
                                                            {{$s->name}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($company as $c)
                                                            {{$c->name}}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($lecture as $l)
                                                            {{$l->name}}
                                                        @endforeach
                                                    </td>
                                                    @foreach($studentInCourse as $sic)
                                                        <?php
                                                        $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                                        ?>
                                                        <td>
                                                            @if(count($studentReport)>0)
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#{{$sic->id}}{{"view-student-report"}}">
                                                                    {{'Xem'}}
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(count($companyAssess)>0)
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#{{$sic->id}}{{"view-company-assess"}}">
                                                                    {{'Xem'}}
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$sic->lecture_point}}
                                                        </td>
                                                        <td>
                                                            {{$sic->company_point}}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @include('manage-internship-course.tab-lecture-assess')
                        @include('manage-internship-course.tab-timekeeping')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('manage-internship-course.modal-student-result')

    @foreach($arrStudentQue as $asq)
        <?php
        $student = \App\Student::getStudentFMSV($asq->msv);
        ?>
        @foreach($student as $s)
            <div class="modal fade" id="{{$s->id}}{{"studentQue"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 data-keyboard="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Phân công thực tập cho
                                sinh viên {{$s->name}}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="assign-additional-form" method="POST" role="form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="courseID" id="courseID" value="{{$courseID}}">
                                <input type="hidden" name="studentID" id="studentID" value="{{$s->id}}">
                                <span style="font-size: 15px">Chọn công ty</span>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên công ty</th>
                                            <th>Số sinh viên đã nhận</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($arrCompany as $ac)
                                            <tr>
                                                <td>
                                                    <input type="radio" name="chooseCompany" required="required"
                                                           value="{{$ac->id}}">
                                                </td>
                                                <td>{{$ac->name}}</td>
                                                <?php
                                                $comIC = \App\CompanyInternShipCourse::getComInCourse($ac->id, $courseID);
                                                ?>
                                                @foreach($comIC as $cic)
                                                    <td>{{$cic->student_quantity}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-primary">Phân công</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    <script>
        $(function () {
            $('#list-course').addClass('menu-menu');
            $('a#list-course').css('color', '#000000');
            $('#course-student-register').addClass('active');
            $('#table-student').DataTable({
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
            $('#table-lecture').DataTable({
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
            $('#table-company').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3},
                    {"orderable": false, "targets": 4}
                ],
            });
            $('#student-assign').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('#student-not-assign').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3},
                    {"orderable": false, "targets": 4}
                ],
            });
            $('#student-danger-assign').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3}
                ]
            });
            $('#student-result').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('#lecture-assess').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('#timekeeping').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('.selectAll').click(function () {
                if (this.checked) {
                    $('.select').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.select').each(function () {
                        this.checked = false;
                    });
                }
            });
            $('#print-many-report').click(function () {
                var arrLIC = new Array();
                var arrAll = new Array();
                var arrPrint = new Array();
                $('.select').each(function () {
                    if (this.checked) {
                        arrLIC.push($(this).val());
                    }
                    arrAll.push($(this).val());
                });
                if (arrLIC.length == 0) {
                    for (var i = 0; i < arrAll.length; i++) {
                        arrPrint[i] = arrAll[i];
                    }
                } else {
                    for (var i = 0; i < arrLIC.length; i++) {
                        arrPrint[i] = arrLIC[i];
                    }
                }

                var w = window.open('', 'printwindow');
                w.document.open();
                w.document.onreadystatechange = function () {
                    if (this.readyState === 'complete') {
                        this.onreadystatechange = function () {
                        };
                        w.focus();
                        w.print();
                        w.close();
                    }
                };
                w.document.write('<!DOCTYPE html>');
                w.document.write('<html><head>');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="publlic/bootstrap/css/bootstrap-theme.css">');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="public/bootstrap/css/bootstrap.min.css" >');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="public/bootstrap/css/bootstrap-theme.min.css" >');
                w.document.write('</head><body>');
                var count = 0;
                for (var i = 0; i < arrPrint.length; i++) {
                    if ($("#" + arrPrint[i] + "printStudentReport").length > 0) {
                        w.document.write($("#" + arrPrint[i] + "printStudentReport").html());
                        w.document.write('<div style="page-break-after: always">&nbsp;</div>')
                    }
                }
                w.document.write('</body></html>');
                w.document.close();
            });
            $('#print-many-company-assess').click(function () {
                var arrLIC = new Array();
                var arrAll = new Array();
                var arrPrint = new Array();
                $('.select').each(function () {
                    if (this.checked) {
                        arrLIC.push($(this).val());
                    }
                    arrAll.push($(this).val());
                });
                if (arrLIC.length == 0) {
                    for (var i = 0; i < arrAll.length; i++) {
                        arrPrint[i] = arrAll[i];
                    }
                } else {
                    for (var i = 0; i < arrLIC.length; i++) {
                        arrPrint[i] = arrLIC[i];
                    }
                }
                var w = window.open('', 'printwindow');
                w.document.open();
                w.document.onreadystatechange = function () {
                    if (this.readyState === 'complete') {
                        this.onreadystatechange = function () {
                        };
                        w.focus();
                        w.print();
                        w.close();
                    }
                };
                w.document.write('<!DOCTYPE html>');
                w.document.write('<html><head>');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="public/bootstrap/css/bootstrap-theme.css">');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="public/bootstrap/css/bootstrap.min.css" >');
                w.document.write('<link rel="stylesheet" media="screen,print" type="text/css" href="public/bootstrap/css/bootstrap-theme.min.css" >');
                w.document.write('</head><body>');
                for (var i = 0; i < arrPrint.length; i++) {
                    if ($("#" + arrPrint[i] + "printAs").length > 0) {
                        w.document.write($("#" + arrPrint[i] + "printAs").html());
                        w.document.write('<div style="page-break-after: always">&nbsp;</div>');
                    }
                }
                w.document.write('</body></html>');
                w.document.close();
            });
        });
    </script>
@endsection