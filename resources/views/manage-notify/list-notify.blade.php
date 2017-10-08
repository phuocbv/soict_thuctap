@extends('home-user.index')
@section('title')
    {{'Quản lý tin tức'}}
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
    @if(session()->has('editSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('editSuccess')}}</div>
    @endif
    @if(session()->has('insertSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('insertSuccess')}}</div>
    @endif
    @if(session()->has('deleteSuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteSuccess')}}</div>
    @endif
    @if(session()->has('deleteManySuccess'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteManySuccess')}}</div>
    @endif
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-8 col-sm-9 col-md-10 col-lg-11" style="margin-left: -15px">
            <span class="name-page-profile">Quản lý chung</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="manage-notify" style="color: #333">
                <span class="company-register name-page-profile">Quản lý tin tức</span>
            </a>
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <a href="create-notify" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus-sign"></span> tạo
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive" style="margin-top: 15px">
            <table id="myTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="selectAll" id="selectAll">
                    </th>
                    <th style="min-width: 400px">Tên tin tức</th>
                    <th style="min-width: 83px">Ngày tạo tin</th>
                    <th style="min-width: 99px">Ngày cập nhật</th>
                    <th style="min-width: 67px">Thao tác</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Tên tin tức</th>
                    <th>Ngày tạo tin</th>
                    <th>Ngày cập nhật</th>
                    <th>Thao tác</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($notify as $n)
                    <tr>
                        <td>
                            <input type="checkbox" name="select[]" class="select" value="{{$n->id}}">
                        </td>
                        <td>
                            <a href="#" data-toggle="modal"
                               data-target="#{{$n->id}}{{"view"}}">
                                <span style="color: #333;">
                                    {{$n->title}}
                                </span>
                            </a>
                        </td>
                        <td>{{date('d/m/Y',strtotime($n->created_at))}}</td>
                        <td>{{date('d/m/Y',strtotime($n->updated_at))}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="edit-notify?id={{encrypt($n->id)}}" class="btn btn-success btn-sm"
                                   data-toggle="modal">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#{{$n->id}}{{'delete'}}">
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
                <span class="">Xóa tin tức</span>
            </a>
        </div>
    </div>
    @foreach($notify as $n)
        <div class="modal fade" id="{{$n->id}}{{"view"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">{{$n->title}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p>{!! $n->content !!}</p>

                                <p class="date">
                                    {{date("d/m/Y",strtotime($n->updated_at))}}
                                </p>
                                <hr/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{$n->id}}{{"delete"}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn xóa tin tức {{$n->title}} khỏi hệ thống
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-notify-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="notifyID" value="{{encrypt($n->id)}}">
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
                            Bạn thực sự muốn xóa các tin tức đã chọn
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="delete-many-notify-form" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="notifyClass" value="" class="notifyClass">
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
    @endforeach
    <script>
        $(function () {
            $('#manage-notify').addClass('menu-menu');
            $('a#manage-notify').css('color', '#000000');
            $('#myTable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[2, "desc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 0},
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 4},
                ]
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
                $('.notifyClass').val(arrNotify);
            });
        })
    </script>
@endsection