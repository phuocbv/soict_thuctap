<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentTmp extends Model
{
    public $table = "student_tmp";

    /**
     * insert new student_tmp
     *
     * @param $msv
     * @param $courseTerm
     * @param $status
     * @param $subject
     */
    public static function insert($msv, $courseTerm, $subject, $status)
    {
        $studentTmp = new StudentTmp();
        $studentTmp->msv = $msv;
        $studentTmp->course_term = $courseTerm;
        $studentTmp->subject = $subject;
        $studentTmp->status = $status;
        $studentTmp->save();
    }

    /**
     * check msv-course_term. pair are !
     *
     * @param $msv
     * @param $courseTerm
     * @return bool
     */
    public static function checkMSVCourseTerm($msv, $courseTerm)
    {
        $check = StudentTmp::where('msv', '=', $msv)->where('course_term', '=', $courseTerm)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * get student_tmp
     *
     * @param $courseTerm
     * @param $status
     * @return mixed
     */
    public static function getStudentTmp($courseTerm, $status)
    {
        $studentTmp = StudentTmp::where('course_term', '=', $courseTerm)->
        where('status', '=', $status)->get();
        return $studentTmp;
    }

    /**
     * delete student_tmp
     *
     * @param $id
     */
    public static function deleteStudentTmp($id)
    {
        $find = StudentTmp::find($id);
        $find->delete();
    }


    /**
     * lay studentTmp follow msv, courseTerm
     * FMC: follow msv courseTerm
     *
     * @param $msv
     * @param $courseTerm
     * @return mixed
     */
    public static function getStudentTmpFMC($msv, $courseTerm)
    {
        $studentTmp = StudentTmp::where('msv', '=', $msv)
            ->where('course_term', '=', $courseTerm)->get();
        return $studentTmp;
    }

    public static function deleteStudentTmp2($msv, $courseTerm)
    {
        $studentTmp = StudentTmp::getStudentTmpFMC($msv, $courseTerm);
        foreach ($studentTmp as $s) {
            StudentTmp::deleteStudentTmp($s->id);
        }
    }

    public static function getStudent($msv, $status)
    {
        $student = StudentTmp::where('msv', '=', $msv)
            ->where('status', '=', $status)->get();
        return $student;
    }

    /**
     * xoa sinh vien trong bang tam theo ma sinh vien va trang thai
     *
     * @param $msv
     * @param $status
     */
    public static function deleteStudent($msv, $status)
    {
        $student = StudentTmp::getStudent($msv, $status);
        foreach ($student as $s) {
            $find = StudentTmp::find($s->id);
            $find->delete();
        }
    }
}
