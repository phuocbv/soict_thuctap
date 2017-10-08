<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Thông tin chung</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        @foreach($user as $u)
            <ul class="nav navbar-stacked user-menu">
                <li>
                    <a href="user-lecture-home?user_id={{bcrypt($u->user_id)}}&type={{'lecture'}}"
                       id="menu-home">Thông báo</a>
                </li>
                <li>
                    <a href="company-information-lecture" id="company-information">Doanh nghiệp hợp
                        tác</a>
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
                <a href="lecture-profile" id="lectureProfile">Xem thông tin cá nhân</a>
            </li>
            <li>
                <a href="lecture-change-pass" id="lectureChangePass">Đổi mật khẩu</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Kỳ thực tập</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="lecture-join" id="lecture-join">Các kỳ tham gia</a>
            </li>
        </ul>
    </div>
</div>
