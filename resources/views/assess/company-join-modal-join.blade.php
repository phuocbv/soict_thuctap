@foreach($courseJoin as $cj)
    <?php
    $group = \App\InternShipGroup::getGroupFollowCI($companyID, $cj->id);
    $comInCourse = \App\CompanyInternShipCourse::getComInCourse($companyID, $cj->id);
    $hrName = "";
    foreach ($comInCourse as $cic) {
        $hrName = $cic->hr_name;
    }
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
                            <th><input type="checkbox" name="" class="selectAllJoin" data-id="{{$cj->id}}"></th>
                            <th>Môn học</th>
                            <th style="min-width: 100px">MSV</th>
                            <th style="min-width: 130px">Sinh viên</th>
                            <th style="min-width: 130px">Giảng viên</th>
                            <th style="min-width: 40px">
                                <span>nhiệm vụ</span><br>
                                (sinh viên)
                            </th>
                            <th style="min-width: 80px">
                                <span>Báo cáo</span><br>
                                (sinh viên)
                            </th>
                            <th style="min-width:80px ">
                                <span>Nhận xét</span><br>
                                (Công ty)
                            </th>
                            <th style="min-width:90px">Điểm</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <a href="#" class="print-many-re" data-id="{{$cj->id}}">
                                <span class="glyphicon glyphicon-print"></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" class="print-many-as" data-id="{{$cj->id}}">
                                <span class="glyphicon glyphicon-print"></span>
                            </a>
                        </th>
                        <th>
                            <?php
                            $timekeeping = \App\Timekeeping::getFollowCourseIDCompanyID($companyID, $cj->id);
                            ?>
                            @if(count($timekeeping)>0)
                                <a href="" data-toggle="modal"
                                   data-target="#{{$cj->id}}view-timekeeping">
                                    <span>File chấm công</span>
                                </a>
                            @endif
                        </th>
                        </tfoot>
                        <tbody>
                        @foreach($group as $g)
                            <?php
                            $student = \App\Student::getStudentFollowID($g->student_id);
                            $lecture = \App\Lecture::getLectureFollowID($g->lecture_id);
                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
                            $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" class="selectJoin{{$cj->id}}"
                                           value="{{$g->id}}">
                                </td>
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
                                    @foreach($lecture as $l)
                                        {{$l->name}}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($studentInCourse as $sic)
                                        @if($sic->assign_work!=null)
                                            <a href="#" data-toggle="modal"
                                               data-target="#{{$g->id}}viewAssign">
                                                <span>Xem</span>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                @foreach($studentInCourse as $sic)
                                    <td>
                                        <?php
                                        $studentReport = \App\StudentReport::getStudentReport($sic->id);
                                        ?>
                                        @if(count($studentReport)>0)
                                            <a href="#" data-toggle="modal"
                                               data-target="#{{$g->id}}studentRe">
                                                <span>Xem</span>
                                            </a>
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    @if(count($companyAssess)>0)
                                        <a href="#" data-toggle="modal"
                                           data-target="#{{$g->id}}viewAs">
                                            <span>Xem</span>
                                        </a>
                                    @endif
                                </td>
                                @foreach($studentInCourse as $sic)
                                    <td>{{$sic->company_point}}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach($group as $g)
        <?php
        $student = \App\Student::getStudentFollowID($g->student_id);
        $lecture = \App\Lecture::getLectureFollowID($g->lecture_id);
        $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
        $company = \App\Company::getCompanyFollowID($companyID);
        $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
        ?>
        {{--modal Xem bao cao cua sinh vien--}}
        @foreach($studentInCourse as $sic)
            <?php
            $studentReport = \App\StudentReport::getStudentReport($sic->id);
            ?>
            @if(count($studentReport)>0)
                <div class="modal fade" id="{{$g->id}}{{"studentRe"}}" tabindex="-1" role="dialog"
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
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="row" id="{{$g->id}}{{"printRe"}}">
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
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Thời gian được cử
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
                                                    <span style="font-weight: normal;">{!! nl2br(e(trim($sr->assign_work))) !!}</span>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                II, Kết quả thực hiện<br>
                                                @foreach($studentReport as $sr)
                                                    <span style="font-weight: normal;">{!! nl2br(e(trim($sr->result))) !!}</span>
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
                                                    <span style="font-weight: normal;">{!! nl2br(e(trim($sr->advantage))) !!}</span>
                                                @endforeach
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                                 style="font-weight: bold">
                                                - Nhược điểm<br>
                                                @foreach($studentReport as $sr)
                                                    <span style="font-weight: normal;">{!! nl2br(e(trim($sr->dis_advantage))) !!}</span>
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
            @endif
        @endforeach

        {{--modal xem nhan xet cua cong ty--}}
        @if(count($companyAssess)>0)
            <div class="modal fade" id="{{$g->id}}{{"viewAs"}}" tabindex="-1" role="dialog"
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
                                            <span>Người phụ trách: {{$hrName}}</span><br>
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
                                                <span style="font-weight: bold;float: right">XÁC NHẬN NGƯỜI PHỤ TRÁCH</span>
                                                <br>
                                                <br>
                                                <br>
                                                <span style="font-weight: bold;float: right;margin-right: 45px">{{$hrName}}</span>
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
            </div>{{--ket thuc modal xem nhan xet cong ty--}}
        @endif

        {{--modal xem nhiem vu cua sinh vien--}}
        <div class="modal fade" id="{{$g->id}}{{"viewAssign"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Nhiệm vụ sinh viên
                            @foreach($student as $s)
                                {{$s->name}}
                            @endforeach
                            được giao
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                @foreach($studentInCourse as $sic)
                                    {!! nl2br(e(trim($sic->assign_work))) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    <div class="modal fade" id="{{$cj->id}}{{"view-timekeeping"}}" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Bảng chấm công</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="{{$cj->id}}timekeeping">
                        <div style="text-align:center">
                            <h3>BẢNG CHẤM CÔNG</h3>
                        </div>
                        <table class="table table-hover table-bordered" style="font-size: 12px;margin-top: 20px">
                            <thead>
                            <tr>
                                <th>Họ tên</th>
                                <th colspan="31">Tháng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $fromDate = $cj->from_date;
                            $toDate = $cj->to_date;
                            $yearFromDate = date('Y', strtotime($fromDate));
                            $yearToDate = date('Y', strtotime($toDate));
                            $arrGroup = \App\InternShipGroup::getGroupFollowCI($companyID, $cj->id);
                            ?>
                            @if($yearFromDate==$yearToDate)
                                @for($i=date('m',strtotime($fromDate));$i<=date('m',strtotime($toDate));$i++)
                                    <tr>
                                        <td></td>
                                        <td colspan="31">Tháng {{$i}} {{$yearFromDate}}</td>
                                    </tr>
                                    @foreach($arrGroup as $ag)
                                        <?php
                                        $arrStudent = \App\Student::getStudentFollowID($ag->student_id);
                                        ?>
                                        @foreach($arrStudent as $as)
                                            @if($i==2)
                                                @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=29;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j))
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=28;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                <tr>
                                                    <td>{{$as->name}}</td>
                                                    @for($j=1;$j<=31;$j++)
                                                        <?php
                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                        ?>
                                                        @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                            <td>{{$j}}
                                                                <input type="checkbox" checked="checked"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @else
                                                            <td>{{$j}}
                                                                <input type="checkbox"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($i==4||$i==6||$i==9||$i==11)
                                                <tr>
                                                    <td>{{$as->name}}</td>
                                                    @for($j=1;$j<=30;$j++)
                                                        <?php
                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                        ?>
                                                        @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                            <td>{{$j}}
                                                                <input type="checkbox" checked="checked"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @else
                                                            <td>{{$j}}
                                                                <input type="checkbox"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endfor
                            @else
                                @for($i=date('m',strtotime($fromDate));$i<=12;$i++)
                                    <tr>
                                        <td></td>
                                        <td colspan="31">Tháng {{$i}} {{$yearFromDate}}</td>
                                    </tr>
                                    @foreach($arrGroup as $ag)
                                        <?php
                                        $arrStudent = \App\Student::getStudentFollowID($ag->student_id);
                                        ?>
                                        @foreach($arrStudent as $as)
                                            @if($i==2)
                                                @if(($yearFromDate % 100 != 0) && ($yearFromDate % 4 == 0) || ($yearFromDate % 400 == 0))
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=29;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=28;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                <tr>
                                                    <td>{{$as->name}}</td>
                                                    @for($j=1;$j<=31;$j++)
                                                        <?php
                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                        ?>
                                                        @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                            <td>{{$j}}
                                                                <input type="checkbox" checked="checked"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @else
                                                            <td>{{$j}}
                                                                <input type="checkbox"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                                @if($i==4||$i==6||$i==9||$i==11)
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=30;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
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
                                        <td></td>
                                        <td colspan="31">Tháng {{$i}} {{$yearToDate}}</td>
                                    </tr>
                                    @foreach($arrGroup as $ag)
                                        <?php
                                        $arrStudent = \App\Student::getStudentFollowID($ag->student_id);
                                        ?>
                                        @foreach($arrStudent as $as)

                                            @if($i==2)
                                                @if(($yearToDate % 100 != 0) && ($$yearToDate % 4 == 0) || ($yearToDate % 400 == 0))
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=29;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=28;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($i==1||$i==3||$i==5||$i==7||$i==7||$i==8||$i==10||$i==12)
                                                <tr>
                                                    <td>{{$as->name}}</td>
                                                    @for($j=1;$j<=31;$j++)
                                                        <?php
                                                        $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                        ?>
                                                        @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                            <td>{{$j}}
                                                                <input type="checkbox" checked="checked"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @else
                                                            <td>{{$j}}
                                                                <input type="checkbox"
                                                                       name="workDay[]"
                                                                       class="check-timekeeping"
                                                                       value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                            </td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                                @if($i==4||$i==6||$i==9||$i==11)
                                                    <tr>
                                                        <td>{{$as->name}}</td>
                                                        @for($j=1;$j<=30;$j++)
                                                            <?php
                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                            ?>
                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                <td>{{$j}}
                                                                    <input type="checkbox" checked="checked"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                </td>
                                                            @else
                                                                <td>{{$j}}
                                                                    <input type="checkbox"
                                                                           name="workDay[]"
                                                                           class="check-timekeeping"
                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
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
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                             style="font-weight: bold;text-align: center">
                            <span>XÁC NHẬN PHÍA CÔNG TY</span><br>
                            <span>
                                @foreach($user as $u)
                                    {{$u->name}}
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <div class="row" style="text-align: center">
                        <button type="button" class="btn btn-primary print-timekeeping"
                                name="print-assess" data-id="{{$cj->id}}">In file chấm công
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>{{--ket thuc modal xem nhan xet cong ty--}}
@endforeach
<script>
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
    $('.print-timekeeping').click(function () {
        var courseID = $(this).attr('data-id');
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
        w.document.write($("#" + courseID + "timekeeping").html());
        w.document.write('</body></html>');
        w.document.close();
    });
    $('.selectAllJoin').change(function () {
        var courseID = $(this).attr('data-id');
        if (this.checked) {
            $("." + "selectJoin" + courseID).each(function () {
                this.checked = true;
            })
        } else {
            $("." + "selectJoin" + courseID).each(function () {
                this.checked = false;
            })
        }
    });
    $('.print-many-as').click(function () {
        var arrGroupID = new Array();
        var courseID = $(this).attr('data-id');
        var arrAll = new Array();
        var arrPrint = new Array();
        $("." + "selectJoin" + courseID).each(function () {
            if (this.checked) {
                arrGroupID.push($(this).val());
            }
            arrAll.push($(this).val());
        });
        if (arrGroupID.length == 0) {
            for (var i = 0; i < arrAll.length; i++) {
                arrPrint[i] = arrAll[i];
            }
        } else {
            for (var i = 0; i < arrGroupID.length; i++) {
                arrPrint[i] = arrGroupID[i];
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
        var count = 0;
        for (var i = 0; i < arrPrint.length; i++) {
            if ($("#" + arrPrint[i] + "printAs").length > 0) {
                w.document.write($("#" + arrPrint[i] + "printAs").html());
                w.document.write('<div style="page-break-after: always">&nbsp;</div>')
            }
        }
        w.document.write('</body></html>');
        w.document.close();
    });
    $('.print-many-re').click(function () {
        var courseID = $(this).attr('data-id');
        var arrGroupID = new Array();
        var arrAll = new Array();
        var arrPrint = new Array();
        $("." + "selectJoin" + courseID).each(function () {
            if (this.checked) {
                arrGroupID.push($(this).val());
            }
            arrAll.push($(this).val());
        });
        if (arrGroupID.length == 0) {
            for (var i = 0; i < arrAll.length; i++) {
                arrPrint[i] = arrAll[i];
            }
        } else {
            for (var i = 0; i < arrGroupID.length; i++) {
                arrPrint[i] = arrGroupID[i];
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
        var count = 0;
        for (var i = 0; i < arrPrint.length; i++) {
            if ($("#" + arrPrint[i] + "printRe").length > 0) {
                w.document.write($("#" + arrPrint[i] + "printRe").html());
                w.document.write('<div style="page-break-after: always">&nbsp;</div>')
            }
        }
        w.document.write('</body></html>');
        w.document.close();
    });

</script>