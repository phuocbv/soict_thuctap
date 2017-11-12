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
                <li>
                    <a href="{{ url('/company-information-company') }}" id="company-information">Doanh nghiệp hợp
                        tác</a>
                </li>
            </ul>
        @endif
    </div>
</div>
<div class="panel panel-default" style="margin-left: -15px;">
    <div class="panel-heading">
        <h3 class="panel-title name-notify">Thông tin công ty</h3>
    </div>
    <div class="panel-body" style="padding: 0px">
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="company-profile" id="companyProfile">Xem thông tin công ty</a>
            </li>
            <li>
                <a href="company-change-pass" id="companyChangePass">Đổi mật khẩu</a>
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
                <a href="company-join" id="company-join">Các kỳ tham gia</a>
            </li>
        </ul>
        <ul class="nav navbar-stacked user-menu">
            <li>
                <a href="company-register" id="companyRegister">Đăng ký tham gia</a>
            </li>
        </ul>
    </div>
</div>
