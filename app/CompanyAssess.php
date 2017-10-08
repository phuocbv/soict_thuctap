<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAssess extends Model
{
    public $table = 'company_assess';

    public static function getCompanyAssess($groupID)
    {
        $companyAssess = CompanyAssess::where('group_id', '=', $groupID)->get();
        return $companyAssess;
    }

    public static function insert($assessGeneral, $IT, $work, $learnWork, $manage, $english, $teamwork, $dateAssess, $groupID)
    {
        $companyAssess = new CompanyAssess();
        $companyAssess->assess_general = $assessGeneral;
        $companyAssess->it = $IT;
        $companyAssess->work = $work;
        $companyAssess->learn_work = $learnWork;
        $companyAssess->manage = $manage;
        $companyAssess->english = $english;
        $companyAssess->teamwork = $teamwork;
        $companyAssess->date_assess = $dateAssess;
        $companyAssess->group_id = $groupID;
        $companyAssess->save();
    }

    public static function updateAssess($id, $assessGeneral, $IT, $work, $learnWork, $manage, $english, $teamwork, $dateAssess)
    {
        $companyAssess = CompanyAssess::find($id);
        $companyAssess->assess_general = $assessGeneral;
        $companyAssess->it = $IT;
        $companyAssess->work = $work;
        $companyAssess->learn_work = $learnWork;
        $companyAssess->manage = $manage;
        $companyAssess->english = $english;
        $companyAssess->teamwork = $teamwork;
        $companyAssess->date_assess = $dateAssess;
        $companyAssess->save();
    }

    /**
     * xoa nhung nhan xet cua cong ty ve sinh vien
     *
     * @param $groupID
     */
    public static function deleteAsess($groupID)
    {
        $assess = CompanyAssess::where('group_id', '=', $groupID)->get();
        foreach ($assess as $a) {
            $find = CompanyAssess::find($a->id);
            $find->delete();
        }
    }
}
