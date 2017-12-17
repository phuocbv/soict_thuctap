<?php

namespace App\Http\Controllers;

use App\InternShipCourse;
use App\InternShipGroup;
use App\StudentInternShipCourse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportAssignToExcel(Request $request)
    {
        $param = $request->only('courseId');
        $course = InternShipCourse::find($param['courseId']);
        if (!$course) {
            return;
        }
        $listInternshipGroup = $course->internShipGroup->sortBy('lecture_id');
        $dataExport = collect([]);
        foreach ($listInternshipGroup as $item) {
            $lecture = $item->lecture;
            $company = $item->company;
            $student = $item->student;
            $studentInternshipCourse = StudentInternShipCourse::where([
                'internship_course_id' => $course->id,
                'student_id' => $student->id
            ])->first();

            $dataExport->push([
                'email_lecture' => $lecture->user->email,
                'name_lecture' => $lecture->name,
                'email_company' => $company->user->email,
                'name_company' => $company->name,
                'hr_name' => $company->hr_name,
                'hr_mail' => $company->hr_mail,
                'hr_phone' => $company->hr_phone,
                'mssv' => $student->msv,
                'name_student' => $student->name,
                'class' => $student->class,
                'grade' => $student->grade,
                'subject' => $studentInternshipCourse->subject,
                'class_code' => $studentInternshipCourse->class_code,
                'program_university' => $student->program_university,
                'note' => ''
            ]);
        }

        return Excel::create('assignStudent', function($excel) use ($dataExport) {
            $excel->sheet('assign', function($sheet) use ($dataExport) {
                $sheet->fromArray($dataExport);
            });
            $excel->sheet('note', function($sheet) {
            });
        })->download();
    }
}
