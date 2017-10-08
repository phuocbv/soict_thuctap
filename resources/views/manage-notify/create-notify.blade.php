@extends('manage-notify.index')
@section('title')
    {{'Tạo tin mới'}}
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
        <a href="" style="color: #333">
            <span class="company-register name-page-profile">Tạo tin mới</span>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="create-notify-form" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($user as $u)
                    <input type="hidden" name="adminID" value="{{encrypt($u->id)}}">
                @endforeach
                <div class="form-group">
                    <label for="">Tiêu đề tin tức</label>
                                <textarea name="title" id="title" class="form-control"
                                          style="width: 100%;overflow: hidden" onkeyup="textArea(this)"
                                          required="required">
                                </textarea>
                    <label for="" style="margin-top: 15px">Nội dung tin tức</label>
                                <textarea name="content" id="content" class="form-control" rows="3" required="required">
                                </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
    <script>
        function textArea(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
        $('#content').summernote();
        $('#manage-notify').addClass('menu-menu');
        $('a#manage-notify').css('color', '#000000');
    </script>
@endsection