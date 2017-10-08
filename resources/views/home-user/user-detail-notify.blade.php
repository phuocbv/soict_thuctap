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
    <div class="panel panel-default" style="min-height: 100vh">
        @foreach($notify as $n)
            <div class="panel-heading">
                @foreach($user as $u)
                    @if($type=='student')
                        <a href="user-student-home?user_id={{bcrypt($u->user_id)}}&type={{'student'}}">
                            <span class="name-page-profile" style="color: #333333">Thông báo</span>
                        </a>
                    @elseif($type=='lecture')
                        <a href="user-lecture-home?user_id={{bcrypt($u->user_id)}}&type={{'lecture'}}">
                            <span class="name-page-profile" style="color: #333333">Thông báo</span>
                        </a>
                    @elseif($type=='company')
                        <a href="user-company-home?user_id={{bcrypt($u->user_id)}}&type={{'company'}}">
                            <span class="name-page-profile" style="color: #333333">Thông báo</span>
                        </a>
                    @elseif($type=='admin')
                        <a href="user-admin-home?user_id={{bcrypt($u->user_id)}}&type={{'admin'}}">
                            <span class="name-page-profile" style="color: #333333">Thông báo</span>
                        </a>
                    @endif
                @endforeach
                <span class="glyphicon glyphicon-menu-right small"></span>
                <a href="" style="color: #333">
                    <span class="name-page-profile">{{$n->title}}</span>
                </a>
            </div>
            <div class="panel-body body-padding">
                <p>{!! $n->content !!}</p>

                <p class="date">
                    {{date("d/m/Y",strtotime($n->updated_at))}}
                </p>
                <hr/>
            </div>
        @endforeach
    </div>
@endsection