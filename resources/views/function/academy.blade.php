<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-11 col-sm-9 col-md-10 col-lg-11">
                <h3 class="panel-title name-page-profile">Các bộ môn</h3>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-2 col-lg-1">
                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#{{"addAcademy"}}">
                    <span class="glyphicon glyphicon-plus-sign"></span>tạo
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body" style="padding: 0px">
        <div class="table-responsive" style="background-color: #EEEEEE">
            <table id="table-academy" class="table table-hover table-bordered" style="background-color: #FFFFFF">
                <thead>
                <tr>
                    <th style="min-width: 37px">
                        <input type="checkbox" name="" id="selectAllAcademy">
                    </th>
                    <th style="min-width: 44px">STT</th>
                    <th style="min-width: 488px">Tên Bộ môn</th>
                    <th style="min-width: 148px">Thao tác</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>STT</th>
                    <th>Tên Bộ Môn</th>
                    <th>Thao tác</th>
                </tr>
                </tfoot>
                <tbody>
                <?php
                $j = 0;
                ?>
                @foreach($academy as $a)
                    <tr>
                        <td>
                            <input type="checkbox" name="select[]" class="selectAcademy" value="{{$a->id}}">
                        </td>
                        <td>{{++$j}}</td>
                        <td>
                            {{$a->name}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="btn btn-success btn-sm"
                                   data-toggle="modal" data-target="#{{$a->id}}{{'editAcademy'}}">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#{{$a->id}}{{'deleteAcademy'}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-danger" data-toggle="modal"
               data-target="#deleteManyAcademy" style="margin-bottom: 20px;margin-top: -15px">
                <span class="">Xóa bộ môn</span>
            </a>
        </div>
    </div>

</div>

{{--modal them bo mon--}}
<div class="modal fade " id="addAcademy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thêm bộ môn</h4>
            </div>
            <div class="modal-body">
                <form action="add-academy" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="academy" id="" class="form-control" required="required"
                           placeholder="nhập tên bộ môn">
                    <br>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{--modal sua bo mon--}}
@foreach($academy as $a)
    {{--modal sua he dao tao--}}
    <div class="modal fade " id="{{$a->id}}editAcademy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Sửa bộ môn{{$a->name}}</h4>
                </div>
                <div class="modal-body">
                    <form action="edit-academy" method="POST" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="academyID" value="{{encrypt($a->id)}}">
                        <input type="text" name="academy" id="" class="form-control" required="required"
                               value="{{$a->name}}">
                        <br>
                        <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>{{--ket thuc modal sua he dao tao--}}
    {{--modal xoa bo mon--}}
    <div class="modal fade" id="{{$a->id}}{{"deleteAcademy"}}" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                        Bạn thực sự muốn xóa bộ môn {{$a->name}}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <form action="delete-academy" method="POST" role="form"
                                  style="text-align: center">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="academyID" value="{{encrypt($a->id)}}">
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
    </div>{{--ket thuc modal xoa bo mon--}}
@endforeach

{{--modal xoa nhieu bo mon--}}
<div class="modal fade" id="deleteManyAcademy" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                    Bạn thực sự muốn xóa các bộ môn đã chọn
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="delete-many-academy" method="POST" role="form"
                              style="text-align: center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="academyID" value="" class="academy">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"
                                    style="min-width: 70px">Không
                            </button>
                            <button type="submit" class="btn btn-danger" style="min-width: 70px" name="manyAcademy">Có
                            </button>
                        </form>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#table-academy').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ordering": false
    });
    $('#selectAllAcademy').click(function () {
        if (this.checked) {
            $('.selectAcademy').each(function () {
                this.checked = true;
            });
        } else {
            $('.selectAcademy').each(function () {
                this.checked = false;
            });
        }
    });
    $('#deleteManyAcademy').click(function () {
        var arr = new Array();
        $('.selectAcademy').each(function () {
            if (this.checked) {
                arr.push($(this).val());
            }
        });
        $('.academy').val(arr);
    });
</script>