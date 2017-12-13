@extends('home-user.index')
@section('title')
    {{'Danh sách khóa thực tập'}}
@endsection
@section('user-content')
    <style>
        .pagination {
            margin-top: 0px;
            margin-bottom: -6px;
        }
    </style>
    @include('elements.shared.flash')
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <div class="col-xs-8 col-sm-6 col-md-8 col-lg-10">
            <span class="name-page-profile">Quản lý khóa thực tập</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="list-course" style="color: #333">
                <span class="company-register name-page-profile">Phân công giảng viên</span>
            </a>
        </div>
        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-1">
            <a href="javascript:void(0)" class="btn btn-default btn-sm" id="btnAssignLecture">
                <span class="glyphicon glyphicon-plus-sign"></span> Thêm
            </a>
        </div>
        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-1">
            <a href="javascript:void(0)" class="btn btn-default btn-sm" id="btnImport">
                <span class="glyphicon glyphicon-plus-sign"></span> Import
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive" style="margin-top: 15px">
            <table id="myTable" class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 23px">STT</th>
                    <th style="min-width: 163px">Công ty</th>
                    <th style="min-width: 146px">Giảng viên</th>
                    <th style="min-width: 163px">Kỳ thực tập</th>
                    <th>Giá</th>
                    <th style="min-width: 143px">Chỉnh sửa</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach($listAssignLecture as $item)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$item->company->name}}</td>
                            <td>{{$item->lecture->name}}</td>
                            <td>{{$item->internshipCourse->name}}</td>
                            <td>{{$item->price}}</td>
                            <td>
                                <div class="btn-group">
                                    {{--<a href="javascript:void(0)" data-lecture-assign-company-id="{{ $item->id }}"--}}
                                        {{--class="btn btn-success btn-sm error-edit-time btnEditAssignLecture">--}}
                                        {{--<span class="glyphicon glyphicon-edit"></span>--}}
                                    {{--</a>--}}
                                    <a href="javascript:void(0)" data-lecture-assign-company-id="{{ $item->id }}"
                                       class="btn btn-danger btn-sm btnDeleteAssignLecture">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="dialogImport">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Import danh sách phân công giảng viên</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.assignLectureController.assignLectureToCompany') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="mssv">Chọn kỳ</label>
                            <select class="form-control" name="courseId" required>
                                <option value="">Chọn khóa học</option>
                                @foreach ($listCourse as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 16px">Chọn file phân công giảng viên: </label>
                            <input type="file" name="file" id="importFile"
                                         style="display: inline" required="required"
                                         accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                        </div>
                        <div style="text-align: center;margin-top: 15px">
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAssignLecture" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.assignLectureController.assignLecture') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Phân công giảng viên</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mssv">Chọn giảng viên</label>
                            <select class="form-control" name="lectureId" required>
                                <option value="">Chọn giảng viên</option>
                                @foreach ($listLecture as $lecture)
                                    <option value="{{ $lecture->id }}">{{ $lecture->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="companyId">Danh sách công ty</label>
                            <div class="table-responsive" style="height: 400px; overflow-y: auto;">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên công ty</th>
                                        {{--<th>Số sinh viên đã nhận/Tổng số</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody id="checkboxListCompany">
                                    @foreach($listCompany as $item)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="companyId[]" value="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Phân công</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAssignLectureEdit" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.assignLectureController.assignLecture') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="companyId" id="companyIdEdit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Phân công công ty cho giáo viên</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="companyId">Công ty phân công</label>
                        </div>
                        <div class="form-group">
                            <label for="mssv">Chọn giảng viên</label>
                            <select class="form-control" name="lectureId" required id="selectLecture">
                                <option value="">Chọn giảng viên</option>
                                @foreach ($listLecture as $lecture)
                                    <option value="{{ $lecture->id }}">{{ $lecture->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Phân công</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#list-internship').addClass('menu-menu');
        $('a#list-internship').css('color', '#000000');
        var tableAssignLecture = $('#myTable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "order": [[0, "asc"], [1, "asc"]]
        });

        var btnImport = $('#btnImport');
        var btnAssignLecture = $('#btnAssignLecture');
        //var btnEditAssignLecture = $('#btnEditAssignLecture');
        var modalAssignLecture = $('#modalAssignLecture');
        var dialogImport = $('#dialogImport');
        var importFile = $('#importFile');
        var checkboxListCompany = $('#checkboxListCompany');
        var modalAssignLectureEdit = $('#modalAssignLectureEdit')

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            btnImport.on('click', showDialog);
            btnAssignLecture.on('click', showDialogAssignLecture);
            $('table#myTable').on('click', 'a.btnDeleteAssignLecture', function() {
                var current = $(this);
                deleteAssignLecture(current.data('lecture-assign-company-id'), current);
            });
            $('table#myTable').on('click', 'a.btnEditAssignLecture', function() {
                var current = $(this);
                console.log(current.data('lecture-assign-company-id'));
            });
        });
        
        function showDialogEditAssign(id) {
            
        }

        function showDialog() {
            importFile.val('');
            dialogImport.modal();
        }
        
        function showDialogAssignLecture() {
            modalAssignLecture.modal();
        }

        function deleteAssignLecture(id, element) {
            if (confirm('Chắn muốn xóa')) {
                var param = {
                    id: id
                };
                var ajax = $.ajax({
                    url: '{{ route('admin.assignLectureController.deleteLectureAssignCompany') }}',
                    type: 'POST',
                    data: param
                });
                ajax.done(function (data) {
                    var result = JSON.parse(data);
                    if (result.status === 'success') {
                        var company = result.data.company;
                        console.log(company);
                        tableAssignLecture.row(element.parents('tr')).remove().draw();
                        var checkbox = '<tr><td><input type="checkbox" name="companyId[]" value="'
                            + company.id + '"></td><td>' + company.name + '</td></tr>';
                        checkboxListCompany.append(checkbox);
                        //alert('Xóa thành công');
                    }
                    if (result.status === 'error') {
                        alert(result.messages);
                    }
                });
                ajax.fail(function () {
                    console.log("error");
                });
            }
        }
    </script>
@endsection