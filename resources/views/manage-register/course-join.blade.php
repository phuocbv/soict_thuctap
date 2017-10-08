@extends('home-user.index')
@section('title')
    {{'Khóa tham gia'}}
@endsection
@section('user-content')
    <style>
        .stars {
            display: inline-block;
        }

        input.star {
            display: none;
        }

        label.star {
            float: right;
            padding-left: 10px;
            font-size: 20px;
            color: #bdc3c7;
            transition: all .2s;
        }

        input.star:checked ~ label.star:before {
            content: '\f005';
            color: #FFD700;
            transition: all .25s;
        }

        input.star-1:checked ~ label.star:before {
            color: #F62;
        }

        label.star:hover {
            transform: rotate(-15deg) scale(1.3);
        }

        label.star:before {
            content: '\f006';
            font-family: FontAwesome;
        }

        .style-form {
            font-weight: bold;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Khóa thực tập</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="course-join" style="color: #333">
            <span class="name-page-profile">Các khóa tham gia</span>
        </a>
    </div>
    @if(session()->has('uploadReportSuccess'))
        <div class="alert alert-success myLabel"
             role="alert">{{session()->get('uploadReportSuccess')}}</div>
    @endif
    @if(session()->has('writeReportSuccess'))
        <div class="alert alert-success myLabel"
             role="alert">Viết báo cáo thành công
        </div>
    @endif
    @if(session()->has('editReportSuccess'))
        <div class="alert alert-success myLabel"
             role="alert">Chỉnh sửa báo cáo thành công
        </div>
    @endif
    @if(session()->has('editError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>Lỗi sửa báo cáo
        </div>
    @endif
    <script>
        $(document).ready(function () {
            $('#courseJoin').addClass('menu-menu');
            $('a#courseJoin').css('color', '#000000');
        });
    </script>
    <div class="panel panel-default" style="background-color: #EEEEEE;min-height: 100vh">
        <div class="panel panel-default">
            <div class="panel-body">
                @if(count($courseCurrent)==0)
                    <div class="panel panel-default"
                         style="border-color: #FFFFFF;margin: -15px">
                        <div style="text-align: center;padding-top: 15px">
                            <h3 class="panel-title" style="font-weight: bold">Kỳ thực tập hiện tại
                            </h3>
                            <span style="color:#E80000">(không có kỳ thực tập nào đang diễn ra)</span>
                        </div>
                    </div>
                @else
                    @foreach($courseCurrent as $cc)
                        <?php
                        $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($studentID, $cc->id);
                        $fromDate = $cc->from_date;
                        $toDate = $cc->to_date;
                        ?>
                        <div class="panel panel-default"
                             style="border-color: #FFFFFF;margin: -15px">
                            <div style="text-align: center;padding-top: 15px">
                                <h3 class="panel-title" style="font-weight: bold">Kỳ thực tập hiện
                                    tại {{$cc->course_term}}
                                </h3>
                            <span>(Bắt đầu: {{date('d/m/y',strtotime($cc->from_date))}}
                                , kết thúc {{date('d/m/Y',strtotime($cc->to_date))}})</span>
                            </div>
                            @if(count($studentInCourse)==0)
                                <div style="color:#E80000;text-align: center">
                                    <span>Bạn chưa tham gia khóa thực tập này</span>
                                </div>
                            @else
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        </div>
                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                            @foreach($studentInCourse as $sic)
                                                <?php
                                                $groupCurrent = \App\InternShipGroup::getGroupFollowSI($sic->student_id, $sic->internship_course_id);
                                                $companyCurrent = array();
                                                $lectureCurrent = array();
                                                $lecInCourse = array();
                                                $companyAssess = array();
                                                $timekeeping = array();
                                                $companyInCourse = array();
                                                $student = \App\Student::getStudentFollowID($sic->student_id);
                                                foreach ($groupCurrent as $gc) {
                                                    $com = App\Company::getCompanyFollowID($gc->company_id);
                                                    $lec = \App\Lecture::getLectureFollowID($gc->lecture_id);
                                                    $lecInC = \App\LectureInternShipCourse::getLecInCourse($gc->lecture_id, $gc->internship_course_id);
                                                    $comAssess = \App\CompanyAssess::getCompanyAssess($gc->id);
                                                    $timekeeping = \App\Timekeeping::getFollowStudentIDCourseID($gc->student_id, $gc->internship_course_id);
                                                    $comInC = \App\CompanyInternShipCourse::getComInCourse($gc->company_id, $gc->internship_course_id);
                                                    foreach ($com as $c) {
                                                        $companyCurrent[] = $c;
                                                    }
                                                    foreach ($lec as $l) {
                                                        $lectureCurrent[] = $l;
                                                    }
                                                    foreach ($lecInC as $li) {
                                                        $lecInCourse[] = $li;
                                                    }
                                                    foreach ($comAssess as $ca) {
                                                        $companyAssess[] = $ca;
                                                    }
                                                    foreach ($comInC as $ci) {
                                                        $companyInCourse[] = $ci;
                                                    }
                                                }
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td style="width: 50%">Môn thực tập</td>
                                                            <td>{{$sic->subject}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 50%">
                                                                Tên công ty thực tập:
                                                            </td>
                                                            <td>
                                                                @foreach($companyCurrent as $cc)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$cc->id}}{{"companyCurrent"}}">
                                                                        {{$cc->name}}
                                                                    </a>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Giảng viên phụ trách:
                                                            </td>
                                                            <td>
                                                                @foreach($lectureCurrent as $lc)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$lc->id}}{{"lectureCurrent"}}">
                                                                        {{$lc->name}}
                                                                    </a>
                                                                @endforeach

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Công việc được giao:</td>
                                                            <td>
                                                                @if($sic->assign_work!=null)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$sic->id}}{{"assign-work"}}">
                                                                        {{'Xem'}}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Công ty nhận xét:
                                                            </td>
                                                            <td>
                                                                @if(count($companyAssess)>0)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$sic->id}}{{"company-assess"}}">
                                                                        {{'Xem'}}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Bảng chấm công:
                                                            </td>
                                                            <td>
                                                                @if(count($timekeeping)>0)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$sic->id}}{{"timekeeping"}}">
                                                                        {{'Xem'}}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Điểm giảng viên:
                                                            </td>
                                                            <td>{{$sic->lecture_point}} điểm</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Điểm công ty:
                                                            </td>
                                                            <td>{{$sic->company_point}} điểm</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Đánh giá công ty:
                                                            </td>
                                                            <td>
                                                                <div class="stars">
                                                                    @foreach($groupCurrent as $gcVote)
                                                                        <?php
                                                                        $companyVote = \App\CompanyVote::getFStudentIDCompanyID($gcVote->student_id, $gcVote->company_id);
                                                                        ?>
                                                                        @foreach($companyVote as $cv)
                                                                            <form action="" method="post">
                                                                                <input type="hidden" name="studentIDV"
                                                                                       id="studentIDV"
                                                                                       value="{{$cv->student_id}}">
                                                                                <input type="hidden"
                                                                                       name="companyIDV"
                                                                                       id="companyIDV"
                                                                                       value="{{$cv->company_id}}">
                                                                                @if($cv->vote==4)
                                                                                    <input class="star star-4 star-radio"
                                                                                           id="star-4"
                                                                                           type="radio"
                                                                                           name="star" checked="checked"
                                                                                           value="4"/>
                                                                                    <label class="star star-4"
                                                                                           for="star-4"></label>
                                                                                @else
                                                                                    <input class="star star-4 star-radio"
                                                                                           id="star-4"
                                                                                           type="radio"
                                                                                           name="star" value="4"/>
                                                                                    <label class="star star-4"
                                                                                           for="star-4"></label>
                                                                                @endif
                                                                                @if($cv->vote==3)
                                                                                    <input class="star star-3 star-radio"
                                                                                           id="star-3"
                                                                                           type="radio"
                                                                                           name="star" checked="checked"
                                                                                           value="3"/>
                                                                                    <label class="star star-3"
                                                                                           for="star-3"></label>
                                                                                @else
                                                                                    <input class="star star-3 star-radio"
                                                                                           id="star-3"
                                                                                           type="radio"
                                                                                           name="star" value="3"/>
                                                                                    <label class="star star-3"
                                                                                           for="star-3"></label>
                                                                                @endif
                                                                                @if($cv->vote==2)
                                                                                    <input class="star star-2 star-radio"
                                                                                           id="star-2"
                                                                                           type="radio"
                                                                                           name="star" checked="checked"
                                                                                           value="2"/>
                                                                                    <label class="star star-2"
                                                                                           for="star-2"></label>
                                                                                @else
                                                                                    <input class="star star-2 star-radio"
                                                                                           id="star-2"
                                                                                           type="radio"
                                                                                           name="star" value="2"/>
                                                                                    <label class="star star-2"
                                                                                           for="star-2"></label>
                                                                                @endif
                                                                                @if($cv->vote==1)
                                                                                    <input class="star star-1 star-radio"
                                                                                           id="star-1"
                                                                                           type="radio"
                                                                                           name="star" checked="checked"
                                                                                           value="1"/>
                                                                                    <label class="star star-1"
                                                                                           for="star-1"></label>
                                                                                @else
                                                                                    <input class="star star-1 star-radio"
                                                                                           id="star-1"
                                                                                           type="radio"
                                                                                           name="star" value="1"/>
                                                                                    <label class="star star-1"
                                                                                           for="star-1"></label>
                                                                                @endif
                                                                            </form>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-body" style="text-align: center">
                                                        <?php
                                                        $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                                        ?>
                                                        <div>
                                                            <span>
                                                                Hoàn thành báo cáo
                                                            </span>
                                                            <span>
                                                                @if(count($studentReport)>0)
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$sic->id}}{{"studentViewReport"}}">
                                                                        {{'Xem báo cáo'}}
                                                                    </a>
                                                                @else
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#{{$sic->id}}{{"studentWriteReport"}}">
                                                                        {{'Viết báo cáo'}}
                                                                    </a>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--modal cong ty nhan xet--}}
                                                <div class="modal fade" id="{{$sic->id}}{{"company-assess"}}"
                                                     tabindex="-1" role="dialog"
                                                     aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="text-align: center">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span>
                                                                </button>

                                                                <h4 class="modal-title" id="myModalLabel"
                                                                    style="font-weight: bold">Nhận xét
                                                                    sinh viên</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row" id="{{$sic->id}}{{"printAssess"}}">
                                                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                                                        <form action="" method="POST" role="form">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                                     style="font-weight: bold;text-align: center">
                                                                                    BẢNG ĐÁNH GIÁ KẾT QUẢ THỰC TẬP DOANH
                                                                                    NGHIỆP
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                </div>
                                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                    @foreach($companyAssess as $ca)
                                                                                        <span style="float:right;">Ngày {{date('d',strtotime($ca->date_assess))}}
                                                                                            tháng {{date('m',strtotime($ca->date_assess))}}
                                                                                            năm {{date('Y',strtotime($ca->date_assess))}}</span>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="margin-top: 20px">
                                                                                <span>Tên sinh viên:
                                                                                    @foreach($student as $s)
                                                                                        {{$s->name}}
                                                                                    @endforeach
                                                                                </span><br>
                                                                            </div>
                                                                            <div class="row">
                                                                                @foreach($companyCurrent as $c)
                                                                                    <span>Công ty tiếp nhận thực tập: {{$c->name}}</span>
                                                                                    <br>
                                                                                    <span>Email: {{$c->hr_mail}}</span>
                                                                                    <br>
                                                                                @endforeach
                                                                                <span>Người phụ trách:
                                                                                    @foreach($companyInCourse as $cic)
                                                                                        {{$cic->hr_name}}
                                                                                    @endforeach
                                                                                </span>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span style="font-weight: bold">Đánh giá chung về khóa thực tập</span>
                                                                                @foreach($companyAssess as $ca)
                                                                                    {{$ca->assess_general}}
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="row" style="margin-top: 15px">
                                                                                <span style="font-weight: bold">Đánh giá kết quả thực tập</span>

                                                                                <div class="table-responsive">
                                                                                    <table class="table table-hover table-bordered">
                                                                                        <tbody>
                                                                                        @foreach($companyAssess as $ca)
                                                                                            <tr>
                                                                                                <td>Năng lực IT</td>
                                                                                                @if($ca->IT==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->IT==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->IT==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->IT==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->IT==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="it"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Phương pháp làm
                                                                                                    việc
                                                                                                </td>
                                                                                                @if($ca->work==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->work==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->work==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->work==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->work==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="work"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Năng lực năm bắt
                                                                                                    công việc
                                                                                                </td>
                                                                                                @if($ca->learn_work==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->learn_work==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->learn_work==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->learn_work==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->learn_work==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="learnWork"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Năng lực quản lý
                                                                                                </td>
                                                                                                @if($ca->manage==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->manage==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->manage==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->manage==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->manage==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="manage"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Năng lực tiếng anh
                                                                                                </td>
                                                                                                @if($ca->english==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->english==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->english==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->english==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->english==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="english"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Năng lực làm việc
                                                                                                    nhóm
                                                                                                </td>
                                                                                                @if($ca->teamwork==1)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               checked="checked">1
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="1"
                                                                                                               disabled="disabled">1
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->teamwork==2)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               checked="checked">2
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="2"
                                                                                                               disabled="disabled">2
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->teamwork==3)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               checked="checked">3
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="3"
                                                                                                               disabled="disabled">3
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->teamwork==4)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               checked="checked">4
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="4"
                                                                                                               disabled="disabled">4
                                                                                                    </td>
                                                                                                @endif
                                                                                                @if($ca->teamwork==5)
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               checked="checked">5
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>
                                                                                                        <input type="radio"
                                                                                                               name="teamWork"
                                                                                                               id=""
                                                                                                               value="5"
                                                                                                               disabled="disabled">5
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span style="font-weight: bold">Tổng điểm: </span>
                                                                                <?php
                                                                                $sum = 0;
                                                                                foreach ($companyAssess as $ca) {
                                                                                    $sum = $ca->IT + $ca->work + $ca->learn_work + $ca->manage + $ca->english + $ca->teamwork;
                                                                                }
                                                                                ?>
                                                                                {{$sum}} điểm
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                </div>
                                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                    <span style="font-weight: bold;float: right">XÁC NHẬN NGƯỜI PHỤ TRÁCH</span><br>
                                                                                    <span style="font-weight: bold;float:right;margin-right:45px">
                                                                                        @foreach($companyInCourse as $cic)
                                                                                            {{$cic->hr_name}}
                                                                                        @endforeach
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="text-align: center">
                                                                    <button type="button"
                                                                            class="btn btn-primary print-assess"
                                                                            name="print-assess" data-id="{{$sic->id}}">
                                                                        In
                                                                        nhận xét
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>{{--ket thuc modal xem nhan xet cong ty ve--}}

                                                {{--modal xem cham cong cua tung sinh vien--}}
                                                <div class="modal fade" id="{{$sic->id}}{{"timekeeping"}}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="text-align: center">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span>
                                                                </button>
                                                                <h4 class="modal-title" id="myModalLabel"
                                                                    style="font-weight: bold">Bảng chấm
                                                                    công</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive"
                                                                     id="{{$sic->id}}time-keeping">
                                                                    <div style="text-align:center">
                                                                        <h3>BẢNG CHẤM CÔNG</h3>
                                                                    </div>
                                                                    <table class="table table-hover table-bordered"
                                                                           style="font-size: 12px;margin-top: 20px">
                                                                        <thead>
                                                                        <tr>
                                                                            <th colspan="31">Tháng</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $yearFromDate = date('Y', strtotime($fromDate));
                                                                        $yearToDate = date('Y', strtotime($toDate));
                                                                        ?>
                                                                        @if($yearFromDate==$yearToDate)
                                                                            @for($i=date('m',strtotime($fromDate));$i<=date('m',strtotime($toDate));$i++)
                                                                                <tr>
                                                                                    <td colspan="31">
                                                                                        Tháng {{$i}} {{$yearFromDate}}</td>
                                                                                </tr>
                                                                                @if($i==2)
                                                                                    @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                                                        <tr>
                                                                                            @for($j=1;$j<=29;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j))
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @else
                                                                                        <tr>
                                                                                            @for($j=1;$j<=28;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                                @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                                                    <tr>
                                                                                        @for($j=1;$j<=31;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                @endif
                                                                                @if($i==4||$i==6||$i==9||$i==11)
                                                                                    <tr>
                                                                                        @for($j=1;$j<=30;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                @endif
                                                                            @endfor
                                                                        @else
                                                                            @for($i=date('m',strtotime($fromDate));$i<=12;$i++)
                                                                                <tr>
                                                                                    <td colspan="31">
                                                                                        Tháng {{$i}} {{$yearFromDate}}</td>
                                                                                </tr>
                                                                                @if($i==2)
                                                                                    @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                                                        <tr>
                                                                                            @for($j=1;$j<=29;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @else
                                                                                        <tr>
                                                                                            @for($j=1;$j<=28;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                                @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                                                    <tr>
                                                                                        @for($j=1;$j<=31;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                    @if($i==4||$i==6||$i==9||$i==11)
                                                                                        <tr>
                                                                                            @for($j=1;$j<=30;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                            @endfor
                                                                            @for($i=1;$i<=date('m',strtotime($toDate));$i++)
                                                                                <tr>
                                                                                    <td colspan="31">
                                                                                        Tháng {{$i}} {{$yearToDate}}</td>
                                                                                </tr>
                                                                                @if($i==2)
                                                                                    @if(($yearToDate % 100 != 0) && ($$yearToDate % 4 == 0) || ($yearToDate % 400 == 0))
                                                                                        <tr>
                                                                                            @for($j=1;$j<=29;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @else
                                                                                        <tr>
                                                                                            @for($j=1;$j<=28;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                                @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                                                    <tr>
                                                                                        @for($j=1;$j<=31;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                    @if($i==4||$i==6||$i==9||$i==11)
                                                                                        <tr>
                                                                                            @for($j=1;$j<=30;$j++)
                                                                                                <?php
                                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                                ?>
                                                                                                @if(\App\Timekeeping::check2($sic->student_id,$sic->internship_course_id,$checkDate))
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               checked="checked"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @else
                                                                                                    <td>{{$j}}
                                                                                                        <input type="checkbox"
                                                                                                               name="workDay[]"
                                                                                                               class="check-timekeeping"
                                                                                                               value="">
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                            @endfor
                                                                        @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="row" style="text-align: center">
                                                                    <button type="button"
                                                                            class="btn btn-primary print-timekeeping"
                                                                            name="print-assess" data-id="{{$sic->id}}">
                                                                        In
                                                                        file chấm công
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>{{--ket thuc modal xem nhan xet cong ty--}}

                                            @endforeach
                                        </div>
                                        <div class="col-xs-10 col-sm-2 col-md-2 col-lg-2">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="text-align: center">
                <h3 class="panel-title" style="font-weight: bold">Các khóa thực tập tham gia</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="min-width: 80px">Tên khóa</th>
                        <th style="">Môn thực tập</th>
                        <th style="min-width: 106px">Tên công ty</th>
                        <th style="min-width: 123px">Tên giảng viên</th>
                        <th style="min-width: 126px">Điểm giảng viên</th>
                        <th style="min-width: 106px">Điểm công ty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inCourseJoin as $icj)
                        <?php
                        $inCourse = \App\InternShipCourse::getInCourse($icj->internship_course_id);
                        $group = \App\InternShipGroup::getGroupFollowSI($icj->student_id, $icj->internship_course_id);
                        $company = array();
                        $lecture = array();
                        $comInC = array();
                        foreach ($group as $g) {
                            $co = App\Company::getCompanyFollowID($g->company_id);
                            $le = \App\Lecture::getLectureFollowID($g->lecture_id);
                            $comInC = \App\CompanyInternShipCourse::getComInCourse($g->company_id, $g->internship_course_id);
                            foreach ($co as $c2) {
                                $company[] = $c2;
                            }
                            foreach ($le as $l2) {
                                $lecture[] = $l2;
                            }
                        }
                        ?>
                        <tr>
                            @foreach($inCourse as $ic)
                                <td>{{$ic->course_term}}</td>
                            @endforeach
                            <td>{{$icj->subject}}</td>
                            <td>
                                @foreach($comInC as $cic)
                                    <a href="#" data-toggle="modal"
                                       data-target="#{{$cic->id}}{{"company"}}">
                                        @foreach($company as $c)
                                            {{$c->name}}
                                        @endforeach
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @foreach($lecture as $l)
                                    <a href="#" data-toggle="modal"
                                       data-target="#{{$l->id}}{{"lecture"}}">
                                        {{$l->name}}
                                    </a>
                                @endforeach
                            </td>
                            <td>{{$icj->lecture_point}}</td>
                            <td>{{$icj->company_point}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--modal hien thi ky thuc tap hien tai ma sinh vien tham gia--}}
    @foreach($courseCurrent as $cc)
        <?php
        $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($studentID, $cc->id);
        $student = \App\Student::getStudentFollowID($studentID);
        $fromDate = date('d/m/Y', strtotime($cc->from_date));
        $toDate = date('d/m/Y', strtotime($cc->to_date));
        ?>
        @foreach($studentInCourse as $sic)
            <?php
            $groupCurrent = \App\InternShipGroup::getGroupFollowSI($sic->student_id, $sic->internship_course_id);
            $companyCurrent = array();
            $lectureCurrent = array();
            $courseID = $sic->internship_course_id;
            foreach ($groupCurrent as $gc) {
                $com = App\Company::getCompanyFollowID($gc->company_id);
                $lec = \App\Lecture::getLectureFollowID($gc->lecture_id);
                foreach ($com as $c) {
                    $companyCurrent[] = $c;
                }
                foreach ($lec as $l) {
                    $lectureCurrent[] = $l;
                }
            }
            ?>
            @foreach($lectureCurrent as $lc)
                <div class="modal fade" id="{{$lc->id}}{{"lectureCurrent"}}" tabindex="-1" role="dialog"
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
                                    tiết giảng viên {{$lc->name}}</h4>
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
                                                        {{$lc->name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bộ môn</td>
                                                    <td>
                                                        {{$lc->address}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Trình độ</td>
                                                    <td>
                                                        {{$lc->qualification}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Điện thoại</td>
                                                    <td>{{$lc->phone}}</td>
                                                </tr>
                                                <?php
                                                $myUser = \App\MyUser::getUserFollowID($lc->user_id);
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
            @endforeach
            @foreach($companyCurrent as $cc)
                <?php
                $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($cc->id, $courseID);
                ?>
                <div class="modal fade" id="{{$cc->id}}{{"companyCurrent"}}" tabindex="-1" role="dialog"
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
                                    tiết
                                    công ty {{$cc->name}}</h4>
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
                                                    <td>{{$cc->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ngày thành lập:</td>
                                                    <td>{{date('d-m-Y',strtotime($cc->birthday))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Địa chỉ:</td>
                                                    <td>{{$cc->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mail hỗ trợ:</td>
                                                    <td>{{$cc->hr_mail}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Số điện thoại hỗ trợ:</td>
                                                    <td>{{$cc->hr_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mô tả ngắn gọn:</td>
                                                    <td>
                                                        {!! nl2br(e(trim($cc->description))) !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Yêu cầu:</td>
                                                    <td>
                                                        @foreach($companyInCourse as $cic)
                                                            {!! nl2br(e(trim($cic->require_skill))) !!}
                                                        @endforeach
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
            @endforeach
            <div class="modal fade" id="{{$sic->id}}{{"studentWriteReport"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" data-keyboard="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>

                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Sinh viên viết báo
                                cáo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                                <form action="write-report" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="studentInCourseID" value="{{encrypt($sic->id)}}">

                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                 style="text-align: center;font-weight: bold">
                                                <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span><br>
                                                <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                                <span>––––––––––––</span>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                 style="text-align: center;font-weight: bold">
                                                <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                                <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                                <span>––––––––––––––––––––––––––––</span><br>
                                                Hà Nội, ngày {{date('d')}}
                                                tháng{{date('m')}} năm {{date('Y')}}
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                                BÁO CÁO<br>
                                                KẾT QUẢ THỰC TẬP TẠI ĐƠN VỊ NGOÀI TRƯỜNG
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                Kính gửi:<input type="text" name="school" id="school"
                                                                required="required" style="width: 92%">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                @foreach($student as $s)
                                                    <div>Họ và tên sinh viên:{{$s->name}}</div>
                                                    <div>Lớp, Khóa:{{$s->grade}}</div>
                                                    <div>Điện thoại:{{$s->phone}}</div>
                                                @endforeach
                                                @foreach($company as $c)
                                                    <div>Địa chỉ đến thực tập:{{($c->name)}}{{$c->address}}</div>
                                                @endforeach
                                                @foreach($lectureCurrent as $lc)
                                                    <div>Giáo viên phụ trách:{{$lc->name}}</div>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                @foreach($student as $s)
                                                    <div>MSSV:{{$s->msv}}</div>
                                                    <div></div>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Thời gian được cử đi
                                                thực tập: từ ngày
                                                {{$fromDate}}, đến ngày {{$toDate}}</div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                I, Nội dung công việc được giao<br>
                                                <textarea name="work" id="work" cols="30"
                                                          style="width: 100%;overflow: hidden"
                                                          onkeyup="textArea(this)"
                                                          class="form-control"></textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                II, Kết quả thực hiện<br>
                                                <textarea name="result" id="result" cols="30"
                                                          style="width: 100%;overflow: hidden"
                                                          onkeyup="textArea(this)"
                                                          class="form-control"></textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                II, Tự đánh giá
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                - Ưu điểm<br>
                                                <textarea name="advantage" id="advantage" cols="30"
                                                          style="width: 100%;overflow: hidden"
                                                          onkeyup="textArea(this)" class="form-control"></textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                - Nhược điểm
                                                <textarea name="disAdvantage" id="disAdvantage" cols="30"
                                                          style="width: 100%;overflow: hidden"
                                                          onkeyup="textArea(this)" class="form-control"></textarea>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                 style="text-align: center;margin-top: 30px; font-weight: bold">
                                                SINH VIÊN
                                                <br>
                                                <span style="font-weight: normal">
                                                    @foreach($student as $s)
                                                        {{$s->name}}
                                                    @endforeach
                                                </span>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                 style="text-align: center;margin-top: 50px;font-weight: bold">
                                                XÁC NHẬN NƠI THỰC TẬP
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                 style=" text-align: center;margin-top: 50px;font-weight: bold">
                                                XÁC NHẬN CỦA VIỆN
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                         style="text-align: center;margin-top: 20px">
                                        <hr>
                                        <button type="submit" class="btn btn-primary">Nộp báo cáo</button>
                                    </div>
                                </form>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="{{$sic->id}}{{"studentViewReport"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" data-keyboard="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>

                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Sinh viên viết báo
                                cáo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <?php
                                $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                ?>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="studentInCourseID" value="{{$sic->id}}">

                                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" id="student-view">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="text-align: center;font-weight: bold">
                                            <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span><br>
                                            <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                            <span>––––––––––––</span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="text-align: center;font-weight: bold">
                                            <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                            <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                            <span>––––––––––––––––––––––––––––</span><br>
                                            @foreach($studentReport as $sr)
                                                Hà Nội, ngày {{date('d',strtotime($sr->date_report))}}
                                                tháng {{date('m',strtotime($sr->date_report))}}
                                                năm {{date('Y',strtotime($sr->date_report))}}
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                             style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                            BÁO CÁO<br>
                                            KẾT QUẢ THỰC TẬP TẠI ĐƠN VỊ NGOÀI TRƯỜNG
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            Kính gửi:
                                            @foreach($studentReport as $sr)
                                                {{$sr->school}}
                                            @endforeach
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            @foreach($student as $s)
                                                <div>Họ và tên sinh viên:{{$s->name}}</div>
                                                <div>Lớp, Khóa:{{$s->grade}}</div>
                                                <div>Điện thoại:{{$s->phone}}</div>
                                            @endforeach
                                            @foreach($company as $c)
                                                <div>Địa chỉ đến thực tập:{{($c->name)}}{{$c->address}}</div>
                                            @endforeach
                                            @foreach($lectureCurrent as $lc)
                                                <div>Giáo viên phụ trách:{{$lc->name}}</div>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            @foreach($student as $s)
                                                <div>MSSV:{{$s->msv}}</div>
                                                <div></div>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Thời gian được cử đi
                                            thực tập: từ ngày
                                            {{$fromDate}}, đến ngày {{$toDate}}</div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-weight: bold">
                                            I, Nội dung công việc được giao<br>
                                            @foreach($studentReport as $sr)
                                                <span style="font-weight: normal;">
                                                    {!! nl2br(e(trim($sr->assign_work))) !!}
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-weight: bold">
                                            II, Kết quả thực hiện<br>
                                            @foreach($studentReport as $sr)
                                                <span style="font-weight: normal;">
                                                    {!! nl2br(e(trim($sr->result))) !!}
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-weight: bold">
                                            II, Tự đánh giá
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-weight: bold">
                                            - Ưu điểm<br>
                                            @foreach($studentReport as $sr)
                                                <span style="font-weight: normal;">
                                                    {!! nl2br(e(trim($sr->advantage))) !!}
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-weight: bold">
                                            - Nhược điểm<br>
                                            @foreach($studentReport as $sr)
                                                <p style="font-weight: normal;"> {!! nl2br(e(trim($sr->dis_advantage))) !!}</p>
                                            @endforeach

                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="text-align: center;margin-top: 30px;font-weight: bold">
                                            SINH VIÊN
                                            <br>
                                            <span style="font-weight: normal">
                                                @foreach($student as $s)
                                                    {{$s->name}}
                                                @endforeach
                                            </span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="text-align: center;margin-top: 50px;font-weight: bold">
                                            XÁC NHẬN NƠI THỰC TẬP
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="text-align: center;margin-top: 50px;font-weight: bold">
                                            XÁC NHẬN CỦA VIỆN
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                     style="text-align: center;margin-top: 20px" id="student-view2">
                                    <hr>
                                    <form action="" method="POST" class="form-inline" role="form">
                                        <button type="button" class="btn btn-primary" id="edit-report">Sửa báo cáo
                                        </button>
                                        <button type="button" class="btn btn-primary" id="print-report">In báo cáo
                                        </button>
                                    </form>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                            </div>

                            <div class="row" id="student-edit">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                                <form action="edit-report" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @foreach($studentReport as $sr)
                                        <input type="hidden" name="studentReportID" value="{{encrypt($sr->id)}}">
                                    @endforeach
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center">
                                                <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span>
                                                <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                                <span>––––––––––––</span>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center">
                                                <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                                <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                                <span>––––––––––––––––––––––––––––</span><br>
                                                Hà Nội, ngày {{date('d')}}
                                                tháng {{date('m')}}
                                                năm {{date('Y')}}
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form"
                                                 style="text-align: center;margin-top: 20px;margin-bottom: 15px">
                                                BÁO CÁO<br>
                                                KẾT QUẢ THỰC TẬP TẠI ĐƠN VỊ NGOÀI TRƯỜNG
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                @foreach($studentReport as $sr)
                                                    Kính gửi:<input type="text" name="school" id="school"
                                                                    required="required" style="width: 92%"
                                                                    value="{{$sr->school}}">
                                                @endforeach
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                @foreach($student as $s)
                                                    <div>Họ và tên sinh viên:{{$s->name}}</div>
                                                    <div>Lớp, Khóa:{{$s->grade}}</div>
                                                    <div>Điện thoại:{{$s->phone}}</div>
                                                @endforeach
                                                @foreach($company as $c)
                                                    <div>Địa chỉ đến thực tập:{{($c->name)}}{{$c->address}}</div>
                                                @endforeach
                                                @foreach($lectureCurrent as $lc)
                                                    <div>Giáo viên phụ trách:{{$lc->name}}</div>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                @foreach($student as $s)
                                                    <div>MSSV:{{$s->msv}}</div>
                                                    <div></div>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Thời gian được cử đi
                                                thực tập: từ ngày
                                                {{$fromDate}}, đến ngày {{$toDate}}</div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form">
                                                I, Nội dung công việc được giao<br>
                                                <textarea name="work" id="work" cols="30"
                                                          style="width: 100%;overflow: hidden; min-height: 150px"
                                                          onkeyup="textArea(this)"
                                                          class="form-control">@foreach($studentReport as $sr){{$sr->assign_work}}@endforeach
                                                </textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form">
                                                II, Kết quả thực hiện<br>
                                                <textarea name="result" id="result" cols="30"
                                                          style="width: 100%;overflow: hidden; min-height: 150px"
                                                          onkeyup="textArea(this)"
                                                          class="form-control">@foreach($studentReport as $sr){{$sr->result}}@endforeach
                                                </textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form">
                                                II, Tự đánh giá
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form">
                                                - Ưu điểm<br>
                                                    <textarea name="advantage" id="advantage" cols="30"
                                                              style="width: 100%;overflow: hidden; min-height: 150px"
                                                              onkeyup="textArea(this)"
                                                              class="form-control">@foreach($studentReport as $sr){{$sr->advantage}}@endforeach
                                                </textarea>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form">
                                                - Nhược điểm
                                                <textarea name="disAdvantage" id="disAdvantage" cols="30"
                                                          style="width: 100%;overflow: hidden; min-height: 150px"
                                                          onkeyup="textArea(this)"
                                                          class="form-control">@foreach($studentReport as $sr){{$sr->dis_advantage}}@endforeach
                                                </textarea>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center;margin-top: 30px">
                                                SINH VIÊN
                                                <br>
                                                <span style="font-weight: normal">
                                                    @foreach($student as $s)
                                                        {{$s->name}}
                                                    @endforeach
                                                </span>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center;margin-top: 50px">
                                                XÁC NHẬN NƠI THỰC TẬP
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center;margin-top: 50px">
                                                XÁC NHẬN CỦA VIỆN
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                         style="text-align: center;margin-top: 20px">
                                        <hr>
                                        <button type="button" class="btn btn-default" id="cancel-edit">Hủy bỏ</button>
                                        <button type="submit" class="btn btn-primary" id="cancel-edit">Chỉnh sửa
                                        </button>
                                    </div>
                                </form>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="{{$sic->id}}{{"assign-work"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Nhiệm vụ được giao
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! nl2br(e(trim($sic->assign_work))) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    {{--modal hien thi cac khoa thuc tap ma sinh vien tham gia--}}
    @foreach($inCourseJoin as $icj3)
        <?php
        $group = \App\InternShipGroup::getGroupFollowSI($icj3->student_id, $icj3->internship_course_id);
        $company = array();
        $lecture = array();
        $courseID = $icj3->internship_course_id;
        foreach ($group as $g3) {
            $comJoin = App\Company::getCompanyFollowID($g3->company_id);
            $leJoin = \App\Lecture::getLectureFollowID($g3->lecture_id);
            foreach ($comJoin as $cj3) {
                $company[] = $cj3;
            }
            foreach ($leJoin as $lj3) {
                $lecture[] = $lj3;
            }
        }
        ?>
        @foreach($lecture as $l3)
            <div class="modal fade" id="{{$l3->id}}{{"lecture"}}" tabindex="-1" role="dialog"
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
                                tiết giảng viên {{$l3->name}}</h4>
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
                                                    {{$l3->name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bộ môn</td>
                                                <td>
                                                    {{$l3->address}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trình độ</td>
                                                <td>
                                                    {{$l3->qualification}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Điện thoại</td>
                                                <td>{{$l3->phone}}</td>
                                            </tr>
                                            <?php
                                            $myUser = \App\MyUser::getUserFollowID($l3->user_id);
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
        @endforeach
        @foreach($company as $c3)
            <?php
            $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($c3->id, $courseID);
            ?>
            @foreach($companyInCourse as $cic)
                <div class="modal fade" id="{{$cic->id}}{{"company"}}" tabindex="-1" role="dialog"
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
                                    tiết
                                    công ty {{$c3->name}}</h4>
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
                                                    <td>{{$c3->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ngày thành lập:</td>
                                                    <td>{{date('d-m-Y',strtotime($c3->birthday))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Địa chỉ:</td>
                                                    <td>{{$c3->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mail hỗ trợ:</td>
                                                    <td>{{$c3->hr_mail}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Số điện thoại hỗ trợ:</td>
                                                    <td>{{$c3->hr_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mô tả ngắn gọn:</td>
                                                    <td>
                                                        {!! nl2br(e(trim($c3->description))) !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Yêu cầu:</td>
                                                    <td>
                                                        {!! nl2br(e(trim($cic->require_skill))) !!}
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
            @endforeach
        @endforeach

    @endforeach
    <script>
        function textArea(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
        $('.star-radio').change(function () {
            var studentIDV = $('#studentIDV').val();
            var companyIDV = $('#companyIDV').val();
            if (this.checked && $(this).val() == 4) {
                var vote4 = $(this).val();
                $.get('update-vote?studentID=' + studentIDV + '&' + 'companyID=' + companyIDV + '&' + 'vote=' + vote4, function (data) {
                });
            } else if (this.checked && $(this).val() == 3) {
                var vote3 = $(this).val();
                $.get('update-vote?studentID=' + studentIDV + '&' + 'companyID=' + companyIDV + '&' + 'vote=' + vote3, function (data) {
                });
            } else if (this.checked && $(this).val() == 2) {
                var vote2 = $(this).val();
                $.get('update-vote?studentID=' + studentIDV + '&' + 'companyID=' + companyIDV + '&' + 'vote=' + vote2, function (data) {
                });
            } else {
                var vote1 = $(this).val();
                $.get('update-vote?studentID=' + studentIDV + '&' + 'companyID=' + companyIDV + '&' + 'vote=' + vote1, function (data) {
                });
            }
        });
        $('#student-edit').hide();
        $('#edit-report').click(function () {
            $('#student-view').hide();
            $('#student-view2').hide();
            $('#student-edit').show();
        });
        $('#cancel-edit').click(function () {
            $('#student-view').show();
            $('#student-view2').show();
            $('#student-edit').hide();
        });
        $('#print-report').click(function () {
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
            w.document.write($("#student-view").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-assess').click(function () {
            var dataID = $(this).attr('data-id');
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
            w.document.write($("#" + dataID + "printAssess").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-timekeeping').click(function () {
            var dataID = $(this).attr('data-id');
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
            w.document.write($("#" + dataID + "time-keeping").html());
            w.document.write('</body></html>');
            w.document.close();
        });
    </script>
@endsection