<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 12/12/2017
 * Time: 19:10
 */

namespace App\Http\Controllers\Course;


use App\Company;
use App\Http\Controllers\Controller;
use App\InternShipGroup;
use App\LectureInternShipCourse;
use App\StudentInternShipCourse;
use Illuminate\Http\Request;

class LectureInCourseController extends Controller
{
    public function showListLectureManageStudent(Request $request)
    {
        $param = $request->only('lectureInCourseId');
        $lectureInternshipCourse = LectureInternShipCourse::find($param['lectureInCourseId']);

        //trong trường hợp không tìm thấy giảng viên được phân công tương ứng
        if (!$lectureInternshipCourse) {
            return $this->responseJson([
                'status' => 'error',
                'data' => [],
                'messages' => 'Không tìm thấy giảng viên phân công tương ứng'
            ]);
        }

        //tìm danh sách sinh viên được phân công cho giảng viên
        //với điều kiện kì thực tập và id giảng viên truyền vào
        $listInternshipGroup = InternShipGroup::where([
            'internship_course_id' => $lectureInternshipCourse->internship_course_id,
            'lecture_id' => $lectureInternshipCourse->lecture_id
        ])->get();
        //duyet từng phần tử để lấy giá trị subject
        $listInternshipGroup->each(function ($item) {
            //lấy giá trị subject trong table student_internship_course
            $item['subject'] = StudentInternShipCourse::where([
                'internship_course_id' => $item->internship_course_id,
                'student_id' => $item->student_id
            ])->first()->subject;
            $item['name_company'] = Company::find($item->company_id)->name;
        });
        $listInternshipGroup = $listInternshipGroup->groupBy('company_id');

        return view('manage-internship-course.lecture-in-internship-course')->with([
            'listInternshipGroup' => $listInternshipGroup
        ]);
    }
}