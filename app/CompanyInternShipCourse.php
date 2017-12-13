<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInternShipCourse extends Model
{
    public $table = 'company_internship_course';

    protected $fillable = ['company_id', 'internship_course_id', 'student_quantity', 'hr_name'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function internShipCourse()
    {
        return $this->belongsTo('App\InternShipCourse', 'internship_course_id');
    }

    /**
     * internship_course_id- company_id ! trong mot khoa thuc tap
     *
     * @param $companyID
     * @param $internShipCourseID
     * @return bool
     */
    public static function checkCompanyInternShipCourse($companyID, $internShipCourseID)
    {
        $check = CompanyInternShipCourse::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $internShipCourseID)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * insert company_internship_course
     *
     * @param $companyID
     * @param $internShipCourseID
     */
    public static function insertCompanyInternShipCourse($companyID, $internShipCourseID, $quantity)
    {
        $ci = new CompanyInternShipCourse();
        $ci->company_id = $companyID;
        $ci->internship_course_id = $internShipCourseID;
        $ci->student_quantity = $quantity;
        $ci->save();
    }

    public static function getCompanyInternShipCourse($internShipCourseID)
    {
        $companyInternShipCourse = CompanyInternShipCourse::where('internship_course_id', '=', $internShipCourseID)->paginate(3);
        return $companyInternShipCourse;
    }

    public static function getCompanyInCourse($internShipCourseID)
    {
        $companyInternShipCourse = CompanyInternShipCourse::where('internship_course_id', '=', $internShipCourseID)->get();
        return $companyInternShipCourse;
    }

    /**
     * get company internship course follow company_id and internship_course_id
     *
     * @param $companyID
     * @param $internShipCourseID
     * @return mixed
     */
    public static function getComInCourse($companyID, $internShipCourseID)
    {
        $comInCourse = CompanyInternShipCourse::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $internShipCourseID)->get();
        return $comInCourse;
    }

    /**
     * check full student in one company when register
     *
     * @param $studentQuantity
     * @param $countStudent
     * @return bool
     */
    public static function checkRegisterFull($countStudent, $studentQuantity)
    {
        if ($studentQuantity == "") {
            return false;
        } else {
            if ($countStudent < $studentQuantity) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * lay chi tieu tiep nhan sinh vien cua doanh nghiep
     *
     * @param $companyID
     * @param $internShipCourseID
     * @return int
     */
    public static function getQuantity($companyID, $internShipCourseID)
    {
        $quantity = 0;
        $comInCourse = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID);
        foreach ($comInCourse as $cic) {
            $quantity = $cic->student_quantity;
        }
        return $quantity;
    }

    /**
     * insert into company_internship_course
     *
     * @param $companyID
     * @param $courseID
     * @param $studentQuantity
     */
    public static function insert($companyID, $courseID, $studentQuantity, $requireSkill, $hrName)
    {
        $companyInternshipCourse = new CompanyInternShipCourse();
        $companyInternshipCourse->company_id = $companyID;
        $companyInternshipCourse->internship_course_id = $courseID;
        $companyInternshipCourse->student_quantity = $studentQuantity;
        $companyInternshipCourse->require_skill = $requireSkill;
        $companyInternshipCourse->hr_name = $hrName;
        $companyInternshipCourse->save();
    }

    /**
     * update student_quantity
     *
     * @param $companyID
     * @param $internShipCourseID
     * @param $studentQuantity
     */
    public static function updateStudentQuantity($companyID, $internShipCourseID, $studentQuantity)
    {
        $companyInternShipCourse = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID);
        $companyInternShipCourseID = "";
        foreach ($companyInternShipCourse as $cic) {
            $companyInternShipCourseID = $cic->id;
        }
        $find = CompanyInternShipCourse::find($companyInternShipCourseID);
        $find->student_quantity = $studentQuantity;
        $find->save();
    }

    public static function updateRequireSkill($companyID, $internShipCourseID, $requireSkill)
    {
        $companyInternShipCourse = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID);
        $companyInternShipCourseID = "";
        foreach ($companyInternShipCourse as $cic) {
            $companyInternShipCourseID = $cic->id;
        }
        $find = CompanyInternShipCourse::find($companyInternShipCourseID);
        $find->require_skill = $requireSkill;
        $find->save();
    }

    public static function updateHrName($companyID, $internShipCourseID, $hrName)
    {
        $companyInternShipCourse = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID);
        foreach ($companyInternShipCourse as $cic) {
            $companyInternShipCourseID = $cic->id;
            $find = CompanyInternShipCourse::find($companyInternShipCourseID);
            $find->hr_name = $hrName;
            $find->save();
        }
    }

    /**
     * delete company_internship_course
     * @param $companyID
     * @param $internShipCourseID
     */
    public static function deleteCompanyInCourse($companyID, $internShipCourseID)
    {
        $companyInternShipCourse = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID);
        $companyInternShipCourseID = "";
        foreach ($companyInternShipCourse as $cic) {
            $companyInternShipCourseID = $cic->id;
        }
        $find = CompanyInternShipCourse::find($companyInternShipCourseID);
        $find->delete();
    }

    /**
     * lay danh sach khoa thuc tap ma giang vien tham gia
     *
     * @param $companyID
     * @return mixed
     */
    public static function getCompanyInCourseFCID($companyID)
    {
        $comInCourse = CompanyInternShipCourse::where('company_id', '=', $companyID)->get();
        return $comInCourse;
    }

    /**
     * xoa khoa thuc tap ma cong ty da dang ky
     *
     * @param $companyID
     */
    public static function deleteCompanyJoin($companyID)
    {
        $companyInCourse = CompanyInternShipCourse::where('company_id', '=', $companyID)->get();
        foreach ($companyInCourse as $cic) {
            $find = CompanyInternShipCourse::find($cic->id);
            $find->delete();
        }
    }

    public static function deleteCIC($courseID)
    {
        $companyInCourse = CompanyInternShipCourse::where('internship_course_id', '=', $courseID)->get();
        foreach ($companyInCourse as $cic) {
            $find = CompanyInternShipCourse::find($cic->id);
            $find->delete();
        }
    }
}
