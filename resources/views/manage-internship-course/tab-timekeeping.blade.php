<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title name-page-profile align-assign">Bảng chấm công</h3>
    </div>
    @foreach($course as $c)
        <div class="table-responsive student-assign">
            <table id="timekeeping" class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 14px"><input type="checkbox" name="selectAllTimekeeping" class="selectAllTimekeeping"></th>
                    <th style="min-width: 127px">Tên công ty</th>
                    <th style="min-width: 128px">Chấm công</th>
                </tr>
                </thead>
                <tfoot>

                <tr>
                    <th></th>
                    <th></th>
                    <th>
                        <a href="#" id="print-many-timekeeping">
                            <span class="glyphicon glyphicon-print"></span>
                        </a>
                    </th>
                </tr>
                </tfoot>
                <tbody>
                <?php
                $companyInCourse = \App\CompanyInternShipCourse::getCompanyInCourse($c->id);
                ?>
                @foreach($companyInCourse as $cic)
                    <?php
                    $company = \App\Company::getCompanyFollowID($cic->company_id);
                    $timekeeping = \App\Timekeeping::getFollowCourseIDCompanyID($cic->company_id, $cic->internship_course_id);
                    ?>
                    <tr>
                        <td><input type="checkbox" name="selectTimekeeping[]" value="{{$cic->id}}"
                                   class="selectTimekeeping">
                        </td>
                        <td>
                            @foreach($company as $com)
                                {{$com->name}}
                            @endforeach
                        </td>
                        @if(count($timekeeping)>0)
                            <td>
                                <a href="#" data-toggle="modal"
                                   data-target="#{{$cic->id}}{{"view-timekeeping"}}">
                                    {{'Xem file chấm công'}}
                                </a>
                            </td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <?php
        $fromDate = $c->from_date;
        $toDate = $c->to_date;
        $yearFromDate = date('Y', strtotime($fromDate));
        $yearToDate = date('Y', strtotime($toDate));
        ?>
        @foreach($companyInCourse as $cic)
            <?php
            $timekeeping = \App\Timekeeping::getFollowCourseIDCompanyID($cic->company_id, $cic->internship_course_id);
            $arrGroup = \App\InternShipGroup::getGroupFollowCI($cic->company_id, $cic->internship_course_id);
            $company = \App\Company::getCompanyFollowID($cic->company_id);
            ?>
            @if(count($timekeeping)>0)
                <div class="modal fade" id="{{$cic->id}}{{"view-timekeeping"}}" tabindex="-1" role="dialog"
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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" id="{{$cic->id}}timekeeping">
                                            <div style="text-align:center">
                                                <h3>BẢNG CHẤM CÔNG</h3>
                                            </div>
                                            <table class="table table-hover table-bordered"
                                                   style="font-size: 12px;margin-top: 20px">
                                                <thead>
                                                <tr>
                                                    <th>Họ tên</th>
                                                    <th colspan="31">Tháng</th>
                                                </tr>
                                                </thead>
                                                <tbody>
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
                                                                                        <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled" checked="checked"
                                                                                               name="workDay[]" class="check-timekeeping"
                                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled" name="workDay[]"
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
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" readonly
                                                                                               checked="checked"
                                                                                               name="workDay[]"
                                                                                               class="check-timekeeping"
                                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" readonly
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
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
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
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked" name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           name="workDay[]" class="check-timekeeping"
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
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               checked="checked" name="workDay[]" class="check-timekeeping"
                                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               name="workDay[]" class="check-timekeeping"
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
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               checked="checked" name="workDay[]" class="check-timekeeping"
                                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               name="workDay[]" class="check-timekeeping"
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
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked" name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
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
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
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
                                                                    @if(($yearToDate % 100 != 0) && ($yearToDate % 4 == 0) || ($yearToDate % 400 == 0))
                                                                        <tr>
                                                                            <td>{{$as->name}}</td>
                                                                            @for($j=1;$j<=29;$j++)
                                                                                <?php
                                                                                $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                                ?>
                                                                                @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               checked="checked"
                                                                                               name="workDay[]"
                                                                                               class="check-timekeeping"
                                                                                               value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
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
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
                                                                                               checked="checked"
                                                                                               name="workDay[]"
                                                                                               class="check-timekeeping"
                                                                                               value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                    </td>
                                                                                @else
                                                                                    <td><div>{{$j}}</div>
                                                                                        <input type="checkbox" disabled="disabled"
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
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
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
                                                                            $checkDate = date('Y-m-d H:i:s', strtotime($yearToDate . "-" . $i . "-" . $j));
                                                                            ?>
                                                                            @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           checked="checked"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @else
                                                                                <td><div>{{$j}}</div>
                                                                                    <input type="checkbox" disabled="disabled"
                                                                                           name="workDay[]"
                                                                                           class="check-timekeeping"
                                                                                           value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                                </td>
                                                                            @endif
                                                                        @endfor
                                                                    </tr>
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
                                                    @foreach($company as $c)
                                                        {{$c->name}}
                                                    @endforeach
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <div class="row" style="text-align: center">
                                    <button type="button" class="btn btn-primary print-timekeeping"
                                            name="print-assess" data-id="{{$cic->id}}">In file chấm công
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>{{--ket thuc modal xem nhan xet cong ty--}}
            @endif
        @endforeach
    @endforeach
</div>
<script>
    $('.selectAllTimekeeping').click(function () {
        if (this.checked) {
            $('.selectTimekeeping').each(function () {
                this.checked = true;
            });
        } else {
            $('.selectTimekeeping').each(function () {
                this.checked = false;
            });
        }
    });

    var tabTimekeeping = $('#tabTimekeeping');

    $(function () {
        tabTimekeeping.on('click', 'button.print-timekeeping', function () {
            var current = $(this);
            printKeeping(current);
        });
    });

    function printKeeping(element) {
        var content = element.parents('.modal-content').find('.modal-body');
        var param = {
            content: content.html(),
            name: 'timekeeping'
        };
        var ajax = $.ajax({
            url: '{{ route('setDataPrint') }}',
            type: 'POST',
            data: param
        });
        ajax.done(function (data) {
            var result = JSON.parse(data);
            if (result.status === 'success') {
                window.location = '{{ route('printReport') }}?type=landscape';
            } else if (result.status === 'error') {
                alert(result.messages);
            }
        });
        ajax.fail(function () {
            console.log("error");
        });
    }


    $('#print-many-timekeeping').click(function () {
        var arrCIC = new Array();
        var arrAll = new Array();
        var arrPrint = new Array();
        $('.selectTimekeeping').each(function () {
            if (this.checked) {
                arrCIC.push($(this).val());
            }
            arrAll.push($(this).val());
        });
        if (arrCIC.length == 0) {
            for (var i = 0; i < arrAll.length; i++) {
                arrPrint[i] = arrAll[i];
            }
        } else {
            for (var i = 0; i < arrCIC.length; i++) {
                arrPrint[i] = arrCIC[i];
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
            if ($("#" + arrPrint[i] + "timekeeping").length > 0) {
                w.document.write($("#" + arrPrint[i] + "timekeeping").html());
                w.document.write('<div style="page-break-after: always">&nbsp;</div>')
            }
        }
        w.document.write('</body></html>');
        w.document.close();
    });
</script>
