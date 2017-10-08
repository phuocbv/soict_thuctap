@extends('home-user.index')
@section('title')
    {{'Kỳ tham gia'}}
@endsection
@section('user-content')
    <style>
        .align-assign {
            text-align: center;
        }

        .lecture-assess {
            font-size: 13px;
            background-color: #EEEEEE;
        }

        #table-current, #table-join {
            background-color: #FFFFFF;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <span class="name-page-profile">Kỳ thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="lecture-join" style="color: #333">
                <span class="company-register name-page-profile">Các kỳ tham gia</span>
            </a>
        </div>
    </div>
    @if(session()->has('writeReportSuccess'))
        <div class="alert alert-success myLabel"
             role="alert">Viết báo cáo thành công
        </div>
    @endif
    @if(session()->has('editReportSuccess'))
        <div class="alert alert-success myLabel"
             role="alert">Đã chỉnh sửa báo cáo
        </div>
    @endif
    @if(session()->has('editError'))
        <div class="alert alert-success myLabel"
             role="alert">Đã xảy ra lỗi
        </div>
    @endif
    @if(session()->has('updateLecturePointError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('updateLecturePointError')}}
        </div>
    @endif
    @if(session()->has('updateLectureAssessSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateLecturePointSuccess')}}</div>
    @endif
    @if(session()->has('updateLectureAssessError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('updateLectureAssessError')}}
        </div>
    @endif
    <div class="panel panel-default" style="min-height: 100vh">
        <div class="panel-body">
            <div class="panel panel-default">
                @if(count($courseCurrent)==0)
                    <div class="panel-heading align-assign">
                        <h3 class="panel-title name-page-profile">Kỳ thực tập hiện tại</h3>
                        <span style="color:#E80000">(không có kỳ thực tập nào đang diễn ra)</span>
                    </div>
                @else
                    @foreach($courseCurrent as $cc)
                        <input type="hidden" value="{{$cc->id}}" class="courseCurrentClass">
                        <div class="panel-heading align-assign">
                            <h3 class="panel-title name-page-profile">Kỳ thực tập hiện tại {{$cc->course_term}}</h3>
                        <span>(Bắt đầu: {{date('d/m/y',strtotime($cc->from_date))}}
                            , kết thúc {{date('d/m/Y',strtotime($cc->to_date))}})</span>
                        </div>
                        <?php
                        $lecInCourse = \App\LectureInternShipCourse::getLecInCourse($lectureID, $cc->id);
                        ?>
                        @if(count($lecInCourse)>0)
                            <?php
                            $group = \App\InternShipGroup::getGroupFollowLI($lectureID, $cc->id);
                            $lectureInCourseID = $lecInCourse->first()->id;
                            $lectureReport = \App\LectureReport::get($lectureInCourseID);
                            $lecture = \App\Lecture::getLectureFollowID($lectureID);
                            ?>
                            <div class="table-responsive lecture-assess">
                                <table id="table-current" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Môn học</th>
                                        <th style="min-width: 69px">MSV</th>
                                        <th style="min-width: 120px">Tên sinh viên</th>
                                        <th style="min-width: 120px;">Công ty</th>
                                        <th style="min-width:30px"><span>Nhiệm vụ</span><br>
                                            Sinh viên
                                        </th>
                                        <th style="min-width: 40px">Chấm công</th>
                                        <th style="min-width: 56px">
                                            <span>Nhận xét</span><br>
                                            (Công ty)
                                        </th>
                                        <th style="min-width: 50px">
                                            <span>Báo cáo</span><br>
                                            (sinh viên)
                                        </th>
                                        <th style="min-width: 85px">Cho điểm</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Môn học</th>
                                        <th style="min-width: 69px">MSV</th>
                                        <th style="min-width: 120px">Tên sinh viên</th>
                                        <th style="min-width:120px">Công ty</th>
                                        <th style="min-width:30px"><span>Nhiệm vụ</span><br>
                                            Sinh viên
                                        </th>
                                        <th style="min-width:40px">Chấm công</th>
                                        <th style="min-width: 56px">
                                            <span>Nhận xét</span><br>
                                            (Công ty)
                                        </th>
                                        <th style="min-width: 50px">
                                            <span>Báo cáo</span><br>
                                            (sinh viên)
                                        </th>
                                        <th style="min-width: 85px">Cho điểm</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach($group as $gp)
                                        <?php
                                        $i++;
                                        ?>
                                        @foreach($gp as $g)
                                            <?php
                                            $student = \App\Student::getStudentFollowID($g->student_id);
                                            $company = \App\Company::getCompanyFollowID($g->company_id);
                                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                            $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
                                            $timekeeping = \App\Timekeeping::getFollowStudentIDCourseID($g->student_id, $g->internship_course_id);
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
                                                            <a href="#" data-toggle="modal"
                                                               data-target="#{{$s->id}}{{"student"}}"
                                                               style="color: #333">
                                                                {{$s->name}}
                                                            </a>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($company as $c)
                                                            <a href="#" data-toggle="modal"
                                                               data-target="#{{$c->id}}{{"company"}}"
                                                               style="color: #333">
                                                                {{$c->name}}
                                                            </a>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($studentInCourse as $sic)
                                                            @if($sic->assign_work!=null)
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#{{$g->id}}{{"assign-work"}}">
                                                                    xem
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @if(count($timekeeping)>0)
                                                            <a href="#" data-toggle="modal"
                                                               data-target="#{{$g->id}}{{"timekeeping"}}">
                                                                Xem
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count($companyAssess)>0)
                                                            <a href="#" data-toggle="modal"
                                                               data-target="#{{$g->id}}{{"company-assess"}}">
                                                                Xem
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach($studentInCourse as $sic)
                                                            <?php
                                                            $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                                            ?>
                                                            @if(count($studentReport)>0)
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#{{$g->id}}{{"student-report"}}">
                                                                    Xem
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @foreach($studentInCourse as $sic)
                                                        <td>
                                                            <input type="number" name="lecture-point" id="" min="0"
                                                                   max="10" class="lectureToScore form-control"
                                                                   data-id="{{$sic->student_id}}"
                                                                   value="{{$sic->lecture_point}}"
                                                                   style="width: 85px">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                                @endforeach
                                                <tr style="text-align: center">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <?php
                                                        $lectureInCourseID = $lecInCourse->first()->id;
                                                        $lectureReport = \App\LectureReport::get($lectureInCourseID);
                                                        ?>
                                                        @if(count($lectureReport)>0)
                                                            <a href="#"
                                                               data-toggle="modal"
                                                               data-target="#{{'view-assessGeneral'}}">
                                                                <span>Xem báo cáo</span>
                                                            </a>
                                                        @else
                                                            <a href="#"
                                                               data-toggle="modal"
                                                               data-target="#{{'assessGeneral'}}">
                                                                <span>Nhận xét chung</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{--xem nhan xet ma giang vien da viet--}}
                            <div class="modal fade" id="{{'view-assessGeneral'}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="text-align: center">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span>
                                            </button>

                                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Giảng
                                                viên viết nhận xét
                                                chung</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row lecture-view1">
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                                     id="lecture-write-report">
                                                    <div class="row" id="print-lecture-report">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                             style="text-align: center;font-weight: bold">
                                                            <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span>
                                                            <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                                            <span>––––––––––––</span>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                             style="text-align: center;font-weight: bold">
                                                            <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                                            <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                                            <span>––––––––––––––––––––––––––––</span><br>
                                                            @foreach($lectureReport as $lr)
                                                                Hà Nội, ngày {{date('d',strtotime($lr->date_report))}}
                                                                tháng {{date('m',strtotime($lr->date_report))}}
                                                                năm {{date('Y',strtotime($lr->date_report))}}
                                                            @endforeach
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form"
                                                             style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                                            BÁO CÁO<br>
                                                            KẾT QUẢ ĐƯA SINH VIÊN ĐI THỰC TẬP TẠI ĐƠN VỊ NGOÀI TRƯỜNG
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            @foreach($lecture as $l)
                                                                <div>Họ và tên giảng viên phụ
                                                                    trách:{{$l->name}}</div>
                                                                <div>Bộ môn:{{$l->address}}</div>
                                                            @endforeach
                                                            <div>Thời gian được cử đi thực tập từ ngày
                                                                {{date('d/m/Y',strtotime($cc->from_date))}}
                                                                đến ngày
                                                                {{date('d/m/Y',strtotime($cc->to_date))}}
                                                            </div>
                                                            <div>Nội dung của đợt thực tập: Thực tập tại doanh nghiệp
                                                                theo
                                                                chương trình
                                                                đào
                                                                tạo
                                                            </div>
                                                            <div>
                                                                <label>Kết quả đánh giá sinh viên</label>
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>STT</th>
                                                                        <th>Mã sinh viên</th>
                                                                        <th>Họ và tên</th>
                                                                        <th>Điểm quá trình</th>
                                                                        <th>Điểm cuối kỳ</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $i = 0;
                                                                    ?>
                                                                    @foreach($group as $gp)
                                                                        @foreach($gp as $g)
                                                                            <?php
                                                                            $student = \App\Student::getStudentFollowID($g->student_id);
                                                                            $company = \App\Company::getCompanyFollowID($g->company_id);
                                                                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                                                            ?>
                                                                            <tr>
                                                                                <td>{{++$i}}</td>
                                                                                @foreach($student as $s)
                                                                                    <td>{{$s->msv}}</td>
                                                                                    <td>{{$s->name}}</td>
                                                                                @endforeach
                                                                                @foreach($studentInCourse as $sic)
                                                                                    <td>{{$sic->company_point}}</td>
                                                                                    <td>{{$sic->lecture_point}}</td>
                                                                                @endforeach
                                                                            </tr>
                                                                        @endforeach
                                                                    @endforeach
                                                                    @foreach($lecInCourse as $lic)
                                                                        <input type="hidden"
                                                                               name="lectureInCourseID"
                                                                               value="{{$lic->id}}">
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div>
                                                                @foreach($lectureReport as $lr)
                                                                    <label>Thuận lợi</label><br>
                                                                    {!! nl2br(e(trim($lr->advantage))) !!}
                                                                    <br>
                                                                    <label>Khó khăn</label><br>
                                                                    {!! nl2br(e(trim($lr->dis_advantage))) !!}
                                                                    <br>
                                                                    <label>Kiến nghị</label><br>
                                                                    {!! nl2br(e(trim($lr->proposal))) !!}
                                                                    <br>
                                                                    <label>Đánh giá chung</label><br>
                                                                    {!! nl2br(e(trim($lr->assess_general))) !!}
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                             style="text-align: center;margin-top: 50px;font-weight: bold">
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                             style="text-align: center;margin-top: 50px;font-weight: bold">
                                                            GIẢNG VIÊN PHỤ TRÁCH
                                                            <br>
                                                            <?php
                                                            $lecture = \App\Lecture::getLectureFollowID($lectureID);
                                                            ?>
                                                            @foreach($lecture as $l)
                                                                {{$l->name}}
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                         style="text-align: center">
                                                        <button type="button" class="btn btn-primary" id="edit-report">
                                                            Chỉnh sửa
                                                        </button>
                                                        <button type="button" class="btn btn-primary" id="print-report">
                                                            In báo cáo
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                            <div class="row lecture-view2">
                                                <form action="lecture-edit-report" method="POST" role="form">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                                         id="lecture-write-report">
                                                        <div class="row" id="print-lecture-report">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;font-weight: bold">
                                                                <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span>
                                                                <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                                                <span>––––––––––––</span>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;font-weight: bold">
                                                                <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                                                <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                                                <span>––––––––––––––––––––––––––––</span><br>
                                                                @foreach($lectureReport as $lr)
                                                                    <input type="hidden" name="lectureReportID"
                                                                           value="{{encrypt($lr->id)}}">
                                                                    Hà Nội,
                                                                    ngày {{date('d',strtotime($lr->date_report))}}
                                                                    tháng {{date('m',strtotime($lr->date_report))}}
                                                                    năm {{date('Y',strtotime($lr->date_report))}}
                                                                @endforeach
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form"
                                                                 style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                                                BÁO CÁO<br>
                                                                KẾT QUẢ ĐƯA SINH VIÊN ĐI THỰC TẬP TẠI ĐƠN VỊ NGOÀI
                                                                TRƯỜNG
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <?php
                                                                $lecture = \App\Lecture::getLectureFollowID($lectureID);
                                                                ?>
                                                                @foreach($lecture as $l)
                                                                    <div>Họ và tên giảng viên phụ
                                                                        trách:{{$l->name}}</div>
                                                                    <div>Bộ môn:{{$l->address}}</div>
                                                                @endforeach
                                                                @foreach($courseCurrent as $cc)
                                                                    <div>Thời gian được cử đi thực tập từ ngày
                                                                        {{date('d/m/Y',strtotime($cc->from_date))}}
                                                                        đến ngày
                                                                        {{date('d/m/Y',strtotime($cc->to_date))}}
                                                                    </div>
                                                                @endforeach
                                                                <div>Nội dung của đợt thực tập: Thực tập tại doanh
                                                                    nghiệp theo
                                                                    chương trình
                                                                    đào
                                                                    tạo
                                                                </div>
                                                                <div>
                                                                    <label>Kết quả đánh giá sinh viên</label>
                                                                    <table class="table table-hover table-bordered">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>STT</th>
                                                                            <th>Mã sinh viên</th>
                                                                            <th>Họ và tên</th>
                                                                            <th>Điểm quá trình</th>
                                                                            <th>Điểm cuối kỳ</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $i = 0;
                                                                        ?>
                                                                        @foreach($group as $gp)
                                                                            @foreach($gp as $g)
                                                                                <?php
                                                                                $student = \App\Student::getStudentFollowID($g->student_id);
                                                                                $company = \App\Company::getCompanyFollowID($g->company_id);
                                                                                $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                                                                ?>
                                                                                <tr>
                                                                                    <td>{{++$i}}</td>
                                                                                    @foreach($student as $s)
                                                                                        <td>{{$s->msv}}</td>
                                                                                        <td>{{$s->name}}</td>
                                                                                    @endforeach
                                                                                    @foreach($studentInCourse as $sic)
                                                                                        <td>{{$sic->company_point}}</td>
                                                                                        <td>{{$sic->lecture_point}}</td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        @endforeach
                                                                        @foreach($lecInCourse as $lic)
                                                                            <input type="hidden"
                                                                                   name="lectureInCourseID"
                                                                                   value="{{$lic->id}}">
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div>
                                                                    @foreach($lectureReport as $lr)
                                                                        <label>Thuận lợi</label>
                                                                        <textarea name="advantage" id=""
                                                                                  style="width: 100%;overflow: hidden;min-height: 100px"
                                                                                  onkeyup="textArea(this)"
                                                                                  class="form-control">{{$lr->advantage}}
                                                                        </textarea>
                                                                        <br>
                                                                        <label>Khó khăn</label>
                                                                        <textarea name="disAdvantage" id=""
                                                                                  style="width: 100%;overflow: hidden;min-height: 100px"
                                                                                  onkeyup="textArea(this)"
                                                                                  class="form-control">{{$lr->dis_advantage}}
                                                                        </textarea>

                                                                        <br>
                                                                        <label>Kiến nghị</label>
                                                                        <textarea name="proposal" id=""
                                                                                  style="width: 100%;overflow: hidden;min-height: 100px"
                                                                                  onkeyup="textArea(this)"
                                                                                  class="form-control">{{$lr->proposal}}
                                                                        </textarea>
                                                                        <br>
                                                                        <label>Đánh giá chung</label>
                                                                        <textarea name="assessGeneral" id=""
                                                                                  style="width: 100%;overflow: hidden;min-height: 100px"
                                                                                  onkeyup="textArea(this)"
                                                                                  class="form-control">{{$lr->assess_general}}</textarea>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;margin-top: 50px;font-weight: bold">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;margin-top: 50px;font-weight: bold">
                                                                GIẢNG VIÊN PHỤ TRÁCH
                                                                <br>
                                                                @foreach($lecture as $l)
                                                                    {{$l->name}}
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                             style="text-align: center">
                                                            <button type="button" class="btn btn-default"
                                                                    id="cancel-edit-report">Hủy bỏ
                                                            </button>
                                                            <button type="submit" class="btn btn-primary"
                                                                    id="edit-report-form">Chỉnh sửa
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="{{'assessGeneral'}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="text-align: center">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span>
                                            </button>

                                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Giảng
                                                viên viết nhận xét
                                                chung</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <form action="lecture-write-report" method="POST" role="form">
                                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                                         id="lecture-write-report">
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;font-weight: bold">
                                                                <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span>
                                                                <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                                                <span>––––––––––––</span>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;font-weight: bold">
                                                                <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                                                <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                                                <span>––––––––––––––––––––––––––––</span><br>
                                                                Hà Nội, ngày {{date('d')}}
                                                                tháng {{date('m')}}
                                                                năm {{date('Y')}}
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form"
                                                                 style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                                                BÁO CÁO<br>
                                                                KẾT QUẢ ĐƯA SINH VIÊN ĐI THỰC TẬP TẠI ĐƠN VỊ NGOÀI
                                                                TRƯỜNG
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                @foreach($lecture as $l)
                                                                    <div>Họ và tên giảng viên phụ
                                                                        trách:{{$l->name}}</div>
                                                                    <div>Bộ môn:{{$l->address}}</div>
                                                                @endforeach
                                                                <div>Thời gian được cử đi thực tập từ ngày
                                                                    {{date('d/m/Y',strtotime($cc->from_date))}}
                                                                    đến
                                                                    ngày {{date('d/m/Y',strtotime($cc->to_date))}}</div>
                                                                <div>Nội dung của đợt thực tập: Thực tập tại doanh
                                                                    nghiệp theo
                                                                    chương trình
                                                                    đào
                                                                    tạo
                                                                </div>
                                                                <div>
                                                                    <label>Kết quả đánh giá sinh viên</label>
                                                                    <table class="table table-hover table-bordered">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>STT</th>
                                                                            <th>Mã sinh viên</th>
                                                                            <th>Họ và tên</th>
                                                                            <th>Điểm quá trình</th>
                                                                            <th>Điểm cuối kỳ</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $i = 0;
                                                                        ?>
                                                                        @foreach($group as $gp)
                                                                            @foreach($gp as $g)
                                                                                <?php
                                                                                $student = \App\Student::getStudentFollowID($g->student_id);
                                                                                $company = \App\Company::getCompanyFollowID($g->company_id);
                                                                                $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                                                                ?>
                                                                                <tr>
                                                                                    <td>{{++$i}}</td>
                                                                                    @foreach($student as $s)
                                                                                        <td>{{$s->msv}}</td>
                                                                                        <td>{{$s->name}}</td>
                                                                                    @endforeach
                                                                                    @foreach($studentInCourse as $sic)
                                                                                        <td>{{$sic->company_point}}</td>
                                                                                        <td>{{$sic->lecture_point}}</td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        @endforeach
                                                                        @foreach($lecInCourse as $lic)
                                                                            <input type="hidden"
                                                                                   name="lectureInCourseID"
                                                                                   value="{{encrypt($lic->id)}}">
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div>
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <label>Thuận lợi</label>
                                                                    <textarea name="advantage" id=""
                                                                              style="width: 100%;overflow: hidden"
                                                                              onkeyup="textArea(this)"
                                                                              class="form-control"></textarea>
                                                                    <br>
                                                                    <label>Khó khăn</label>
                                                                    <textarea name="disAdvantage" id=""
                                                                              style="width: 100%;overflow: hidden"
                                                                              onkeyup="textArea(this)"
                                                                              class="form-control"></textarea>
                                                                    <br>
                                                                    <label>Kiến nghị</label>
                                                                    <textarea name="proposal" id=""
                                                                              style="width: 100%;overflow: hidden"
                                                                              onkeyup="textArea(this)"
                                                                              class="form-control"></textarea>
                                                                    <br>
                                                                    <label>Đánh giá chung</label>
                                                                    <textarea name="assessGeneral" id=""
                                                                              style="width: 100%;overflow: hidden"
                                                                              onkeyup="textArea(this)"
                                                                              class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;margin-top: 50px;font-weight: bold">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                                 style="text-align: center;margin-top: 50px;font-weight: bold">
                                                                GIẢNG VIÊN PHỤ TRÁCH
                                                                <br>
                                                                @foreach($lecture as $l)
                                                                    {{$l->name}}
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                             style="text-align: center">
                                                            <button type="submit" class="btn btn-primary">lưu lại báo
                                                                cáo đánh
                                                                giá
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach($group as $gp)
                                @foreach($gp as $g)
                                    <?php
                                    $hrName = "";
                                    $student = \App\Student::getStudentFollowID($g->student_id);
                                    $company = \App\Company::getCompanyFollowID($g->company_id);
                                    $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                    $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
                                    $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($g->company_id, $g->internship_course_id);
                                    foreach ($companyInCourse as $cic) {
                                        $hrName = $cic->hr_name;
                                    }

                                    ?>

                                    @foreach($student as $s)
                                        <?php
                                        $studentUser = \App\MyUser::getUserFollowUserID($s->user_id);
                                        ?>
                                        {{--modal hien thi thong tin sinh vien --}}
                                        <div class="modal fade" id="{{$s->id}}{{"student"}}" tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel">
                                            <div class="modal-dialog " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span>
                                                        </button>

                                                        <h4 class="modal-title" id="myModalLabel"
                                                            style="font-weight: bold">Thông tin
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
                                                                            <td>Mã sinh viên:</td>
                                                                            <td>
                                                                                {{$s->msv}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Họ và tên:</td>
                                                                            <td>{{$s->name}}</td>
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
                                    @endforeach

                                    @foreach($company as $c)
                                        {{--modal hien thi thong tin cong ty --}}
                                        <div class="modal fade" id="{{$c->id}}{{"company"}}" tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span>
                                                        </button>

                                                        <h4 class="modal-title" id="myModalLabel"
                                                            style="font-weight: bold">Thông tin
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
                                                                            <td>{{date('d-m-Y',strtotime($c->birthday))}}</td>
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
                                                                            <td>{{$c->description}}</td>
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
                                    @endforeach{{--ket thuc modal cong ty--}}

                                    {{--modal Xem bao cao cua sinh vien--}}
                                    @foreach($studentInCourse as $sic)
                                        <div class="modal fade" id="{{$g->id}}{{"student-report"}}" tabindex="-1"
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
                                                            style="font-weight: bold">Báo cáo</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <?php
                                                            $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                                            ?>
                                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                            </div>
                                                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                                                 id="{{$g->id}}{{"printReport"}}">
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
                                                                            Hà Nội,
                                                                            ngày {{date('d',strtotime($sr->date_report))}}
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
                                                                            <div>Địa chỉ đến thực
                                                                                tập:{{($c->name)}}{{$c->address}}</div>
                                                                        @endforeach
                                                                        @foreach($lecture as $l)
                                                                            <div>Giáo viên phụ trách:{{$l->name}}</div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                        @foreach($student as $s)
                                                                            <div>MSSV:{{$s->msv}}</div>
                                                                            <div></div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        Thời gian được
                                                                        cử
                                                                        đi
                                                                        thực tập: từ ngày
                                                                        {{date('d/m/Y',strtotime($cc->from_date))}},
                                                                        đến ngày
                                                                        {{date('d/m/Y',strtotime($cc->to_date))}}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold">
                                                                        I, Nội dung công việc được giao<br>
                                                                        @foreach($studentReport as $sr)
                                                                            <span style="font-weight: normal;">{!! nl2br(e(trim($sr->assign_work))) !!}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold">
                                                                        II, Kết quả thực hiện<br>
                                                                        @foreach($studentReport as $sr)
                                                                            <span style="font-weight: normal;">{!! nl2br(e(trim($sr->result))) !!}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold">
                                                                        II, Tự đánh giá
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold">
                                                                        - Ưu điểm<br>
                                                                        @foreach($studentReport as $sr)
                                                                            <span style="font-weight: normal; margin-left: 15px">{!! nl2br(e(trim($sr->advantage))) !!}</span>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold">
                                                                        - Nhược điểm<br>
                                                                        @foreach($studentReport as $sr)
                                                                            <span style="font-weight: normal; margin-left: 15px">{!! nl2br(e(trim($sr->dis_advantage))) !!}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                                         style="text-align: center;margin-top: 30px;font-weight: bold">
                                                                        SINH VIÊN
                                                                        <br>
                                                                        @foreach($student as $s)
                                                                            {{$s->name}}
                                                                        @endforeach
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
                                                                 style="text-align: center;margin-top: 20px">
                                                                <hr>
                                                                <form action="" method="POST" class="form-inline"
                                                                      role="form">
                                                                    <button type="button"
                                                                            class="btn btn-primary print-report"
                                                                            data-id="{{$g->id}}">In báo
                                                                        cáo
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="{{$g->id}}{{"assign-work"}}" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel"
                                                            style="font-weight: bold">Nhiệm vụ sinh viên
                                                            @foreach($student as $s)
                                                                {{$s->name}}
                                                            @endforeach
                                                            được giao
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
                                    {{--nhan xet cua cong ty ve sinh vien--}}
                                    <div class="modal fade" id="{{$g->id}}{{"company-assess"}}" tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="text-align: center">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span>
                                                    </button>

                                                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                                                        Nhận xét
                                                        sinh viên</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row" id="{{$g->id}}{{"printAssess"}}">
                                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                        </div>
                                                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                                            <form action="" method="POST" role="form">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                                         style="font-weight: bold;text-align: center">
                                                                        BẢNG ĐÁNH GIÁ KẾT QUẢ THỰC TẬP DOANH NGHIỆP
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
                                                                    @foreach($company as $c)
                                                                        <span>Công ty tiếp nhận thực tập: {{$c->name}}</span>
                                                                        <br>
                                                                        <span>Email: {{$c->hr_mail}}</span><br>
                                                                    @endforeach
                                                                    <span>Người phụ trách: {{$hrName}}</span>
                                                                </div>
                                                                <div class="row">
                                                                    <span style="font-weight: bold">Đánh giá chung về khóa thực tập</span><br>
                                                                    @foreach($companyAssess as $ca)
                                                                        {!! nl2br(e(trim($ca->assess_general))) !!}
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
                                                                                                   name="it" id=""
                                                                                                   value="1"
                                                                                                   checked="checked">1
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="1"
                                                                                                   disabled="disabled">1
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->IT==2)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="2"
                                                                                                   checked="checked">2
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="2"
                                                                                                   disabled="disabled">2
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->IT==3)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="3"
                                                                                                   checked="checked">3
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="3"
                                                                                                   disabled="disabled">3
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->IT==4)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="4"
                                                                                                   checked="checked">4
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="4"
                                                                                                   disabled="disabled">4
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->IT==5)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="5"
                                                                                                   checked="checked">5
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="it" id=""
                                                                                                   value="5"
                                                                                                   disabled="disabled">5
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Phương pháp làm việc</td>
                                                                                    @if($ca->work==1)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="1"
                                                                                                   checked="checked">1
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="1"
                                                                                                   disabled="disabled">1
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->work==2)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="2"
                                                                                                   checked="checked">2
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="2"
                                                                                                   disabled="disabled">2
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->work==3)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="3"
                                                                                                   checked="checked">3
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="3"
                                                                                                   disabled="disabled">3
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->work==4)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="4"
                                                                                                   checked="checked">4
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="4"
                                                                                                   disabled="disabled">4
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->work==5)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="5"
                                                                                                   checked="checked">5
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="work" id=""
                                                                                                   value="5"
                                                                                                   disabled="disabled">5
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Năng lực năm bắt công việc</td>
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
                                                                                    <td>Năng lực quản lý</td>
                                                                                    @if($ca->manage==1)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="1"
                                                                                                   checked="checked">1
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="1"
                                                                                                   disabled="disabled">1
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->manage==2)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="2"
                                                                                                   checked="checked">2
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="2"
                                                                                                   disabled="disabled">2
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->manage==3)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="3"
                                                                                                   checked="checked">3
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="3"
                                                                                                   disabled="disabled">3
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->manage==4)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="4"
                                                                                                   checked="checked">4
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="4"
                                                                                                   disabled="disabled">4
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->manage==5)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="5"
                                                                                                   checked="checked">5
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="manage" id=""
                                                                                                   value="5"
                                                                                                   disabled="disabled">5
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Năng lực tiếng anh</td>
                                                                                    @if($ca->english==1)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="1"
                                                                                                   checked="checked">1
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="1"
                                                                                                   disabled="disabled">1
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->english==2)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="2"
                                                                                                   checked="checked">2
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="2"
                                                                                                   disabled="disabled">2
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->english==3)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="3"
                                                                                                   checked="checked">3
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="3"
                                                                                                   disabled="disabled">3
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->english==4)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="4"
                                                                                                   checked="checked">4
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="4"
                                                                                                   disabled="disabled">4
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->english==5)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="5"
                                                                                                   checked="checked">5
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="english" id=""
                                                                                                   value="5"
                                                                                                   disabled="disabled">5
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Năng lực làm việc nhóm</td>
                                                                                    @if($ca->teamwork==1)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="1"
                                                                                                   checked="checked">1
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="1"
                                                                                                   disabled="disabled">1
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->teamwork==2)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="2"
                                                                                                   checked="checked">2
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="2"
                                                                                                   disabled="disabled">2
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->teamwork==3)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="3"
                                                                                                   checked="checked">3
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="3"
                                                                                                   disabled="disabled">3
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->teamwork==4)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="4"
                                                                                                   checked="checked">4
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="4"
                                                                                                   disabled="disabled">4
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($ca->teamwork==5)
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
                                                                                                   value="5"
                                                                                                   checked="checked">5
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <input type="radio"
                                                                                                   name="teamWork" id=""
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
                                                                        <span style="font-weight: bold;float: right;margin-right:45px">{{$hrName}}</span>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="text-align: center">
                                                        <button type="button" class="btn btn-primary print-assess"
                                                                name="print-assess" data-id="{{$g->id}}">In nhận xét
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>{{--ket thuc modal xem nhan xet cong ty ve--}}

                                    <div class="modal fade" id="{{$g->id}}{{"timekeeping"}}" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="text-align: center">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                                                        Bảng chấm
                                                        công</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive" id="{{$g->id}}time-keeping">
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
                                                            $fromDate = $cc->from_date;
                                                            $toDate = $cc->to_date;
                                                            $yearFromDate = date('Y', strtotime($fromDate));
                                                            $yearToDate = date('Y', strtotime($toDate));
                                                            ?>
                                                            @if($yearFromDate==$yearToDate)
                                                                @for($i=date('m',strtotime($fromDate));$i<=date('m',strtotime($toDate));$i++)
                                                                    <tr>
                                                                        <td colspan="31">
                                                                            Tháng {{$i}} {{$yearFromDate}}</td>
                                                                    </tr>
                                                                    <?php
                                                                    $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                                    ?>
                                                                    @foreach($arrStudent as $as)
                                                                        @if($i==2)
                                                                            @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                                                <tr>
                                                                                    @for($j=1;$j<=29;$j++)
                                                                                        <?php
                                                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j))
                                                                                        ?>
                                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       checked="checked"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                            </td>
                                                                                        @else
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       checked="checked"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                            </td>
                                                                                        @else
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                        <td>{{$j}}
                                                                                            <input type="checkbox"
                                                                                                   checked="checked"
                                                                                                   name="workDay[]"
                                                                                                   class="check-timekeeping"
                                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                        </td>
                                                                                    @else
                                                                                        <td>{{$j}}
                                                                                            <input type="checkbox"
                                                                                                   name="workDay[]"
                                                                                                   class="check-timekeeping"
                                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                        <td>{{$j}}
                                                                                            <input type="checkbox"
                                                                                                   checked="checked"
                                                                                                   name="workDay[]"
                                                                                                   class="check-timekeeping"
                                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                        </td>
                                                                                    @else
                                                                                        <td>{{$j}}
                                                                                            <input type="checkbox"
                                                                                                   name="workDay[]"
                                                                                                   class="check-timekeeping"
                                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                        </td>
                                                                                    @endif
                                                                                @endfor
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endfor
                                                            @else
                                                                @for($i=date('m',strtotime($fromDate));$i<=12;$i++)
                                                                    <tr>
                                                                        <td colspan="31">
                                                                            Tháng {{$i}} {{$yearFromDate}}</td>
                                                                    </tr>
                                                                    @foreach($arrGroup as $ag)
                                                                        <?php
                                                                        $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                                        ?>
                                                                        @foreach($arrStudent as $as)
                                                                            @if($i==2)
                                                                                @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                                                    <tr>
                                                                                        @for($j=1;$j<=29;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       checked="checked"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                            </td>
                                                                                        @else
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endfor
                                                                @for($i=1;$i<=date('m',strtotime($toDate));$i++)
                                                                    <tr>
                                                                        <td colspan="31">
                                                                            Tháng {{$i}} {{$yearToDate}}</td>
                                                                    </tr>
                                                                    @foreach($arrGroup as $ag)
                                                                        <?php
                                                                        $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                                        ?>
                                                                        @foreach($arrStudent as $as)

                                                                            @if($i==2)
                                                                                @if(($yearToDate % 100 != 0) && ($$yearToDate % 4 == 0) || ($yearToDate % 400 == 0))
                                                                                    <tr>
                                                                                        @for($j=1;$j<=29;$j++)
                                                                                            <?php
                                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                            ?>
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       checked="checked"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                            </td>
                                                                                        @else
                                                                                            <td>{{$j}}
                                                                                                <input type="checkbox"
                                                                                                       name="workDay[]"
                                                                                                       class="check-timekeeping"
                                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                                            @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           checked="checked"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @else
                                                                                                <td>{{$j}}
                                                                                                    <input type="checkbox"
                                                                                                           name="workDay[]"
                                                                                                           class="check-timekeeping"
                                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                                                </td>
                                                                                            @endif
                                                                                        @endfor
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endfor
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row" style="text-align: center">
                                                        <button type="button" class="btn btn-primary print-timekeeping"
                                                                name="print-assess" data-id="{{$g->id}}">In file chấm
                                                            công
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>{{--ket thuc modal xem nhan xet cong ty--}}
                                @endforeach
                            @endforeach
                        @else
                            <div style="background-color: #FFFFFF;text-align: center;min-height: 45px; padding-top: 10px">
                                <p style="color:#E80000">Bạn chưa tham gia khóa thực tập này</p>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-heading align-assign">
                    <h3 class="panel-title name-page-profile">Các kỳ tham gia</h3>
                </div>
                <div class="table-responsive lecture-assess">
                    <table id="table-join" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="min-width: 166px">Kỳ thực tập</th>
                            <th style="min-width: 186px">Ngày bắt đầu</th>
                            <th style="min-width: 193px">Ngày kết thúc</th>
                            <th style="min-width: 172px">Xem chi tiết</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th style="min-width: 166px">Kỳ thực tập</th>
                            <th style="min-width: 186px">Ngày bắt đầu</th>
                            <th style="min-width: 193px">Ngày kết thúc</th>
                            <th style="min-width: 172px">Xem chi tiết</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($courseJoin as $cj)
                            <tr>
                                <td>{{$cj->course_term}}</td>
                                <td>{{date('d-m-Y',strtotime($cj->from_date))}}</td>
                                <td>{{date('d-m-Y',strtotime($cj->to_date))}}</td>
                                <td>
                                    <a href="#" data-toggle="modal"
                                       data-target="#{{$cj->id}}{{"courseJoin"}}">
                                        <span>Chi tiết</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach($courseJoin as $cj)
        <?php
        $group = \App\InternShipGroup::getGroupFollowLI($lectureID, $cj->id);
        $lecInCourse = \App\LectureInternShipCourse::getLecInCourse($lectureID, $cj->id);
        $lecture = \App\Lecture::getLectureFollowID($lectureID);
        ?>
        <div class="modal fade" id="{{$cj->id}}{{"courseJoin"}}" tabindex="-1" role="dialog"
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
                            tiết khóa thực tập {{$cj->course_term}}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-detail">
                            <thead>
                            <tr>
                                <th style="min-width: 74px">Môn học</th>
                                <th style="min-width: 69px">MSV</th>
                                <th style="min-width: 120px">Tên sinh viên</th>
                                <th style="min-width: 140px">Công ty</th>
                                <th style="min-width: 64px"><span>Nhiệm vụ</span><br>
                                    Sinh viên
                                </th>
                                <th style="min-width: 64px">Chấm công</th>
                                <th style="min-width: 70px">
                                    <span>Nhận xét</span><br>
                                    (Công ty)
                                </th>
                                <th style="min-width: 60px">
                                    <span>Báo cáo</span><br>
                                    (sinh viên)
                                </th>
                                <th style="min-width: 54px">Điểm</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            ?>
                            @foreach($group as $gp)
                                <?php
                                $i++;
                                ?>
                                @foreach($gp as $g)
                                    <?php
                                    $student = \App\Student::getStudentFollowID($g->student_id);
                                    $company = \App\Company::getCompanyFollowID($g->company_id);
                                    $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                    $timekeeping = \App\Timekeeping::getFollowStudentIDCourseID($g->student_id, $g->internship_course_id);
                                    $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
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
                                            @foreach($student as $s)
                                                <td>
                                                    {{$s->msv}}
                                                </td>
                                                <td>
                                                    {{$s->name}}
                                                </td>
                                            @endforeach
                                            <td>
                                                @foreach($company as $c)
                                                    {{$c->name}}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($studentInCourse as $sic)
                                                    @if($sic->assign_work!=null)
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#{{$g->id}}{{"assign-w"}}">
                                                            Xem
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if(count($timekeeping)>0)
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#{{$g->id}}{{"timeke"}}">
                                                        Xem
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($companyAssess)>0)
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#{{$g->id}}{{"company-as"}}">
                                                        Xem
                                                    </a>
                                                @endif
                                            </td>
                                            @foreach($studentInCourse as $sic)
                                                <?php
                                                $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                                ?>
                                                <td>
                                                    @if(count($studentReport)>0)
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#{{$g->id}}{{"student-re"}}">
                                                            Xem
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$sic->lecture_point}}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php
                                                $lectureInCourseID = $lecInCourse->first()->id;
                                                $lectureReport = \App\LectureReport::get($lectureInCourseID);
                                                ?>
                                                @if(count($lectureReport)>0)
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#{{$cj->id}}view-asg">
                                                        <span>Xem báo cáo</span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($group as $gp)
            @foreach($gp as $g)
                <?php
                $student = \App\Student::getStudentFollowID($g->student_id);
                $company = \App\Company::getCompanyFollowID($g->company_id);
                $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
                $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($g->company_id, $g->internship_course_id);
                ?>
                {{--xem file cong ty cham cong cho sinh vien--}}
                <div class="modal fade" id="{{$g->id}}{{"timeke"}}" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Bảng chấm
                                    công</h4>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive" id="{{$g->id}}time-ke">
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
                                        $fromDate = $cj->from_date;
                                        $toDate = $cj->to_date;
                                        $yearFromDate = date('Y', strtotime($fromDate));
                                        $yearToDate = date('Y', strtotime($toDate));
                                        ?>
                                        @if($yearFromDate==$yearToDate)
                                            @for($i=date('m',strtotime($fromDate));$i<=date('m',strtotime($toDate));$i++)
                                                <tr>
                                                    <td colspan="31">Tháng {{$i}} {{$yearFromDate}}</td>
                                                </tr>
                                                <?php
                                                $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                ?>
                                                @foreach($arrStudent as $as)
                                                    @if($i==2)
                                                        @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                            <tr>
                                                                @for($j=1;$j<=29;$j++)
                                                                    <?php
                                                                    $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j))
                                                                    ?>
                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                        <td>{{$j}}
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td>{{$j}}
                                                                            <input type="checkbox"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                        <td>{{$j}}
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td>{{$j}}
                                                                            <input type="checkbox"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                    <td>{{$j}}
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td>{{$j}}
                                                                        <input type="checkbox"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                    <td>{{$j}}
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td>{{$j}}
                                                                        <input type="checkbox"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                    </td>
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endfor
                                        @else
                                            @for($i=date('m',strtotime($fromDate));$i<=12;$i++)
                                                <tr>
                                                    <td colspan="31">Tháng {{$i}} {{$yearFromDate}}</td>
                                                </tr>
                                                @foreach($arrGroup as $ag)
                                                    <?php
                                                    $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                    ?>
                                                    @foreach($arrStudent as $as)
                                                        @if($i==2)
                                                            @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                                <tr>
                                                                    @for($j=1;$j<=29;$j++)
                                                                        <?php
                                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                                        ?>
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                        <td>{{$j}}
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td>{{$j}}
                                                                            <input type="checkbox"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endfor
                                            @for($i=1;$i<=date('m',strtotime($toDate));$i++)
                                                <tr>
                                                    <td colspan="31">Tháng {{$i}} {{$yearToDate}}</td>
                                                </tr>
                                                @foreach($arrGroup as $ag)
                                                    <?php
                                                    $arrStudent = \App\Student::getStudentFollowID($g->student_id);
                                                    ?>
                                                    @foreach($arrStudent as $as)

                                                        @if($i==2)
                                                            @if(($yearToDate % 100 != 0) && ($$yearToDate % 4 == 0) || ($yearToDate % 400 == 0))
                                                                <tr>
                                                                    @for($j=1;$j<=29;$j++)
                                                                        <?php
                                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                        ?>
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                    @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                        <td>{{$j}}
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td>{{$j}}
                                                                            <input type="checkbox"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
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
                                                                        @if(\App\Timekeeping::check($as->id,$g->internship_course_id,$g->company_id,$checkDate))
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       checked="checked"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{$j}}
                                                                                <input type="checkbox"
                                                                                       name="workDay[]"
                                                                                       class="check-timekeeping"
                                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$g->internship_course_id}}*{{$g->company_id}}">
                                                                            </td>
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endfor
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row" style="text-align: center">
                                    <button type="button" class="btn btn-primary print-timeke"
                                            name="print-assess" data-id="{{$g->id}}">In file chấm công
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>{{--ket thuc modal xem nhan xet cong ty--}}
                <div class="modal fade" id="{{$g->id}}{{"company-as"}}" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>

                                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Nhận xét
                                    sinh viên</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row" id="{{$g->id}}{{"printAs"}}">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <form action="" method="POST" role="form">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold;text-align: center">
                                                    BẢNG ĐÁNH GIÁ KẾT QUẢ THỰC TẬP DOANH NGHIỆP
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
                                                @foreach($company as $c)
                                                    <span>Công ty tiếp nhận thực tập: {{$c->name}}</span><br>
                                                    <span>Email: {{$c->hr_mail}}</span><br>
                                                @endforeach
                                                @foreach($companyInCourse as $cic)
                                                    <span>Người phụ trách: {{$cic->hr_name}}</span><br>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <span style="font-weight: bold">Đánh giá chung về khóa thực tập</span><br>
                                                @foreach($companyAssess as $ca)
                                                    {!! nl2br(e(trim($ca->assess_general))) !!}
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
                                                                        <input type="radio" name="it" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->IT==2)
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->IT==3)
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->IT==4)
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->IT==5)
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="it" id=""
                                                                               value="5" disabled="disabled">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td>Phương pháp làm việc</td>
                                                                @if($ca->work==1)
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->work==2)
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->work==3)
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->work==4)
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->work==5)
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="work" id=""
                                                                               value="5" disabled="disabled">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td>Năng lực năm bắt công việc</td>
                                                                @if($ca->learn_work==1)
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->learn_work==2)
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->learn_work==3)
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->learn_work==4)
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->learn_work==5)
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="learnWork" id=""
                                                                               value="5" disabled="disabled">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td>Năng lực quản lý</td>
                                                                @if($ca->manage==1)
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->manage==2)
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->manage==3)
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->manage==4)
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->manage==5)
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="manage" id=""
                                                                               value="5" disabled="disabled">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td>Năng lực tiếng anh</td>
                                                                @if($ca->english==1)
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->english==2)
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->english==3)
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->english==4)
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->english==5)
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="english" id=""
                                                                               value="5" disabled="disabled">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td>Năng lực làm việc nhóm</td>
                                                                @if($ca->teamwork==1)
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="1" checked="checked">1
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="1" disabled="disabled">1
                                                                    </td>
                                                                @endif
                                                                @if($ca->teamwork==2)
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="2" checked="checked">2
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="2" disabled="disabled">2
                                                                    </td>
                                                                @endif
                                                                @if($ca->teamwork==3)
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="3" checked="checked">3
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="3" disabled="disabled">3
                                                                    </td>
                                                                @endif
                                                                @if($ca->teamwork==4)
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="4" checked="checked">4
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="4" disabled="disabled">4
                                                                    </td>
                                                                @endif
                                                                @if($ca->teamwork==5)
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="5" checked="checked">5
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input type="radio" name="teamWork" id=""
                                                                               value="5" disabled="disabled">5
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
                                                    @foreach($companyInCourse as $cic)
                                                        <span style="font-weight: bold;float: right;margin-right:45px">{{$cic->hr_name}}</span>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                </div>
                                <div class="row" style="text-align: center">
                                    <button type="button" class="btn btn-primary print-as"
                                            name="print-assess" data-id="{{$g->id}}">In nhận xét
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>{{--ket thuc modal xem nhan xet cong ty ve--}}
                @foreach($studentInCourse as $sic)
                    <div class="modal fade" id="{{$g->id}}{{"student-re"}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="text-align: center">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span
                                                aria-hidden="true">&times;</span>
                                    </button>

                                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Báo cáo</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <?php
                                        $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                        ?>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                        </div>
                                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                             id="{{$g->id}}{{"printRe"}}">
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
                                                        <div>Địa chỉ đến thực
                                                            tập:{{($c->name)}}{{$c->address}}</div>
                                                    @endforeach
                                                    @foreach($lecture as $l)
                                                        <div>Giáo viên phụ trách:{{$l->name}}</div>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    @foreach($student as $s)
                                                        <div>MSSV:{{$s->msv}}</div>
                                                        <div></div>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Thời gian được
                                                    cử
                                                    đi
                                                    thực tập: từ ngày
                                                    {{date('d/m/Y',strtotime($cj->from_date))}},
                                                    đến ngày
                                                    {{date('d/m/Y',strtotime($cj->to_date))}}
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold">
                                                    I, Nội dung công việc được giao<br>
                                                    @foreach($studentReport as $sr)
                                                        <span style="font-weight: normal;">{!! nl2br(e(trim($sr->assign_work))) !!}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold">
                                                    II, Kết quả thực hiện<br>
                                                    @foreach($studentReport as $sr)
                                                        <span style="font-weight: normal;">{!! nl2br(e(trim($sr->result))) !!}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold">
                                                    II, Tự đánh giá
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold">
                                                    - Ưu điểm<br>
                                                    @foreach($studentReport as $sr)
                                                        <span style="font-weight: normal;">{!! nl2br(e(trim($sr->advantage))) !!}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                     style="font-weight: bold">
                                                    - Nhược điểm<br>
                                                    @foreach($studentReport as $sr)
                                                        <span style="font-weight: normal;">{!! nl2br(e(trim($sr->dis_advantage))) !!}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     style="text-align: center;margin-top: 30px;font-weight: bold">
                                                    SINH VIÊN
                                                    <br>
                                                    @foreach($student as $s)
                                                        {{$s->name}}
                                                    @endforeach
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
                                             style="text-align: center;margin-top: 20px">
                                            <hr>
                                            <form action="" method="POST" class="form-inline" role="form">
                                                <button type="button" class="btn btn-primary print-re"
                                                        data-id="{{$g->id}}">In báo
                                                    cáo
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="{{$g->id}}{{"assign-w"}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="text-align: center">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Nhiệm vụ sinh
                                        viên
                                        @foreach($student as $s)
                                            {{$s->name}}
                                        @endforeach
                                        được giao
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
        @endforeach
        <?php
        if (count($lecInCourse) > 0) {
            $lectureInCourseID = $lecInCourse->first()->id;
            $lectureReport = \App\LectureReport::get($lectureInCourseID);
        }
        ?>
        <div class="modal fade" id="{{$cj->id}}view-asg" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Giảng viên viết nhận xét
                            chung</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row lecture-view1">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                 id="lecture-write-report">
                                <div class="row" id="{{$cj->id}}print-lecture-re">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                         style="text-align: center;font-weight: bold">
                                        <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span>
                                        <span>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</span><br>
                                        <span>––––––––––––</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                         style="text-align: center;font-weight: bold">
                                        <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
                                        <span>Độc Lập – Tự do – Hạnh phúc</span><br>
                                        <span>––––––––––––––––––––––––––––</span><br>
                                        @foreach($lectureReport as $lr)
                                            Hà Nội, ngày {{date('d',strtotime($lr->date_report))}}
                                            tháng {{date('m',strtotime($lr->date_report))}}
                                            năm {{date('Y',strtotime($lr->date_report))}}
                                        @endforeach
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 style-form"
                                         style="text-align: center;margin-top: 20px;margin-bottom: 15px;font-weight: bold">
                                        BÁO CÁO<br>
                                        KẾT QUẢ ĐƯA SINH VIÊN ĐI THỰC TẬP TẠI ĐƠN VỊ NGOÀI TRƯỜNG
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        @foreach($lecture as $l)
                                            <div>Họ và tên giảng viên phụ trách:{{$l->name}}</div>
                                            <div>Bộ môn:{{$l->address}}</div>
                                        @endforeach
                                        <div>Thời gian được cử đi thực tập từ ngày
                                            {{date('d/m/Y',strtotime($cj->from_date))}}
                                            đến ngày
                                            {{date('d/m/Y',strtotime($cj->to_date))}}
                                        </div>
                                        <div>Nội dung của đợt thực tập: Thực tập tại doanh nghiệp theo
                                            chương trình
                                            đào
                                            tạo
                                        </div>
                                        <div>
                                            <label>Kết quả đánh giá sinh viên</label>
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã sinh viên</th>
                                                    <th>Họ và tên</th>
                                                    <th>Điểm quá trình</th>
                                                    <th>Điểm cuối kỳ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $group = \App\InternShipGroup::getGroupFollowLI($lectureID, $cj->id);
                                                $i = 0;
                                                ?>
                                                @foreach($group as $gp)
                                                    @foreach($gp as $g)
                                                        <?php
                                                        $student = \App\Student::getStudentFollowID($g->student_id);
                                                        $company = \App\Company::getCompanyFollowID($g->company_id);
                                                        $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                                                        ?>
                                                        <tr>
                                                            <td>{{++$i}}</td>
                                                            @foreach($student as $s)
                                                                <td>{{$s->msv}}</td>
                                                                <td>{{$s->name}}</td>
                                                            @endforeach
                                                            @foreach($studentInCourse as $sic)
                                                                <td>{{$sic->company_point}}</td>
                                                                <td>{{$sic->lecture_point}}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                                @foreach($lecInCourse as $lic)
                                                    <input type="hidden" name="lectureInCourseID"
                                                           value="{{$lic->id}}">
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            @foreach($lectureReport as $lr)
                                                <label>Thuận lợi</label><br>
                                                {!! nl2br(e(trim($lr->advantage))) !!}
                                                <br>
                                                <label>Khó khăn</label><br>
                                                {!! nl2br(e(trim($lr->dis_advantage))) !!}<br>
                                                <label>Kiến nghị</label><br>
                                                {!! nl2br(e(trim($lr->proposal))) !!}
                                                <br>
                                                <label>Đánh giá chung</label><br>
                                                {!! nl2br(e(trim($lr->assess_general))) !!}
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                         style="text-align: center;margin-top: 50px;font-weight: bold">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                         style="text-align: center;margin-top: 50px;font-weight: bold">
                                        GIẢNG VIÊN PHỤ TRÁCH
                                        <br>
                                        <?php
                                        $lecture = \App\Lecture::getLectureFollowID($lectureID);
                                        ?>
                                        @foreach($lecture as $l)
                                            {{$l->name}}
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                     style="text-align: center">
                                    <button type="button" class="btn btn-primary print-asg" data-id="{{$cj->id}}">In báo
                                        cáo
                                    </button>
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
    <script>
        $('.lecture-to-score').hide();
        $('#lecture-join').addClass('menu-menu');
        $('a#lecture-join').css('color', '#000000');
        $('#table-current').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ordering": false
        });
        $('#table-join').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ordering": false
        });
        $('.table-detail').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ordering": false
        });

        /*
         bắt sự kiện chọn nút selectAll
         */
        $('#selectAll').click(function () {
            if (this.checked) {
                $('.selectStudent').each(function () {
                    this.checked = true;
                });
            } else {
                $('.selectStudent').each(function () {
                    this.checked = false;
                });
            }
        });

        /*
         su kien change
         */
        $('.lectureToScore').change(function () {
            var courseID = $('.courseCurrentClass').val();
            var studentID = $(this).attr('data-id');
            var getLecturePoint = $(this).val();
            var lecturePoint = parseFloat(getLecturePoint);
            if (!isNaN(lecturePoint)) {//isNaN(x) neu x la so thi tra ve false
                if (lecturePoint >= 0 && lecturePoint <= 10) {
                    $.get('lecture-to-score?studentID=' + studentID + '&' + 'courseID=' + courseID + '&' + 'lecturePoint=' + lecturePoint, function (data) {
                    });
                } else {
                    if (alert('Điểm lớn hơn hoặc bằng 0, nhỏ hơn hoặc bằng 10')) {
                    }
                    else {
                        location.reload();
                    }
                }
            } else {
                if (alert('không phải là số')) {
                }
                else {
                    location.reload();
                }
            }
        });
        $('#cancel-edit-report').hide();
        $('#edit-report-form').hide();
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
            w.document.write($("#print-lecture-report").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.lecture-view2').hide();
        $('#edit-report').click(function () {
            $('#cancel-edit-report').show();
            $('#edit-report-form').show();
            $('#print-report').hide();
            $(this).hide();
            $('.lecture-view1').hide();
            $('.lecture-view2').show();
        });
        $('#cancel-edit-report').click(function () {
            $('#print-report').show();
            $('#edit-report').show();
            $('#cancel-edit-report').hide();
            $('#edit-report-form').hide();
            $('.lecture-view2').hide();
            $('.lecture-view1').show();
        });
        $('.print-report').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "printReport").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-assess').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "printAssess").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-timekeeping').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "time-keeping").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-timeke').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "time-ke").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-as').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "printAs").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-re').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "printRe").html());
            w.document.write('</body></html>');
            w.document.close();
        });
        $('.print-asg').click(function () {
            var groupID = $(this).attr('data-id');
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
            w.document.write($("#" + groupID + "print-lecture-re").html());
            w.document.write('</body></html>');
            w.document.close();
        });
    </script>
@endsection