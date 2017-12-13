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

        .height20p {
            height: 20px;
        }

        .mar-bottom {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div style="margin-left: 85px; margin-top: 30px;">
        <div style="width: 100%;">
            <div><b>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</b></div>
            <div>VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</div>
        </div>
        <div class="height20p"></div>
        <div style="text-align: center;">
            <div style="font-size: 18px; font-weight: bold;">GIẤY ĐỀ NGHỊ THANH TOÁN HỖ TRỢ THỰC TẬP</div>
            <div style="font-size: 12px;">
                <div>(Theo quyết định số 7 /QĐ-CNTT- TT-TTDN ngày &nbsp; &nbsp; tháng &nbsp; &nbsp;  năm &nbsp; &nbsp;&nbsp; &nbsp;</div>
                <div>về việc cử giảng viên đưa sinh viên đi {{ $classSubject->subject_name . ' ' . $classSubject->subject }}</div>
                <div>học kỳ {{ $internshipCourse->course_term }} năm học &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;)</div>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px; margin-left: 85px">
        <div>Giáo viên hướng dẫn: {{ $lecture->qualification . ' ' . $lecture->name }}</div>
        <div>Bộ môn: {{ $lecture->address }}</div>
        <div>Đơn vị thực tập: {{ $company->name }}</div>
        <div>Thời gian thực tập: {{ date('d/m/Y', strtotime($internshipCourse->from_date)) }} - {{ date('d/m/Y', strtotime($internshipCourse->to_date)) }}</div>
        <div>Tiền hỗ trợ thực tập bao gồm</div>
        <div style="margin-top: 20px">
            <table width="100%">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nội dung</th>
                        <th>SL sinh viên</th>
                        <th>Số tiền định mức/1sv</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Chi hướng dẫn thực tập</td>
                        <td>{{ count($listGroup) }}</td>
                        <td>{{ number_format($classSubject->price) }}</td>
                        <td>{{ number_format(count($listGroup) * $classSubject->price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 50px">
            <table style="border: hidden" width="100%">
                <tbody>
                    <tr style="text-align: center">
                        <th width="33%" style="border: hidden"><div>Người đề nghị</div><div>thanh toán</div></th>
                        <th width="33%" style="border: hidden">
                            <div>Phòng Kế hoạch </div><div>- Tài vụ</div></th>
                        <th width="33%" style="border: hidden">Lãnh đạo viện</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-break"></div>

    <div style="margin-top: 30px;">
        <div style="text-align: center; width: 50%; display: inline-block">
            <div>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</div>
            <div>VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</div>
            <div>––––––––––––</div>
            <div>Số: 7/QĐ-CNTT- TT-TTDN</div>
        </div><div style="text-align: center; width: 50%; display: inline-block">
            <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span>Độc Lập – Tự do – Hạnh phúc</span><br>
            <span>––––––––––––––––––––––––––––</span><br>
            <div>
                Hà Nội, ngày {{date('d',strtotime(date('Y-m-d')))}}
            tháng {{date('m',strtotime(date('Y-m-d')))}}
            năm {{date('Y',strtotime(date('Y-m-d')))}}
            </div>
        </div>
    </div>
    <div style="text-align: center; font-weight: bold; margin-left: 70px">
        <div>QUYẾT ĐỊNH</div>
        <div>Về việc cử giảng viên đưa sinh viên đi {{ $classSubject->subject_name . ' ' . $classSubject->subject }}</div>
        <div>học kỳ {{ $internshipCourse->course_term }} năm học &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
    </div>
    <div style="margin-top: 10px; margin-left: 70px">
        <div style="margin-bottom: 10px; font-weight: bold; text-align: center">VIỆN TRƯỞNG VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</div>
        <div>&nbsp; &nbsp; &nbsp;Căn cứ Điều lệ trường đại học ban hành theo Quyết định số 58/2010/QĐ-TTg
            ngày 22 tháng 09 năm 2010 của Thủ tướng Chính phủ;</div>
        <div>&nbsp; &nbsp; &nbsp;Căn cứ quy chế đào tạo dại học và cao đẳng hệ chính quy theo học chế tin chỉ
        ban hành theo quyết định số 804/QĐ-ĐHBK- ĐTĐH ngày 17/8/2007, quy chế sửa
        đổi ban hành theo quyết định số 34/QĐ-ĐHBK- ĐTĐH ngày 18/3/2009 và quyết
        định số 450b/ĐH-BKHN- ĐTĐH ngày 16/8/2010 của Hiệu trưởng trường Đại học
            Bách Khoa Hà Nội;</div>
        <div>&nbsp; &nbsp; &nbsp;Căn cứ quyết định số 2524/QĐ-ĐHBK- HCTH của Hiệu trưởng trường ĐHBK
        Hà Nội ngày 15/10/2012 về việc phân cấp quản lý cho các Học viện, Viện nghiên
            cứu cà các trung tâm nghiên cứu (Thuộc trường);</div>
        <div>&nbsp; &nbsp; &nbsp;Xét đề nghị của các ông bà trưởng bộ môn thuộc viện Công nghệ thông tin và
            truyền thông;</div>
        <div style="margin-bottom: 10px; text-align: center"><b>QUYẾT ĐỊNH:</b></div>
        <div><b>&nbsp; &nbsp; &nbsp;Điều 1.</b> Cử đoàn sinh viên gồm 2 sinh viên do giảng viên {{ $lecture->qualification . ' ' . $lecture->name }}
        thuộc bộ môn Công nghệ phần mềm làm trưởng đoàn đi thực tập tại {{ $company->name }} từ ngày {{ date('d/m/Y', strtotime($internshipCourse->from_date)) }} đến ngày
            {{ date('d/m/Y', strtotime($internshipCourse->to_date)) }} . Danh sách sinh viên được cử đi kèm theo quyết định này;</div>
        <div><b>&nbsp; &nbsp; &nbsp;Điều 2.</b> Giảng viên và các sinh viên của đoàn được hưởng chế độ và tiền phụ
            cấp theo quy định hiện hành;</div>
        <div><b>&nbsp; &nbsp; &nbsp;Điều 3.</b> Các ông bà trưởng bộ môn, giảng viên, sinh viên có tên trong quyết
        định này và các cá nhân liên quan thuộc Viện Công nghệ thông tin và Truyền thông
            chịu trách nhiệm thi hành quyết định này./.</div>
    </div>

    <div style="margin-left: 70px">
        <table style="border: hidden" width="100%">
            <tbody>
            <tr>
                <td style="border: hidden">
                    <div><b>Nơi nhận:</b></div>
                    <div>- Như điều 3 </div>
                    <div>- Lưu: VT Viện CNTT&amp;TT</div>
                </td>
                <td style="border: hidden">
                    <b>VIỆN TRƯỞNG</b>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div style="margin-top: 30px">
        <div style="text-align: center; font-weight: bold">
            <div>Viện công nghệ thông tin và truyền thông</div>
            <div>Bộ môn: {{ $lecture->address }}</div>
            <div>DANH SÁCH SINH VIÊN ĐI THỰC TẬP</div>
        </div>
    </div>

    <div style="margin-top: 20px; margin-left: 70px">
        <div class="mar-bottom">Giáo viên trưởng đoàn: {{ $lecture->qualification . ' ' . $lecture->name }}</div>
        <div class="mar-bottom">Thời gian thực tập: {{ date('d/m/Y', strtotime($internshipCourse->from_date)) }}
            - {{ date('d/m/Y', strtotime($internshipCourse->to_date)) }}</div>
        <div class="mar-bottom">Địa điểm thực tập: {{ $company->name }}</div>
        <div class="mar-bottom">Khoảng cách:</div>
        <div class="mar-bottom">Môn học: thực tập kỹ thuật Mã môn: {{ $classSubject->subject }}</div>
    </div>
    <div style="margin-left: 70px; margin-top: 20px">
        <table width="100%">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>MSSV</td>
                    <td>Họ và tên</td>
                    <td>Lớp/Khóa</td>
                    <td>Mã lớp</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach($listGroup as $item)
                    @php
                        $studentInternshipCourse = \App\StudentInternShipCourse::where([
                            'student_id' => $item->student_id,
                            'internship_course_id' => $item->internship_course_id
                        ])->first();
                    @endphp
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $item->student->msv }}</td>
                        <td>{{ $item->student->name }}</td>
                        <td>{{ $item->student->class }}</td>
                        <td>{{ $studentInternshipCourse->class_code }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px">(Danh sách này gồm {{ count($listGroup) }} người)</div>

        <div style="margin-top: 40px">
            <table width="100%" style="border: hidden">
                <tbody>
                    <tr>
                        <td style="border: hidden; text-align: center"><b>BAN LÃNH ĐẠO VIỆN</b></td>
                        <td style="border: hidden; text-align: center">
                            <div> Hà Nội, ngày {{date('d',strtotime(date('Y-m-d')))}}
                                tháng {{date('m',strtotime(date('Y-m-d')))}}
                                năm {{date('Y',strtotime(date('Y-m-d')))}}</div>
                            <div><b>TRƯỞNG BỘ MÔN</b></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 150px; text-align: center">
            <b>Xác nhận của cơ sở thực tập</b>
        </div>
    </div>

    <div class="page-break"></div>

    <div style="margin-top: 30px;">
        <div style="text-align: center; width: 50%; display: inline-block">
            <div>TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI</div>
            <div>VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG</div>
            <div>––––––––––––</div>
            <div>
                <div>Viện Công nghệ thông tin và truyền thông</div>
                <div>Bộ môn: {{  $lecture->address }}</div>
            </div>
        </div><div style="text-align: center; width: 50%; display: inline-block; padding-bottom: 70px">
            <span>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span>Độc Lập – Tự do – Hạnh phúc</span><br>
            <span>––––––––––––––––––––––––––––</span><br>
        </div>
    </div>

    <div style="margin-top: 20px; text-align: center">
        <div><b>BÁO CÁO THỰC TẬP</b></div>
        <div>Số quyết định thực tập: 7/QĐ-CNTT- TT-TTDN ngày {{date('d/m/Y',strtotime(date('Y-m-d'))) }}</div>
        <div><b>(Báo cáo này do giáo viên trưởng đoàn làm)</b></div>
    </div>

    <div style="margin-top: 20px; margin-left: 70px">
        <div>1. Số lượng sinh viên toàn đoàn {{ count($listGroup) }}</div>
        <div>2. Địa điểm thực tập {{ $company->name }}</div>
        <div>
            3. Thời gian thực tập từ ngày {{ date('d/m/Y', strtotime($internshipCourse->from_date)) }}
            đến ngày {{ date('d/m/Y', strtotime($internshipCourse->to_date)) }}
        </div>
        <div>
            4. Họ và tên các bộ trưởng đoàn: {{ $lecture->name }}
        </div>
        <div style="padding-left: 21px">
            Họ và tên sinh viên thực tập/trưởng nhóm: {{ $listGroup->first()->student->name }}
        </div>
        <div>5. Nội dung của đợt thực tập</div>
        <div style="margin-bottom: 70px">
        </div>
        <div style="margin-top: 20px">Người hướng dẫn (trong và ngoài trường)</div>
        <div style="margin-top: 20px">
            <table width="100%">
                <thead>
                <tr style="text-align: center">
                    <td>STT</td>
                    <td>Người hướng dẫn</td>
                    <td>Nội dung</td>
                    <td>Số giờ</td>
                    <td>Ghi chú</td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $lecture->name }}</td>
                        <td>Giáo viên hướng dẫn</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-break"></div>

    <div style="margin-top: 30px; margin-left: 70px">
        <div style="margin-top: 20px">6. Kết quả đạt được</div>
        <div>
            <div>- Khá giỏi:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
            <div>- Trung bình:&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
            <div>- Kém:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;%)</div>
            <div>- Khen thưởng, kỉ luật</div>
        </div>
        <div>7. Thuận lợi, khó khăn, kiến nghị:</div>
        <div style="padding-left: 20px">
            <div>- Thuận lợi: </div>
            <div>- Khó khăn: </div>
            <div>- Kiến nghị: </div>
        </div>
        <div style="width: 100%; margin-top: 50px">
            <table width="100%" style="border: hidden">
                <tbody>
                <tr>
                    <td style="border: hidden; text-align: center"><b>NHẬN XÉT CỦA CƠ SỞ</b></td>
                    <td style="border: hidden; text-align: center">
                        <div> Hà Nội, ngày {{date('d',strtotime(date('Y-m-d')))}}
                            tháng {{date('m',strtotime(date('Y-m-d')))}}
                            năm {{date('Y',strtotime(date('Y-m-d')))}}</div>
                        <div><b>GIẢNG VIÊN PHỤ TRÁCH</b></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
