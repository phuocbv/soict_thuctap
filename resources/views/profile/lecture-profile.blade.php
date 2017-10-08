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
            <a href="lecture-profile" style="color: #333">
                <span class="name-page-profile">Xem thông tin cá nhân</span>
            </a>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
            @foreach($user as $u1)
                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#{{$u1->id}}">
                    <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
            @endforeach
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-3">
                <div class="thumbnail">
                    <img src="public/img/icon-teacher.png" class="img-responsive" alt="Image">
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div class="table-responsive">
                    @foreach($user as $u2)
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td style="width: 50%">Họ và tên:</td>
                                <td>{{$u2->name}}</td>
                            </tr>
                            <tr>
                                <td>Ngày sinh:</td>
                                <td>
                                    @if(date('Y',strtotime($u2->birthday))!=1970&&date('Y',strtotime($u2->birthday))!=-0001)
                                        {{date("d/m/Y",strtotime($u2->birthday))}}
                                    @endif
                                </td>
                            </tr>
                            <?php
                            $myUser = \App\MyUser::getUserFollowUserID($u2->user_id);
                            ?>
                            @foreach($myUser as $mu)
                                <tr>
                                    <td>Email:</td>
                                    <td>{{$mu->email}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Bộ môn:</td>
                                <td>{{$u2->address}}
                                </td>
                            </tr>
                            <tr>
                                <td>Điện thoại:</td>
                                <td>{{$u2->phone}}</td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @foreach($user as $u3)
        <div class="modal fade" id="{{$u3->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                        <form action="edit-lecture-profile" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{encrypt($u3->id)}}">

                            <div class="form-group">
                                <label for="">Số điện thoại</label>
                                <input type="number" name="phone" id="inputPhone" class="form-control"
                                       value="{{$u3->phone}}" min="0" max="99999999999" step="1" required="required">
                                <br>
                                <label for="">Ngày sinh</label>
                                @if(date('Y',strtotime($u3->birthday))!=1970&&date('Y',strtotime($u3->birthday))!=-0001)
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           value="{{date("Y-m-d",strtotime($u3->birthday))}}"
                                           required="required">
                                @else
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           required="required">
                                @endif
                                <label id="errorBirthday" style="color:#c0392b">Không đúng (giảng viên phải hơn 23
                                    tuổi)</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        $(document).ready(function () {
            $('#errorBirthday').hide();
            $('#lectureProfile').addClass('menu-menu');
            $('a#lectureProfile').css('color', '#000000');
            $('#birthday').change(function () {
                var data = $(this).val();
                var birthday = new Date(data);
                var currentDate = new Date();
                var yearBirthday = birthday.getFullYear().toString();
                var yearCurrent = currentDate.getFullYear().toString();
                if (parseInt(yearCurrent) - parseInt(yearBirthday) < 24) {
                    $('#errorBirthday').show();
                } else {
                    $('#errorBirthday').hide();
                }
            });
        });
    </script>
@endsection