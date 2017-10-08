@extends('home-user.index')
@section('title')
    {{'Đăng ký tham gia'}}
@endsection
@section('user-content')
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Khóa thực tập</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="company-register" style="color: #333">
            <span class="company-register name-page-profile">Đăng ký tham gia</span>
        </a>
    </div>
    @if(session()->has('companyRegisterSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('companyRegisterSuccess')}}</div>
    @endif
    @if(session()->has('companyRegisterError'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('companyRegisterError')}}
        </div>
    @endif
    @if(session()->has('companyEditRegisterSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('companyEditRegisterSuccess')}}</div>
    @endif
    @if(session()->has('companyDeleteRegisterSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('companyDeleteRegisterSuccess')}}</div>
    @endif
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="min-width: 132px">Tên khóa</th>
                        <th style="min-width: 107px">Ngày bắt đầu</th>
                        <th style="min-width: 111px">Ngày kết thúc</th>
                        <th style="min-width: 69px">Chỉ tiêu</th>
                        <th style="min-width: 107px">Tham gia</th>
                        <th style="min-width: 85px">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inCourse as $ic)
                        <tr>
                            <td>{{$ic->name}}</td>
                            <td>{{date('d-m-Y',strtotime($ic->from_date))}}</td>
                            <td>{{date('d-m-Y',strtotime($ic->to_date))}}</td>
                            <?php
                            $quantity = \App\CompanyInternShipCourse::getQuantity($companyID, $ic->id);
                            ?>
                            <td>{{$quantity}}</td>
                            <?php
                            $nowDate = date('Y-m-d');
                            $startRegister = date('Y-m-d', strtotime($ic->start_register));
                            $finishRegister = date('Y-m-d', strtotime($ic->finish_register));
                            $toDate = date('Y-m-d', strtotime($ic->to_date));
                            $nowTime = strtotime($nowDate);
                            $startTime = strtotime($startRegister);
                            $finishTime = strtotime($finishRegister);
                            $toTime = strtotime($toDate);
                            $time1970 = strtotime('1970-01-01');
                            ?>
                            @if(\App\CompanyInternShipCourse::checkCompanyInternShipCourse($companyID,$ic->id))
                                @if($startTime==$time1970||$nowTime<$startTime)
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                           data-target="#{{$ic->id}}{{'add'}}">
                                            <span>Tham gia</span>
                                        </a>
                                    </td>
                                    <td>không có</td>
                                @else
                                    <td>chưa tham gia</td>
                                    <td>không có</td>
                                @endif
                            @else
                                <td>
                                    <span>đã tham gia</span>
                                </td>
                                @if($startTime==$time1970||$nowTime<$startTime)
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                               data-target="#{{$ic->id}}{{'edit'}}">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                               data-target="#{{$ic->id}}{{'delete'}}">
                                                <span class="glyphicon glyphicon-remove-sign"></span>
                                            </a>
                                        </div>
                                    </td>
                                @else
                                    @if($nowTime<=$toTime)
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                                   data-target="#{{$ic->id}}{{'edit2'}}">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                            </div>
                                        </td>
                                    @else
                                        <td>không có</td>
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach($inCourse as $ic2)
        <?php
        $quantity = \App\CompanyInternShipCourse::getQuantity($companyID, $ic2->id);
        $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($companyID, $ic2->id);
        ?>
        <div class="modal fade" id="{{$ic2->id}}{{"add"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Tham gia khóa thực tập</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="company-register-form" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseIDAdd" value="{{encrypt($ic2->id)}}">
                                    <input type="hidden" name="companyIDAdd" value="{{encrypt($companyID)}}">

                                    <div class="form-group">
                                        <label>Người phụ trách thực tập</label>
                                        <input type="text" name="hrName" id="hrName" class="form-control"
                                               placeholder="họ tên người phụ trách">
                                        <label for="">Kỹ năng yêu cầu</label>
                                        <textarea name="requireSkillAdd" id="requireSkillAdd" class="form-control"
                                                  required="required" style="width: 100%;overflow: hidden"
                                                  onkeyup="textArea(this)">
                                        </textarea>
                                        <label for="">Chỉ tiêu</label>
                                        <input type="number" name="quantityAdd" id="quantityAdd" class="form-control"
                                               step="1" min="0" placeholder="số lượng sinh viên tiếp nhận">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                </form>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$ic2->id}}{{"edit"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa thông tin tham
                            gia</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="company-edit-register-form" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseIDEdit" value="{{encrypt($ic2->id)}}">
                                    <input type="hidden" name="companyIDEdit" value="{{encrypt($companyID)}}">

                                    <div class="form-group">
                                        @foreach($companyInCourse as $cic)
                                            <label>Người phụ trách thực tập</label>
                                            <input type="text" name="hrName" id="hrName" class="form-control"
                                                   placeholder="họ tên người phụ trách" value="{{$cic->hr_name}}">
                                            <label for="">Kỹ năng yêu cầu</label>
                                            <textarea name="requireSkillEdit" id="requireSkillEdit" class="form-control"
                                                      style="width: 100%;overflow: hidden;min-height: 150px"
                                                      onkeyup="textArea(this)">{{$cic->require_skill}}
                                            </textarea>
                                        @endforeach
                                        <label for="">Chỉ tiêu</label>
                                        <input type="number" name="quantityEdit" id="quantityEdit" class="form-control"
                                               step="1" min="0" value="{{$quantity}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                </form>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$ic2->id}}{{"edit2"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa thông tin tham
                            gia</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="company-edit-hrName" method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseIDEdit" value="{{encrypt($ic2->id)}}">
                                    <input type="hidden" name="companyIDEdit" value="{{encrypt($companyID)}}">

                                    <div class="form-group">
                                        @foreach($companyInCourse as $cic)
                                            <label>Người phụ trách thực tập</label>
                                            <input type="text" name="hrName" id="hrName" class="form-control"
                                                   placeholder="họ tên người phụ trách" value="{{$cic->hr_name}}">
                                            <label for="">Kỹ năng yêu cầu</label>
                                            <textarea name="requireSkillEdit" id="requireSkillEdit" class="form-control"
                                                      style="width: 100%;overflow: hidden;min-height: 150px" disabled="disabled">{{$cic->require_skill}}
                                            </textarea>
                                        @endforeach
                                        <label for="">Chỉ tiêu</label>
                                        <input type="number" name="quantityEdit" id="quantityEdit" class="form-control"
                                               step="1" min="0" value="{{$quantity}}" disabled="disabled">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                </form>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$ic2->id}}{{"delete"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa đăng ký
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="company-delete-register-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseIDDelete" value="{{encrypt($ic2->id)}}">
                                    <input type="hidden" name="companyIDDelete" value="{{encrypt($companyID)}}">
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
        </div>

    @endforeach
    <script>
        function textArea(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
        $(document).ready(function () {
            $('#companyRegister').addClass('menu-menu');
            $('a#companyRegister').css('color', '#000000');
        });
    </script>
@endsection