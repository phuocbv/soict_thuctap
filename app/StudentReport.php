<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentReport extends Model
{
    public $table = 'student_report';

    /**
     * lay bao cao cua sinh vien
     *
     * @param $studentInCourseID
     * @return mixed
     */
    public static function getStudentReport($studentInCourseID)
    {
        $studentReport = StudentReport::where('student_in_course_id', '=', $studentInCourseID)->get();
        return $studentReport;
    }

    public static function writeReport($assignWork, $result, $advantage, $disAdvantage, $school, $studentInCourseID, $dateReport)
    {
        $studentReport = new StudentReport();
        $studentReport->assign_work = $assignWork;
        $studentReport->result = $result;
        $studentReport->advantage = $advantage;
        $studentReport->dis_advantage = $disAdvantage;
        $studentReport->school = $school;
        $studentReport->student_in_course_id = $studentInCourseID;
        $studentReport->date_report = $dateReport;
        $studentReport->save();
    }

    public static function checkReport($id)
    {
        $check = StudentReport::where('id', '=', $id)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function editReport($id, $assignWork, $result, $advantage, $disAdvantage,
                                      $school, $dateReport)
    {
        $studentReport = StudentReport::find($id);
        $studentReport->assign_work = $assignWork;
        $studentReport->result = $result;
        $studentReport->advantage = $advantage;
        $studentReport->dis_advantage = $disAdvantage;
        $studentReport->school = $school;
        $studentReport->date_report = $dateReport;
        $studentReport->save();
    }

    /**
     * xoa bao cao cua sinh vien
     *
     * @param $studentInCourseID
     */
    public static function deleteReport($studentInCourseID)
    {
        $studentReport = StudentReport::where('student_in_course_id', '=', $studentInCourseID)->get();
        if (count($studentReport) > 0) {
            $studentReportID = $studentReport->first()->id;
            $find = StudentReport::find($studentReportID);
            $find->delete();
        }
    }
}
