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
        <h3 class="panel-title name-notify">Doanh nghiệp</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        @if (Auth::check())
            <ul class="nav navbar-stacked user-menu">
                <li>
                    <a href="getListCompany">Thông tin doanh nghiệp</a>
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
            <li id="validateCompany">
                <a href="javascript:void(0)">Xác thực công ty</a>
            </li>
        </ul>
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
                    <div class="form-group">
                        <label for="name-student">Tên sinh viên(Tên có dấu)</label>
                        <input type="text" class="form-control" id="name_student"
                               placeholder="Tên sinh viên" name="name_student" required>
                    </div>
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
<div class="modal fade" id="modalValidateCompany" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Xác thực tài khoản công ty</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameCompany">Tên công ty</label>
                    <input type="text" class="form-control" id="nameCompany"
                           placeholder="Tên công ty" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email"
                           placeholder="Email" name="email" required>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label for="phone">Số điện thoại</label>--}}
                    {{--<input type="text" class="form-control" id="phone"--}}
                           {{--placeholder="Khóa" name="phone" required>--}}
                {{--</div>--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btnValidateCompany">Xác thực</button>
            </div>
        </div>
    </div>
</div>
<script>
    var btnValidateStudent = $('#btnValidateStudent');
    var btnValidateCompany = $('#btnValidateCompany');
    var validateStudent = $('#validateStudent');
    var validateCompany = $('#validateCompany');

    var modal = $('#modalValidate');
    var modalCompany = $('#modalValidateCompany');

    //student
    var studentCode = $('#studentCode');
    var nameStudent = $('#name_student');
    var grade = $('#grade');

    //company
    var nameCompany = $('#nameCompany');
    var email = $('#email');
    var phone = $('#phone');

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        validateStudent.on('click', showValidate);
        btnValidateStudent.on('click', validate);
        validateCompany.on('click', showModalValidateCompany);
        btnValidateCompany.on('click', validateDataCompany)
    });

    function showValidate() {
        studentCode.val('');
        nameStudent.val('');
        grade.val('');
        modal.modal();
    }

    function showModalValidateCompany() {
        nameCompany.val('');
        email.val('');
        phone.val('');
        modalCompany.modal();
    }

    function validate() {
        if (studentCode.val() === '' || studentCode.val() === undefined) {
            alert("Mã số sinh viên trống");
            return;
        }

        if (nameStudent.val() === '' || nameStudent.val() === undefined) {
            alert('Tên sinh viên trống');
            return;
        }

        if (grade.val() === '' || grade.val() === undefined) {
            alert('Khóa sinh viên trống');
            return;
        }

        var data = {
            studentCode: studentCode.val(),
            nameStudent: nameStudent.val(),
            grade: grade.val()
        };

        postValidate(data);
    }
    
    function validateDataCompany() {
        if (nameCompany.val() === '' || nameCompany.val() === undefined) {
            alert('Tên công ty trống');
            return;
        }

        if (email.val() === '' || email.val() === undefined) {
            alert('Email trống');
            return;
        }

//        if (phone.val() === '' || email.val() === undefined) {
//            alert('Điện thoại trống');
//            return;
//        }

        var data = {
            nameCompany: nameCompany.val(),
            email: email.val(),
            //phone: phone.val()
        };

        postValidateCompany(data);
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
    
    function postValidateCompany(param) {
        var ajax = $.ajax({
            url: '{{ route('validateCompany') }}',
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
            alert('Có lỗi');
        });
    }
</script>
