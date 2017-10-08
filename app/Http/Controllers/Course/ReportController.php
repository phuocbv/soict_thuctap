<?php

namespace App\Http\Controllers\Course;

use App\LectureReport;
use App\StudentReport;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function studentReport(Request $request)
    {
        StudentReport::writeReport($request->input('work'), $request->input('result'),
            $request->input('advantage'), $request->input('disAdvantage'),
            $request->input('school'), decrypt($request->input('studentInCourseID')), date('Y-m-d H:i:s', strtotime(date('Y-m-d'))));
        return redirect()->back()->with('writeReportSuccess', 'Viết báo cáo thành công');
    }

    public function editReport(Request $request)
    {
        $studentReportID = decrypt($request->input('studentReportID'));
        if (StudentReport::checkReport($studentReportID)) {
            StudentReport::editReport($studentReportID, $request->input('work'), $request->input('result'),
                $request->input('advantage'), $request->input('disAdvantage'),
                $request->input('school'), date('Y-m-d H:i:s', strtotime(date('Y-m-d'))));
            return redirect()->back()->with('editReportSuccess', 'sửa báo cáo thành công');
        } else {
            return redirect()->back()->with('editError', 'đã xảy ra lỗi');
        }
    }

    public function lectureReport(Request $request)
    {
        LectureReport::insert($request->input('advantage'), $request->input('disAdvantage'), $request->input('proposal'),
            $request->input('assessGeneral'), decrypt($request->input('lectureInCourseID')), date('Y-m-d H:i:s', strtotime(date('Y-m-d'))));
        return redirect()->back()->with('writeReportSuccess', 'Vi?t báo cáo thành công');
    }

    public function lectureEditReport(Request $request)
    {
        $lectureReportID = decrypt($request->input('lectureReportID'));
        if (LectureReport::check($lectureReportID)) {
            LectureReport::edit($lectureReportID, $request->input('advantage'), $request->input('disAdvantage'),
                $request->input('proposal'), $request->input('assessGeneral'), date('Y-m-d H:i:s', strtotime(date('Y-m-d'))));
            return redirect()->back()->with('editReportSuccess', 'sửa báo cáo thành công');
        } else {
            return redirect()->back()->with('editError', 'đã xảy ra lỗi');
        }
    }
}
