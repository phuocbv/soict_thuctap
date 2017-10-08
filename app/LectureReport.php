<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureReport extends Model
{
    public $table = 'lecture_report';

    public function lectureInternShipCourse()
    {
        return $this->belongsTo(LectureInternShipCourse::class, 'lecture_in_course_id');
    }

    public static function insert($advantage, $disAdvantage, $proposal, $assessGeneral, $lectureInCourseID, $dateReport)
    {
        $lectureReport = new LectureReport();
        $lectureReport->advantage = $advantage;
        $lectureReport->dis_advantage = $disAdvantage;
        $lectureReport->proposal = $proposal;
        $lectureReport->assess_general = $assessGeneral;
        $lectureReport->lecture_in_course_id = $lectureInCourseID;
        $lectureReport->date_report = $dateReport;
        $lectureReport->save();
    }

    public static function edit($id, $advantage, $disAdvantage, $proposal, $assessGeneral, $dateReport)
    {
        $find = LectureReport::find($id);
        $find->advantage = $advantage;
        $find->dis_advantage = $disAdvantage;
        $find->proposal = $proposal;
        $find->assess_general = $assessGeneral;
        $find->date_report = $dateReport;
        $find->save();
    }

    public static function get($lectureInCourseID)
    {
        $lectureReport = LectureReport::where('lecture_in_course_id', '=', $lectureInCourseID)->get();
        return $lectureReport;
    }

    public static function check($id)
    {
        $check = LectureReport::where('id', '=', $id)->count();
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * xoa nhuna bao cao cua giang vien
     *
     * @param $lectureInCourseID
     */
    public static function deleteLectureReport($lectureInCourseID)
    {
        $lecReport = LectureReport::where('lecture_in_course_id', '=', $lectureInCourseID)->get();
        if (count($lecReport) > 0) {
            $lecReportID = $lecReport->first()->id;
            $find = LectureReport::find($lecReportID);
            $find->delete();
        }
    }

    /**
     * thay doi lecture_in_course_id
     *
     * @param $id
     * @param $lecInCourseID
     */
    public static function changeLectureInCourseID($id, $lecInCourseID)
    {
        $find = LectureReport::find($id);
        $find->lecture_in_course_id = $lecInCourseID;
        $find->save();
    }
}
