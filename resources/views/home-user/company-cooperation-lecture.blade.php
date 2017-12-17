@extends('home-user.index')
@section('title')
    {{'Trang chủ'}}
@endsection
@section('user-content')
    <div class="panel panel-default" style="min-height: 50vh">
        <div class="panel-heading">
            <span class="name-page-profile">Thông tin chung</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="company-information-lecture" style="color:#333">
                <span class="name-page-profile">Doanh nghiệp hợp tác</span>
            </a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="table-company" class="table table-hover">
                    <thead>
                    <tr>
                        <th style="min-width: 250px">Tên công ty</th>
                        <th style="min-width: 104px">Ngày thành lập</th>
                        <th style="min-width: 200px">Địa chỉ</th>
                        <th style="min-width: 80px">chi tiết</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($company as $c)
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>
                                @if(date('Y',strtotime($c->birthday))!=1970 &&date('Y',strtotime($c->birthday))!=-0001)
                                    {{date('d/m/Y',strtotime($c->birthday))}}
                                @endif
                            </td>
                            <td>{{$c->address}}</td>
                            <td>
                                {{--<a href="#" data-toggle="modal"--}}
                                   {{--data-target="#{{$c->id}}">--}}
                                    {{--<span>chi tiết</span>--}}
                                {{--</a>--}}
                                <a href="{{ route('showInformationCompany', ['companyId' => encrypt($c->id)]) }}">Chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach($company as $c)
        {{--modal hien thi thong tin cong ty --}}
        <div class="modal fade" id="{{$c->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="myModalLabel"
                            style="font-weight: bold">Thông tin
                            chi
                            tiết công ty {{$c->name}}</h4>
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
                                            <td>{{$c->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày thành lập:</td>
                                            <td>
                                                @if(date('Y',strtotime($c->birthday))!=1970 &&date('Y',strtotime($c->birthday))!=-0001)
                                                    {{date('d/m/Y',strtotime($c->birthday))}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Địa chỉ:</td>
                                            <td>{{$c->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mail hỗ trợ:</td>
                                            <td>{{$c->hr_mail}}</td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại hỗ trợ:</td>
                                            <td>{{$c->hr_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mô tả ngắn gọn:</td>
                                            <td>{{$c->description}}</td>
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
    @endforeach{{--ket thuc modal cong ty--}}
    <script>
        $('#table-company').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ordering": false
        });
        $('#company-information').addClass('menu-menu');
        $('a#company-information').css('color', '#000000');
    </script>
@endsection