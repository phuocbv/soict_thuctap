@extends('manage-notify.index')
@section('title')
    {{'Chỉnh sửa tin tức'}}
@endsection
@section('content')
    <style>
        .note-editable {
            min-height: 200px;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Quản lý chung</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="manage-notify" style="color: #333">
            <span class="company-register name-page-profile">Quản lý tin tức</span>
        </a>
        <span class="glyphicon glyphicon-menu-right small"></span>
        @foreach($notify as $n)
            <a href="" style="color: #333">
                <span class="company-register name-page-profile">Chỉnh sửa tin tức: {{$n->title}}</span>
            </a>
        @endforeach
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="edit-notify-form" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if ($user)
                    <input type="hidden" name="adminID" value="{{encrypt($user->id)}}">
                @endif
                @foreach($notify as $n)
                    <div class="form-group">
                        <input type="hidden" name="notifyID" value="{{encrypt($n->id)}}">
                        <label for="">Tiêu đề tin tức</label>
                        <textarea name="title" id="title" class="form-control"
                                  style="width: 100%;overflow: hidden; min-height: 100px"
                                  onkeyup="textArea(this)" required="required">{{$n->title}}
                        </textarea>
                        <label for="" style="margin-top: 15px">Nội dung tin tức</label>
                        <textarea name="content" id="content" class="form-control" rows="3" required="required">
                            {{$n->content}}
                        </textarea>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
            </form>
        </div>
    </div>
    <script>
        $('#manage-notify').addClass('menu-menu');
        $('a#manage-notify').css('color', '#000000');
        function textArea(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
        $('#content').summernote();
    </script>
@endsection