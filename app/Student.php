<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $table = 'student';

    public function myUser()
    {
        return $this->belongsTo('App\MyUser', 'user_id');
    }

    public function studentInternShipCourse()
    {
        return $this->hasMany('StudentInternShipCourse', 'student_id');
    }

    public function internShipGroup()
    {
        return $this->hasMany('InternShipGroup', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * get studentID
     *
     * @param $idUser
     * @return mixed
     */
    public static function getStudentID($idUser)
    {
        $studentID = Student::where('user_id', '=', $idUser)->get()->first()->id;
        return $studentID;
    }

    /**
     * get student
     *
     * @param $idUser
     * @return mixed
     */
    public static function getStudent($idUser)
    {
        $student = Student::where('user_id', '=', $idUser)->get();
        return $student;
    }

    /**
     * insert student
     *
     * @param $name
     * @param $grade
     * @param $programUniversity
     * @param $msv
     * @param $userID
     */
    public static function insertStudent($name, $grade, $programUniversity, $msv, $userID)
    {
        $student = new Student();
        $student->name = $name;
        $student->grade = $grade;
        $student->program_university = $programUniversity;
        $student->msv = $msv;
        $student->user_id = $userID;
        $student->save();
    }

    /**
     * update student profile
     *
     * @param $id
     * @param $english
     * @param $phone
     * @param $birthday
     * @param $programingSkill
     * @param $programingSkillBest
     */
    public static function updateProfile($id, $english, $phone, $birthday, $programingSkill, $programingSkillBest)
    {
        $student = Student::find($id);
        $student->english = $english;
        $student->phone = $phone;
        $student->birthday = $birthday;
        $student->programing_skill = $programingSkill;
        $student->programing_skill_best = $programingSkillBest;
        $student->save();
    }

    /**
     * get student
     *
     * @param $studentID
     * @return mixed
     */
    public static function getStudentFollowID($studentID)
    {
        $student = Student::where('id', '=', $studentID)->get();
        return $student;
    }

    /**
     * get student follow msv
     *
     * @param $msv
     * @return mixed
     */
    public static function getStudentFMSV($msv)
    {
        $student = Student::where('msv', '=', $msv)->get();
        return $student;
    }

    public static function getStudentIDFMsv($msv)
    {
        $studentID = Student::where('msv', '=', $msv)->get()->first()->id;
        return $studentID;
    }

    /**
     * kiem tra su ton tai cua sinh vien
     *
     * @param $studentID
     * @return bool
     */
    public static function checkStudent($studentID)
    {
        $check = count(Student::getStudentFollowID($studentID));
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * admin update profile for student
     */
    public static function adminUpdateProfile($id, $name, $grade, $programUniversity, $msv, $phone, $birthday, $programingSkill, $programingSkillBest, $english)
    {
        $find = Student::find($id);
        $find->name = $name;
        $find->grade = $grade;
        $find->program_university = $programUniversity;
        $find->msv = $msv;
        $find->phone = $phone;
        $find->birthday = $birthday;
        $find->programing_skill = $programingSkill;
        $find->programing_skill_best = $programingSkillBest;
        $find->english = $english;
        $find->save();
    }

    /**
     * xoa sinh vien theo ma sinh vien
     *
     * @param $id
     */
    public static function deleteStudent($id)
    {
        $find = Student::find($id);
        $find->delete();
    }
}
