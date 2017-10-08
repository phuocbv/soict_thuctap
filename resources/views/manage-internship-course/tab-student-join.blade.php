<div role="tabpanel" class="tab-pane" id="student">
    <div class="table-responsive">
        <table id="table-student" class="table table-bordered">
            <thead>
            <tr>
                <th style="min-width: 95px">Mã sinh viên</th>
                <th style="min-width: 124px">Họ tên</th>
                <th style="min-width: 36px">Khóa</th>
                <th style="min-width: 207px">Email</th>
                <th style="min-width: 100px">Điện thoại</th>
                <th style="min-width: 98px">Thao tác</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th style="min-width: 95px">Mã sinh viên</th>
                <th style="min-width: 124px">Họ tên</th>
                <th style="min-width: 36px">Khóa</th>
                <th style="min-width: 207px">Email</th>
                <th style="min-width: 100px">Điện thoại</th>
                <th style="min-width: 98px">Thao tác</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($studentInCourse as $sic)
                <?php
                $student = \App\Student::getStudentFollowID($sic->student_id);
                ?>
                @foreach($student as $s)
                    <tr class="tr">
                        <td>
                            {{$s->msv}}
                        </td>
                        <td>{{$s->name}}</td>
                        <td>{{$s->grade}}</td>
                        <td>
                            <?php
                            $myUser = \App\MyUser::getUserFollowUserID($s->user_id);
                            ?>
                            @foreach($myUser as $mu)
                                {{$mu->email}}
                            @endforeach
                        </td>
                        <td>
                            {{$s->phone}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="btn btn-danger btn-sm"
                                   data-toggle="modal"
                                   data-target="#{{"stop-intern"}}{{$sic->id}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                                <a href="#" class="btn btn-primary btn-sm"
                                   data-toggle="modal"
                                   data-target="#{{"change-company"}}{{$sic->id}}">
                                    <span>Chuyển</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@foreach($studentInCourse as $sic)
    <?php
    $student = \App\Student::getStudentFollowID($sic->student_id);
    $group = \App\InternShipGroup::getGroupFollowSI($sic->student_id, $sic->internship_course_id);
    $listCompany = array();
    foreach ($group as $g) {
        $listCompany = \App\Company::getCompanyContain($g->company_id);
    }
    ?>
    @foreach($student as $s)
        <div class="modal fade" id="{{"stop-intern"}}{{$sic->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa sinh viên {{$s->name}} khỏi khóa thực tập
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="stop-intern" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseID" value="{{$courseID}}">
                                    <input type="hidden" name="studentID" value="{{$s->id}}">
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
        </div>{{--ket thuc modal giang vien dung quan lý thuc tap--}}
        <div class="modal fade" id="{{"change-company"}}{{$sic->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Chuyển công ty thực tập cho sinh viên {{$s->name}}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <label>Chọn công ty muốn vào thực tập</label>

                        <form action="change-company" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="courseID" value="{{encrypt($courseID)}}">
                            <input type="hidden" name="studentID" value="{{encrypt($s->id)}}">

                            <div class="panel panel-default">
                                <div class="table-responsive" style="height: 200px;overflow-y: auto">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 2%">#</th>
                                            <th style="width: 25%">Tên công ty</th>
                                            <th style="width: 25%">Mail liên lạc</th>
                                            <th style="width: 18%">Điện thoại</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listCompany as $lc)
                                            <tr>
                                                <td>
                                                    <input type="radio" name="companyID" id=""
                                                           value="{{encrypt($lc->id)}}" required="required">
                                                </td>
                                                <td>{{$lc->name}}</td>
                                                <td>{{$lc->hr_mail}}</td>
                                                <td>{{$lc->hr_phone}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Chuyển công ty</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal giang vien dung quan lý thuc tap--}}
    @endforeach
@endforeach
