<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageBanner extends Model
{
    public $table = 'image_banner';

    /**
     * lay danh sach anh banner
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function listImgBanner()
    {
        $imgBanner = ImageBanner::all();
        return $imgBanner;
    }

    public static function addImageBanner($url, $nameDisplay, $status, $adminID)
    {
        $ib = new ImageBanner();
        $ib->url = $url;
        $ib->name_display = $nameDisplay;
        $ib->status = $status;
        $ib->admin_id = $adminID;
        $ib->save();
    }

    public static function edit($nameDisplay, $status, $id)
    {
        $ib = ImageBanner::where('id', '=', $id)->get();
        foreach ($ib as $i) {
            $find = ImageBanner::find($i->id);
            $find->name_display = $nameDisplay;
            $find->status = $status;
            $find->save();
        }
    }

    public static function getImg($id)
    {
        $img = ImageBanner::where('id', '=', $id)->get();
        return $img;
    }

    public static function deleteImg($id)
    {
        $ib = ImageBanner::where('id', '=', $id)->get();
        foreach ($ib as $i) {
            $find = ImageBanner::find($i->id);
            $find->delete();
        }
    }

    /**
     * lay nhung hinh anh co trang thai hien thi
     *
     * @param $status
     * @return mixed
     */
    public static function getImgDisplay($status)
    {
        $img = ImageBanner::where('status', '=', $status)->get();
        return $img;
    }
}
