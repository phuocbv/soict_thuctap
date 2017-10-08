@extends('home-user.index')
@section('title')
    {{'Kế hoạch học tập'}}
@endsection
@section('user-content')
    @if(session()->has('addPlanError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('addPlanError')}}
        </div>
    @endif
    @if(session()->has('addPlanSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('addPlanSuccess')}}</div>
    @endif
    @if(session()->has('deleteSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteSuccess')}}</div>
    @endif
    @if(session()->has('deleteManySuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteManySuccess')}}</div>
    @endif
    @if(session()->has('editPlanSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('editPlanSuccess')}}</div>
    @endif
    @if(session()->has('editPlanError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('editPlanError')}}
        </div>
    @endif
    <style>
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-10 col-sm-9 col-md-10 col-lg-11">
            <span class="name-page-profile">Quản lý khóa thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="plan-learning" style="color: #333">
                <span class="company-register name-page-profile">Kế hoạch học tập</span>
            </a>
        </div>
        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-1">
            <a href="#" class="btn btn-default btn-sm" style="padding-left: 2px" data-toggle="modal"
               data-target="#addPlan">
                <span class="glyphicon glyphicon-plus-sign"></span> Thêm
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive" style="margin-top: 15px">
                <table id="myTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectAll" id="selectAll">
                        </th>
                        <th style="min-width: 117px">Năm học</th>
                        <th style="min-width: 162px">Ngày bắt đầu</th>
                        <th style="min-width: 162px">Ngày kết thúc</th>
                        <th style="min-width: 132px">Thao tác</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Năm học</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Thao tác</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($planLearning as $pl)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectPlan[]" class="select" value="{{$pl->id}}">
                            </td>
                            <td>
                                <a href="#" data-toggle="modal"
                                   data-target="#{{$pl->id}}{{"view"}}">
                                <span>
                                    {{date("Y",strtotime($pl->start))}}-{{date('Y',strtotime($pl->finish))}}
                                </span>
                                </a>
                            </td>
                            <td>{{date('d/m/Y',strtotime($pl->start))}}</td>
                            <td>{{date('d/m/Y',strtotime($pl->finish))}}</td>
                            <td>
                                <div class="btn-group">
                                    <?php
                                    $course = \App\InternShipCourse::getCourseFPlanID($pl->id);
                                    ?>
                                    @if(count($course)==0)
                                        <a href="#" data-toggle="modal" class="btn btn-success btn-sm"
                                           data-target="#{{$pl->id}}{{"edit"}}">
                                        <span class="glyphicon glyphicon-edit">
                                        </span>
                                        </a>
                                        <a href="#" data-toggle="modal" class="btn btn-danger btn-sm"
                                           data-target="#{{$pl->id}}{{"delete"}}">
                                        <span class="glyphicon glyphicon-remove-sign">
                                        </span>
                                        </a>
                                    @else
                                        <a href="#" data-toggle="modal" class="btn btn-success btn-sm edit">
                                        <span class="glyphicon glyphicon-edit">
                                        </span>
                                        </a>
                                        <a href="#" data-toggle="modal" class="btn btn-danger btn-sm delete">
                                        <span class="glyphicon glyphicon-remove-sign">
                                        </span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="#" class="btn btn-danger" data-toggle="modal"
                   data-target="#deleteMany" style="margin-bottom: 20px;margin-top: -15px">
                    <span class="">Xóa kế hoạch</span>
                </a>
            </div>
        </div>
    </div>

    <div class="modal fade " id="addPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         data-keyboard="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tạo kế hoạch năm học</h4>
                </div>
                <div class="modal-body">
                    <form action="add-plan-learning" method="POST" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Ngày bắt đầu năm học</label>
                                <input type="date" name="start" id="start" class="form-control"
                                       value="" required="required">
                                <label id="errorStart" style="color:#c0392b">Năm học bắt đấu từ tháng 8</label>
                                <br>
                                <label for="">Ngày bắt đầu kỳ 1</label>
                                <input type="date" name="startTerm1" id="startTerm1" class="form-control"
                                       value="" required="required" readonly="readonly">
                                <br>
                                <label for="">Ngày bắt đầu kỳ 2</label>
                                <input type="date" name="startTerm2" id="startTerm2" class="form-control"
                                       value="" required="required">
                                <label id="errorStartTerm2" style="color:#c0392b">Ngày kết thúc phải lớn hơn ngày
                                    kết thúc kỳ 1
                                    đầu</label>
                                <br>
                                <label for="">Ngày bắt đầu kỳ 3</label>
                                <input type="date" name="startTerm3" id="startTerm3" class="form-control"
                                       value="" required="required">
                                <label id="errorStartTerm31" style="color:#c0392b">Ngày bắt đầu phải lớn hơn ngày kết
                                    thúc kỳ 2</label>
                                <label id="errorStartTerm32" style="color:#c0392b">Ngày kết thúc phải nhỏ hơn
                                    năm</label>
                                <br>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">Ngày kết thúc năm học</label>
                                    <input type="date" name="finish" id="finish" class="form-control"
                                           value="" required="required">
                                    <label id="errorFinish" style="color:#c0392b">Năm học kết thúc vào tháng 7</label>
                                    <label id="errorFinish1" style="color:#c0392b">Ngày kết thúc phải lớn hơn ngày bắt
                                        đầu</label>
                                    <label id="errorFinish2" style="color:#c0392b">Năm học kéo dài trong 2 năm</label>
                                    <br>
                                    <label for="">Ngày kết thúc kỳ 1</label>
                                    <input type="date" name="finishTerm1" id="finishTerm1" class="form-control"
                                           value="" required="required">
                                    <label id="errorFinishTerm11" style="color:#c0392b">Ngày kết thúc phải lớn hơn ngày
                                        bắt
                                        đầu</label>
                                    <br>
                                    <label for="">Ngày kết thúc kỳ 2</label>
                                    <input type="date" name="finishTerm2" id="finishTerm2" class="form-control"
                                           value="" required="required">
                                    <label id="errorFinishTerm2" style="color:#c0392b">Ngày kết thúc phải lớn hơn ngày
                                        bắt</label>
                                    <br>
                                    <label for="">Ngày kết thúc kỳ 3</label>
                                    <input type="date" name="finishTerm3" id="finishTerm3" class="form-control"
                                           value="" required="required" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Thêm kế hoạch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($planLearning as $pl)
        {{--modal xem chi tiet--}}
        <div class="modal fade " id="{{$pl->id}}{{"view"}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Kế hoạch học tập năm
                            học {{date("Y",strtotime($pl->start))}}-{{date('Y',strtotime($pl->finish))}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="margin-top: -16px">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td style="width: 225px">Thời điểm bắt đầu năm học:</td>
                                    <td>{{date('d/m/y',strtotime($pl->start))}}</td>
                                    <td style="width: 197px">Thời điểm kết thúc năm học:</td>
                                    <td>{{date('d/m/y',strtotime($pl->finish))}}</td>
                                </tr>
                                <tr>
                                    <td>Thời điểm bắt đầu học kỳ {{date('Y',strtotime($pl->start_term1))}}1:</td>
                                    <td>{{date('d/m/y',strtotime($pl->start_term1))}}</td>
                                    <td>Thời kết thúc học kỳ {{date('Y',strtotime($pl->finish_term1))}}1:</td>
                                    <td>{{date('d/m/y',strtotime($pl->finish_term1))}}</td>
                                </tr>
                                <tr>
                                    <td>Thời điểm bắt đầu học kỳ {{date('Y',strtotime($pl->start_term1))}}2:</td>
                                    <td>{{date('d/m/y',strtotime($pl->start_term2))}}</td>
                                    <td>Thời kết thúc học kỳ {{date('Y',strtotime($pl->finish_term1))}}2:</td>
                                    <td>{{date('d/m/y',strtotime($pl->finish_term2))}}</td>
                                </tr>
                                <tr>
                                    <td>Thời điểm bắt đầu học kỳ {{date('Y',strtotime($pl->start_term1))}}3:</td>
                                    <td>{{date('d/m/y',strtotime($pl->start_term3))}}</td>
                                    <td>Thời kết thúc học kỳ {{date('Y',strtotime($pl->finish_term1))}}3:</td>
                                    <td>{{date('d/m/y',strtotime($pl->finish_term3))}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal xem chi tiet--}}
        <div class="modal fade" id="{{$pl->id}}{{"delete"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa kế hoạch học tập năm học {{date("Y",strtotime($pl->start))}}
                            -{{date('Y',strtotime($pl->finish))}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-plan-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="planID" value="{{$pl->id}}">
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
        </div>{{--ket thuc modal xoa sinh vien--}}
        <div class="modal fade" id="{{$pl->id}}{{"edit"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Chỉnh sửa kế hoạch học tập năm học: {{date("Y",strtotime($pl->start))}}
                            -{{date('Y',strtotime($pl->finish))}}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="edit-plan-learning" method="POST" role="form" id="{{$pl->id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="planID" value="{{encrypt($pl->id)}}">

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <label for="">Ngày bắt đầu năm học</label>
                                    <input type="date" name="start" id="start{{$pl->id}}" class="form-control start"
                                           data-id="{{$pl->id}}"
                                           value="{{date('Y-m-d',strtotime($pl->start))}}" required="required">
                                    <label id="errorStart{{$pl->id}}" style="color:#c0392b" hidden="hidden">Bắt đầu năm
                                        học
                                        là tháng 8</label>
                                    <br>
                                    <label for="">Ngày bắt đầu kỳ 1</label>
                                    <input type="date" name="startTerm1" id="startTerm1{{$pl->id}}" class="form-control"
                                           value="{{date('Y-m-d',strtotime($pl->start_term1))}}" required="required"
                                           readonly="readonly">
                                    <br>
                                    <label for="">Ngày bắt đầu kỳ 2</label>
                                    <input type="date" name="startTerm2" id="startTerm2{{$pl->id}}"
                                           class="form-control startTerm2" data-id="{{$pl->id}}"
                                           value="{{date('Y-m-d',strtotime($pl->start_term2))}}" required="required">
                                    <label id="errorStartTerm2{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                        kết thúc phải lớn
                                        hơn ngày
                                        kết thúc kỳ 1
                                        đầu</label>
                                    <br>
                                    <label for="">Ngày bắt đầu kỳ 3</label>
                                    <input type="date" name="startTerm3" id="startTerm3{{$pl->id}}"
                                           class="form-control startTerm3" data-id="{{$pl->id}}"
                                           value="{{date('Y-m-d',strtotime($pl->start_term3))}}" required="required">
                                    <label id="errorStartTerm31{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                        bắt đầu phải lớn
                                        hơn ngày
                                        kết
                                        thúc kỳ 2</label>
                                    <label id="errorStartTerm32{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                        kết thúc phải nhỏ
                                        hơn
                                        năm</label>
                                    <br>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="">Ngày kết thúc năm học</label>
                                        <input type="date" name="finish" id="finish{{$pl->id}}"
                                               class="form-control finish" data-id="{{$pl->id}}"
                                               value="{{date('Y-m-d',strtotime($pl->finish))}}" required="required">
                                        <label id="errorFinish{{$pl->id}}" style="color:#c0392b" hidden="hidden">Kết
                                            thúc năm
                                            học là tháng 7</label>
                                        <label id="errorFinish1{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                            kết thúc phải lớn hơn ngày
                                            bắt
                                            đầu</label>
                                        <label id="errorFinish2{{$pl->id}}" style="color:#c0392b" hidden="hidden">Năm
                                            học kéo dài trong 2
                                            năm</label>
                                        <br>
                                        <label for="">Ngày kết thúc kỳ 1</label>
                                        <input type="date" name="finishTerm1" id="finishTerm1{{$pl->id}}"
                                               class="form-control finishTerm1" data-id="{{$pl->id}}"
                                               value="{{date('Y-m-d',strtotime($pl->finish_term1))}}"
                                               required="required">
                                        <label id="errorFinishTerm11{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                            kết thúc
                                            phải lớn hơn
                                            ngày
                                            bắt
                                            đầu</label>
                                        <br>
                                        <label for="">Ngày kết thúc kỳ 2</label>
                                        <input type="date" name="finishTerm2" id="finishTerm2{{$pl->id}}"
                                               class="form-control finishTerm2" data-id="{{$pl->id}}"
                                               value="{{date('Y-m-d',strtotime($pl->finish_term2))}}"
                                               required="required">
                                        <label id="errorFinishTerm2{{$pl->id}}" style="color:#c0392b" hidden="hidden">Ngày
                                            kết thúc phải
                                            lớn hơn
                                            ngày
                                            bắt</label>
                                        <br>
                                        <label for="">Ngày kết thúc kỳ 3</label>
                                        <input type="date" name="finishTerm3" id="finishTerm3{{$pl->id}}"
                                               class="form-control finishTerm3"
                                               value="{{date('Y-m-d',strtotime($pl->finish_term3))}}"
                                               required="required" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="text-align: center">
                                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal xoa sinh vien--}}
    @endforeach
    <div class="modal fade" id="{{"deleteMany"}}" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                        Bạn thực sự muốn xóa các kế hoạch học tập đã chọn
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <form action="delete-manyPlan-form" method="POST" role="form"
                                  style="text-align: center">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="planClass" value="" class="planClass">
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
    </div>{{--ket thuc modal xoa sinh vien--}}
    <script>
        $(document).ready(function () {
            $('#errorFinish1').hide();
            $('#errorFinish2').hide();
            $('#errorFinishTerm11').hide();
            $('#errorStartTerm2').hide();
            $('#errorFinishTerm2').hide();
            $('#errorStartTerm31').hide();
            $('#errorStartTerm32').hide();
            $('#errorStart').hide();
            $('#errorFinish').hide();
            $('#plan-learning').addClass('menu-menu');
            $('a#plan-learning').css('color', '#000000');
            $('#start').change(function () {
                var start = new Date($(this).val());
                var month = start.getMonth();
                if (month + 1 != 8) {
                    $('#errorStart').show();
                } else {
                    $('#errorStart').hide();
                }
                $('#startTerm1').val($(this).val());
            });
            $('#finish').change(function () {
                var finish = new Date($(this).val());
                var start = new Date($('#start').val());
                if (finish.getTime() > start.getTime() && finish.getFullYear() - start.getFullYear() == 1) {
                    $('#finishTerm3').val($(this).val());
                    $('#errorFinish1').hide();
                    $('#errorFinish2').hide();
                } else {
                    if (finish.getTime() < start.getTime()) {
                        $('#errorFinish1').show();
                        $('#errorFinish2').hide();
                    } else if (finish.getFullYear() - start.getFullYear() != 1) {
                        $('#errorFinish1').hide();
                        $('#errorFinish2').show();
                    }
                }
                if (finish.getMonth() + 1 != 7) {
                    $('#errorFinish').show();
                } else {
                    $('#errorFinish').hide();
                }
            });
            $('#finishTerm1').change(function () {
                var finishTerm1 = new Date($(this).val());
                var startTerm1 = new Date($('#startTerm1').val());
                if (finishTerm1.getTime() > startTerm1.getTime()) {
                    $('#errorFinishTerm11').hide();
                } else {
                    $('#errorFinishTerm11').show();
                }
            });
            $('#startTerm2').change(function () {
                var finishTerm1 = new Date($('#finishTerm1').val());
                var startTerm2 = new Date($(this).val());
                if (startTerm2.getTime() < finishTerm1.getTime()) {
                    $('#errorStartTerm2').show();
                } else {
                    $('#errorStartTerm2').hide();
                }
            });
            $('#finishTerm2').change(function () {
                var startTerm2 = new Date($('#startTerm2').val());
                var finishTerm2 = new Date($(this).val());
                if (finishTerm2.getTime() < startTerm2.getTime()) {
                    $('#errorFinishTerm2').show();
                } else {
                    $('#errorFinishTerm2').hide();
                }
            });
            $('#startTerm3').change(function () {
                var startTerm3 = new Date($(this).val());
                var finishTerm2 = new Date($('#finishTerm2').val());
                if (finishTerm2.getTime() < startTerm3.getTime()) {
                    $('#errorStartTerm31').hide();
                } else {
                    $('#errorStartTerm31').show();
                }
            });
        });
        $('#myTable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "order": [[2, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": 0},
                {"orderable": false, "targets": 3},
                {"orderable": false, "targets": 1},
                {"orderable": false, "targets": 4},
            ]
        });
        $('#selectAll').click(function () {
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
        $('#deleteMany').click(function () {
            var arrPlan = new Array();
            $('.select').each(function () {
                if (this.checked) {
                    arrPlan.push($(this).val());
                }
            });
            $('.planClass').val(arrPlan);
        });
        $('.edit').click(function () {
            alert('Đã tạo khóa học cho năm học này nên không sửa được kế hoạch học tập');
        });
        $('.delete').click(function () {
            alert('Vẫn tồn tại khóa học của năm học này nên không xóa được kế hoạch học tập');
        });
        $('.start').change(function () {
            var planID = $(this).attr('data-id');
            var start = new Date($("#" + "start" + planID).val());
            if (start.getMonth() + 1 != 8) {
                $("#" + "errorStart" + planID).show();
            } else {
                $("#" + "errorStart" + planID).hide();
            }
            $("#" + "startTerm1" + planID).val($("#" + "start" + planID).val());
        });
        $('.finish').change(function () {
            var planID = $(this).attr('data-id');
            var finish = new Date($("#" + "finish" + planID).val());
            var start = new Date($("#" + "start" + planID).val());
            if (finish.getTime() > start.getTime() && finish.getFullYear() - start.getFullYear() == 1) {
                $("#" + "finishTerm3" + planID).val($(this).val());
                $("#" + "errorFinish1" + planID).hide();
                $("#" + "errorFinish2" + planID).hide();
            } else {
                if (finish.getTime() < start.getTime()) {
                    $("#" + "errorFinish1" + planID).show();
                    $("#" + "errorFinish2" + planID).hide();
                } else if (finish.getFullYear() - start.getFullYear() != 1) {
                    $("#" + "errorFinish1" + planID).hide();
                    $("#" + "errorFinish2" + planID).show();
                }
            }
            if (finish.getMonth() + 1 != 7) {
                $("#" + "errorFinish" + planID).show();
            } else {
                $("#" + "errorFinish" + planID).hide();
            }
        });
        $('.finishTerm1').change(function () {
            var planID = $(this).attr('data-id');
            var finishTerm1 = new Date($("#" + "finishTerm1" + planID).val());
            var startTerm1 = new Date($("#" + "startTerm1" + planID).val());
            if (finishTerm1.getTime() > startTerm1.getTime()) {
                $("#" + "errorFinishTerm11" + planID).hide();
            } else {
                $("#" + "errorFinishTerm11" + planID).show();
            }
        });
        $('.startTerm2').change(function () {
            var planID = $(this).attr('data-id');
            var finishTerm1 = new Date($("#" + "finishTerm1" + planID).val());
            var startTerm2 = new Date($("#" + "startTerm2" + planID).val());
            if (startTerm2.getTime() < finishTerm1.getTime()) {
                $("#" + "errorStartTerm2" + planID).show();
            } else {
                $("#" + "errorStartTerm2" + planID).hide();
            }
        });
        $('.finishTerm2').change(function () {
            var planID = $(this).attr('data-id');
            var startTerm2 = new Date($("#" + "startTerm2" + planID).val());
            var finishTerm2 = new Date($("#" + "finishTerm2" + planID).val());
            if (finishTerm2.getTime() < startTerm2.getTime()) {
                $("#" + "errorFinishTerm2" + planID).show();
            } else {
                $("#" + "errorFinishTerm2" + planID).hide();
            }
        });
        $('.startTerm3').change(function () {
            var planID = $(this).attr('data-id');
            var startTerm3 = new Date($("#" + "startTerm3" + planID).val());
            var finishTerm2 = new Date($("#" + "finishTerm2" + planID).val());
            if (finishTerm2.getTime() < startTerm3.getTime()) {
                $("#" + "errorStartTerm31" + planID).hide();
            } else {
                $("#" + "errorStartTerm31" + planID).show();
            }
        });
    </script>
@endsection