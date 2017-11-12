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
        <h3 class="panel-title name-notify">Thông tin cá nhân</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="admin-change-pass" id="adminChangePass">Đổi mật khẩu</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">
            <a href="#">Quản lý khóa thực tập</a>
        </h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="list-course" id="list-course">Danh sách khóa thực tập</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="plan-learning" id="plan-learning">Kế hoạch học tập</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">
            <a href="#">Quản lý người dùng</a>
        </h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="list-user" id="list-user">Danh sách người dùng</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="add-users" id="add-user">Thêm người dùng</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">
            Quản lý chung
        </h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="manage-notify" id="manage-notify">Tin tức</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="img-banner" id="img-banner">Ảnh Banner</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="manage-function" id="manage-function">Quản lý chức năng</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="statistic-vote" id="statistic-vote">Thống kê đánh giá</a>
            </li>
        </ul>
    </div>
</div>
