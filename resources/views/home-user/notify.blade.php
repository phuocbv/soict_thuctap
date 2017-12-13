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
        <div class="panel-heading">
            <a href="{{url('/')}}" style="color: #333">
                <span class="name-page-profile">Thông báo</span>
            </a>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="" style="color: #333">
                @foreach($notify as $n)
                    <span class="name-page-profile">{{$n->title}}</span>
                @endforeach
            </a>
        </div>
        <div class="panel-body body-padding">
            @foreach($notify as $n)
                <p>{!! $n->content !!}</p>
                <p class="date">
                    {{date("d/m/Y",strtotime($n->updated_at))}}
                </p>
                <hr/>
            @endforeach
        </div>
    </div>
@endsection
