<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timekeeping extends Model
{
    public $table = 'time_keeping';

    public static function getFollowCourseIDCompanyID($companyID, $courseID)
    {
        $timekeeping = Timekeeping::where('company_id', '=', $companyID)
            ->where('course_id', '=', $courseID)
            ->get();
        return $timekeeping;
    }

    public static function getFollowStudentIDCourseID($studentID, $courseID)
    {
        $timekeeping = Timekeeping::where('student_id', '=', $studentID)
            ->where('course_id', '=', $courseID)
            ->get();
        return $timekeeping;
    }

    public static function insert($studentID, $courseID, $companyID, $day, $month, $dateFull)
    {
        $timekeeping = new Timekeeping();
        $timekeeping->student_id = $studentID;
        $timekeeping->course_id = $courseID;
        $timekeeping->company_id = $companyID;
        $timekeeping->day = $day;
        $timekeeping->month = $month;
        $timekeeping->date_full = $dateFull;
        $timekeeping->save();
    }

    public static function check($studentID, $courseID, $companyID, $dateFull)
    {
        $check = Timekeeping::where('student_id', '=', $studentID)
            ->where('course_id', '=', $courseID)
            ->where('company_id', '=', $companyID)
            ->where('date_full', '=', $dateFull)
            ->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function check2($studentID, $courseID, $dateFull)
    {
        $check = Timekeeping::where('student_id', '=', $studentID)
            ->where('course_id', '=', $courseID)
            ->where('date_full', '=', $dateFull)
            ->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * xoa nhung bang cong cua sinh vien
     *
     * @param $studentID
     */
    public static function deleteTimekeepingStudent($studentID)
    {
        $timekeeping = Timekeeping::where('student_id', '=', $studentID)->get();
        foreach ($timekeeping as $tk) {
            $find = Timekeeping::find($tk->id);
            $find->delete();
        }
    }

    /**
     * xoa bang cong cua sinh vien trong ky
     *
     * @param $courseID
     */
    public static function deleteTimeKeepingCourse($courseID)
    {
        $timekeeping = Timekeeping::where('course_id', '=', $courseID)->get();
        foreach ($timekeeping as $tk) {
            $find = Timekeeping::find($tk->id);
            $find->delete();
        }
    }

    /**
     * xoa bang cong cua sinh vien theo ma sinh vien, ky hoc
     *
     * @param $studentID
     * @param $courseID
     */
    public static function deleteFStudentCourse($studentID, $courseID)
    {
        $timekeeping = Timekeeping::where('student_id', '=', $studentID)
            ->where('course_id', '=', $courseID)
            ->get();
        foreach ($timekeeping as $tk) {
            $find = Timekeeping::find($tk->id);
            $find->delete();
        }
    }
}
