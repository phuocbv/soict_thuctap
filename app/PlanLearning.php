<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanLearning extends Model
{
    public $table = 'plan_learning';

    public static function allPlanLearning()
    {
        $planLearning = PlanLearning::all();
        return $planLearning;
    }

    /**
     * kiem tra truoc khi them khoa hoc co bi trung khong
     *
     * @param $yearStart
     * @param $yearFinish
     * @return bool
     */
    public static function checkInsertPlan($yearStart, $yearFinish)
    {
        $count = 0;
        $plan = PlanLearning::all();
        if (count($plan) == 0) {
            return true;
        } else {
            foreach ($plan as $p) {
                $start = (int)date('Y', strtotime($p->start));
                $finish = (int)date('Y', strtotime($p->finish));
                if ($start == $yearStart && $finish == $yearFinish) {
                    $count++;
                }
            }
            if ($count > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function insertPlan($start, $finish, $startTerm1, $finishTerm1,
                                      $startTerm2, $finishTerm2,
                                      $startTerm3, $finishTerm3, $adminID)
    {
        $plan = new PlanLearning();
        $plan->start = $start;
        $plan->finish = $finish;
        $plan->start_term1 = $startTerm1;
        $plan->finish_term1 = $finishTerm1;
        $plan->start_term2 = $startTerm2;
        $plan->finish_term2 = $finishTerm2;
        $plan->start_term3 = $startTerm3;
        $plan->finish_term3 = $finishTerm3;
        $plan->admin_id = $adminID;
        $plan->save();
    }

    /**
     * get now plan (plan of now year)
     *
     * @param $year
     * @return array
     */
    public static function getPlan($year)
    {
        $allPlan = PlanLearning::all();
        $nowPlan = array();
        foreach ($allPlan as $ap) {
            $checkYear = (int)date('Y', strtotime($ap->start));
            if ($checkYear == $year) {
                $nowPlan[] = $ap;
            }
        }
        return $nowPlan;
    }

    public static function checkPlan($planID)
    {
        $check = PlanLearning::where('id', '=', $planID)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function deletePlan($planID)
    {
        $find = PlanLearning::find($planID);
        $find->delete();
    }

    public static function editPlan($start, $finish, $startTerm1, $finishTerm1,
                                    $startTerm2, $finishTerm2,
                                    $startTerm3, $finishTerm3, $planID)
    {
        $plan = PlanLearning::find($planID);
        $plan->start = $start;
        $plan->finish = $finish;
        $plan->start_term1 = $startTerm1;
        $plan->finish_term1 = $finishTerm1;
        $plan->start_term2 = $startTerm2;
        $plan->finish_term2 = $finishTerm2;
        $plan->start_term3 = $startTerm3;
        $plan->finish_term3 = $finishTerm3;
        $plan->save();
    }
}
