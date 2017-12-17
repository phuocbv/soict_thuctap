<div class="panel panel-default tab-lecture-access">
    <div class="panel-heading">
        <h3 class="panel-title name-page-profile align-assign">Bảng nhận xét chung của mỗi giảng viên</h3>
    </div>
    @foreach($course as $c)
        <div class="table-responsive student-assign">
            <table id="lecture-assess" class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 14px"><input type="checkbox" name="selectAllLecture" class="selectAllLecture"></th>
                    <th style="min-width: 127px">Họ và tên giảng viên</th>
                    <th style="min-width: 128px">Xem nhận xét chung</th>
                    <th style="min-width: 128px"></th>
                </tr>
                </thead>
                <tfoot>

                <tr>
                    <th></th>
                    <th></th>
                    <th>
                        <a href="#" id="print-many">
                            <span class="glyphicon glyphicon-print"></span>
                        </a>
                    </th>
                    <th style="min-width: 128px"></th>
                </tr>
                </tfoot>
                <tbody>
                <?php
                $lectureInCourse = \App\LectureInternShipCourse::getLectureInCourse($c->id);
                ?>
                @foreach($lectureInCourse as $lic)
                    <?php
                    $lecture = \App\Lecture::getLectureFollowID($lic->lecture_id);
                    $lectureReport = \App\LectureReport::get($lic->id);
                    ?>
                    <tr>
                        <td><input type="checkbox" name="selectLecture[]" value="{{$lic->id}}" class="selectLecture">
                        </td>
                        <td>
                            @foreach($lecture as $l)
                                {{$l->name}}
                            @endforeach
                        </td>
                        @if(count($lectureReport)>0)
                            <td>
                                <a href="#" data-toggle="modal"
                                   data-target="#{{$lic->id}}{{"view-assessGeneral"}}">
                                    {{'Xem nhận xét chung'}}
                                </a>
                            </td>
                        @else
                            <td></td>
                        @endif
                        <td>
                            <a href="javascript:void(0)"
                                class="btn btn-success btn-sm error-edit-time commentOfLecture"
                                data-lecture-in-course="{{ $lic->id }}">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @foreach($lectureInCourse as $lic)
            <?php
            $lecture = \App\Lecture::getLectureFollowID($lic->lecture_id);
            $lectureReport = \App\LectureReport::get($lic->id);
            $group = \App\InternShipGroup::getGroupFollowLI($lic->lecture_id, $lic->internship_course_id);
            ?>
            @if(count($lectureReport)>0)
                <div class="modal fade" id="{{$lic->id}}{{'view-assessGeneral'}}" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                                    Giảng viên viết nhận xétchung
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row view-assess">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"
                                         id="lecture-write-report">
                                        <div class="row" id="{{$lic->id}}{{'print-assess'}}">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center;font-weight: bold">

                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 style-form"
                                                 style="text-align: center;font-weight: bold">
                                            </div>
                                            <table width="100%" style="border: hidden">
                                                <tbody>
                                                    <tr style="text-align: center">
                                                        <td width="50%" style="border: hidden">
                                                            <div>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</div>
                                                            <div>VIỆN CÔNG NGHỆ THÔNG TIN  VÀ TRUYỀN THÔNG</div>
                                                            <div>––––––––––––</div>
                                                        </td>
                                                        <td width="50%" style="padding-top: 10px; border: hidden">
                                                            <div>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                                                            <div>Độc Lập – Tự do – Hạnh phúc</div>
                                                            <div>––––––––––––––––––––––––––––</div>
                                                            @foreach($lectureReport as $lr)
                                                                Hà Nội, ngày {{date('d',strtotime($lr->date_report))}}
                                                                tháng {{date('m',strtotime($lr->date_report))}}
                                                                năm {{date('Y',strtotime($lr->date_report))}}
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                                    {{date('d/m/Y',strtotime($c->from_date))}}
                                                    đến ngày
                                                    {{date('d/m/Y',strtotime($c->to_date))}}
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
                                                @foreach($lecture as $l)
                                                    {{$l->name}}
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                             style="text-align: center">
                                            <hr>
                                            <button type="button" class="btn btn-primary print-assess"
                                                    data-id="{{$lic->id}}">
                                                In Nhận xét chung
                                            </button>
                                            {{--<a href="{{ route('admin.printCommentOfLecture', ['licId' => $lic->id]) }}"--}}
                                                {{--class="btn btn-primary">In Nhận xét chung</a>--}}
                                        </div>
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
    @endforeach
</div>

<div class="modal fade" role="dialog" id="lectureInCourse">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: bold">Báo cáo của giảng viên</h4>
            </div>
            <div class="modal-body">
                <div id="showLectureInCourse"></div>
            </div>
        </div>
    </div>
</div>

<script>
    /*$('.print-assess').click(function () {
        //var licID = $(this).attr('data-id');
        var licId = $(this).data('id');console.log(licId);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        /!*var w = window.open('', 'printwindow');
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
        w.document.write($("#" + licID + "print-assess").html());
        w.document.write('</body></html>');
        w.document.close();*!/
        $.ajax({
            url: '',
            type: 'GET',
            data: {licId: licId},
        })
        .done(function(data) {
            console.log("success");
            console.log(data);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    });*/
    $('.selectAllLecture').click(function () {
        if (this.checked) {
            $('.selectLecture').each(function () {
                this.checked = true;
            });
        } else {
            $('.selectLecture').each(function () {
                this.checked = false;
            });
        }
    });
    $('#print-many').click(function () {
        var arrLIC = new Array();
        var arrAll = new Array();
        var arrPrint = new Array();
        $('.selectLecture').each(function () {
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
            if ($("#" + arrPrint[i] + "print-assess").length > 0) {
                w.document.write($("#" + arrPrint[i] + "print-assess").html());
                w.document.write('<div style="page-break-after: always">&nbsp;</div>')
            }
        }
        w.document.write('</body></html>');
        w.document.close();
    });

    var commentOfLecture = $('.btn.commentOfLecture');
    var lectureInCourse = $('#lectureInCourse');
    var showLectureInCourse = $('#showLectureInCourse');

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        commentOfLecture.on('click', function () {
            var lectureInCourseId = $(this).data('lecture-in-course');
            showListLectureManageStudent(lectureInCourseId);
        });

        $('#lectureInCourse').on('click', '.print-lecture-in-course', function () {
            var current = $(this);
            var param = {
                lectureId: current.data('lecture-id'),
                internshipCourseId: current.data('internship-course-id'),
                courseTerm: current.data('course-term'),
                companyId: current.data('company-id')
            };
            console.log(param);
            printLectureInCourse(param);
        });

        $('.tab-lecture-access').on('click', '.print-assess', function () {
            var current = $(this);
            var body = current.parents('.modal-body').html();
            var btn = current.parents('.col-xs-12.col-sm-12.col-md-12.col-lg-12').html();
            var param = {
                content: body.replace(btn, ''),
                name: 'lectureInCourse'
            };
            printLectureAccess(param);
        });
    });

    function showListLectureManageStudent(lectureInCourseId) {
        var ajax = $.ajax({
            url: '{{ route('admin.lectureInCourseController.showListLectureManageStudent') }}',
            type: 'GET',
            data: {lectureInCourseId: lectureInCourseId},
        });
        ajax.done(function(data) {
            console.log(data);
            showLectureInCourse.html(data);
            lectureInCourse.modal();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function printLectureInCourse(param) {
        var ajax = $.ajax({
            url: '{{ route('setDataPrint') }}',
            type: 'POST',
            data: {
                content: param
            }
        });
        ajax.done(function(data) {
            var result = JSON.parse(data);
            if (result.status === 'success') {
                window.location.href = '{{ route('print.printLectureInCourse') }}';
            }
            if (result.status === 'error') {
                alert(result.messages);
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
    
    function printLectureAccess(param) {
        var ajax = $.ajax({
            url: '{{ route('setDataPrint') }}',
            type: 'POST',
            data: param
        });
        ajax.done(function(data) {
            var result = JSON.parse(data);
            if (result.status === 'success') {
                window.location.href = '{{ route('printReport') }}';
            }
            if (result.status === 'error') {
                alert(result.messages);
            }
        });
    }
</script>
