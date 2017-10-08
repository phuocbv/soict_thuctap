@extends('index')
@section('title')
    {{'Trang chủ'}}
@endsection
@section('home-content')
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
        </div>
        <div class="panel-body body-padding">
            @foreach($notify as $n)
                <span>
                    <a href="detail-notify?idNotify={{$n->id}}" style="color:#000000;font-weight: bold">
                        {{$n->title}}
                    </a>
                </span>
                <p class="date">
                    {{date("d/m/Y",strtotime($n->updated_at))}}
                </p>
                <hr style="margin-top: 0px;margin-bottom: 0px">
            @endforeach
            {{$notify->links()}}
        </div>
    </div>
@endsection
