@extends('home-user.index')
@section('title')
    {{'Kỳ tham gia'}}
@endsection
@section('user-content')
    <style>
        .align-assign {
            text-align: center;
        }

        .company-join {
            font-size: 13px;
            background-color: #EEEEEE;
        }

        #table-current, #table-join {
            background-color: #FFFFFF;
        }
    </style>
    @if(session()->has('assignWorkSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('assignWorkSuccess')}}</div>
    @endif
    @if(session()->has('timekeepingSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('timekeepingSuccess')}}</div>
    @endif
    @if(session()->has('updateCompanyPointSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateCompanyPointSuccess')}}</div>
    @endif
    @if(session()->has('updateCompanyPointError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('updateCompanyPointError')}}
        </div>
    @endif
    @if(session()->has('insertSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('insertSuccess')}}</div>
    @endif
    @if(session()->has('updateAssess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateAssess')}}</div>
    @endif
    @if(session()->has('updateCompanyAssessError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('updateCompanyAssessError')}}
        </div>
    @endif
    @if(session()->has('updateTimeKeepingSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateTimeKeepingSuccess')}}</div>
    @endif
    @if(session()->has('updateTimeKeepingError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('updateTimeKeepingError')}}
        </div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <span class="name-page-profile">Kỳ thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="company-join" style="color: #333">
                <span class="company-register name-page-profile">Các kỳ tham gia</span>
            </a>
        </div>
    </div>
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
                        <input type="hidden" name="" class="courseCurrentClass" value="{{$cc->id}}">
                        <div class="panel-heading align-assign">
                            <h3 class="panel-title name-page-profile">Kỳ thực tập hiện tại {{$cc->course_term}}</h3>
                        <span>(Bắt đầu: {{date('d/m/y',strtotime($cc->from_date))}}
                            , kết thúc {{date('d/m/Y',strtotime($cc->to_date))}})</span>
                        </div>
                        <?php
                        $comInCourse = \App\CompanyInternShipCourse::getComInCourse($companyID, $cc->id);
                        ?>
                        @if(count($comInCourse)>0)
                            <?php
                            $group = \App\InternShipGroup::getGroupFollowCI($companyID, $cc->id);
                            ?>
                            <div class="table-responsive company-join">
                                <table id="table-current" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" class="selectAllCurrent"></th>
                                        <th>Môn học</th>
                                        <th style="min-width: 100px">Sinh viên</th>
                                        <th style="min-width: 100px">Giảng viên</th>
                                        <th style="min-width: 44px">Giao nhiệm vụ</th>
                                        <th style="min-width: 64px">
                                            <span>Báo cáo</span><br>
                                            (sinh viên)
                                        </th>
                                        <th style="min-width: 64px">
                                            <span>Nhận xét</span><br>
                                            (Công ty)
                                        </th>
                                        <th style="min-width: 105px">Chấm điểm</th>
                                        <th style="min-width: 90px">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <a href="#" class="btn btn-primary btn-sm" id="assign-work-many"
                                               data-toggle="modal"
                                               data-target="#{{"assign-work-many-modal"}}">
                                                <span>Giao</span>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" id="print-many-report">
                                                <span class="glyphicon glyphicon-print"></span>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" id="print-many-assess">
                                                <span class="glyphicon glyphicon-print"></span>
                                            </a>
                                        </th>
                                        <th></th>
                                        <th>
                                            <?php
                                            $timekeeping = \App\Timekeeping::getFollowCourseIDCompanyID($companyID, $cc->id);
                                            ?>
                                            @if(count($timekeeping)>0)
                                                <a href="viewTimekeeping?courseID={{$cc->id}}">
                                                    Xem chấm công
                                                </a>
                                            @else
                                                <a href="timekeeping?courseID={{$cc->id}}"
                                                   class="btn btn-primary btn-sm">Chấm
                                                    công</a>
                                            @endif
                                        </th>
                                    </tr>
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
                                                <input type="checkbox" name="selectCurrent" class="selectCurrent"
                                                       value="{{$g->id}}">
                                            </td>
                                            <td>
                                                @foreach($studentInCourse as $sic)
                                                    {{$sic->subject}}
                                                @endforeach
                                            </td>
                                            @foreach($student as $s)
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#{{$s->id}}{{"student"}}"
                                                       style="color: #333">
                                                        {{$s->name}}
                                                    </a>
                                                </td>
                                            @endforeach
                                            @foreach($lecture as $l)
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#{{$l->id}}{{"lecture"}}"
                                                       style="color: #333">
                                                        {{$l->name}}
                                                    </a>
                                                </td>
                                            @endforeach
                                            <td>
                                                @foreach($studentInCourse as $sic)
                                                    @if($sic->assign_work==null)
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#{{$g->id}}{{"assign-work"}}">
                                                            giao
                                                        </a>
                                                    @else
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#{{$g->id}}{{"view-assign-work"}}">
                                                            xem
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
                                                           data-target="#{{$g->id}}studentReport">
                                                            <span>Xem</span>
                                                        </a>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                @if(count($companyAssess)>0)
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#{{$g->id}}viewAssess">
                                                        <span>Xem</span>
                                                    </a>
                                                @endif
                                            </td>
                                            @foreach($studentInCourse as $sic)
                                                <td>
                                                    <input type="number" name="companyPoint" id=""
                                                           class="form-control companyPoint" min="0" max="10"
                                                           data-id="{{$sic->student_id}}"
                                                           data-internship-course-id="{{$cc->id}}"
                                                           value="{{$sic->company_point}}"
                                                           style="width: 85px">
                                                </td>
                                            @endforeach
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm"
                                                   data-toggle="modal"
                                                   data-target="#{{$g->id}}{{"assess"}}">
                                                    <span>Đánh giá</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div style="background-color: #FFFFFF;text-align: center;min-height: 45px; padding-top: 10px">
                                <p style="color:#E80000">Công ty chưa tham gia khóa thực tập này</p>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-heading align-assign">
                    <h3 class="panel-title name-page-profile">Các kỳ tham gia</h3>
                </div>
                <div class="table-responsive company-join">
                    <table id="table-join" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Kỳ thực tập</th>
                            <th style="min-width: 186px">Ngày bắt đầu</th>
                            <th style="min-width: 193px">Ngày kết thúc</th>
                            <th style="min-width: 172px">Xem chi tiết</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Kỳ thực tập</th>
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
    @include('assess.company-join-modal-current')
    @include('assess.company-join-modal-join')
    <script>
        $('#company-join').addClass('menu-menu');
        $('a#company-join').css('color', '#000000');
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
        $('.companyPoint').change(function () {
            var courseID = $(this).data('internship-course-id');
            var studentID = $(this).attr('data-id');
            var getCompanyPoint = $(this).val();
            var companyPoint = parseFloat(getCompanyPoint);
            if (!isNaN(companyPoint)) {//isNaN(x) neu x la so thi tra ve false
                if (companyPoint >= 0 && companyPoint <= 10) {
                    $.get('company-to-score?studentID=' + studentID + '&' + 'courseID=' + courseID + '&' + 'companyPoint=' + companyPoint, function (data) {
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
        $('.selectAllCurrent').change(function () {
            if (this.checked) {
                $('.selectCurrent').each(function () {
                    this.checked = true;
                })
            } else {
                $('.selectCurrent').each(function () {
                    this.checked = false;
                });
            }
        });
        $('#print-many-report').click(function () {
            var arrGroupID = new Array();
            var arrAll = new Array();
            var arrPrint = new Array();
            $('.selectCurrent').each(function () {
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
                if ($("#" + arrPrint[i] + "printReport").length > 0) {
                    w.document.write($("#" + arrPrint[i] + "printReport").html());
                    w.document.write('<div style="page-break-after: always">&nbsp;</div>')
                }
            }
            w.document.write('</body></html>');
            w.document.close();
        });
        $('#print-many-assess').click(function () {
            var arrGroupID = new Array();
            var arrAll = new Array();
            var arrPrint = new Array();
            $('.selectCurrent').each(function () {
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
                if ($("#" + arrPrint[i] + "printAssess").length > 0) {
                    w.document.write($("#" + arrPrint[i] + "printAssess").html());
                    w.document.write('<div style="page-break-after: always">&nbsp;</div>')
                }
            }
            w.document.write('</body></html>');
            w.document.close();
        });
        $('#assign-work-many').click(function () {
            var arrGroupID = new Array();
            var arrAll = new Array();
            var arrAssign = new Array();
            $('.selectCurrent').each(function () {
                if (this.checked) {
                    arrGroupID.push($(this).val());
                }
                arrAll.push($(this).val());
            });
            if (arrGroupID.length == 0) {
                for (var i = 0; i < arrAll.length; i++) {
                    arrAssign[i] = arrAll[i];
                }
            } else {
                for (var i = 0; i < arrGroupID.length; i++) {
                    arrAssign[i] = arrGroupID[i];
                }
            }
            $('.groupIDAssign').val(arrAssign);
        });
    </script>
@endsection