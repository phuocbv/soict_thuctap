<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInternShipCourse extends Model
{
    public $table = 'student_internship_course';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function internShipCourse()
    {
        return $this->belongsTo('InternShipCourse', 'internship_course_id');
    }

    public function classSubject()
    {
        return $this->hasOne(ClassSubject::class, 'subject', 'subject');
    }

    /**
     * insert into student_internship_course
     *
     * @param $studentID
     * @param $internShipCourseID
     */
    public static function insertSIC($studentID, $internShipCourseID)
    {
        $sic = new StudentInternShipCourse();
        $sic->student_id = $studentID;
        $sic->internship_course_id = $internShipCourseID;
        $sic->save();
    }

    /**
     * them vao bang S_I co ten mon hoc
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $subject
     */
    public static function insertSICHasSubject($studentID, $internShipCourseID, $subject)
    {
        $sic = new StudentInternShipCourse();
        $sic->student_id = $studentID;
        $sic->internship_course_id = $internShipCourseID;
        $sic->subject = $subject;
        $sic->save();
    }

    /**
     * get student_internship_course follow student_id
     *
     * @param $studentID
     * @return mixed
     */
    public static function getSIC($studentID)
    {
        $sic = StudentInternShipCourse::where('student_id', '=', $studentID)->get();
        return $sic;
    }

    /**
     * upload report_file
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $url
     */
    public static function uploadReport($studentID, $internShipCourseID, $url)
    {
        $sicID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($sicID);
        $find->report_file = $url;
        $find->save();
    }

    /**
     * upload file giang vien nhan xet sinh vien
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $url
     */
    public static function uploadLectureAssess($studentID, $internShipCourseID, $url)
    {
        $studentInCourseID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($studentInCourseID);
        $find->lecture_review_file = $url;
        $find->save();
    }

    /**
     * lay internship_course follow internship_course_id
     *
     * @param $inCourseID
     * @return mixed
     */
    public static function getSICFCourseID($inCourseID)
    {
//        InternShipGroup::where([
//            'internship_course_id' => $inCourseID,
//            'lecture_id' => null
//        ])->get();

        $sic = StudentInternShipCourse::where('internship_course_id', '=', $inCourseID)->get();
        return $sic;
    }

    /**
     * delete student_internship_course
     *
     * @param $studentID
     * @param $courseID
     */
    public static function deleteSIC($studentID, $courseID)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->get();
        $sicID = "";
        foreach ($studentInCourse as $sic) {
            $sicID = $sic->id;
        }
        $find = StudentInternShipCourse::find($sicID);
        $find->delete();
    }

    /**
     * kiem tra su ton tai cua ban ghi student_internship_course
     *
     * @param $studentID
     * @param $courseID
     * @return bool
     */
    public static function checkSI($studentID, $courseID)
    {
        $check = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * lay sinh vien da tham gia khoa thuc tap. Lay nhu nay se lay duoc 1 ban ghi duy nhat
     *
     * @param $studentID
     * @param $courseID
     * @return mixed
     */
    public static function getStudentInCourse($studentID, $courseID)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->get();
        return $studentInCourse;
    }

    /**
     * update điểm giảng viên chấm cho sinh viên
     *
     * @param $studentID
     * @param $courseID
     * @param $lecturePoint
     */
    public static function updateLecturePoint($studentID, $courseID, $lecturePoint)
    {
        $studentInCourseID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($studentInCourseID);
        $find->lecture_point = $lecturePoint;
        $find->save();
    }

    /**
     * cap nhat diem cho sinh vien
     *
     * @param $studentID
     * @param $courseID
     * @param $companyPoint
     */
    public static function updateCompanyPoint($studentID, $courseID, $companyPoint)
    {
        $studentInCourseID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($studentInCourseID);
        $find->company_point = $companyPoint;
        $find->save();
    }

    public static function uploadCompanyAssess($studentID, $internShipCourseID, $url)
    {
        $studentInCourseID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($studentInCourseID);
        $find->company_review_file = $url;
        $find->save();
    }

    public static function uploadTimeKeeping($studentID, $internShipCourseID, $url)
    {
        $studentInCourseID = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->first()->id;
        $find = StudentInternShipCourse::find($studentInCourseID);
        $find->timekeeping_file = $url;
        $find->save();
    }

    /**
     * xóa những khóa thực tập mà sinh viên tham gia
     *
     * @param $studentID
     */
    public static function deleteStudentRegister($studentID)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)->get();
        foreach ($studentInCourse as $sic) {
            $find = StudentInternShipCourse::find($sic->id);
            $find->delete();
        }
    }

    /**
     *
     * @param $courseID
     */
    public static function deleteStudentInCourse($courseID)
    {
        $studentInCourse = StudentInternShipCourse::where('internship_course_id', '=', $courseID)->get();
        foreach ($studentInCourse as $sic) {
            $find = StudentInternShipCourse::find($sic->id);
            $find->delete();
        }
    }

    /**
     * sinh vien xoa dang ky. Khi dang dang ky
     *
     * @param $studentID
     * @param $courseID
     */
    public static function deleteSR($studentID, $courseID)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)
            ->get();
        foreach ($studentInCourse as $sic) {
            $find = StudentInternShipCourse::find($sic->id);
            $find->delete();
        }
    }

    /**
     * them mon hoc cho moi sinh vien khi phan cong
     * mon hoc duoc lay theo danh sach sinh vien da dang ky tren sis
     *
     * @param $studentID
     * @param $courseID
     * @param $subject
     */
    public static function updateSubject($studentID, $courseID, $subject)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)
            ->get();
        foreach ($studentInCourse as $sic) {
            $find = StudentInternShipCourse::find($sic->id);
            $find->subject = $subject;
            $find->save();
        }
    }

    /**
     * cap nhat nhiem vu ma cong ty giao cho sinh vien
     *
     * @param $studentID
     * @param $courseID
     * @param $assignWork
     */
    public static function updateAssignWork($studentID, $courseID, $assignWork)
    {
        $studentInCourse = StudentInternShipCourse::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)
            ->get();
        foreach ($studentInCourse as $sic) {
            $find = StudentInternShipCourse::find($sic->id);
            $find->assign_work = $assignWork;
            $find->save();
        }
    }
}
