@extends('home-user.index')
@section('title')
    {{'Thông tin cá nhân'}}
@endsection
@section('user-content')
    @if(session()->has('errorPhone'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorPhone')}}
        </div>
    @endif
    @if(session()->has('errorBirthday'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorBirthday')}}
        </div>
    @endif
    @if(session()->has('updateSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateSuccess')}}</div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
            <span class="name-page-profile">Thông tin cá nhân</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="student-profile" style="color: #333">
                <span class="name-page-profile">Xem thông tin cá nhân</span>
            </a>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
            @if (isset($user))
                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#{{$user->id}}">
                    <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
            @endif
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-3">
                <div class="thumbnail">
                    <img src="public/img/icon-user.png" class="img-responsive" alt="Image">
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div class="table-responsive">
                    @if(isset($user))
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td style="width: 50%">Mã sinh viên:</td>
                                <td>{{$user->msv}}</td>
                            </tr>
                            <tr>
                                <td>Họ và tên:</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td>Khóa:</td>
                                <td>{{$user->grade}}</td>
                            </tr>
                            <tr>
                                <td>Hệ đào tạo:</td>
                                <td>
                                    {{$user->program_university}}
                                </td>
                            </tr>
                            <tr>
                                <td>Tiếng anh:</td>
                                <td>{{$user->english}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{$user->user->email}}</td>
                            </tr>
                            <tr>
                                <td>Điện thoại:</td>
                                <td>{{$user->phone}}</td>
                            </tr>
                            <tr>
                                <td>Ngày sinh:</td>
                                <td>
                                    @if(date('Y',strtotime($user->birthday))!=1970&&date('Y',strtotime($user->birthday))!=-0001)
                                        {{date("d/m/Y",strtotime($user->birthday))}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Kỹ năng lập trình:</td>
                                <td>{{$user->programing_skill}}
                                </td>
                            </tr>
                            <tr>
                                <td>Kỹ năng lập trình tốt nhất:</td>
                                <td>{{$user->programing_skill_best}}</td>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (isset($user))
        <div class="modal fade" id="{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa thông tin cá
                            nhân</h4>
                    </div>
                    <div class="modal-body">
                        <form action="edit-student-profile" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{encrypt($user->id)}}">

                            <div class="form-group">
                                <label for="">Tiếng anh</label>
                                <input type="text" class="form-control" name="english" value="{{$user->english}}"
                                       required="required" maxlength="11">
                                <br>
                                <label for="">Số điện thoại</label>
                                <input type="number" name="phone" id="inputPhone" class="form-control"
                                       value="{{$user->phone}}" min="0" max="99999999999" step="1" required="required">
                                <br>
                                <label for="">Ngày sinh</label>
                                @if(date('Y',strtotime($user->birthday))!=1970&&date('Y',strtotime($user->birthday))!=-0001)
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           value="{{date("Y-m-d",strtotime($user->birthday))}}"
                                           required="required">
                                @else
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           required="required">
                                @endif
                                <label id="errorBirthday" style="color:#c0392b">Không đúng (sinh viên phải hơn 18
                                    tuổi)</label>
                                <br>
                                <label for="">Kỹ năng lập trình</label>
                                <input type="text" class="form-control" name="programingSkill"
                                       value="{{$user->programing_skill}}" maxlength="255" required="required">
                                <br>
                                <label for="">Kỹ năng lập trình tốt nhất</label>
                                <input type="text" class="form-control" name="programingSkillBest"
                                       value="{{$user->programing_skill_best}}" maxlength="255" required="required">
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function () {
            $('#errorBirthday').hide();
            $('#studentProfile').addClass('menu-menu');
            $('a#studentProfile').css('color', '#000000');
            $('#birthday').change(function () {
                var data = $(this).val();
                var birthday = new Date(data);
                var currentDate = new Date();
                var yearBirthday = birthday.getFullYear().toString();
                var yearCurrent = currentDate.getFullYear().toString();
                if (parseInt(yearCurrent) - parseInt(yearBirthday) < 18) {
                    $('#errorBirthday').show();
                } else {
                    $('#errorBirthday').hide();
                }
            });
        });
    </script>
@endsection