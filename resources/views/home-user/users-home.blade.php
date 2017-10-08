@extends('home-user.index')
@section('title')
    {{'Trang chủ'}}
@endsection
@section('user-content')
    <style type="text/css">
        .date {
            color: #7f8c8d;
            font-style: italic;
        }

        .heading-panel {
            padding: 15px;
        }

        .body-padding {
            padding-bottom: 0px;
        }

        .pagination {
            margin: 0px;
        }
    </style>
    <div class="panel panel-default" style="min-height: 100vh">
        <div class="panel-heading">
            <span class="name-page-profile">Thông tin chung</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            @if($type=='student')
                @foreach($user as $u)
                    <a href="user-student-home?user_id={{bcrypt($u->user_id)}}&type={{'student'}}">
                        <span class="name-page-profile" style="color: #333333">Thông báo</span>
                    </a>
                @endforeach
            @elseif($type=='lecture')
                @foreach($user as $u)
                    <a href="user-lecture-home?user_id={{bcrypt($u->user_id)}}&type={{'lecture'}}">
                        <span class="name-page-profile" style="color: #333333">Thông báo</span>
                    </a>
                @endforeach
            @elseif($type=='company')
                @foreach($user as $u)
                    <a href="user-company-home?user_id={{bcrypt($u->user_id)}}&type={{'company'}}">
                        <span class="name-page-profile" style="color: #333333">Thông báo</span>
                    </a>
                @endforeach
            @elseif($type=='admin')
                {{--@if (Auth::check())--}}
                {{--{{ dd(Auth::user()->id) }}--}}
                {{--<a href="user-admin-home?user_id={{bcrypt(Auth::user()->id)}}&type={{'admin'}}">--}}
                {{--<span class="name-page-profile" style="color: #333333">Thông báo</span>--}}
                {{--</a>--}}
                {{--@endif--}}
            @endif
        </div>
        <div class="panel-body body-padding">
            @foreach($notify as $n)
                @if($type=='student')
                    @foreach($user as $u)
                        <span>
                            <a href="student-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($u->user_id)}}&type={{'student'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endforeach
                @elseif($type=='lecture')
                    @foreach($user as $u)
                        <span>
                            <a href="lecture-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($u->user_id)}}&type={{'lecture'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endforeach
                @elseif($type=='company')
                    @foreach($user as $u)
                        <span>
                            <a href="company-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($u->user_id)}}&type={{'company'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endforeach
                @elseif($type=='admin')
                    @if (Auth::check())
                        <span>
                            <a href="admin-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($user->user_id)}}&type={{'admin'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endif
                @endif
                <p class="date">
                    {{date("d/m/Y",strtotime($n->updated_at))}}
                </p>
                <hr style="margin-top: 0px;margin-bottom: 0px">
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#menu-home').addClass('menu-menu');
            $('a#menu-home').css('color', '#000000');
        });
    </script>
@endsection
