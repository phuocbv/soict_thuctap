<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-11 col-sm-9 col-md-10 col-lg-11">
                <h3 class="panel-title name-page-profile">Hệ đào tạo</h3>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-2 col-lg-1">
                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#{{"addLearning"}}">
                    <span class="glyphicon glyphicon-plus-sign"></span>tạo
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body" style="padding: 0px">
        <div class="table-responsive" style="background-color: #EEEEEE">
            <table id="table-learning" class="table table-hover table-bordered" style="background-color: #FFFFFF">
                <thead>
                <tr>
                    <th style="min-width: 37px">
                        <input type="checkbox" name="" id="selectAllLearn">
                    </th>
                    <th style="min-width: 44px">STT</th>
                    <th style="min-width: 488px">Hệ đào tạo</th>
                    <th style="min-width: 148px">Thao tác</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>STT</th>
                    <th>Hệ đào tạo</th>
                    <th>Thao tác</th>
                </tr>
                </tfoot>
                <tbody>
                <?php
                $i = 0;
                ?>
                @foreach($learningPrograming as $lp)
                    <tr>
                        <td>
                            <input type="checkbox" name="select[]" class="selectLearn" value="{{$lp->id}}">
                        </td>
                        <td>{{++$i}}</td>
                        <td>
                            {{$lp->name}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="btn btn-success btn-sm"
                                   data-toggle="modal" data-target="#{{$lp->id}}{{'editLearn'}}">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#{{$lp->id}}{{'deleteLearn'}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-danger" data-toggle="modal"
               data-target="#deleteManyLearn" style="margin-bottom: 20px;margin-top: -15px">
                <span class="">Xóa hệ đào tạo</span>
            </a>
        </div>
    </div>
</div>
{{--modal thêm hệ đào tạo--}}
<div class="modal fade " id="addLearning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Thêm hệ đào tạo</h4>
            </div>
            <div class="modal-body">
                <form action="add-learning-programing" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="learningPrograming" id="" class="form-control" required="required"
                           placeholder="nhập tên hệ đào tạo">
                    <br>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>{{--ket thuc modal them he dao tao--}}
@foreach($learningPrograming as $lp)
    {{--modal sua he dao tao--}}
    <div class="modal fade " id="{{$lp->id}}editLearn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Sửa hệ đào
                        tạo {{$lp->name}}</h4>
                </div>
                <div class="modal-body">
                    <form action="edit-learn-program" method="POST" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="learnID" value="{{encrypt($lp->id)}}">
                        <input type="text" name="learnProgram" id="" class="form-control" required="required"
                               value="{{$lp->name}}">
                        <br>
                        <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>{{--ket thuc modal sua he dao tao--}}

    {{--modal xoa he dao tao--}}
    <div class="modal fade" id="{{$lp->id}}{{"deleteLearn"}}" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                        Bạn thực sự muốn xóa hệ đào tạo: {{$lp->name}}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <form action="delete-learn" method="POST" role="form"
                                  style="text-align: center">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="learnID" value="{{encrypt($lp->id)}}">
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
    </div>{{--ket thuc modal xoa he dao tao--}}
@endforeach

{{--modal xoa nhieu he dao tao--}}
<div class="modal fade" id="deleteManyLearn" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                    Bạn thực sự muốn xóa các hệ đào tạo đã chọn
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="delete-many-learn" method="POST" role="form"
                              style="text-align: center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="learnID" value="" class="learn">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"
                                    style="min-width: 70px">Không
                            </button>
                            <button type="submit" class="btn btn-danger" style="min-width: 70px" name="manyLearn">Có
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
    $('#table-learning').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ordering": false
    });
    $('#selectAllLearn').click(function () {
        if (this.checked) {
            $('.selectLearn').each(function () {
                this.checked = true;
            });
        } else {
            $('.selectLearn').each(function () {
                this.checked = false;
            });
        }
    });
    $('#deleteManyLearn').click(function () {
        var arr = new Array();
        $('.selectLearn').each(function () {
            if (this.checked) {
                arr.push($(this).val());
            }
        });
        $('.learn').val(arr);
    });
</script>