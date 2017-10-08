@foreach($courseCurrent as $cc)
    <?php
    $comInCourse = \App\CompanyInternShipCourse::getComInCourse($companyID, $cc->id);
    ?>
    @if(count($comInCourse)>0)
        <?php
        $hrName = "";
        foreach ($comInCourse as $ci) {
            $hrName = $ci->hr_name;
        }
        $group = \App\InternShipGroup::getGroupFollowCI($companyID, $cc->id);
        ?>
        @foreach($group as $g)
            <?php
            $student = \App\Student::getStudentFollowID($g->student_id);
            $lecture = \App\Lecture::getLectureFollowID($g->lecture_id);
            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($g->student_id, $g->internship_course_id);
            $company = \App\Company::getCompanyFollowID($companyID);
            $companyAssess = \App\CompanyAssess::getCompanyAssess($g->id);
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
                                                    <td>Tiếng anh:</td>
                                                    <td>{{$s->english}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kỹ năng:</td>
                                                    <td>{{$s->programing_skill}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kỹ năng tốt nhất:</td>
                                                    <td>{{$s->programing_skill_best}}</td>
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
            @foreach($lecture as $l)
                <div class="modal fade" id="{{$l->id}}{{"lecture"}}" tabindex="-1" role="dialog"
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
            @endforeach

            {{--Nhan xet sinh vien--}}
            <div class="modal fade" id="{{$g->id}}{{"assess"}}" tabindex="-1" role="dialog"
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
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                    <form action="company-assess" method="POST" role="form">
                                        <input type="hidden" name="groupID" value="{{encrypt($g->id)}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                                                    <span style="float:right;">Ngày {{date('d')}} tháng {{date('m')}}
                                                        năm {{date('Y')}}</span>
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
                                            <span>Người phụ trách: {{$hrName}}</span>
                                        </div>
                                        <div class="row">
                                            <span style="font-weight: bold">Đánh giá chung về khóa thực tập</span>
                                            @if(count($companyAssess)==0)
                                                <textarea name="assessGeneral" id="input" class="form-control"
                                                          style="width: 100%;overflow: hidden"
                                                          onkeyup="textArea(this)"></textarea>
                                            @else
                                                @foreach($companyAssess as $ca)
                                                    <input type="hidden" name="companyAssessID" value="{{$ca->id}}">
                                                    <textarea name="assessGeneral" id="input" class="form-control"
                                                              style="width: 100%;overflow: hidden;min-height: 200px"
                                                              onkeyup="textArea(this)">{{$ca->assess_general}}</textarea>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="row" style="margin-top: 15px">
                                            <span style="font-weight: bold">Đánh giá kết quả thực tập</span>

                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    @if(count($companyAssess)==0)
                                                        <tbody>
                                                        <tr>
                                                            <td>Năng lực IT</td>
                                                            <td>
                                                                <input type="radio" name="it" id="" value="1"
                                                                       required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="it" id="" value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="it" id="" value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="it" id="it" value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="it" id="it" value="5">5
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phương pháp làm việc</td>
                                                            <td>
                                                                <input type="radio" name="work" id="" value="1"
                                                                       required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="work" id="" value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="work" id="" value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="work" id="it" value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="work" id="it" value="5">5
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Năng lực năm bắt công việc</td>
                                                            <td>
                                                                <input type="radio" name="learnWork" id=""
                                                                       value="1" required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="learnWork" id=""
                                                                       value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="learnWork" id=""
                                                                       value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="learnWork" id=""
                                                                       value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="learnWork" id=""
                                                                       value="5">5
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Năng lực quản lý</td>
                                                            <td>
                                                                <input type="radio" name="manage" id="" value="1"
                                                                       required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="manage" id="" value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="manage" id="" value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="manage" id="" value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="manage" id="" value="5">5
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Năng lực tiếng anh</td>
                                                            <td>
                                                                <input type="radio" name="english" id="" value="1"
                                                                       required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="english" id="" value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="english" id="" value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="english" id="" value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="english" id="" value="5">5
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Năng lực làm việc nhóm</td>
                                                            <td>
                                                                <input type="radio" name="teamWork" id="" value="1"
                                                                       required="required">1
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="teamWork" id="" value="2">2
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="teamWork" id="" value="3">3
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="teamWork" id="" value="4">4
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="teamWork" id="" value="5">5
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    @else
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
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
                                                                               value="1">1
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
                                                                               value="2">2
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
                                                                               value="3">3
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
                                                                               value="4">4
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
                                                                               value="5">5
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <span style="font-weight: bold;float: right">XÁC NHẬN NGƯỜI PHỤ TRÁCH</span><br>
                                                    <br>
                                                    <br>
                                                    <span style="font-weight: bold;float: right; margin-right:40px">{{$hrName}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if(count($companyAssess)==0)
                                            <button type="submit" class="btn btn-primary" name="company-assess">Nhận
                                                xét
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-primary"
                                                    name="company-edit-assess">Sửa Nhận xét
                                            </button>
                                        @endif
                                    </form>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>{{--ket thuc modal nhan xet sinh vien--}}

            {{--Sinh vien xem nhan xet cua cong ty ve minh--}}
            @if(count($companyAssess)>0)
                <div class="modal fade" id="{{$g->id}}{{"viewAssess"}}" tabindex="-1" role="dialog"
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
                                                    <span>Công ty tiếp nhận thực tập: {{$c->name}}</span><br>
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
                                                    <span style="font-weight: bold;float: right;margin-right:40px">{{$hrName}}</span>
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
                </div>{{--ket thuc modal xem nhan xet cong ty ve minh--}}
            @endif
            {{--Xem bao cao cua sinh vien--}}
            @foreach($studentInCourse as $sic)
                <?php
                $studentReport = \App\StudentReport::getStudentReport($sic->id);
                ?>
                @if(count($studentReport)>0)
                    <div class="modal fade" id="{{$g->id}}{{"studentReport"}}" tabindex="-1" role="dialog"
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
                                            <div class="row" id="{{$g->id}}{{"printReport"}}">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     style="text-align: center;font-weight: bold;">
                                                    <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span><br>
                                                    <span>Viện Công Nghệ Thông Tin và Truyền Thông</span><br>
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
                                                    {{date('d/m/Y',strtotime($cc->from_date))}},
                                                    đến ngày
                                                    {{date('d/m/Y',strtotime($cc->to_date))}}
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
                                                <button type="button" class="btn btn-primary print-report"
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
            <div class="modal fade" id="{{$g->id}}{{"assign-work"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Giao nhiệm vụ cho sinh
                                viên</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <form action="assign-work" method="POST" role="form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="studentID" value="{{encrypt($g->student_id)}}">
                                        <input type="hidden" name="courseID"
                                               value="{{encrypt($g->internship_course_id)}}">

                                        <textarea name="assignWork" class="form-control"
                                                  required="required" placeholder="tìm hiểu ngôn ngữ,..."
                                                  style="width: 100%;overflow: hidden" onkeyup="textArea(this)">
                                        </textarea>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="{{$g->id}}{{"view-assign-work"}}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa nhiệm vụ giao
                                cho sinh viên</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <form action="assign-work" method="POST" role="form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="studentID" value="{{encrypt($g->student_id)}}">
                                        <input type="hidden" name="courseID"
                                               value="{{encrypt($g->internship_course_id)}}">
                                        <textarea name="assignWork" class="form-control"
                                                  style="width: 100%;overflow: hidden;margin:0px; min-height: 200px"
                                                  onkeyup="textArea(this)"
                                                  onload="setHeight(this)">@foreach($studentInCourse as $sic){!! trim($sic->assign_work) !!}
                                            @endforeach
                                        </textarea>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="modal fade" id="{{"assign-work-many-modal"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Giao nhiệm vụ cho sinh
                            viên</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form action="assign-work-many" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="groupID" value="" class="groupIDAssign">
                                        <textarea name="assignWork" class="form-control"
                                                  required="required" placeholder="tìm hiểu ngôn ngữ,..."
                                                  style="width: 100%;overflow: hidden" onkeyup="textArea(this)">
                                        </textarea>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
<script>
    function textArea(o) {
        o.style.height = "1px";
        o.style.height = (25 + o.scrollHeight) + "px";
    }
    //    $('textarea#test').html($('textarea#test').html().trim());
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
</script>