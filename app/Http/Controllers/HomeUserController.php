<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Company;
use App\Lecture;
use App\MyUser;
use App\News;
use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeUserController extends Controller
{
    /**
     * return user-home page is student
     *
     * @return $this
     */
    public function studentHome()
    {
        /*
         * get newNotify
         * get uniNotify
         * get comNotify
         */
        $notify = News::getNotify();

        $studentSession = new SessionController();
        $student = Student::getStudent($studentSession->getStudentSession());
        $type = 'student';

        return view('home-user.users-home')->with([
            'notify' => $notify,
            'user' => $student,
            'type' => $type
        ]);
    }

    public function companyInformationStudent()
    {
        $notify = News::getNotify();

        $studentSession = new SessionController();
        $student = Student::getStudent($studentSession->getStudentSession());
        $type = 'student';

        //allCompany
        $company = Company::all();
        return view('home-user.company-cooperation-student')->with([
            'notify' => $notify,
            'user' => $student,
            'company' => $company,
            'type' => $type
        ]);
    }

    /**
     * return user-home page is lecture
     *
     * @return $this
     */
    public function lectureHome()
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

        return view('home-user.users-home')->with([
            'notify' => $notify,
            'user' => $lecture,
            'type' => $type
        ]);
    }

    public function companyInformationLecture()
    {
        $notify = News::getNotify();
        $lectureSession = new  SessionController();
        $lecture = Lecture::getLecture($lectureSession->getLectureSession());
        $type = 'lecture';

        $company = Company::all();

        return view('home-user.company-cooperation-lecture')->with([
            'notify' => $notify,
            'user' => $lecture,
            'company' => $company,
            'type' => $type
        ]);
    }

    /**
     * return user-home page is company
     *
     * @return $this
     */
    public function companyHome()
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

        return view('home-user.users-home')->with([
            'notify' => $notify,
            'user' => $company,
            'type' => $type
        ]);
    }

    public function companyInformationCompany()
    {
        $notify = News::getNotify();

        $companySession = new  SessionController();
        $company = Company::getCompany($companySession->getCompanySession());
        $type = 'company';

        $allCompany = Company::all();
        return view('home-user.company-cooperation-company')->with([
            'notify' => $notify,
            'user' => $company,
            'company' => $allCompany,
            'type' => $type
        ]);
    }

    /**
     * return user-home page is admin
     *
     * @return $this
     */
    public function adminHome()
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

        return view('home-user.users-home')->with([
            'notify' => $notify,
            'user' => $admin,
            'type' => $type
        ]);
    }

    /**
     * process user complex contain: user-home, user-guide, user-notify, user-assess
     *
     * @param Request $requests
     * @return $this
     */
    public function userComplex(Request $requests)
    {
        $type = $requests->input('type');
        $user_id = $requests->input('user_id');
        $allUser = MyUser::getUserFType($type);
        $userID = "";
        foreach ($allUser as $au) {
            if (Hash::check($au->id, $user_id)) {
                $userID = $au->id;
                break;
            }
        }
        return $this->userHome($type, $userID);
    }

    /**
     * return user-home when click 'trang chu'. It is difference after login
     *
     * @param $type
     * @param $userID
     * @return $this
     */
    public function userHome($type, $userID)
    {
        /*
         * get newNotify
         * get uniNotify
         * get comNotify
         */
        $notify = News::getNotify();
        //$session = new SessionController();
        $user = Auth::user();

        if ($type == 'student') {
            if (isset($user)) {
                $student = $user->student;
                return view('home-user.users-home')->with([
                    'notify' => $notify,
                    'user' => $student,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        } else if ($type == 'lecture') {
            if (isset($user)) {
                $lecture = $user->lecture;
                return view('home-user.users-home')->with([
                    'notify' => $notify,
                    'user' => $lecture,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }

        } else if ($type == 'company') {
            if (isset($user)) {
                $company = $user->company;
                return view('home-user.users-home')->with([
                    'notify' => $notify,
                    'user' => $company,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }

        } else if ($type == 'admin') {
            if (isset($user)) {
                $admin = $user->admin;
                return view('home-user.users-home')->with([
                    'notify' => $notify,
                    'user' => $admin,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        }
    }

    public function notifyDetail(Request $request)
    {
        $user_id = $request->input('user_id');
        $notifyID = $request->input('notify_id');
        $type = $request->input('type');
        $allUser = MyUser::getUserFType($type);
        $userID = "";

        foreach ($allUser as $au) {
            if (Hash::check($au->id, $user_id)) {
                $userID = $au->id;
            }
        }
        $notify = News::getNotifyFID($notifyID);

        $session = new SessionController();
        if ($type == 'student') {
            $student = Student::getStudent($userID);
            $studentSession = $session->getStudentSession();
            if ($studentSession != null) {
                return view('home-user.user-detail-notify')->with([
                    'notify' => $notify,
                    'user' => $student,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        } elseif ($type == 'lecture') {
            $lecture = Lecture::getLecture($userID);
            $lectureSession = $session->getLectureSession();
            if ($lectureSession != null) {
                return view('home-user.user-detail-notify')->with([
                    'notify' => $notify,
                    'user' => $lecture,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        } elseif ($type == 'company') {
            $company = Company::getCompany($userID);
            $companySession = $session->getCompanySession();
            if ($companySession != null) {
                return view('home-user.user-detail-notify')->with([
                    'notify' => $notify,
                    'user' => $company,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        } else {
            $admin = Admin::getAdmin($userID);
            $adminSession = $session->getAdminSession();
            if ($adminSession != null) {
                return view('home-user.user-detail-notify')->with([
                    'notify' => $notify,
                    'user' => $admin,
                    'type' => $type
                ]);
            } else {
                return redirect()->back();
            }
        }
    }
}
