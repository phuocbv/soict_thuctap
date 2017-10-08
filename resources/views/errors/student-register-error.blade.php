@extends('home-user.index')
@section('title')
    {{'Đăng ký tham gia'}}
@endsection
@section('user-content')
    <script>
        $(document).ready(function () {
            $('#studentRegister').addClass('menu-menu');
            $('a#studentRegister').css('color', '#000000');
        });
    </script>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Đăng ký thực</span>
    </div>
    <div class="panel panel-default">
        <label style="color:#c0392b;margin-top: 10px;margin-left: 15px">Không phải thời điểm đăng ký thực tập</label>
        <div class="panel-body">
            <div class="panel panel-default" style="min-height: 135px;margin-top: -15px">
                <div class="panel-heading" style="text-align: center">
                    <h3 class="panel-title" style="font-weight: bold">Chọn doanh nghiệp</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Tên công ty</th>
                            <th>Địa chỉ</th>
                            <th>Số lượng đăng ký</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center">
                    <h3 class="panel-title" style="font-weight: bold">Doanh nghiệp mà sinh viên đã chọn</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="text-align: center">
                        <span style="color:#c0392b">Sinh viên chưa chọn doanh nghiệp nào</span>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                </div>
            </div>
        </div>
    </div>
@endsection