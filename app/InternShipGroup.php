<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternShipGroup extends Model
{
    public $table = 'internship_group';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function interShipCourse()
    {
        return $this->belongsTo(InternShipCourse::class, 'internship_course_id');
    }

    /**
     * get group follow studentID and internshipCourseID
     *
     * @param $studentID
     * @param $internshipCourseID
     * @return mixed
     */
    public static function getGroupFollowSI($studentID, $internshipCourseID)
    {
        $group = InternShipGroup::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internshipCourseID)->get();
        return $group;
    }

    /**
     * dem so sinh vien da dang ky vao cong ty
     *
     * @param $companyID
     * @param $internShipCourseID
     * @return mixed
     */
    public static function countStudentInCompany($companyID, $internShipCourseID)
    {
        $count = InternShipGroup::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $internShipCourseID)->count();
        return $count;
    }

    /**
     * get student_id from internship_group
     *
     * @param $companyID
     * @param $internShipCourseID
     * @return mixed
     */
    public static function getStudentID($companyID, $internShipCourseID)
    {
        $studentID = InternShipGroup::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->pluck('student_id');
        return $studentID;
    }

    /**
     * kiem tra sinh vien da dang ky chua
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $companyID
     * @return bool
     */
    public static function checkRegistered($studentID, $internShipCourseID, $companyID)
    {
        $check = InternShipGroup::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)
            ->where('company_id', '=', $companyID)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update group
     *
     * @param $groupID
     * @param $companyID
     */
    public static function updateGroup($groupID, $companyID)
    {
        $group = InternShipGroup::find($groupID);
        $group->company_id = $companyID;
        $group->save();
    }

    /**
     * insert into internship_group
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $companyID
     */
    public static function insertGroup($studentID, $internShipCourseID, $companyID)
    {
        $group = new InternShipGroup();
        $group->student_id = $studentID;
        $group->internship_course_id = $internShipCourseID;
        $group->company_id = $companyID;
        $group->save();
    }

    /**
     * update vote
     *
     * @param $studentID
     * @param $internShipCourseID
     * @param $vote
     */
    public static function upDateVote($studentID, $internShipCourseID, $vote)
    {
        $groupID = InternShipGroup::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $internShipCourseID)->get()->first()->id;
        $find = InternShipGroup::find($groupID);
        $find->student_vote = $vote;
        $find->save();
    }

    public static function deleteGroup($studentID, $courseID)
    {
        $studentInGroup = InternShipGroup::where('student_id', '=', $studentID)
            ->where('internship_course_id', '=', $courseID)->get();
        $sigID = "";
        foreach ($studentInGroup as $sig) {
            $sigID = $sig->id;
        }
        $find = InternShipGroup::find($sigID);
        $find->delete();
    }

    public static function updateLecture($companyID, $courseID, $lectureID)
    {
        $group = InternShipGroup::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $courseID)->get();
        foreach ($group as $g) {
            $find = InternShipGroup::find($g->id);
            $find->lecture_id = $lectureID;
            $find->save();
        }
    }

    /**
     * get group follow internship_course_id
     *
     * @param $courseID
     * @return mixed
     */
    public static function getGroupFCourseID($courseID)
    {
        $group = InternShipGroup::where('internship_course_id', '=', $courseID)->get()->groupBy('company_id');
        return $group;
    }

    /**
     * lay id cua giang vien da duoc phan cong vao mot khoa thuc tap
     *
     * @param $companyID
     * @param $courseID
     * @return mixed
     */
    public static function getLectureID($companyID, $courseID)
    {
        $lecture = InternShipGroup::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $courseID)
            ->get();
        $lectureID = "";
        foreach ($lecture as $l) {
            $lectureID = $l->lecture_id;
            break;
        }
        return $lectureID;
    }

    public static function insertGroupAddLectureID($studentID, $lectureID, $companyID, $courseID)
    {
        $group = new InternShipGroup();
        $group->student_id = $studentID;
        $group->lecture_id = $lectureID;
        $group->company_id = $companyID;
        $group->internship_course_id = $courseID;
        $group->save();
    }

    /**
     * lay danh sach cac nhom theo giang vien, ky hoc
     *
     *
     * @param $lectureID
     * @param $courseID
     * @return mixed
     */
    public static function getGroupFollowLI($lectureID, $courseID)
    {
        $group = InternShipGroup::where('lecture_id', '=', $lectureID)
            ->where('internship_course_id', '=', $courseID)->get()->groupBy('company_id');
        return $group;
    }

    public static function getGroupFollowLIGroupByCompany($lectureID, $courseID)
    {
        $group = InternShipGroup::where('lecture_id', '=', $lectureID)
            ->where('internship_course_id', '=', $courseID)->get()->groupBy('company_id');
        return $group;
    }

    /**
     * lay danh sach nhom theo cong ty, ky hoc
     *
     * @param $companyID
     * @param $courseID
     * @return mixed
     */
    public static function getGroupFollowCI($companyID, $courseID)
    {
        $group = InternShipGroup::where('company_id', '=', $companyID)
            ->where('internship_course_id', '=', $courseID)->get();
        return $group;
    }

    /**
     * lay khoa thuc tap da phan cong. Nghia la truong lecture_id khac rong
     *
     * @param $courseID
     * @return mixed
     */
    public static function getGroupAssigned($courseID)
    {
        $group = InternShipGroup::where('internship_course_id', '=', $courseID)
            ->where('lecture_id', '<>', '')
            ->get()
            ->groupBy('company_id');
        return $group;
    }

    /**
     * xoa nhung nhom ma sinh vien tham gia. Một kỳ sinh viên chỉ thuộc một nhóm
     *
     * @param $studentID
     */
    public static function deleteStudentRegister($studentID)
    {
        $group = InternShipGroup::where('student_id', '=', $studentID)->get();
        foreach ($group as $g) {
            $find = InternShipGroup::find($g->id);
            $find->delete();
        }
    }

    public static function deleteGroupFCourseID($courseID)
    {
        $group = InternShipGroup::where('internship_course_id', '=', $courseID)->get();
        foreach ($group as $g) {
            $find = InternShipGroup::find($g->id);
            $find->delete();
        }
    }

    /**
     * lay nhom thoe ma sinh vien
     *
     * @param $studentID
     * @return mixed
     */
    public static function getInGroup($studentID)
    {
        $group = InternShipGroup::where('student_id', '=', $studentID)->get();
        return $group;
    }

    /**
     * lay cac nhom cua mot ky
     *
     * @param $courseID
     * @return mixed
     */
    public static function getGroupFCourse($courseID)
    {
        $group = InternShipGroup::where('internship_course_id', '=', $courseID)->get();
        return $group;
    }

    /**
     * thay doi giang vien. trong truong hop giang vien bi om. Ta thay giang vien khac phu trach nhom
     *
     * @param $lectureIDOld
     * @param $courseID
     * @param $lectureIDNew
     */
    public static function changeLecture($lectureIDOld, $courseID, $lectureIDNew)
    {
        $group = InternShipGroup::where('lecture_id', '=', $lectureIDOld)
            ->where('internship_course_id', '=', $courseID)->get();
        foreach ($group as $g) {
            $find = InternShipGroup::find($g->id);
            $find->lecture_id = $lectureIDNew;
            $find->save();
        }
    }

    /**
     * lay danh sach nhom theo ma nhom
     *
     * @param $groupID
     * @return mixed
     */
    public static function getGroupFGroup($groupID)
    {
        $group = InternShipGroup::where('id', '=', $groupID)->get();
        return $group;
    }
}
