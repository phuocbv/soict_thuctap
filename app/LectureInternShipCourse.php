<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureInternShipCourse extends Model
{
    public $table = 'lecture_internship_course';

    public function internshipCourse()
    {
        return $this->belongsTo(InternShipCourse::class, 'internship_course_id');
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_id');
    }

    public function lectureReports()
    {
        return $this->hasMany(LectureReport::class, 'lecture_in_course_id');
    }

    /**
     * internship_course_id- lecture_id ! trong mot khoa thuc tap
     *
     * @param $internShipCourseID
     * @param $lectureID
     * @return bool
     */
    public static function checkLectureInternShipCourse($lectureID, $internShipCourseID)
    {
        $check = LectureInternShipCourse::where('lecture_id', '=', $lectureID)
            ->where('internship_course_id', '=', $internShipCourseID)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * insert lecture_internship_course
     *
     * @param $lectureID
     * @param $internShipCourseID
     */
    public static function insertLectureInternShipCourse($lectureID, $internShipCourseID)
    {
        $li = new LectureInternShipCourse();
        $li->lecture_id = $lectureID;
        $li->internship_course_id = $internShipCourseID;
        $li->save();
    }

    /**
     * get list lecture_internship_course
     *
     * @param $internShipCourseID
     * @return mixed
     */
    public static function getLectureInCourse($internShipCourseID)
    {
        $lic = LectureInternShipCourse::where('internship_course_id', '=', $internShipCourseID)->get();
        return $lic;
    }

    /**
     * lay cac khoa thuc tap ma giang vien tham gia
     *
     * @param $lectureID
     * @return mixed
     */
    public static function getLectureInCourseFLID($lectureID)
    {
        $lectureInCourse = LectureInternShipCourse::where('lecture_id', '=', $lectureID)->get();
        return $lectureInCourse;
    }

    /**
     * lấy được một bản ghi duy nhất theo lectureID và internshipCourseID
     *
     * @param $lectureID
     * @param $courseID
     * @return mixed
     */
    public static function getLecInCourse($lectureID, $courseID)
    {
        $lecInCourse = LectureInternShipCourse::where('lecture_id', '=', $lectureID)
            ->where('internship_course_id', '=', $courseID)->get();
        return $lecInCourse;
    }

    /**
     * xoa nhung khoa thuc tap ma giang vien da tham gia
     *
     * @param $lectureID
     */
    public static function deleteLectureJoin($lectureID)
    {
        $lectureInCourse = LectureInternShipCourse::where('lecture_id', '=', $lectureID)->get();
        foreach ($lectureInCourse as $lic) {
            $find = LectureInternShipCourse::find($lic->id);
            $find->delete();
        }
    }

    public static function deleteLectureInCourse($courseID)
    {
        $lectureInCourse = LectureInternShipCourse::where('internship_course_id', '=', $courseID)->get();
        foreach ($lectureInCourse as $lic) {
            $find = LectureInternShipCourse::find($lic->id);
            $find->delete();
        }
    }

    /**
     * xoa ban ghi licInCourse khi cho gian vien dung quan ly thuc tap
     * hoac thay the bang mot giang vien khac
     *
     * @param $lectureID
     * @param $courseID
     */
    public static function deleteFLectureIDCourseID($lectureID, $courseID)
    {
        $lecInCourse = LectureInternShipCourse::getLecInCourse($lectureID, $courseID);
        foreach ($lecInCourse as $lic) {
            $find = LectureInternShipCourse::find($lic->id);
            $find->delete();
        }
    }
}
