<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Thông tin chung</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        @if (Auth::check())
            <ul class="nav navbar-stacked user-menu">
                <li>
                    <a href="{{ route('home') }}"
                       id="menu-home">Thông báo</a>
                </li>
            </ul>
        @endif
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Xác thực</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li id="validateStudent">
                <a href="javascript:void(0)">Xác thực sinh viên</a>
            </li>
        </ul>
    </div>
</div>
<div class="modal fade" id="modalValidate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Xác thực tài khoản sinh viên</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label for="mssv">Mã số sinh viên</label>
                        <input type="text" name="studentCode" class="form-control" id="studentCode"
                               placeholder="Mã số sinh viên" required>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="name-student">Tên sinh viên</label>--}}
                        {{--<input type="text" class="form-control" id="name_student"--}}
                               {{--placeholder="Tên sinh viên" name="name_student" required>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="grade">Khóa</label>
                        <input type="text" class="form-control" id="grade"
                               placeholder="Khóa" name="grade" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btnValidateStudent">Xác thực</button>
            </div>
        </div>
    </div>
</div>
<script>
    var btnValidateStudent = $('#btnValidateStudent');
    var validateStudent = $('#validateStudent');
    var modal = $('#modalValidate');
    var studentCode = $('#studentCode');
    //var nameStudent = $('#name_student');
    var grade = $('#grade');

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        validateStudent.on('click', showValidate);
        btnValidateStudent.on('click', validate);
        showValidate();
    });

    function showValidate() {
        studentCode.val('');
        //nameStudent.val('');
        grade.val('');
        modal.modal();
    }

    function validate() {
        if (studentCode.val() === '' || studentCode.val() === undefined) {
            alert("Mã số sinh viên trống");
            return;
        }

//        if (nameStudent.val() === '' || nameStudent.val() === undefined) {
//            alert('Tên sinh viên trống');
//            return;
//        }

        if (grade.val() === '' || grade.val() === undefined) {
            alert('Khóa sinh viên trống');
            return;
        }

        var data = {
            studentCode: studentCode.val(),
           // nameStudent: nameStudent.val(),
            grade: grade.val()
        };

        postValidate(data);
    }
    
    function postValidate(param) {
        var ajax = $.ajax({
            url: '{{ route('validateStudent') }}',
            type: 'POST',
            data: param
        });
        ajax.done(function (data) {
            var result = JSON.parse(data);

            if (result.status === 'success') {
                window.location.reload();
            }
            if (result.status === 'error') {
                alert(result.messages);
            }
        });
        ajax.fail(function() {
            console.log("error");
        });
    }
</script>
