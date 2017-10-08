<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = 'news';

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    /**
     * get 10 new notify
     *
     * @return mixed
     */
    public static function getNotify()
    {
        $notify = News::orderBy('updated_at', 'DESC')->paginate(10);
        return $notify;
    }

    public static function getNotifyFID($id)
    {
        $notify = News::where('id', '=', $id)->get();
        return $notify;
    }

    /**
     * lay cac thong bao
     *
     * @return mixed
     */
    public static function listNotify()
    {
        $notify = News::orderBy('updated_at', 'DESC')->get();
        return $notify;
    }

    public static function insert($title, $content, $adminID)
    {
        $notify = new News();
        $notify->title = $title;
        $notify->content = $content;
        $notify->admin_id = $adminID;
        $notify->save();
    }

    public static function deleteNotify($id)
    {
        $find = News::find($id);
        $find->delete();
    }

    public static function checkNotify($id)
    {
        $check = News::where('id', '=', $id)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateNotify($id, $title, $content)
    {
        $find = News::find($id);
        $find->title = $title;
        $find->content = $content;
        $find->save();
    }
}
