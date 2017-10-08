<div role="tabpanel" class="tab-pane" id="lecture">
    <div class="table-responsive">
        <table id="table-lecture" class="table table-bordered">
            <thead>
            <tr>
                <th style="min-width: 71px">Họ tên</th>
                <th style="min-width: 139px">Bộ môn</th>
                <th style="min-width: 58px">Trình độ</th>
                <th style="min-width: 88px">Điện thoại</th>
                <th style="min-width: 130px">Email</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th style="min-width: 71px">Họ tên</th>
                <th style="min-width: 139px">Bộ môn</th>
                <th style="min-width: 58px">Trình độ</th>
                <th style="min-width: 88px">Điện thoại</th>
                <th style="min-width: 130px">Email</th>
                <th style="min-width: 102px">Thao tác</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($lectureInCourse as $lic)
                <?php
                $lecture = \App\Lecture::getLectureFollowID($lic->lecture_id);
                ?>
                @foreach($lecture as $l)
                    <tr>
                        <td>{{$l->name}}</td>
                        <td>{{$l->address}}</td>
                        <td>{{$l->qualification}}</td>
                        <td>{{$l->phone}}</td>
                        <?php
                        $myUser = \App\MyUser::getUserFollowID($l->user_id);
                        ?>
                        @foreach($myUser as $mu)
                            <td>{{$mu->email}}</td>
                        @endforeach
                        <td>
                            <div class="btn-group">
                                <a href="#" class="btn btn-danger btn-sm"
                                   data-toggle="modal"
                                   data-target="#{{"stop-join"}}{{$lic->id}}">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                                <a href="#" class="btn btn-primary btn-sm"
                                   data-toggle="modal"
                                   data-target="#{{"change-join"}}{{$lic->id}}">
                                    <span>Thay thế</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@foreach($lectureInCourse as $lic)
    <?php
    $lecture = \App\Lecture::getLectureFollowID($lic->lecture_id);
    $listLecture = \App\Lecture::getLectureContain($lic->lecture_id);
    ?>
    @foreach($lecture as $l)
        {{--modal giảng viên dừng quản lý thực tập--}}
        <div class="modal fade" id="{{"stop-join"}}{{$lic->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Bạn thực sự muốn cho giảng viên {{$l->name}} dừng quản lý thực tập của khóa này
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">

                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <form action="stop-join-lecture" method="POST" role="form"
                                      style="text-align: center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="courseID" value="{{$courseID}}">
                                    <input type="hidden" name="lectureID" value="{{$l->id}}">
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
        </div>{{--ket thuc modal giang vien dung quan lý thuc tap--}}
        {{--modal thay the giang vien--}}
        <div class="modal fade" id="{{"change-join"}}{{$lic->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold">
                            Thay giảng viên phụ trách thực tập
                        </h4>
                    </div>
                    <div class="modal-body">
                        <label>Chọn giảng viên dưới đây để thay cho {{$l->name}}</label>

                        <form action="replace-lecture" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="courseID" value="{{$courseID}}">
                            <input type="hidden" name="lectureID" value="{{$l->id}}">

                            <div class="panel panel-default">
                                <div class="table-responsive" style="height: 200px;overflow-y: auto">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 2%">#</th>
                                            <th style="width: 25%">Tên</th>
                                            <th style="width: 30%">Bộ môn</th>
                                            <th style="width: 25%">Mail liên lạc</th>
                                            <th style="width: 18%">Điện thoại</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listLecture as $ll)
                                            <?php
                                            $myUser = \App\MyUser::where('id', '=', $ll->user_id)->get();
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="lectureIDReplace" id=""
                                                           value="{{$ll->id}}" required="required">
                                                </td>
                                                <td>{{$ll->name}}</td>
                                                <td>{{$ll->address}}</td>
                                                @foreach($myUser as $mu)
                                                    <td>{{$mu->email}}</td>
                                                @endforeach
                                                <td>{{$ll->phone}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thay thế</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>{{--ket thuc modal giang vien dung quan lý thuc tap--}}
    @endforeach
@endforeach
