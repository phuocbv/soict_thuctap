<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyAssess;
use App\CompanyInternShipCourse;
use App\InternShipCourse;
use App\InternShipGroup;
use App\Lecture;
use App\LectureInternShipCourse;
use App\News;
use App\Student;
use App\StudentInternShipCourse;
use App\Timekeeping;
use Illuminate\Http\Request;

use App\Http\Requests;

class AssessController extends Controller
{
    public function lectureJoin()
    {
        /*
         * get newNotify
         * get uniNotify
         * get comNotify
         */
        $notify = News::getNotify();

        $lectureSession = new  SessionController();
        $lecture = Lecture::getLecture($lectureSession->getLectureSession());
        $type = 'lecture';

        /*lay id giang vien*/
        $lectureID = $lecture->first()->id;

        /*lay cac khoa ma giang vien tham gia*/
        $lectureInCourse = LectureInternShipCourse::getLectureInCourseFLID($lectureID);
        $courseJoin = array();
        foreach ($lectureInCourse as $lic) {
            $course = InternShipCourse::getInCourse($lic->internship_course_id);
            foreach ($course as $c) {
                $courseJoin[] = $c;
            }
        }

        /*lay khoa hien tai tu tat ca cac khoa. gioi han lai theo nam tim cho nhanh hon*/
        $nowDate = date('Y-m-d');
        $nowMonth = (int)date('m', strtotime($nowDate));
        $year = 0;
        if ($nowMonth >= 8 && $nowMonth <= 12) {
            $year = (int)date('Y', strtotime($nowDate));
        } else {
            $year = (int)date('Y', strtotime($nowDate)) - 1;
        }
        $course = InternShipCourse::getCourseFollowYear($year);
        $courseCurrent = array();
        $timeNow = strtotime(date('Y-m-d'));
        foreach ($course as $c) {
            $timeFrom = strtotime(date('Y-m-d', strtotime($c->from_date)));
            $timeTo = strtotime(date('Y-m-d', strtotime($c->to_date)));
            if ($timeNow >= $timeFrom && $timeNow <= $timeTo) {
                $courseCurrent[] = $c;
            }
        }
        return view('assess.lecture-assess')->with([
            'courseCurrent' => $courseCurrent,
            'courseJoin' => $courseJoin,
            'lectureID' => $lectureID,
            'notify' => $notify,
            'user' => $lecture,
            'type' => $type
        ]);
    }


    /**
     * cap nhat diem cho sinh vien
     *
     * @param $courseID
     * @param $studentID
     * @param $lecturePoint
     */
    public static function lectureToScore($courseID, $studentID, $lecturePoint)
    {
        $data = array();
        if (!StudentInternShipCourse::checkSI($studentID, $courseID)) {
            StudentInternShipCourse::updateLecturePoint($studentID, $courseID, $lecturePoint);
            $data[] = "true";
        } else {
            $data[] = "false";
        }
    }

    /**
     * upload file giang vien nhan xet mot sinh vien
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lectureAssess(Request $request)
    {
        $studentID = $request->input('studentID');
        $courseID = $request->input('courseID');
        $file = $request->file('fileAssess');
        $url = FileController::uploadFile($file);
        if (!StudentInternShipCourse::checkSI($studentID, $courseID)) {
            $student = Student::getStudentFollowID($studentID);
            $name = $student->first()->name;
            StudentInternShipCourse::uploadLectureAssess($studentID, $courseID, $url);
            return redirect()->back()->with('updateLectureAssessSuccess', 'cập nhật thành công file nhận xét sinh viên' . $name);
        } else {
            return redirect()->back()->with('updateLectureAssessError', 'Lỗi cập nhật file nhận xét');
        }
    }

    public function companyJoin()
    {
        $notify = News::getNotify();

        $companySession = new  SessionController();
        $company = Company::getCompany($companySession->getCompanySession());
        $type = 'company';
        $companyID = $company->first()->id;


        /*lay cac khoa ma cong ty da tham gia*/
        $companyInCourse = CompanyInternShipCourse::getCompanyInCourseFCID($companyID);
        $courseJoin = array();
        foreach ($companyInCourse as $cic) {
            $course = InternShipCourse::getInCourse($cic->internship_course_id);
            foreach ($course as $c) {
                $courseJoin[] = $c;
            }
        }

        /*lay khoa hien tai tu tat ca cac khoa. gioi han lai theo nam tim cho nhanh hon*/
        $nowDate = date('Y-m-d');
        $nowMonth = (int)date('m', strtotime($nowDate));
        $year = 0;
        if ($nowMonth >= 8 && $nowMonth <= 12) {
            $year = (int)date('Y', strtotime($nowDate));
        } else {
            $year = (int)date('Y', strtotime($nowDate)) - 1;
        }
        $course = InternShipCourse::getCourseFollowYear($year);
        $courseCurrent = array();
        $timeNow = strtotime(date('Y-m-d'));
        foreach ($course as $c) {
            $timeFrom = strtotime(date('Y-m-d', strtotime($c->from_date)));
            $timeTo = strtotime(date('Y-m-d', strtotime($c->to_date)));
            if ($timeNow >= $timeFrom && $timeNow <= $timeTo) {
                $courseCurrent[] = $c;
            }
        }

        return view('assess.company-join')->with([
            'courseJoin' => $courseJoin,
            'courseCurrent' => $courseCurrent,
            'companyID' => $companyID,
            'notify' => $notify,
            'user' => $company,
            'type' => $type
        ]);
    }

    public static function companyToScore($studentID, $courseID, $companyPoint)
    {
        $data = array();
        if (!StudentInternShipCourse::checkSI($studentID, $courseID)) {
            StudentInternShipCourse::updateCompanyPoint($studentID, $courseID, $companyPoint);
            $data[] = "true";
        } else {
            $data[] = "false";
        }
    }

    public function companyAssess(Request $request)
    {
        $assessGeneral = $request->input('assessGeneral');
        $it = $request->input('it');
        $work = $request->input('work');
        $learnWork = $request->input('learnWork');
        $manage = $request->input('manage');
        $english = $request->input('english');
        $teamwork = $request->input('teamWork');
        $dateAssess = date('Y-m-d H:i:s', strtotime(date('Y-m-d')));
        if (isset($_POST['company-assess'])) {
            $groupID = decrypt($request->input('groupID'));
            CompanyAssess::insert($assessGeneral, $it, $work, $learnWork, $manage, $english, $teamwork, $dateAssess, $groupID);
            return redirect()->back()->with('insertSuccess', 'Đánh giá thành công');
        } else {
            $companyAssessID = $request->input('companyAssessID');
            CompanyAssess::updateAssess($companyAssessID, $assessGeneral, $it, $work, $learnWork, $manage, $english, $teamwork, $dateAssess);
            return redirect()->back()->with('updateAssess', 'Đã sửa đánh giá');
        }
    }

    public function companyTimeKeeping(Request $request)
    {
        /*
         * get newNotify
         * get uniNotify
         * get comNotify
         */
        $notify = News::getNotify();

        $companySession = new  SessionController();
        $company = Company::getCompany($companySession->getCompanySession());
        $type = 'company';

        $companyID = $company->first()->id;
        $courseID = $request->input('courseID');
        $arrGroup = InternShipGroup::getGroupFollowCI($companyID, $courseID);
        $course = InternShipCourse::getInCourse($courseID);
        return view('assess.timekeeping')->with([
            'course' => $course,
            'arrGroup' => $arrGroup,
            'notify' => $notify,
            'user' => $company,
            'type' => $type
        ]);
    }

    /**
     * xu ly cham cong
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function timekeepingPost(Request $request)
    {
        $arrWorkDay = $request->input('workDay');
        if (isset($_POST['create-new'])) {
            for ($i = 0; $i < count($arrWorkDay); $i++) {
                list($workDay, $studentID, $courseID, $companyID) = explode("*", $arrWorkDay[$i]);
                $date = date('Y-m-d H:i:s', strtotime($workDay));
                $day = date('d', strtotime($date));
                $month = date('m', strtotime($date));
                if (!Timekeeping::check($studentID, (int)($courseID), $companyID, $date)) {
                    Timekeeping::insert($studentID, (int)($courseID), $companyID, $day, $month, $date);
                }
            }
            return redirect('company-join')->with('timekeepingSuccess', 'Hoàn thành chấm công');
        } else {
            $arrDay = array();
            $courseIDTmp = "";
            $companyIDTmp = "";
            /*
             * them ban ghi ma giao dien da check, nhung trong database chua co
             */
            for ($i = 0; $i < count($arrWorkDay); $i++) {
                list($workDay, $studentID, $courseID, $companyID) = explode("*", $arrWorkDay[$i]);
                $date = date('Y-m-d H:i:s', strtotime($workDay));
                $day = date('d', strtotime($date));
                $month = date('m', strtotime($date));
                $arrDay[] = $studentID . strtotime($date);
                if (!Timekeeping::check($studentID, (int)($courseID), $companyID, $date)) {
                    Timekeeping::insert($studentID, (int)($courseID), $companyID, $day, $month, $date);
                }

                $courseIDTmp = $courseID;
                $companyIDTmp = $companyID;
            }

            /*
             * xoa cac ban ghi ma trong database co nhung ben ngoai bo check
             */
            $timekeeping = Timekeeping::getFollowCourseIDCompanyID($companyIDTmp, $courseIDTmp);
            foreach ($timekeeping as $tk) {
                $countCheck = 0;
                $check = $tk->student_id . strtotime($tk->date_full);
                for ($i = 0; $i < count($arrDay); $i++) {
                    if ($check == $arrDay[$i]) {
                        $countCheck++;
                        break;
                    }
                }
                if ($countCheck == 0) {
                    $find = Timekeeping::find($tk->id);
                    $find->delete();
                }
            }
            return redirect()->back()->with('editSuccess', 'Đã chỉnh sửa file chấm công');
        }
    }

    public function viewTimekeeping(Request $request)
    {
        /*
         * get newNotify
         * get uniNotify
         * get comNotify
         */
        $notify = News::getNotify();

        $companySession = new  SessionController();
        $company = Company::getCompany($companySession->getCompanySession());
        $type = 'company';

        $companyID = $company->first()->id;
        $courseID = $request->input('courseID');
        $arrGroup = InternShipGroup::getGroupFollowCI($companyID, $courseID);
        $course = InternShipCourse::getInCourse($courseID);
        return view('assess.view-timekeeping')->with([
            'course' => $course,
            'arrGroup' => $arrGroup,
            'notify' => $notify,
            'user' => $company,
            'type' => $type
        ]);
    }
}
