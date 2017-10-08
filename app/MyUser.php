<?php

namespace App;

use App\Http\Controllers\SessionController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class MyUser extends Model
{
    public $table = "users";

    public function student()
    {
        return $this->hasOne('App\Student', 'user_id');
    }

    public function lecture()
    {
        return $this->hasOne('App\Lecture', 'user_id');
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'user_id');
    }

    public function admin()
    {
        return $this->hasOne('App\Admin', 'user_id');
    }

    /**
     *function check login
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public static function checkLogin($username, $password)
    {

        $myUser = MyUser::where('user_name', '=', $username)->get();
        $count = count($myUser);
        $check = false;
        if ($count > 0) {
            foreach ($myUser as $mu) {
                if (Hash::check($password, $mu->password)) {
                    $check = true;
                }
            }
        }
        return $check;
    }

    /**
     * get user follow username. username !
     *
     * @param $username
     * @return mixed
     */
    public static function getUser($username)
    {
        $myUser = MyUser::where('user_name', '=', $username)->get();
        return $myUser;
    }

    /**
     * get user follow user_id
     *
     * @param $userID
     * @return mixed
     */
    public static function getUserFollowUserID($userID)
    {
        $myUser = MyUser::where('id', '=', $userID)->get();
        return $myUser;
    }

    /**
     * get user follow id
     *
     * @param $id
     * @return mixed
     */
    public static function getUserFollowID($id)
    {
        $myUser = MyUser::where('id', '=', $id)->get();
        return $myUser;
    }

    /**
     * check username
     *
     * @param $username
     * @return bool
     */
    public static function checkUsername($username)
    {
        $check = MyUser::where('user_name', '=', $username)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check email
     *
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        $check = MyUser::where('email', '=', $email)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * insert new user into table users
     *
     * @param $userName
     * @param $email
     * @param $password
     */
    public static function insertUser($userName, $email, $password, $type)
    {
        $myUser = new MyUser();
        $myUser->user_name = $userName;
        $myUser->email = $email;
        $myUser->password = bcrypt($password);
        $myUser->type = $type;
        $myUser->save();
    }

    /**
     * get id follow user_name
     *
     * @param $userName
     * @return mixed
     */
    public static function getID($userName)
    {
        $id = MyUser::where('user_name', '=', $userName)->first()->id;
        return $id;
    }

    /**
     * thay doi mat khau
     *
     * @param $id
     * @param $password
     */
    public static function changePassword($id, $password)
    {
        $find = MyUser::find($id);
        $find->password = bcrypt($password);
        $find->save();
    }

    public static function checkPass($id,$password)
    {
        $user = MyUser::where('id', '=', $id)->get();
        $check = false;
        foreach ($user as $u) {
            if (Hash::check($password, $u->password)) {
                $check = true;
            }
        }
        return $check;
    }

    /**
     * kiem tra ma sinh vien da ton tai hay chua.
     * kiem tra phuc vu chinh sua thong tin nguoi dung
     *
     * @param $userID
     * @param $username
     * @return bool
     */
    public static function checkUserNameEdit($userID, $username)
    {
        $listUser = MyUser::where('id', '<>', $userID)->get();
        $check = true;
        foreach ($listUser as $lu) {
            if ($lu->user_name == $username) {
                $check = false;
                break;
            }
        }
        return $check;
    }

    public static function checkEmailEdit($userID, $email)
    {
        $listUser = MyUser::where('id', '<>', $userID)->get();
        $check = true;
        foreach ($listUser as $lu) {
            if ($lu->email == $email) {
                $check = false;
                break;
            }
        }
        return $check;
    }

    /*
     * update users table
     */
    public static function updateUser($myUserID, $userName, $email)
    {
        $find = MyUser::find($myUserID);
        $find->user_name = $userName;
        $find->email = $email;
        $find->save();
    }

    /**
     * xoa tai khoan dang nhap cua nguoi dung
     *
     * @param $userID
     */
    public static function deleteAccount($id)
    {
        $find = MyUser::find($id);
        $find->delete();
    }

    public static function getUserFType($type)
    {
        $myUser = MyUser::where('type', '=', $type)->get();
        return $myUser;
    }
}
