<?php

namespace App\Http\Controllers;

use App\ClassSubject;
use App\Company;
use App\InternShipCourse;
use App\InternShipGroup;
use App\Lecture;
use App\LectureInternShipCourse;
use App\StudentInternShipCourse;
use FontLib\TrueType\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;

class PrintController extends Controller
{
    public function printCommentOfLecture(Request $request)
    {
        $param = $request->only('licId');
        $lectureInternShipCourse = LectureInternShipCourse::find($param['licId']);

        if (!$lectureInternShipCourse) {
            return $this->responseJson([
                'status' => false,
                'data' => [
                    'licId' => $param['licId']
                ],
                'messages' => [
                    'Not find lecture internship course',
                ]
            ]);
        }

        $group = InternShipGroup::getGroupFollowLI($lectureInternShipCourse->lecture_id,
            $lectureInternShipCourse->internship_course_id);
        $companies = InternShipGroup::getGroupFollowLIGroupByCompany($lectureInternShipCourse->lecture_id,
            $lectureInternShipCourse->internship_course_id);
        $listCompany = collect([]);
        $companies->each(function ($item, $key) use ($listCompany) {
            $listCompany->push(Company::find($key));
        });

        $pdf = PDF::loadView('reports.lecture-report', compact('lectureInternShipCourse', 'listCompany', 'group'));
        return $pdf->download('lectureComment.pdf');
    }

    public function demoPrint()
    {
        $pdf = PDF::loadView('reports.report-of-lecture');
        return $pdf->download('demoprint.pdf');
    }

    public function setDataPrint(Request $request)
    {
        $param = $request->only('content', 'name');
        session([DATA_PRINT => $param]);
        return $this->responseJson([
            'status' => 'success',
            'data' => null,
            'messages'=> []
        ]);
    }

    /**
     * ham in file pdf
     * dữ liệu lấy từ session
     *
     * @param Request $request
     * @return mixed
     */
    public function printReport(Request $request)
    {
        $type = $request->type;
        $type = $type ? $type : 'portrait';
        $param = session()->get(DATA_PRINT);
        $content = $param['content'];
        $name = $param['name'] . '.pdf';
        $pdf = PDF::loadView('reports.index', compact('content'))->setPaper('a4', $type);
        return $pdf->download($name);
    }

    public function printLectureInCourse(Request $request)
    {
       // $param = $request->only('lectureId', 'internshipCourseId', 'courseTerm');

        $param = session()->get(DATA_PRINT);
        $data = $param['content'];

        $listGroup = InternShipGroup::where([
            'internship_course_id' => $data['internshipCourseId'],
            'lecture_id' => $data['lectureId'],
            'company_id' => $data['companyId']
        ])->get();
        //danh sach sinh vien đăn kí thưc tạp
        $listGroup->each(function ($item) {
            //lấy giá trị subject trong table student_internship_course
            $item['subject'] = StudentInternShipCourse::where([
                'internship_course_id' => $item->internship_course_id,
                'student_id' => $item->student_id
            ])->first()->subject;
        });
        $lecture = Lecture::find($data['lectureId']);
        $company = Company::find($data['companyId']);
        $classSubject = ClassSubject::where('subject', strtoupper($data['courseTerm']))->first();
        $internshipCourse = InternShipCourse::find($data['internshipCourseId']);
        $listGroup = $listGroup->where('subject', $data['courseTerm']);
        $pdf = PDF::loadView('reports.report-of-lecture', compact('lecture','company', 'classSubject', 'group', 'internshipCourse', 'listGroup'));
        return $pdf->download($param['name'] . '.pdf');
    }
}
