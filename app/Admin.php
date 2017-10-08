<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $table = 'admin';

    public function myUser()
    {
        return $this->belongsTo('App\MyUser', 'user_id');
    }

    public function news()
    {
        return $this->hasMany('App\News', 'admin_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu', 'admin_id');
    }

    /**
     * get admin
     *
     * @param $idUser
     * @return mixed
     */
    public static function getAdmin($idUser)
    {
        $admin = Admin::where('user_id', '=', $idUser)->get();
        return $admin;
    }
}
