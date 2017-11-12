<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Company;
use App\CompanyVote;
use App\InternShipGroup;
use App\News;
use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;

class VoteController extends Controller
{
    public static function updateVote($studentID, $companyID, $vote)
    {
        $data = array();
        if ($vote >= 1 && $vote <= 4) {
            if (count(CompanyVote::getFStudentIDCompanyID($studentID, $companyID)) > 0) {
                CompanyVote::updateVote($studentID, $companyID, $vote);
                $data[] = "true";
            } else {
                $data[] = "false";
            }
        } else {
            $data[] = "false";
        }
        return $data;
    }

    public function statisticVote(Request $request)
    {
        $admin = $this->currentUser()->admin;
        $type = 'admin';

        return view('vote.vote')->with([
            'user' => $admin,
            'type' => $type
        ]);
    }

    /**
     * cap nhat diem danh gia trung binh cua moi cong ty
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function statisticVoteAjax()
    {
        $company = Company::all();
        foreach ($company as $c) {
            $companyInCompanyVote = CompanyVote::getCompany($c->id);
            if (count($companyInCompanyVote) > 0) {
                $pointVote = 0;
                foreach ($companyInCompanyVote as $value) {
                    $pointVote = $pointVote + $value->vote;
                }
                $average = round($pointVote / count($companyInCompanyVote), 2) * 2;
                Company::updatePointVote($c->id, $average);
            }
        }
        $companyCalculateVote = Company::all();
        return $companyCalculateVote;
    }

    public function companyCooperation()
    {
        $student = $this->currentUser()->student;
        $type = 'student';

        return view('vote.vote-company')->with([
            'user' => $student,
            'type' => $type
        ]);
    }
}
