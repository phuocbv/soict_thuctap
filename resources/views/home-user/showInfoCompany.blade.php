@extends('home-user.index')
@section('title')
    {{'Trang chủ'}}
@endsection
@section('user-content')
    <style type="text/css">
        .name-notify {
            font-weight: bold;
        }

        .date {
            color: #7f8c8d;
            font-style: italic;
        }

        .body-padding {
            padding-bottom: 0px;
        }

        .pagination {
            margin: 0px;
        }
    </style>
    <div class="panel panel-default">
        @if ($company)
            <div class="panel-heading">
                <a href="{{url('company-information-student')}}" style="color: #333">
                    <span class="name-page-profile">Thông tin doanh nghiệp</span>
                </a>
                <a href="javascript:void(0)">
                    <span class="name-page-profile"> / </span>
                </a>
                <a href="{{ route('showInformationCompany', [
                    'companyId' => encrypt($company->id)
                ]) }}" style="color: #333">
                    <span class="name-page-profile">Thông tin công ty</span>
                </a>
            </div>
            <div class="panel-body body-padding">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <div class="table-responsive" style="margin-top: -16px">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td style="width: 25%">Tên công ty:</td>
                                    <td>{{$company->name}}</td>
                                </tr>
                                <tr>
                                    <td>Ngày thành lập:</td>
                                    <td>
                                        @if(date('Y',strtotime($company->birthday))!=1970 &&date('Y',strtotime($company->birthday))!=-0001)
                                            {{date('d/m/Y',strtotime($company->birthday))}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ:</td>
                                    <td>{{$company->address}}</td>
                                </tr>
                                <tr>
                                    <td>Mail hỗ trợ:</td>
                                    <td>{{$company->hr_mail}}</td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại hỗ trợ:</td>
                                    <td>{{$company->hr_phone}}</td>
                                </tr>
                                <tr>
                                    <td>Mô tả ngắn gọn:</td>
                                    <td>
                                        {!! nl2br(e(trim($company->description))) !!}
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
        @endif
    </div>
    <div class="panel panel-default" style="min-height: 50vh">
        <div class="panel-heading">
            <a href="{{url('/')}}" style="color: #333">
                <span class="name-page-profile">Bình luận</span>
            </a>
        </div>
        <div class="panel-body body-padding">
            <div class="fb-comments" data-href="{{ route('showInformationCompany', ['company' => encrypt($company->id)]) }}" data-numposts="5" width="800"></div>
        </div>
    </div>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN /sdk.js#xfbml=1&version=v2.11&appId={{ config('services.facebook.client_id') }}';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
