@extends('home-user.index')
@section('title')
    {{'Đăng ký thực tập'}}
@endsection
@section('user-content')
    <style>
        .pagination {
            margin: 0px;
            margin-bottom: -5px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#studentRegister').addClass('menu-menu');
            $('a#studentRegister').css('color', '#000000');
        });
    </script>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        @foreach($internShipCourse as $in)
            <span class="name-page-profile">Khóa thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="register-intern" style="color: #333">
                <span class="name-page-profile">Đăng ký thực tập kỳ {{$in->course_term}}</span>
            </a>
        @endforeach
    </div>
    @if(session()->has('deleteRegister'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteRegister')}}</div>
    @endif
    @if(session()->has('noChange'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('noChange')}}</div>
    @endif
    @if(session()->has('change'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('change')}}</div>
    @endif
    @if(session()->has('registerSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('registerSuccess')}}</div>
    @endif
    @if(session()->has('full'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong></strong>{{session()->get('full')}}
        </div>
    @endif
    <div class="panel panel-default" style="min-height: 100vh">
        <div class="panel-body" style="background-color: #EEEEEE">
            <div class="panel panel-default" style="min-height: 135px">
                <div class="panel-heading" style="text-align: center">
                    <h3 class="panel-title" style="font-weight: bold">Chọn doanh nghiệp</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <?php
                        $arrComIn = array();
                        $arrCom = array();
                        $inCourseID = "";
                        ?>
                        @foreach($internShipCourse as $in)
                            <?php
                            $companyInternShipCourse = \App\CompanyInternShipCourse::getCompanyInternShipCourse($in->id);
                            foreach ($companyInternShipCourse as $cic) {
                                $arrComIn[] = $cic;
                            }
                            $inCourseID = $in->id;
                            ?>
                        @endforeach
                        <tr>
                            <th style="width: 130px">Tên công ty</th>
                            <th style="width: 460px">Địa chỉ</th>
                            <th style="width: 110px">Đã đăng ký</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($arrComIn as $aci)
                            <?php
                            $company = \App\Company::getCompanyFollowID($aci->company_id);
                            foreach ($company as $com) {
                                $arrCom[] = $com;
                            }
                            ?>
                            @foreach($company as $c)
                                <tr>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#{{$c->id}}">
                                            {{$c->name}}
                                        </a>
                                    </td>
                                    <td>{{$c->address}}{{$c->address}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal"
                                           data-target="#{{$aci->company_id}}{{$aci->internship_course_id}}">
                                            <?php
                                            $count = \App\InternShipGroup::countStudentInCompany($c->id, $aci->internship_course_id);
                                            ?>
                                            {{$count}}/{{$aci->student_quantity}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="student-register?companyID={{encrypt($aci->company_id)}}&courseID={{encrypt($aci->internship_course_id)}}"
                                           class="btn btn-primary btn-sm">
                                            <span>Đăng ký</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center">
                        {{$companyInternShipCourse->links()}}
                    </div>
                </div>
            </div>
            {{--hien thi cong ty ma sinh vien da chon--}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-top: 5px">
                            <h3 class="panel-title" style="font-weight: bold;text-align: center">Doanh nghiệp mà sinh
                                viên đã đăng ký</h3>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="padding: 0px">
                            @if(count($registerCompany)>0)
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#{{'deleteRegister'}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>Xóa
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                @foreach($registerCompany as $rc)
                                    <tr>
                                        <td style="width: 25%">Tên công ty:</td>
                                        <td>{{$rc->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày thành lập:</td>
                                        <td>{{date('d-m-Y',strtotime($rc->birthday))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ:</td>
                                        <td>{{$rc->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mail hỗ trợ:</td>
                                        <td>{{$rc->hr_mail}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại hỗ trợ:</td>
                                        <td>{{$rc->hr_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mô tả ngắn gọn:</td>
                                        <td>
                                            {!! nl2br(e(trim($rc->description))) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Yêu cầu của công ty:</td>
                                        <?php
                                        $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($rc->id, $inCourseID);
                                        ?>
                                        <td>
                                            @foreach($companyInCourse as $cic)
                                                {!! nl2br(e(trim($cic->require_skill))) !!}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                </div>
            </div>

            {{--hien thi phuc vu modal --}}
            @foreach($arrCom as $ac)
                <div class="modal fade" id="{{$ac->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thông tin chi
                                    tiết
                                    công ty {{$ac->name}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="table-responsive" style="margin-top: -16px">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 25%">Tên công ty:</td>
                                                    <td>{{$ac->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ngày thành lập:</td>
                                                    <td>{{date('d-m-Y',strtotime($ac->birthday))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Địa chỉ:</td>
                                                    <td>{{$ac->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mail hỗ trợ:</td>
                                                    <td>{{$ac->hr_mail}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Số điện thoại hỗ trợ:</td>
                                                    <td>{{$ac->hr_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mô tả ngắn gọn:</td>
                                                    <td>
                                                        {!! nl2br(e(trim($ac->description))) !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Yêu cầu của công ty:</td>
                                                    <?php
                                                    $companyInCourse = \App\CompanyInternShipCourse::getComInCourse($ac->id, $inCourseID);
                                                    ?>
                                                    <td>
                                                        @foreach($companyInCourse as $cic)
                                                            {!! nl2br(e(trim($cic->require_skill))) !!}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($arrComIn as $aci2)
                <?php
                $studentID = \App\InternShipGroup::getStudentID($aci2->company_id, $aci2->internship_course_id);
                $i = 0;
                ?>
                <div class="modal fade" id="{{$aci2->company_id}}{{$aci2->internship_course_id}}" tabindex="-1"
                     role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Danh sách sinh
                                    viên
                                    đã
                                    đăng ký vào công ty</h4>
                            </div>
                            <div class="modal-body" style="padding-top: 0px">
                                <div class="row">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th style="text-align: center;width: 50px">STT</th>
                                                    <th style="text-align: center;width: 110px">Mã sinh viên</th>
                                                    <th style="text-align: center;width: 150px">Họ tên</th>
                                                    <th style="text-align: center;width: 125px">Hệ đào tạo</th>
                                                    <th style="text-align: center;width: 180px">Email</th>
                                                    <th style="text-align: center;width: 118px">Điện thoại</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($studentID as $sid)
                                                    <?php
                                                    $student = \App\Student::getStudentFollowID($sid);
                                                    ?>
                                                    @foreach($student as $s)
                                                        <?php
                                                        $myUser = \App\MyUser::getUserFollowID($s->user_id);
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center">{{++$i}}</td>
                                                            <td>
                                                                @foreach($myUser as $mu)
                                                                    {{$mu->user_name}}
                                                                @endforeach
                                                            </td>
                                                            <td>{{$s->name}}</td>
                                                            <td>
                                                                {{$s->program_university}}
                                                            </td>
                                                            <td>
                                                                @foreach($myUser as $mu)
                                                                    {{$mu->email}}
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                {{$s->phone}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{--modal xoa dang ky--}}
            <div class="modal fade" id="deleteRegister" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
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
                                    <form action="student-delete-register" method="POST" role="form"
                                          style="text-align: center">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @foreach($internShipCourse as $ic)
                                            <input type="hidden" name="courseID" value="{{encrypt($ic->id)}}">
                                        @endforeach
                                        @if ($user)
                                            <input type="hidden" name="studentID" value="{{encrypt($user->id)}}">
                                        @endif
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
            </div>{{--ket thuc modal xoa đăng ký--}}

        </div>
    </div>
@endsection