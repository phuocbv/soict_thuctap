<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyVote extends Model
{
    public $table = "company_vote";

    /**
     * kiem tra xem ban ghi student_company da ton tai trong bang chua
     *
     * @param $studentID
     * @param $companyID
     * @return bool
     */
    public static function checkStudentCompany($studentID, $companyID)
    {
        $check = CompanyVote::where('student_id', '=', $studentID)
            ->where('company_id', '=', $companyID)->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * insert new record
     *
     * @param $studentID
     * @param $companyID
     */
    public static function insert($studentID, $companyID)
    {
        $companyVote = new CompanyVote();
        $companyVote->student_id = $studentID;
        $companyVote->company_id = $companyID;
        $companyVote->save();
    }

    /**
     * lay mot ban ghi duy nhat theo studentID va companyID
     *
     * @param $studentID
     * @param $companyID
     * @return mixed
     */
    public static function getFStudentIDCompanyID($studentID, $companyID)
    {
        $sc = CompanyVote::where('student_id', '=', $studentID)
            ->where('company_id', '=', $companyID)
            ->get();
        return $sc;
    }

    public static function updateVote($studentID, $companyID, $vote)
    {
        $companyVoteID = CompanyVote::where('student_id', '=', $studentID)
            ->where('company_id', '=', $companyID)
            ->get()->first()->id;
        $find = CompanyVote::find($companyVoteID);
        $find->vote = $vote;
        $find->save();
    }

    /**
     * lay cac lan cong ty tham gia khoa thuc tap va da duoc danh gia
     *
     * @param $companyID
     * @return mixed
     */
    public static function getCompany($companyID)
    {
        $company = CompanyVote::where('company_id', '=', $companyID)
            ->where('vote', '<>', 0)
            ->get();
        return $company;
    }

    /**
     * xoa nhung ban ghi danh gia ve cong ty theo companyID
     *
     * @param $companyID
     */
    public static function deleteCompanyVote($companyID)
    {
        $companyVote = CompanyVote::where('company_id', '=', $companyID)->get();
        foreach ($companyVote as $cv) {
            $find = CompanyVote::find($cv->id);
            $find->delete();
        }
    }
}
