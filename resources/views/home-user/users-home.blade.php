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
            <a href="{{ route('home') }}">
                <span class="name-page-profile" style="color: #333333">Thông báo</span>
            </a>
        </div>
        <div class="panel-body body-padding">
            @foreach($notify as $n)
                @if($type=='student')
                    @if (Auth::check())
                        <span>
                            <a href="student-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($user->user_id)}}&type={{'student'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endif
                @elseif($type=='lecture')
                    @if (Auth::check())
                        <span>
                            <a href="lecture-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($user->user_id)}}&type={{'lecture'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endif
                @elseif($type=='company')
                    @if (Auth::check())
                        <span>
                            <a href="company-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($user->user_id)}}&type={{'company'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endif
                @elseif($type=='admin')
                    @if (Auth::check())
                        <span>
                            <a href="admin-detail-notify?notify_id={{$n->id}}&user_id={{bcrypt($user->user_id)}}&type={{'admin'}}"
                               style="color:#333333;font-weight: bold">
                                {{$n->title}}
                            </a>
                        </span>
                    @endif
                @else
                    <span>
                        <a href="showNotify?idNotify={{ $n->id }}"
                                style="color:#333333;font-weight: bold">
                            {{ $n->title }}
                        </a>
                    </span>
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
