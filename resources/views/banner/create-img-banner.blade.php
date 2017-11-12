@extends('home-user.index')
@section('title')
    {{'Thêm ảnh mới'}}
@endsection
@section('user-content')
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload {
            width: 100%;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Quản lý chung</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="img-banner" style="color: #333">
            <span class="company-register name-page-profile">Quản lý ảnh banner</span>
        </a>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="" style="color: #333">
            <span class="company-register name-page-profile">Thêm ảnh</span>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="create-img-banner-form" method="POST" role="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if ($user)
                    <input type="hidden" name="adminID" value="{{encrypt($user->id)}}">
                @endif
                <div class="form-group">
                    <label>Tên hiển thị</label>
                    <input type="text" name="nameDisplay" id="" required="required" class="form-control">
                    <br>

                    <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            Chọn ảnh<input name="file" type="file" id="imgInp" required="required" accept=".png, .jpg, .jpeg">
                        </span>
                    </span>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <img id='img-upload'/>
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
    <script>
        $('#img-banner').addClass('menu-menu');
        $('a#img-banner').css('color', '#000000');
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function () {
                readURL(this);
            });
        });
    </script>
@endsection