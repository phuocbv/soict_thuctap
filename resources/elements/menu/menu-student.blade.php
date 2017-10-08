<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Thông tin chung</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        @foreach($user as $u)
            <ul class="nav navbar-stacked user-menu">
                <li>
                    <a href="user-student-home?user_id={{bcrypt($u->user_id)}}&type={{'student'}}"
                       id="menu-home">Thông báo</a>
                </li>
            </ul>
        @endforeach
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Thông tin cá nhân</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="student-profile" id="studentProfile">Xem thông tin cá nhân</a>
            </li>
            <li>
                <a href="student-change-pass" id="studentChangePass">Đổi mật khẩu</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Khóa thực tập</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="register-intern" id="studentRegister">Đăng ký thực tập</a>
            </li>
            <li>
                <a href="course-join" id="courseJoin">Các khóa tham gia</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Doanh nghiệp hợp tác</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="company-cooperation" id="company-cooperation">Điểm doanh nghiệp</a>
            </li>
            <li>
                <a href="company-information-student" id="company-information">Thông tin doanh
                    nghiệp</a>
            </li>
        </ul>
    </div>
</div>
