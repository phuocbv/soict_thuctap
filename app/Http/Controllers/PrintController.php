<?php

namespace App\Http\Controllers;

use App\Company;
use App\InternShipCourse;
use App\InternShipGroup;
use App\Lecture;
use App\LectureInternShipCourse;
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
}
