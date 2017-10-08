@extends('home-user.index')
@section('title')
    {{'Quản lý ảnh banner'}}
@endsection
@section('user-content')
    <style>
        .pagination {
            margin-top: 0px;
            margin-bottom: -6px;
        }

        .date {
            color: #7f8c8d;
        }
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-8 col-sm-9 col-md-10 col-lg-11" style="margin-left: -15px">
            <span class="name-page-profile">Quản lý Chung</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="img-banner" style="color: #333">
                <span class="company-register name-page-profile">Quản lý ảnh banner</span>
            </a>
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <a href="create-img-banner" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus-sign"></span> tạo
            </a>
        </div>
    </div>
    @if(session()->has('addSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('addSuccess')}}</div>
    @endif
    @if(session()->has('editSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('editSuccess')}}</div>
    @endif
    @if(session()->has('deleteSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteSuccess')}}</div>
    @endif
    <div class="panel panel-default">
        <div class="table-responsive" style="margin-top: 15px">
            <table id="myTable" class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 16px">
                        <input type="checkbox" name="selectAll" id="selectAll">
                    </th>
                    <th>Ảnh</th>
                    <th style="min-width: 150px">Tên hiển thị</th>
                    <th style="min-width: 90px">Trạng thái</th>
                    <th style="min-width: 67px">Thao tác</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>
                        #
                    </th>
                    <th>Ảnh</th>
                    <th>Tên hiển thị</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($imgBanner as $ib)
                    <tr>
                        <td>
                            <input type="checkbox" name="select[]" class="select" value="{{$ib->id}}">
                        </td>
                        <td>
                            <a href="#" data-toggle="modal"
                               data-target="#{{$ib->id}}{{"view"}}">
                                <div class="thumbnail">
                                    <img src="public/{{$ib->url}}" class="img-responsive" alt="Image">
                                </div>
                            </a>
                        </td>
                        <td>{{$ib->name_display}}</td>
                        <td>
                            @if($ib->status==1)
                                {{'hiển thị'}}
                            @else
                                {{'ẩn'}}
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                   data-target="#{{$ib->id}}{{'edit'}}">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#{{$ib->id}}{{'delete'}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-danger" data-toggle="modal"
               data-target="#deleteMany" style="margin-bottom: 20px;margin-top: -15px">
                <span class="">Xóa ảnh đã chọn</span>
            </a>
        </div>
    </div>
    @foreach($imgBanner as $ib)
        <div class="modal fade" id="{{$ib->id}}{{"view"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">{{$ib->name_display}}</h4>
                    </div>
                    <div class="modal-body">
                        <img src="public/{{$ib->url}}" class="img-responsive" alt="{{$ib->name_display}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$ib->id}}{{"delete"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa ảnh {{$ib->name_display}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-img-banner-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="imgID" value="{{encrypt($ib->id)}}">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            style="min-width: 70px">Không
                                    </button>
                                    <button type="submit" class="btn btn-danger" style="min-width: 70px">Có</button>
                                </form>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal xoa sinh vien--}}
        <div class="modal fade" id="deleteMany" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa các ảnh đã chọn
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-many-img-banner-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="imgBannerClass" value="" class="imgBannerClass">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            style="min-width: 70px">Không
                                    </button>
                                    <button type="submit" class="btn btn-danger" style="min-width: 70px">Có</button>
                                </form>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal xoa sinh vien--}}
        <div class="modal fade" id="{{$ib->id}}{{"edit"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Chỉnh sửa thông tin ảnh
                            banner</h4>
                    </div>
                    <div class="modal-body">
                        <form action="edit-img-banner-form" method="POST" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="imgID" value="{{encrypt($ib->id)}}">

                            <div class="form-group">
                                <label>Tên hiển thị</label>
                                <input type="text" name="nameDisplay" id="" required="required" class="form-control"
                                       value="{{$ib->name_display}}">
                                <br>
                                <label>Trạng thái hiển thị</label>
                                <select name="status" id="inputID" class="form-control" required="required">
                                    <option value="">Chọn trạng thái hiển thị</option>
                                    @if($ib->status==0)
                                        <option value="0" selected="selected">ẩn</option>
                                        <option value="1">hiển thị</option>
                                    @else
                                        <option value="0">Ẩn</option>
                                        <option value="1" selected="selected">hiển thị</option>
                                    @endif
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        $(function () {
            $('#img-banner').addClass('menu-menu');
            $('a#img-banner').css('color', '#000000');
            $('#myTable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false
            });
            $('#selectAll').click(function () {
                if (this.checked) {
                    $('.select').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.select').each(function () {
                        this.checked = false;
                    });
                }
            });
            $('#deleteMany').click(function () {
                var arrNotify = new Array();
                $('.select').each(function () {
                    if (this.checked) {
                        arrNotify.push($(this).val());
                    }
                });
                $('.imgBannerClass').val(arrNotify);
            });
        })
    </script>
@endsection