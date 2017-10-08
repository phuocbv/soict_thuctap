<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternShipCourse extends Model
{
    public $table = 'internship_course';

    public function studentInternShipCourse()
    {
        return $this->hasMany('StudentInternShipCourse', 'internship_course_id');
    }

    public function companyInternShipCourse()
    {
        return $this->hasMany('CompanyInternShipCourse', 'internship_course_id');
    }

    public function lectureInternShipCourse()
    {
        return $this->hasMany('LectureInternShipCourse', 'internship_course_id');
    }

    public function internShipGroup()
    {
        return $this->hasMany('InternShipGroup', 'internship_course_id');
    }

    public static function allCourse()
    {
        $course = InternShipCourse::all();
        return $course;
    }

    /**
     *
     *
     * @param $courseTerm
     * @return bool
     */
    public static function checkCourse($courseTerm)
    {
        $check = InternShipCourse::where('course_term', '=', $courseTerm)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * insert new course
     *
     * @param $name
     * @param $courseTerm
     * @param $status
     * @param $fromDate
     * @param $toDate
     */
    public static function insertInternShipCourse($name, $courseTerm, $status, $fromDate, $toDate, $planID)
    {
        $internShipCourse = new InternShipCourse();
        $internShipCourse->name = $name;
        $internShipCourse->course_term = $courseTerm;
        $internShipCourse->status = $status;
        $internShipCourse->from_date = $fromDate;
        $internShipCourse->to_date = $toDate;
        $internShipCourse->plan_id = $planID;
        $internShipCourse->save();
    }

    /**
     * get internship course
     *
     * @param $courseTerm
     * @return mixed
     */
    public static function getInternShipCourse($courseTerm)
    {
        $internShipCourse = InternShipCourse::where('course_term', '=', $courseTerm)->get();
        return $internShipCourse;
    }

    /**
     * get internshipCourse follow id
     *
     * @param $courseID
     * @return mixed
     */
    public static function getInCourse($courseID)
    {
        $IC = InternShipCourse::where('id', '=', $courseID)->get();
        return $IC;
    }

    /**
     * get internship course of 1 year follow year
     *
     * @param $year
     * @return array
     */
    public static function getCourseFollowYear($year)
    {
        $term1 = $year . '1';
        $term2 = $year . '2';
        $term3 = $year . '3';
        $inCourse1 = InternShipCourse::getInternShipCourse($term1);
        $inCourse2 = InternShipCourse::getInternShipCourse($term2);
        $inCourse3 = InternShipCourse::getInternShipCourse($term3);
        $arrCourse = array();
        foreach ($inCourse1 as $i1) {
            $arrCourse[] = $i1;
        }
        foreach ($inCourse2 as $i2) {
            $arrCourse[] = $i2;
        }
        foreach ($inCourse3 as $i3) {
            $arrCourse[] = $i3;
        }
        return $arrCourse;
    }

    /**
     * update time register
     *
     * @param $courseID
     * @param $startRegister
     * @param $finishRegister
     */
    public static function updateTimeRegister($courseID, $startRegister, $finishRegister)
    {
        $find = InternShipCourse::find($courseID);
        $find->start_register = $startRegister;
        $find->finish_register = $finishRegister;
        $find->save();
    }

    /**
     * kiem tra su ton tai cua khoa hoc
     *
     * @param $courseID
     * @return bool
     */
    public static function checkCourseFollowID($courseID)
    {
        $check = InternShipCourse::where('id', '=', $courseID)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update status internship_course
     *
     * @param $courseID
     */
    public static function updateStatus($courseID)
    {
        $internshipCourse = InternShipCourse::find($courseID);
        $internshipCourse->status = 'đã phân công';
        $internshipCourse->save();
    }

    public static function deleteCourse($courseID)
    {
        $find = InternShipCourse::find($courseID);
        $find->delete();
    }

    public static function getCourseFPlanID($planID)
    {
        $course = InternShipCourse::where('plan_id', '=', $planID)->get();
        return $course;
    }
}
