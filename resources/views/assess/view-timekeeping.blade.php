@extends('home-user.index')
@section('title')
    {{'Kỳ tham gia'}}
@endsection
@section('user-content')
    <style>
        .align-assign {
            text-align: center;
        }
    </style>
    @if(session()->has('editSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('editSuccess')}}</div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <span class="name-page-profile">Kỳ thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="company-join" style="color: #333">
                <span class="company-register name-page-profile">Các kỳ tham gia</span>
                <span class="glyphicon glyphicon-menu-right small"></span>
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-heading align-assign">
                    @foreach($course as $c)
                        <h3 class="panel-title name-page-profile">Kỳ thực tập hiện tại</h3>
                        <span>(Bắt đầu {{date('d/m/Y',strtotime($c->from_date))}},
                            kết thúc {{date('d/m/Y',strtotime($c->to_date))}})</span>
                    @endforeach
                </div>
                <div class="panel-body">
                    <div style="text-align: center; font-size: 20px">
                        <span class="company-register"><b>BẢNG CHẤM CÔNG</b></span>
                    </div>
                    <div class="row time-keeping">
                        <form action="timekeeping-post" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="table-responsive" id="timekeeping">
                                <table class="table table-hover table-bordered" style="font-size: 12px">
                                    <thead>
                                    <tr>
                                        <th>Họ tên</th>
                                        <th colspan="31">Tháng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fromDate = "";
                                    $toDate = "";
                                    foreach ($course as $c) {
                                        $fromDate = $c->from_date;
                                        $toDate = $c->to_date;
                                    }
                                    $yearFromDate = date('Y', strtotime($fromDate));
                                    $yearToDate = date('Y', strtotime($toDate));
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
                                                                <td style="width: 100px">{{$as->name}}</td>
                                                                @for($j=1;$j<=29;$j++)
                                                                    <?php
                                                                    $checkDate = date('Y-m-d H:i:s', strtotime($yearFromDate . "-" . $i . "-" . $j))
                                                                    ?>
                                                                    @if(\App\Timekeeping::check($as->id,$ag->internship_course_id,$ag->company_id,$checkDate))
                                                                        <td><div>{{$j}}</div>
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td><div>{{$j}}</div>
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
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
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
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
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
                                                                        <td><div>{{$j}}</div>
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td><div>{{$j}}</div>
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
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
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
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearFromDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
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
                                                                            <td><div>{{$j}}</div>
                                                                            <input type="checkbox" checked="checked"
                                                                                   name="workDay[]"
                                                                                   class="check-timekeeping"
                                                                                   value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                        </td>
                                                                    @else
                                                                        <td><div>{{$j}}</div>
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
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox"
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
                                                                        <input type="checkbox" checked="checked"
                                                                               name="workDay[]"
                                                                               class="check-timekeeping"
                                                                               value="{{$yearToDate."-".$i."-".$j}}*{{$as->id}}*{{$ag->internship_course_id}}*{{$ag->company_id}}">
                                                                    </td>
                                                                @else
                                                                    <td><div>{{$j}}</div>
                                                                        <input type="checkbox"
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
                                                    @if($user)
                                                        {{$user->name}}
                                                    @endif
                                                </span>
                                </div>
                            </div>
                            <div class="row" style="text-align: center;">
                                <button type="submit" class="btn btn-primary" name="edit">Chỉnh sửa</button>
                                <button type="button" class="btn btn-primary print-timekeeping" name="edit"
                                        style="min-width: 90px">In file
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#company-join').addClass('menu-menu');
        $('a#company-join').css('color', '#000000');
        var btnPrintTimekeeping = $('.print-timekeeping');

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            btnPrintTimekeeping.on('click', function () {
                var current = $(this);
                printTimekeeping(current);
            });
        });

        function printTimekeeping(element) {
            var panel = element.parents('.panel.panel-default').find('.panel-body');
            var row = element.parents('.row');
            var param = {
                content: panel.html().replace(row.html(), ''),
                name: 'timekeeping'
            };
            console.log(panel.html().replace(row.html(), ''));

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
    </script>
@endsection