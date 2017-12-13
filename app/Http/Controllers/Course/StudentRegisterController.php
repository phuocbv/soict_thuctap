<?php

namespace App\Http\Controllers\Course;

use App\Company;
use App\CompanyInternShipCourse;
use App\CompanyVote;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use App\InternShipCourse;
use App\InternShipGroup;
use App\News;
use App\Student;
use App\StudentInternShipCourse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class StudentRegisterController extends Controller
{
    public function __construct()
    {
        $this->checkStudentResgister = false;
    }

    /**
     * return page student-register
     *
     * @return $this
     */
    public function registerInternship()
    {
        $student = $this->currentUser()->student;
        $type = 'student';
        $studentID = $student->id;

        $nowDate = date('Y-m-d');
        $nowMonth = (int)date('m', strtotime($nowDate));
        $nowYear = 0;
        if ($nowMonth >= 7 && $nowYear <= 12) {
            $nowYear = (int)date('Y', strtotime($nowDate));
        } else {
            $nowYear = (int)date('Y', strtotime($nowDate)) - 1;
        }
        $courseTerm1 = $nowYear . '1';
        $courseTerm2 = $nowYear . '2';
        $courseTerm3 = $nowYear . '3';
        $internShipCourse1 = InternShipCourse::getInternShipCourse($courseTerm1);
        $internShipCourse2 = InternShipCourse::getInternShipCourse($courseTerm2);
        $internShipCourse3 = InternShipCourse::getInternShipCourse($courseTerm3);
        if (count($internShipCourse1) > 0 || count($internShipCourse2) > 0 || count($internShipCourse3) > 0) {
            $timeNow = strtotime($nowDate);
            $internShipCourse = "";
            $registerCompany = "";
            $internShipCourseID = "";
            if (count($internShipCourse1) > 0) {
                $startRegister = "";
                $finishRegister = "";
                foreach ($internShipCourse1 as $in1) {
                    $startRegister = date('Y-m-d', strtotime($in1->start_register));
                    $finishRegister = date('Y-m-d', strtotime($in1->finish_register));
                    $internShipCourseID = $in1->id;
                }
                $timeStartRegister = strtotime($startRegister);
                $timeFinishRegister = strtotime($finishRegister);
                if ($timeNow >= $timeStartRegister && $timeNow <= $timeFinishRegister) {
                    $this->checkStudentResgister = true;
                    $internShipCourse = $internShipCourse1;
                    $registerCompany = $this->registerCompany($studentID, $internShipCourseID);
                }
            }
            if (count($internShipCourse2) > 0) {
                $startRegister = "";
                $finishRegister = "";
                foreach ($internShipCourse2 as $in2) {
                    $startRegister = date('Y-m-d', strtotime($in2->start_register));
                    $finishRegister = date('Y-m-d', strtotime($in2->finish_register));
                    $internShipCourseID = $in2->id;
                }
                $timeStartRegister = strtotime($startRegister);
                $timeFinishRegister = strtotime($finishRegister);
                if ($timeNow >= $timeStartRegister && $timeNow <= $timeFinishRegister) {
                    $this->checkStudentResgister = true;
                    $internShipCourse = $internShipCourse2;
                    $registerCompany = $this->registerCompany($studentID, $internShipCourseID);
                }
            }
            if (count($internShipCourse3) > 0) {
                $startRegister = "";
                $finishRegister = "";
                foreach ($internShipCourse3 as $in3) {
                    $startRegister = date('Y-m-d', strtotime($in3->start_register));
                    $finishRegister = date('Y-m-d', strtotime($in3->finish_register));
                    $internShipCourseID = $in3->id;
                }
                $timeStartRegister = strtotime($startRegister);
                $timeFinishRegister = strtotime($finishRegister);
                if ($timeNow >= $timeStartRegister && $timeNow <= $timeFinishRegister) {
                    $this->checkStudentResgister = true;
                    $internShipCourse = $internShipCourse3;
                    $registerCompany = $this->registerCompany($studentID, $internShipCourseID);
                }
            }
            if (!$this->checkStudentResgister) {
                return view('errors.student-register-error')->with([
                    'user' => $student,
                    'type' => $type
                ]);
            } else {
                return view('manage-register.student-register')->with([
                    'registerCompany' => $registerCompany,
                    'internShipCourse' => $internShipCourse,
                    'user' => $student,
                    'type' => $type
                ]);
            }
        } else {
            return view('errors.student-register-error')->with([
                'user' => $student,
                'type' => $type
            ]);
        }
    }

    /**
     * get company (where student register)
     *
     * @param $studentID
     * @param $internshipCourseID
     * @return array
     */
    public function registerCompany($studentID, $internshipCourseID)
    {
        $group = InternShipGroup::getGroupFollowSI($studentID, $internshipCourseID);
        $company = array();
        foreach ($group as $g) {
            $com = Company::getCompanyFollowID($g->company_id);
            foreach ($com as $c) {
                $company[] = $c;
            }
        }
        return $company;
    }

    public function studentRegister(Request $request)
    {
        $companyID = decrypt($request->input('companyID'));
        $internShipCourseID = decrypt($request->input('courseID'));

        //get studentID
        $student = $this->currentUser()->student;
        $studentID = $student->id;

        //lay gioi han dang ky vao mot cong ty
        $comIn = CompanyInternShipCourse::getComInCourse($companyID, $internShipCourseID)->first();
        $studentQuantity = $comIn->student_quantity;

        //dem so luong sinh vien da dang ky vao mot cong ty
        $countStudent = InternShipGroup::countStudentInCompany($companyID, $internShipCourseID);

        //check full student in company
        if (!CompanyInternShipCourse::checkRegisterFull($countStudent, $studentQuantity)) {
            $countCheck = count(InternShipGroup::getGroupFollowSI($studentID, $internShipCourseID));

            $accessToken = session()->get(ACCESS_TOKEN_SOCIAL);

            if ($countCheck > 0) {
                $checkCompanyID1 = "";
                $groupID = "";
                $group = InternShipGroup::getGroupFollowSI($studentID, $internShipCourseID);
                foreach ($group as $g) {
                    $checkCompanyID1 = $g->company_id;
                    $groupID = $g->id;
                }
                if ($checkCompanyID1 == $companyID) {
                    return redirect()->back()->with('noChange', 'Bạn chưa thay đổi đăng ký');
                } else {//thay đổi đăng ký
                    InternShipGroup::updateGroup($groupID, $companyID);
                    if (CompanyVote::checkStudentCompany($studentID, $companyID)) {
                        CompanyVote::insert($studentID, $companyID);
                    }
                    return redirect()->back()->with('change', 'Bạn đã thay đổi đăng ký');
                }
            } else {//bắt đầu đăng ký
                //$this->postInGroup($comIn, $student, null, 'create');

                if ($accessToken == null) {
                    return redirect()->route('provider.redirect', [
                        'provider' => 'facebook'
                    ]);
                }

               $this->postInGroup($comIn, $student, null, 'create', $accessToken);

                StudentInternShipCourse::insertSIC($studentID, $internShipCourseID);
                InternShipGroup::insertGroup($studentID, $internShipCourseID, $companyID);
                if (CompanyVote::checkStudentCompany($studentID, $companyID)) {
                    CompanyVote::insert($studentID, $companyID);
                }
                return redirect()->back()->with('registerSuccess', 'Bạn đã đăng ký thành công');
            }
        } else {
            $group = InternShipGroup::getGroupFollowSI($studentID, $internShipCourseID);
            $checkCompanyID2 = "";
            foreach ($group as $g) {
                $checkCompanyID2 = $g->company_id;
            }
            if ($checkCompanyID2 == $companyID) {
                return redirect()->back()->with('noChange', 'Bạn chưa thay đổi đăng ký');
            } else {
                return redirect()->back()->with('full', 'Hết chỗ đăng ký');
            }
        }
    }

    private function postInGroup($company, $student, $lecture, $action, $accessToken)
    {
        $message = $action . "\n";
        //$message+= $company->name;

        $facebook = new \Facebook\Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
//            $response = $facebook->post(
//                config('settings.groupID') . '/feed',
//                [
//                    'message' => 'test app'
//                ],
//                $accessToken
//            );

            $response = $facebook->post("/me/feed",
                [
                    'message' => "Hi"
                ],
                $accessToken
            );

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        dd($graphNode);
//        if ($action == 'create') {
//
//        }
    }


    public function courseJoin()
    {
        $student = $this->currentUser()->student;
        $type = 'student';
        $studentID = $student->id;

        //lay khoa thuc tap ma sinh vien tham gia
        $InCourseJoin = StudentInternShipCourse::getSIC($studentID);

        /*
         * lay khoa thuc tap hien tai ma sinh vien co the tham gia (dang le ra xu ly theo ben duoi)
         * nhung lam roi sua lai lau nen de
         */
//        $nowTime = strtotime(date('Y-m-d'));
//        $InCourseJoinCurrent = array();
//        foreach ($InCourseJoin as $icj) {
//            $InCourse = InternShipCourse::getInCourse($icj->internship_course_id);
//            foreach ($InCourse as $i) {
//                $timeStart = strtotime(date('Y-m-d', strtotime($i->from_date)));
//                $timeFinish = strtotime(date('Y-m-d', strtotime($i->to_date)));
//                if ($nowTime >= $timeStart && $nowTime <= $timeFinish) {
//                    $InCourseJoinCurrent[] = $icj;
//                }
//            }
//        }

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
        return view('manage-register.course-join')->with([
            'courseCurrent' => $courseCurrent,
            'inCourseJoin' => $InCourseJoin,
            'studentID' => $studentID,
            //'notify' => $notify,
            'user' => $student,
            'type' => $type
        ]);
    }

    /**
     * upload report_file
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadReport(Request $request)
    {
        $studentID = $request->input('studentID');
        $internShipCourseID = $request->input('internShipCourseID');
        $file = $request->file('reportFile');
        $url = FileController::uploadFile($file);
        StudentInternShipCourse::uploadReport($studentID, $internShipCourseID, $url);
        return redirect()->back()->with('uploadReportSuccess', 'File báo cáo đã được nộp');
    }

    /**
     * sinh viên xóa đăng ký. Khi đang đăng ký
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function studentDeleteRegister(Request $request)
    {
        $studentID = decrypt($request->input('studentID'));
        $courseID = decrypt($request->input('courseID'));
        StudentInternShipCourse::deleteSIC($studentID, $courseID);
        InternShipGroup::deleteGroup($studentID, $courseID);
        return redirect()->back()->with('deleteRegister', 'đã xóa đăng ký');
    }
}
