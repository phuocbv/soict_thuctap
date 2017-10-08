<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
            page-break-after: always;
        }
        body { font-family: DejaVu Sans, sans-serif; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
@foreach($listCompany as $key => $value)
    <div style="">
        <div style="text-align: center; width: 50%; float: left">
            <span>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</span><br>
            <span>VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</span><br>
            <span>––––––––––––</span>
        </div>
        <div style="text-align: center; width: 50%; float: left">
            <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span>Độc Lập – Tự do – Hạnh phúc</span><br>
            <span>––––––––––––––––––––––––––––</span><br>
            {{--@foreach($lectureReport as $lr)--}}
                {{--Hà Nội, ngày {{date('d',strtotime($lr->date_report))}}--}}
                {{--tháng {{date('m',strtotime($lr->date_report))}}--}}
                {{--năm {{date('Y',strtotime($lr->date_report))}}--}}
            {{--@endforeach--}}
        </div>
        <div style="text-align: center; margin-top: 20px; margin-bottom: 15px; padding-top: 90px">
            <div style="font-size: 18px; font-weight: bold;">BÁO CÁO THỰC TẬP</div>
            <div style="margin-left: -100px; font-size: 12px">Số quyết định thực tập:</div>
        </div>
    </div>
    <div style="padding-left: 50px; margin-top: 30px">
        <div style="width: 100%">
            @foreach($group as $keyG => $valueGroup)
                @if ($keyG == $value->id)
                    @php
                        $countSV = count($valueGroup);
                    @endphp
                @endif
            @endforeach
            <div>1. Số lượng sinh viên toàn đoàn {{ $countSV }}</div>
            <div>2. Địa điểm thực tập {{ $value->name }}</div>
            <div>
                3. Thời gian thực tập từ ngày
                @if ($lectureInternShipCourse)
                    {{ date('d/m/Y',strtotime($lectureInternShipCourse->internshipCourse->from_date)) }}
                @endif
                đến ngày
                @if ($lectureInternShipCourse)
                    {{ date('d/m/Y',strtotime($lectureInternShipCourse->internshipCourse->to_date)) }}
                @endif
            </div>
            <div>
                4. Họ và tên các bộ trưởng đoàn:
                @if ($lectureInternShipCourse)
                    {{ $lectureInternShipCourse->lecture->name }}
                @endif
            </div>
            <div style="padding-left: 21px">
                Họ và tên sinh viên thực tập:
                {{--@if ($group)--}}
                    {{--{{ $group->first()->first()->student->name }}--}}
                {{--@endif--}}
                @foreach($group as $keyG => $valueGroup)
                    @if ($keyG == $value->id)
                        {{ $valueGroup->first()->student->name }}
                    @endif
                @endforeach
            </div>
            <div>5. Nội dung của đợt thực tập</div>
            <div style="padding-left: 20px">
                <div>- Học tập công nghệ: Các công cụ lập trình, công nghệ lập trình</div>
                <div>- Học tập kĩ năng làm việc nhóm, thuyết trình, làm báo cáo</div>
                <div>- Tham gia vào các dự án của công ti</div>
            </div>
            <div style="margin-top: 20px">Người hướng dẫn (trong và ngoài trường)</div>
            <div style="margin-top: 20px">
                <table style="width:100%">
                    <tr style="font-weight: bold">
                        <th>STT</th>
                        <th>Họ tên cán bộ hướng dẫn</th>
                        <th>Nội dung</th>
                        <th>Số giờ</th>
                        <th>Ghi chú</th>
                    </tr>
                    @if ($lectureInternShipCourse)
                        <tr>
                            <td>1</td>
                            <td>{{ $lectureInternShipCourse->lecture->name }}</td>
                            <td>Giáo viên hướng dẫn</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @php
                        $i = 1;
                    @endphp
                    <tr>
                    <td>2</td>
                    <td>{{ $value->name }}</td>
                    <td>Hướng dẫn thực tập</td>
                    <td></td>
                    <td></td>
                    </tr>
                    {{--@foreach($listCompany as $value)--}}
                        {{--<tr>--}}
                            {{--<td>{{ ++$i }}</td>--}}
                            {{--<td>{{ $value->name }}</td>--}}
                            {{--<td>Hướng dẫn thực tập</td>--}}
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                </table>
            </div>
            <div style="margin-top: 20px">6. Kết quả đạt được</div>
            <div>
                <div>- Khá giỏi:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
                <div>- Trung bình:&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
                <div>- Kém:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
                <div>- Khen thưởng, kỉ luật</div>
            </div>
            <div class="page-break"></div>
            <div>7. Thuận lợi, khó khăn, kiến nghị:</div>
            {{--<div style="padding-left: 20px">--}}
                {{--<div>- Thuận lợi: </div>--}}
                {{--<div>- Khó khăn: </div>--}}
                {{--<div>- Kiến nghị: </div>--}}
            {{--</div>--}}
        </div>
        <div style="width: 100%; margin-top: 200px">
            <div style="float: left; width: 50%; align-content: center">
                NHẬN XÉT CỦA CƠ SỞ
            </div>
            <div style="float: left; width: 50%; align-content: center">
                <div>Ngày &emsp;&emsp; Tháng &emsp;&emsp; Năm &emsp;&emsp;</div>
                <div style="margin-top: 20px">GIẢNG VIÊN PHỤ TRÁCH</div>
            </div>
        </div>
            <div class="page-break"></div>
            <div style="text-align: center; margin-top: 50px; font-weight: bold">
                <div>Viện công nghệ thông tin và truyền thông</div>
                <div>Bộ môn: </div>
                <div style="font-size: 18px">DANH SÁCH SINH VIÊN ĐI THỰC TẬP</div>
            </div>
            <div style="margin-left: 20px; margin-top: 20px">
                <div>
                    Giáo viên hướng dẫn:
                    @if ($lectureInternShipCourse)
                        {{ $lectureInternShipCourse->lecture->name }}
                    @endif
                </div>
                <div>
                    Thời gian thực tập
                    @if ($lectureInternShipCourse)
                        {{ date('d/m/Y',strtotime($lectureInternShipCourse->internshipCourse->from_date)) }}
                    @endif
                    đến ngày
                    @if ($lectureInternShipCourse)
                        {{ date('d/m/Y',strtotime($lectureInternShipCourse->internshipCourse->to_date)) }}
                    @endif
                </div>
                <div>
                    Địa điểm thực tập: {{ $value->name }}
                </div>
                @foreach($group as $keyG => $valueGroup)
                    @if ($keyG == $value->id)
                        @php
                            $studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($valueGroup->first()->student_id,
                                $valueGroup->first()->internship_course_id)->first();
                        @endphp
                        <div>
                            Môn học: {{ $studentInCourse->classSubject->subject_name }}
                        </div>
                        <div>
                            Mã môn: {{ $studentInCourse->classSubject->subject }}
                        </div>
                    @endif
                @endforeach
            </div>
            <div style="margin-left: 20px; margin-top: 20px">
                <table style="width:100%">
                    <tr style="font-weight: bold">
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Họ và tên</th>
                        <th>Lớp/Khóa</th>
                        <th>Mã lớp</th>
                    </tr>
                    @php
                        $i = 0;
                        $countStudent = 0;
                    @endphp
                    @foreach($group as $keyG => $valueGroup)
                        @if ($keyG == $value->id)
                            @php
                                $countStudent = count($valueGroup);
                            @endphp
                            @foreach($valueGroup as $item)
                                {{--@php--}}
                                    {{--$studentInCourse = \App\StudentInternShipCourse::getStudentInCourse($item->student_id, $item->internship_course_id)->first();--}}
                                {{--@endphp--}}
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->student->msv }}</td>
                                    <td>{{ $item->student->name }}</td>
                                    <td>{{ $item->student->grade }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </table>
            </div>
            <div style="margin-left: 20px; margin-top: 10px">Danh sách gồm {{ $countStudent }} người</div>
            <div style="margin-left: 20px; margin-top: 10px">
                <table style="width:100%">
                    <tr style="font-weight: bold">
                        <th width="40%">BAN LÃNH ĐẠO VIỆN</th>
                        <th width="60%">
                            <div>Hà Nội, ngày &emsp;&emsp;&emsp; tháng &emsp;&emsp;&emsp; năm &emsp;&emsp;</div>
                            <div style="text-align: center; margin-top: 20px">TRƯỞNG BỘ MÔN</div>
                        </th>
                    </tr>
                </table>
            </div>
            <div style="text-align: center; margin-top: 170px; font-weight: bold">
                Xác nhận của cơ sở thực tập
            </div>
        <div class="page-break"></div>
    </div>
@endforeach
</body>
</html>
