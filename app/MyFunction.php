<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFunction extends Model
{
    public $table = 'function';

    /**
     * lay chuong trinh dao tao
     *
     * @return mixed
     */
    public static function learningPrograming()
    {
        $lp = MyFunction::where('type', '=', 1)->get();
        return $lp;
    }

    /**
     * lay cac bo mon
     *
     * @return mixed
     */
    public static function academy()
    {
        $a = MyFunction::where('type', '=', 2)->get();
        return $a;
    }

    /**
     * them du lieu
     *
     * @param $name
     * @param $type
     * @param $adminID
     */
    public static function insert($name, $type, $adminID)
    {
        $f = new MyFunction();
        $f->name = $name;;
        $f->type = $type;
        $f->admin_id = $adminID;
        $f->save();
    }

    /**
     * update ten cua he dao tao, bo mon
     *
     * @param $dataID
     * @param $name
     */
    public static function updateData($dataID, $name)
    {
        $f = MyFunction::where('id', '=', $dataID)->get();
        foreach ($f as $mf) {
            $find = MyFunction::find($mf->id);
            $find->name = $name;
            $find->save();
        }
    }

    /**
     * xoa du lieu
     *
     * @param $dataID
     */
    public static function deleteData($dataID)
    {
        $f = MyFunction::where('id', '=', $dataID)->get();
        foreach ($f as $mf) {
            $find = MyFunction::find($mf->id);
            $find->delete();
        }
    }
}
