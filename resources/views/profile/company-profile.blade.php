@extends('home-user.index')
@section('title')
    {{'Thông tin công ty'}}
@endsection
@section('user-content')
    @if(session()->has('errorPhone'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorPhone')}}
        </div>
    @endif
    @if(session()->has('errorSum'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>Lỗi: </strong>{{session()->get('errorSum')}}
        </div>
    @endif
    @if(session()->has('updateSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateSuccess')}}</div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
            <span class="name-page-profile">Thông tin công ty</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="company-profile" style="color: #333">
                <span class="name-page-profile">Xem thông tin công ty</span>
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
                    @foreach($user as $userImg)
                        <img src="public/{{$userImg->logo}}" class="img-responsive" alt="Image">
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div class="table-responsive">
                    @foreach($user as $u2)
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td style="width: 50%">Tên công ty:</td>
                                <td>{{$u2->name}}</td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td>{{$u2->address}}</td>
                            </tr>
                            <tr>
                                <td>Ngày Thành lập:</td>
                                <td>
                                    @if(date('Y',strtotime($u2->birthday))!=1970&&date('Y',strtotime($u2->birthday))!=-0001)
                                        {{date("d/m/Y",strtotime($u2->birthday))}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Mail tuyển dụng:</td>
                                <td>{{$u2->hr_mail}}</td>
                            </tr>
                            <tr>
                                <td>Điện thoại tuyển dụng:</td>
                                <td>{{$u2->hr_phone}}</td>
                            </tr>
                            <tr>
                                <td>Mô tả công ty:</td>
                                <td>
                                    {!! nl2br(e(trim($u2->description))) !!}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @foreach($user as $u3)
        <div class="modal fade" id="{{$u3->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa thông tin công
                            ty</h4>
                    </div>
                    <div class="modal-body">
                        <form action="edit-company-profile" method="POST" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{encrypt($u3->id)}}">

                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{$u3->address}}"
                                       required="required">
                                <br>
                                <label for="">Ngày thành lập</label>
                                @if(date('Y',strtotime($u3->birthday))!=1970&&date('Y',strtotime($u3->birthday))!=-0001)
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           value="{{date("Y-m-d",strtotime($u3->birthday))}}"
                                           required="required">
                                @else
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           required="required">
                                @endif
                                <label id="errorBirthday" style="color:#c0392b">Không đúng (Công ty chưa thành
                                    lập)</label>
                                <br>
                                <label for="">Mail tuyển dụng</label>
                                <input type="email" class="form-control" name="email" value="{{$u3->hr_mail}}"
                                       required="required">
                                <br>
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{$u3->hr_phone}}" required="required">
                                <br>
                                <label for="">Logo</label>
                                <input type="file" name="logo" id="logoFile" style="width: 100%" accept="image/*">
                                <label>Mô tả ngắn gọn</label>
                                <textarea name="description" id="description" class="form-control"
                                          style="width: 100%;overflow: hidden;min-height: 150px"
                                          onkeyup="textArea(this)">{{trim($u3->description)}}
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </form>
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
            $('#errorBirthday').hide();
            $('#companyProfile').addClass('menu-menu');
            $('a#companyProfile').css('color', '#000000');
            $('#birthday').change(function () {
                var data = $(this).val();
                var birthday = new Date(data);
                var currentDate = new Date();
                var timeBirthday = birthday.getTime();
                var timeCurrentDate = currentDate.getTime();
                if (timeCurrentDate - timeBirthday < 0) {
                    $('#errorBirthday').show();
                } else {
                    $('#errorBirthday').hide();
                }
            });
        });
    </script>
@endsection