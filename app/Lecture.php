<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public $table = 'lecture';

    protected $fillable = [
        'name', 'user_id'
    ];

    public function myUser()
    {
        return $this->belongsTo('App\MyUser', 'user_id');
    }

    public function internShipGroup()
    {
        return $this->hasMany('App\InternShipGroup', 'lecture_id');
    }

    public function lectureInternShipCourse()
    {
        return $this->hasMany('App\LectureInternShipCourse', 'lecture_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * get lecture
     *
     * @param $idUser
     * @return mixed
     */
    public static function getLecture($idUser)
    {
        $lecture = Lecture::where('user_id', '=', $idUser)->get();
        return $lecture;
    }

    /**
     * insert lecture
     *
     * @param $name
     * @param $qualification
     * @param $address
     * @param $userID
     */
    public static function insertLecture($name, $qualification, $address, $userID)
    {
        $lecture = new Lecture();
        $lecture->name = $name;
        $lecture->qualification = $qualification;
        $lecture->address = $address;
        $lecture->user_id = $userID;
        $lecture->save();
    }

    /**
     * update profile lecture
     *
     * @param $id
     * @param $birthday
     * @param $phone
     */
    public static function updateProfile($id, $birthday, $phone)
    {
        $lecture = Lecture::find($id);
        $lecture->birthday = $birthday;
        $lecture->phone = $phone;
        $lecture->save();
    }

    /**
     * get all lecture
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allLecture()
    {
        $lecture = Lecture::all();
        return $lecture;
    }

    /**
     * get lecture follow id
     *
     * @param $lectureID
     * @return mixed
     */
    public static function getLectureFollowID($lectureID)
    {
        $lecture = Lecture::where('id', '=', $lectureID)->get();
        return $lecture;
    }

    /**
     * admin update lecture profile
     *
     * @param $id
     * @param $birthday
     * @param $qualification
     * @param $address
     * @param $phone
     * @param $name
     */
    public static function adminUpdateProfile($id, $name, $birthday, $qualification, $address, $phone)
    {
        $find = Lecture::find($id);
        $find->name = $name;
        $find->birthday = $birthday;
        $find->qualification = $qualification;
        $find->address = $address;
        $find->phone = $phone;
        $find->save();
    }

    /**
     * xoa giang vien
     *
     * @param $id
     */
    public static function deleteLecture($id)
    {
        $find = Lecture::find($id);
        $find->delete();
    }

    /**
     * lay danh sach giang vien con lai. De thay the cho giang vien hien tai
     *
     * @param $lectureID
     * @return mixed
     */
    public static function getLectureContain($lectureID)
    {
        $lecture = Lecture::where('id', '<>', $lectureID)->get();
        return $lecture;
    }
}
