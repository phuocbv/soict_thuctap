<?php

namespace App\Http\Controllers\Course;

use App\Admin;
use App\Company;
use App\CompanyAssess;
use App\CompanyInternShipCourse;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use App\InternShipCourse;
use App\InternShipGroup;
use App\Lecture;
use App\LectureInternShipCourse;
use App\LectureReport;
use App\MyUser;
use App\News;
use App\PlanLearning;
use App\Student;
use App\StudentInternShipCourse;
use App\StudentReport;
use App\StudentTmp;
use App\Timekeeping;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ManageInCourseController extends Controller
{
    public function __construct()
    {
        $this->checkInsertPlan = true;
        $this->checkUpdateTime = true;
        $this->checkExtention = false;
        $this->checkForm = false;
        $this->checkRow = false;
        $this->arrTransition = array();
        $this->checkEditPlan = true;
    }


    public function listCourse()
    {
        /*
        * get newNotify
        * get uniNotify
        * get comNotify
        */
        $notify = News::getNotify();

//        $adminSession = new  SessionController();
//        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $admin = Auth::user()->admin;
        $type = 'admin';

        /*
         * get current year
         */
        $currentYear = (int)date('Y');

        /*
         * get all course
         */
        $course = InternShipCourse::allCourse();
        return view('manage-internship-course.list-course')->with([
            'course' => $course,
            'currentYear' => $currentYear,
            'notify' => $notify,
            'user' => $admin,
            'type' => $type,
        ]);
    }

    public function planLearning()
    {
        /*
       * get newNotify
       * get uniNotify
       * get comNotify
       */
        $notify = News::getNotify();

        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';

        /*
         * get current year
         */
        $currentYear = (int)date('Y');
        $planLearning = PlanLearning::allPlanLearning();
        return view('manage-internship-course.plan-learning')->with([
            'planLearning' => $planLearning,
            'currentYear' => $currentYear,
            'notify' => $notify,
            'user' => $admin,
            'type' => $type,
        ]);
    }

    /**
     * add plan learning
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPlanLearning(Request $request)
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $adminID = 0;
        foreach ($admin as $am) {
            $adminID = $am->id;
        }
        $start = strtotime($request->input('start'));
        $finish = strtotime($request->input('finish'));
        $startTerm1 = strtotime($request->input('startTerm1'));
        $finishTerm1 = strtotime($request->input('finishTerm1'));
        $startTerm2 = strtotime($request->input('startTerm2'));
        $finishTerm2 = strtotime($request->input('finishTerm2'));
        $startTerm3 = strtotime($request->input('startTerm3'));
        $finishTerm3 = strtotime($request->input('finishTerm3'));
        $checkYear = (int)date('Y', $finish) - (int)date('Y', $start);
        $monthStart = date('m', $start);
        $monthFinish = date('m', $finish);
        if ($checkYear == 1) {
            if ($finishTerm1 > $startTerm1 &&
                $finishTerm1 < $startTerm2 && $finishTerm1 < $finishTerm2 &&
                $finishTerm1 < $startTerm3 && $finishTerm1 < $finishTerm3 &&
                $finishTerm1 < $finish
            ) {
                if ($startTerm2 > $startTerm1 && $startTerm2 > $finishTerm1 &&
                    $startTerm2 < $finishTerm2 &&
                    $startTerm2 < $startTerm3 && $startTerm2 < $finishTerm3 &&
                    $startTerm2 < $finish
                ) {
                    if ($startTerm3 < $finishTerm3 &&
                        $startTerm3 < $finish &&
                        $startTerm3 > $finishTerm2 && $startTerm3 > $startTerm2 &&
                        $startTerm3 > $finishTerm1 && $startTerm3 > $startTerm1
                    ) {
                        if ($monthStart == 8 && $monthFinish == 7) {
                            if (PlanLearning::checkInsertPlan((int)date('Y', $start), (int)date('Y', $finish))) {
                                PlanLearning::insertPlan(date('Y-m-d H:i:s', $start), date('Y-m-d H:i:s', $finish),
                                    date('Y-m-d H:i:s', $startTerm1), date('Y-m-d H:i:s', $finishTerm1),
                                    date('Y-m-d H:i:s', $startTerm2), date('Y-m-d H:i:s', $finishTerm2),
                                    date('Y-m-d H:i:s', $startTerm3), date('Y-m-d H:i:s', $finishTerm3), $adminID);
                            } else {
                                $this->checkInsertPlan = false;
                            }
                        } else {
                            $this->checkInsertPlan = false;
                        }
                    } else {
                        $this->checkInsertPlan = false;
                    }
                } else {
                    $this->checkInsertPlan = false;
                }
            } else {
                $this->checkInsertPlan = false;
            }
        } else {
            $this->checkInsertPlan = false;
        }
        if ($this->checkInsertPlan) {
            return redirect()->back()->with('addPlanSuccess', 'Thêm kế hoạch thành công');
        } else {
            return redirect()->back()->with('addPlanError', 'Lỗi thêm kế hoạch');
        }
    }

    /**
     * return create course page
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function createCourse()
    {
        /*
        * get newNotify
        * get uniNotify
        * get comNotify
        */
        $notify = News::getNotify();

        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';


        /*
         * xac dinh nam de truyen ra
         */
        $nowDate = date('Y-m-d');
        $nowMonth = (int)date('m', strtotime($nowDate));
        $year = 0;
        if ($nowMonth >= 7 && $nowMonth <= 12) {
            $year = (int)date('Y', strtotime($nowDate));
        } else {
            $year = (int)date('Y', strtotime($nowDate)) - 1;
        }
        /*
         *danh sách giảng viên, danh sách sinh viên
         */
        $allLecture = Lecture::allLecture();
        $allCompany = Company::allCompany();
        if (count(PlanLearning::getPlan($year)) > 0) {
            return view('manage-internship-course.create-course')->with([
                'lecture' => $allLecture,
                'company' => $allCompany,
                'year' => $year,
                'notify' => $notify,
                'user' => $admin,
                'type' => $type,
            ]);
        } else {
            $errorNotPlan = 'Năm học ' . $year . '-' . ($year + 1) . ' chưa có kế hoạch';
            return redirect()->back()->with('errorNotPlan', $errorNotPlan);
        }
    }

    /**
     * lay ra ngay bat dau, ngay ket thuc cua moi ky
     * phuc vu hien thi form them khoa thuc tap
     *
     * @param $term
     * @return array
     */
    public static function termDate($term)
    {
        $data = array();
        $getTerm = (int)$term;
        $year = (int)($getTerm / 10);
        $t = $getTerm % 10;
        $planLearning = PlanLearning::getPlan($year);
        foreach ($planLearning as $pl) {
            if ($t == 1) {
                $data[] = date('Y-m-d', strtotime($pl->start_term1));
                $data[] = date('Y-m-d', strtotime($pl->finish_term1));
            } else if ($t == 2) {
                $data[] = date('Y-m-d', strtotime($pl->start_term2));
                $data[] = date('Y-m-d', strtotime($pl->finish_term2));
            } else if ($t == 3) {
                $data[] = date('Y-m-d', strtotime($pl->start_term3));
                $data[] = date('Y-m-d', strtotime($pl->finish_term3));
            }
        }
        return $data;
    }

    public function createCourseForm(Request $request)
    {
        $getTerm = (int)($request->input('term'));
        $choseLecture = $request->input('choseLecture');
        $allCompany = Company::allCompany();
        if ($getTerm == "" || count($choseLecture) == 0) {
            $errorEmptyTerm = "";
            $errorEmptyLecture = "";
            if ($getTerm == "") {
                $errorEmptyTerm = "chưa chọn khóa học";
            }
            if (count($choseLecture) == 0) {
                $errorEmptyLecture = "chưa chọn giáo viên";
            }
            return redirect()->back()->with([
                'errorEmptyTerm' => $errorEmptyTerm,
                'errorEmptyLecture' => $errorEmptyLecture
            ]);
        } else {
            /*
         * process get start_term
         */
            $year = (int)($getTerm / 10);
            $term = $getTerm % 10;
            $planLearning = PlanLearning::getPlan($year);
            $planID = "";
            foreach ($planLearning as $pl) {
                $planID = $pl->id;
            }
            $startTerm = "";
            foreach ($planLearning as $pl) {
                if ($term == 1) {
                    $startTerm = strtotime($pl->start_term1);
                } elseif ($term == 2) {
                    $startTerm = strtotime($pl->start_term2);
                } else if ($term == 3) {
                    $startTerm = strtotime($pl->start_term3);
                }
            }
            //complete process start_term
            $nowDate = strtotime(date('Y-m-d'));
            if ($nowDate < $startTerm && InternShipCourse::checkCourse($getTerm)) {
                $name = 'Kỳ thực tập ' . $getTerm;
                $status = 'chưa phân công';
                $fromDate = date('Y-m-d H:i:s', strtotime($request->input('startTerm')));
                $toDate = date('Y-m-d H:i:s', strtotime($request->input('finishTerm')));
                InternShipCourse::insertInternShipCourse($name, $getTerm, $status, $fromDate, $toDate, $planID);
                $internShipCourse = InternShipCourse::getInternShipCourse($getTerm);
                $internShipCourseID = "";
                foreach ($internShipCourse as $i) {
                    $internShipCourseID = $i->id;
                }
                foreach ($choseLecture as $cl) {
                    if (LectureInternShipCourse::checkLectureInternShipCourse($cl, $internShipCourseID)) {
                        LectureInternShipCourse::insertLectureInternShipCourse($cl, $internShipCourseID);
                    }
                }
                foreach ($allCompany as $alc) {
                    if (CompanyInternShipCourse::checkCompanyInternShipCourse($alc->id, $internShipCourseID)) {
                        CompanyInternShipCourse::insertCompanyInternShipCourse($alc->id, $internShipCourseID, 0);
                    }
                }
                $success = 'Tạo thành công khóa thưc tập kỳ ' . $getTerm;
                return redirect('list-course')->with('createSuccessCourse', $success);
            } else {
                $errorCreateTime = "";
                $errorSameTerm = "";
                if ($nowDate > $startTerm) {
                    $errorCreateTime = "Khóa học đã diễn ra ";
                }
                if (!InternShipCourse::checkCourse($getTerm)) {
                    $errorSameTerm = "Khóa học đã tồn tại";
                }
                return redirect()->back()->with([
                    'errorCreateTime' => $errorCreateTime,
                    'errorSameTerm' => $errorSameTerm
                ]);
            }
        }
    }


    public function courseDetail(Request $request)
    {
        /*
       * get newNotify
       * get uniNotify
       * get comNotify
       */
        $notify = News::getNotify();

//        $adminSession = new  SessionController();
//        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $admin = Auth::user()->admin;
        $type = 'admin';

        $courseID = $request->input('id');
        /*
         * lay khoa thuc tap
         */
        $course = InternShipCourse::getInCourse($courseID);


        /*
         * lay danh sach sinh vien tham gia khoa thuc tap
         */
        $studentInCourse = StudentInternShipCourse::getSICFCourseID($courseID);
//        $arrStudent = array();
//        foreach ($studentInCourse as $sic) {
//            $student = Student::getStudentFollowID($sic->student_id);
//            foreach ($student as $s) {
//                $arrStudent[] = $s;
//            }
//        }
        /*
         * lay danh sach cong ty tham gia khoa thuc tap
         */
        $companyInCourse = CompanyInternShipCourse::getCompanyInCourse($courseID);
        $arrCompany = array();
        foreach ($companyInCourse as $cic) {
            $company = Company::getCompanyFollowID($cic->company_id);
            foreach ($company as $c) {
                $arrCompany[] = $c;
            }
        }
        /*
         * lay danh sach giang vien tham gia khoa thuc tap
         */
        $lectureInCourse = LectureInternShipCourse::getLectureInCourse($courseID);
        $arrLecture = array();
        foreach ($lectureInCourse as $lic) {
            $lecture = Lecture::getLectureFollowID($lic->lecture_id);
            foreach ($lecture as $l) {
                $arrLecture[] = $l;
            }
        }

        $courseTerm = "";
        foreach ($course as $c) {
            $courseTerm = $c->course_term;
        }

        /*lay nhom da phan cong*/
//        $arrAssign = InternShipGroup::getGroupFCourseID($courseID);
        $arrAssign = InternShipGroup::getGroupAssigned($courseID);

        /*lay danh sach sinh vien cho phan cong*/
        $arrStudentQue = StudentTmp::getStudentTmp($courseTerm, 0);

        /*lay danh sach sinh vien bi canh cao*/
        $arrStudentDanger = StudentTmp::getStudentTmp($courseTerm, -1);

        return view('manage-internship-course.course-detail')->with([
            'arrCompany' => $arrCompany,
            'arrLecture' => $arrLecture,
            'studentInCourse' => $studentInCourse,
            'companyInCourse' => $companyInCourse,
            'lectureInCourse' => $lectureInCourse,
            'course' => $course,
            'courseID' => $courseID,
            'arrAssign' => $arrAssign,
            'arrStudentQue' => $arrStudentQue,
            'arrStudentDanger' => $arrStudentDanger,
            'notify' => $notify,
            'user' => $admin,
            'type' => $type,
        ]);
    }

    public function updateTimeRegister(Request $request)
    {
        $courseID = decrypt($request->input('courseID'));
        $startRegister = $request->input('startRegister');
        $finishRegister = $request->input('finishRegister');
        $timeStartRegister = strtotime(date('Y-m-d', strtotime($startRegister)));
        $timeFinishRegister = strtotime(date('Y-m-d', strtotime($finishRegister)));
        $course = InternShipCourse::getInCourse($courseID);

        /*
         * kiem tra hop le dau vao truoc khi chinh sua
         */
        $timeCurrent = strtotime(date('Y-m-d'));
        if ($timeStartRegister < $timeFinishRegister && $timeStartRegister >= $timeCurrent) {
            foreach ($course as $c) {
                $timeFromTru2 = strtotime(date('Y-m-d', strtotime($c->from_date)) . " -4 day ");
                if ($timeFinishRegister <= $timeFromTru2) {
                    $this->checkUpdateTime = true;
                } else {
                    $this->checkUpdateTime = false;
                }
            }
        } else {
            $this->checkUpdateTime = false;
        }
        if ($this->checkUpdateTime) {
            InternShipCourse::updateTimeRegister($courseID, $startRegister, $finishRegister);
            return redirect()->back()->with('successUpdateTime', 'Mở đăng ký thành công');
        } else {
            return redirect()->back()->with('errorUpdateTime', 'Cập nhật thời gian đăng ký không thành công');
        }
    }

    public static function deleteCourse(Request $request)
    {
        $courseID = decrypt($request->input('courseID'));

        //xoa nhung bao cao cua sinh vien
        $studentInCourse = StudentInternShipCourse::getSICFCourseID($courseID);
        foreach ($studentInCourse as $sic) {
            StudentReport::deleteReport($sic->id);
        }

        //xoa bang cham cong trong ky
        Timekeeping::deleteTimeKeepingCourse($courseID);

        //xoa nhung nhan xet cua giang vien
        $lectureInCourse = LectureInternShipCourse::getLectureInCourse($courseID);
        foreach ($lectureInCourse as $lic) {
            LectureReport::deleteLectureReport($lic->id);
        }

        //xoa nhung nhan xet cua cong ty
        $group = InternShipGroup::getGroupFCourse($courseID);
        foreach ($group as $g) {
            CompanyAssess::deleteAsess($g->id);
        }

        //xoa quan he S-I
        StudentInternShipCourse::deleteStudentInCourse($courseID);

        //xoa quan he L-I
        LectureInternShipCourse::deleteLectureInCourse($courseID);

        //xoa quan he C-I
        CompanyInternShipCourse::deleteCIC($courseID);

        //xoa group
        InternShipGroup::deleteGroupFCourseID($courseID);

        //xoa khoa thuc tap
        InternShipCourse::deleteCourse($courseID);

        return redirect()->back()->with('deleteSuccess', 'Đã xóa khóa thực tập khỏi hệ thống');
    }

    public static function deletePlan(Request $request)
    {
        $planID = $request->input('planID');
        if (PlanLearning::checkPlan($planID)) {
            PlanLearning::deletePlan($planID);
            return redirect()->back()->with('deleteSuccess', 'Đã xóa kế hoạch học tập');
        } else {
            return redirect()->back();
        }
    }

    public static function deleteManyPlan(Request $request)
    {
        $planClass = $request->input('planClass');
        $arrPlanID = explode(',', $planClass);
        if ($arrPlanID[0] != null) {
            for ($i = 0; $i < count($arrPlanID); $i++) {
                if (count(InternShipCourse::getCourseFPlanID($arrPlanID[$i])) == 0) {
                    PlanLearning::deletePlan($arrPlanID[$i]);
                }
            }
            return redirect()->back()->with('deleteManySuccess', 'đã xóa kế hoạch đã chọn');
        } else {
            return redirect()->back();
        }
    }

    public function editPlan(Request $request)
    {
        $planID = decrypt($request->input('planID'));
        $start = strtotime($request->input('start'));
        $finish = strtotime($request->input('finish'));
        $startTerm1 = strtotime($request->input('startTerm1'));
        $finishTerm1 = strtotime($request->input('finishTerm1'));
        $startTerm2 = strtotime($request->input('startTerm2'));
        $finishTerm2 = strtotime($request->input('finishTerm2'));
        $startTerm3 = strtotime($request->input('startTerm3'));
        $finishTerm3 = strtotime($request->input('finishTerm3'));
        $checkYear = (int)date('Y', $finish) - (int)date('Y', $start);
        $monthStart = date('m', $start);
        $monthFinish = date('m', $finish);
        if ($checkYear == 1) {
            if ($finishTerm1 > $startTerm1 &&
                $finishTerm1 < $startTerm2 && $finishTerm1 < $finishTerm2 &&
                $finishTerm1 < $startTerm3 && $finishTerm1 < $finishTerm3 &&
                $finishTerm1 < $finish
            ) {
                if ($startTerm2 > $startTerm1 && $startTerm2 > $finishTerm1 &&
                    $startTerm2 < $finishTerm2 &&
                    $startTerm2 < $startTerm3 && $startTerm2 < $finishTerm3 &&
                    $startTerm2 < $finish
                ) {
                    if ($startTerm3 < $finishTerm3 &&
                        $startTerm3 < $finish &&
                        $startTerm3 > $finishTerm2 && $startTerm3 > $startTerm2 &&
                        $startTerm3 > $finishTerm1 && $startTerm3 > $startTerm1
                    ) {
                        if ($monthStart == 8 && $monthFinish == 7) {
                            if (PlanLearning::checkPlan($planID)) {
                                PlanLearning::editPlan(date('Y-m-d H:i:s', $start), date('Y-m-d H:i:s', $finish),
                                    date('Y-m-d H:i:s', $startTerm1), date('Y-m-d H:i:s', $finishTerm1),
                                    date('Y-m-d H:i:s', $startTerm2), date('Y-m-d H:i:s', $finishTerm2),
                                    date('Y-m-d H:i:s', $startTerm3), date('Y-m-d H:i:s', $finishTerm3), $planID);
                            } else {
                                $this->checkEditPlan = false;
                            }
                        } else {
                            $this->checkEditPlan = false;
                        }
                    } else {
                        $this->checkEditPlan = false;
                    }
                } else {
                    $this->checkEditPlan = false;
                }
            } else {
                $this->checkEditPlan = false;
            }
        } else {
            $this->checkEditPlan = false;
        }
        if ($this->checkEditPlan) {
            return redirect()->back()->with('editPlanSuccess', 'Đã sửa kế hoạch học tập');
        } else {
            return redirect()->back()->with('editPlanError', 'Lỗi sửa kế hoạch học tập');
        }
    }

    /**
     * cho giang vien dung phu trach thuc tap
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stopJoinLecture(Request $request)
    {

        $courseID = $request->input('courseID');
        $lectureID = $request->input('lectureID');
        $lecInCourseCheck = LectureInternShipCourse::getLectureInCourse($courseID);
        if (count($lecInCourseCheck) > 1) {
            $course = InternShipCourse::getInCourse($courseID);
            $status = "";
            foreach ($course as $c) {
                $status = $c->status;
            }
            if ($status == "chưa phân công") {
                LectureInternShipCourse::deleteFLectureIDCourseID($lectureID, $courseID);
                return redirect()->back()->with('stopJoinLecture', 'Đã cho giảng viên dừng');
            } else {
                $lecInCourse = LectureInternShipCourse::getLecInCourse($lectureID, $courseID);
                /*
                 * xoa nhung bao cao cua giang vien nay
                 */
                foreach ($lecInCourse as $lic) {
                    $lecReport = LectureReport::get($lic->id);
                    foreach ($lecReport as $lr) {
                        $find = LectureReport::find($lr->id);
                        $find->delete();
                    }
                }

                //xoa ban ghi lectureInCourse
                LectureInternShipCourse::deleteFLectureIDCourseID($lectureID, $courseID);

                /*
                 * cap nhat bang group và lectureInCourse bang cach lay ngau nhien mot giang vien da tham gia khoa nay
                 */
                $lectureInCourseContain = LectureInternShipCourse::getLectureInCourse($courseID);
                $lectureInCourseRandom = $lectureInCourseContain->random();
                $lectureIDRandom = $lectureInCourseRandom->lecture_id;

                //cap nhat bang lectureInCourse
                if (LectureInternShipCourse::checkLectureInternShipCourse($lectureIDRandom, $courseID)) {
                    LectureInternShipCourse::insertLectureInternShipCourse($lectureIDRandom, $courseID);
                }

                //Cap nhat group
                InternShipGroup::changeLecture($lectureID, $courseID, $lectureIDRandom);
                return redirect()->back()->with('stopJoinLecture', 'Đã cho giảng viên dừng');
            }
        } else {
            return redirect()->back()->with('errorStopJoinLecture', 'Chỉ còn một giảng viên phụ trách nên không bỏ giảng viên này ra khỏi khóa thực tập được');
        }
    }

    public function replaceLecture(Request $request)
    {
        $courseID = $request->input('courseID');
        $lectureIDOld = $request->input('lectureID');
        $lectureIDNew = $request->input('lectureIDReplace');
        $course = InternShipCourse::getInCourse($courseID);
        $status = "";
        foreach ($course as $c) {
            $status = $c->status;
        }
        if ($status == "chưa phân công") {
            LectureInternShipCourse::deleteFLectureIDCourseID($lectureIDOld, $courseID);
            if (LectureInternShipCourse::checkLectureInternShipCourse($lectureIDNew, $courseID)) {
                LectureInternShipCourse::insertLectureInternShipCourse($lectureIDNew, $courseID);
            }
            return redirect()->back()->with('replaceSuccess', 'Đã thay thế giảng viên');
        } else {
            $lecInCourseOld = LectureInternShipCourse::getLecInCourse($lectureIDOld, $courseID);
            $lecInCourseNew = LectureInternShipCourse::getLecInCourse($lectureIDNew, $courseID);
            $lectureReport = array();
            foreach ($lecInCourseOld as $licO) {
                $lectureReport = LectureReport::get($licO->id);
            }
            if (count($lectureReport) > 0) {
                if (count($lecInCourseNew) > 0) {
                    LectureInternShipCourse::deleteFLectureIDCourseID($lectureIDOld, $courseID);
                    foreach ($lectureReport as $lr) {
                        $find = LectureReport::find($lr->id);
                        $find->delete();
                    }
                } else {
                    LectureInternShipCourse::deleteFLectureIDCourseID($lectureIDOld, $courseID);
                    LectureInternShipCourse::insertLectureInternShipCourse($lectureIDNew, $courseID);
                    $lectureInCourseIDNew = LectureInternShipCourse::getLecInCourse($lectureIDNew, $courseID)->first()->id;
                    foreach ($lectureReport as $lr) {
                        LectureReport::changeLectureInCourseID($lr->id, $lectureInCourseIDNew);
                    }
                }
            } else {
                if (count($lecInCourseNew) > 0) {
                    LectureInternShipCourse::deleteFLectureIDCourseID($lectureIDOld, $courseID);
                } else {
                    LectureInternShipCourse::deleteFLectureIDCourseID($lectureIDOld, $courseID);
                    LectureInternShipCourse::insertLectureInternShipCourse($lectureIDNew, $courseID);
                }
            }

            //Cap nhat group
            InternShipGroup::changeLecture($lectureIDOld, $courseID, $lectureIDNew);
            return redirect()->back()->with('replaceSuccess', 'Đã thay thế giảng viên');
        }
    }


    /**
     * xoa sinh vien khoi khoa thuc tap
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stopIntern(Request $request)
    {
        $studentID = $request->input('studentID');
        $courseID = $request->input('courseID');

        $group = InternShipGroup::getGroupFollowSI($studentID, $courseID);

        //xoa danh gia cong ty ve sinh vien
        foreach ($group as $g) {
            CompanyAssess::deleteAsess($g->id);
        }

        //xoa nhung nhom ma sinh vien tham gia
        InternShipGroup::deleteGroup($studentID, $courseID);

        //xoa cham cong cau sinh vien
        Timekeeping::deleteFStudentCourse($studentID, $courseID);

        //xoa bao cao cua sinh vien
        $studentInCourse = StudentInternShipCourse::getStudentInCourse($studentID, $courseID);
        foreach ($studentInCourse as $sic) {
            StudentReport::deleteReport($sic->id);
        }

        //xoa ban ghi student_course
        StudentInternShipCourse::deleteSIC($studentID, $courseID);
        return redirect()->back()->with('stop-intern', 'Đã xóa sinh viên khỏi khóa thực tập');
    }

    public static function changeCompany(Request $request)
    {
        $studentID = decrypt($request->input('studentID'));
        $courseID = decrypt($request->input('courseID'));
        $companyID = decrypt($request->input('companyID'));
        $group = InternShipGroup::getGroupFollowSI($studentID, $courseID);
        //xoa nhan xet cua cong ty ve sinh vien
        foreach ($group as $g) {
            CompanyAssess::deleteAsess($g->id);
        }

        //xoa bang cham cong cua sinh vien
        Timekeeping::deleteFStudentCourse($studentID, $courseID);

        //xoa bang group
        InternShipGroup::deleteGroup($studentID, $courseID);

        //xoa bao cao cua sinh vien
        $studentInCourse = StudentInternShipCourse::getStudentInCourse($studentID, $courseID);
        foreach ($studentInCourse as $sic) {
            StudentReport::deleteReport($sic->id);
        }

        //cho diem cong ty, giang vien cho ve 0
        StudentInternShipCourse::updateCompanyPoint($studentID, $courseID, "");
        StudentInternShipCourse::updateLecturePoint($studentID, $courseID, "");
        /*
         * xu ly chuyen cong ty
         */
        $course = InternShipCourse::getInCourse($courseID);
        $status = "";
        foreach ($course as $c) {
            $status = $c->status;
        }
        if (CompanyInternShipCourse::checkCompanyInternShipCourse($companyID, $courseID)) {//ban ghi chua ton tai
            CompanyInternShipCourse::insert($companyID, $courseID, 1, "", "");
            if ($status == "chưa phân công") {
                InternShipGroup::insertGroup($studentID, $courseID, $companyID);
            } else {
                //lay ngau nhien mot giang vien trong cac giang vien da tham gia
                $listLecture = LectureInternShipCourse::getLectureInCourse($courseID);
                $lectureIDRandom = $listLecture->random()->lecture_id;
                InternShipGroup::insertGroupAddLectureID($studentID, $lectureIDRandom, $companyID, $courseID);
            }
        } else {//neu da ton tai
            $quantity = CompanyInternShipCourse::getQuantity($companyID, $courseID);
            CompanyInternShipCourse::updateStudentQuantity($companyID, $courseID, $quantity + 1);
            if ($status == "chưa phân công") {
                InternShipGroup::insertGroup($studentID, $courseID, $companyID);
            } else {
                //lay ngau nhien mot giang vien trong cac giang vien da tham gia
                $lectureID = "";
                $lectureIDTmp = InternShipGroup::getLectureID($companyID, $courseID);
                if ($lectureIDTmp == null) {
                    $listLecture = LectureInternShipCourse::getLectureInCourse($courseID);
                    $lectureID = $listLecture->random()->lecture_id;
                } else {
                    $lectureID = $lectureIDTmp;
                }
                InternShipGroup::insertGroupAddLectureID($studentID, $lectureID, $companyID, $courseID);
            }
        }
        return redirect()->back()->with('change-company', 'Đã chuyển công ty');
    }
}
