<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use App\Lecture;
use App\MyUser;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class LectureProfileController extends Controller
{
    public function __construct()
    {
        $this->checkAVlecture = false;
        $this->checkUEmail = false;
    }

    public function lectureProfile()
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

        return view('profile.lecture-profile')->with([
            'notify' => $notify,
            'user' => $lecture,
            'type' => $type
        ]);
    }

    /**
     *update profile lecture
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editProfile(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'phone' => 'required|regex:/(0)[0-9]/|min:10|max:11',
            'birthday' => 'required',
        );
        $validator = Validator::make($input, $rules);
        if (!$validator->fails()) {
            $yearCurrent = (int)date('Y');
            $yearBirthday = (int)date('Y', strtotime($request->input('birthday')));
            if ($yearCurrent - $yearBirthday > 23) {
                $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                Lecture::updateProfile(decrypt($request->input('id')), $birthday, $request->input('phone'));
                return redirect()->back()->with('updateSuccess', 'Thông tin cá nhân đã được cập nhật');
            } else {
                return redirect()->back()->with('errorBirthday', 'giảng viên phải nhiều hơn 23 tuổi');
            }
        } else {
            return redirect()->back()->with('errorPhone', 'Số điện thoại không hợp lệ');
        }
    }

    public function lectureChangePass()
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
        $myUserID = $lectureSession->getLectureSession();

        return view('profile.lecture-change-pass')->with([
            'myUserID' => $myUserID,
            'notify' => $notify,
            'user' => $lecture,
            'type' => $type
        ]);
    }

    public function changePass(Request $request)
    {
        $password = $request->input('password');
        /*
         * validate du lieu truoc cap nhat
         */
        $input = $request->all();
        $rules = array(
            'password' => 'required|min:6'
        );
        $validator = Validator::make($input, $rules);
        if (!$validator->fails()) {
            $session = new SessionController();
            $userID = $session->getLectureSession();
            MyUser::changePassword($userID, $password);
            return redirect()->back()->with('changePasswordSuccess', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('changePasswordError', 'Đổi mật không thành công');
        }
    }

    public function adminEditLecture(Request $request)
    {
        $password = $request->input('password');
        $myUserID = decrypt($request->input('myUserID'));
        $email = $request->input('email');
        $name = trim($request->input('fullName'));
        $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
        $phone = $request->input('phone');
        $qualification = $request->input('qualification');
        $address = $request->input('address');
        if ($password == "") {
            $input = $request->all();
            $rules = array(
                'email' => 'required|email',
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                $this->checkAVlecture = true;
                if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email)) {
                    $this->checkUEmail = true;
                    MyUser::updateUser($myUserID, $email, $email);
                    $lecture = Lecture::getLecture($myUserID);
                    $lectureID = $lecture->first()->id;
                    Lecture::adminUpdateProfile($lectureID, $name, $birthday, $qualification, $address, $phone);
                }
            }
        } else {
            $input = $request->all();
            $rules = array(
                'email' => 'required|email',
                'password' => "required|min:6"
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                $this->checkAVlecture = true;
                if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email)) {
                    $this->checkUEmail = true;
                    MyUser::changePassword($myUserID, $password);
                    MyUser::updateUser($myUserID, $email, $email);
                    $lecture = Lecture::getLecture($myUserID);
                    $lectureID = $lecture->first()->id;
                    Lecture::adminUpdateProfile($lectureID, $name, $birthday, $qualification, $address, $phone);
                }
            }
        }
        $message = $request->input('fullName');
        if ($this->checkAVlecture && $this->checkUEmail) {
            return redirect()->back()->with('editSuccess', 'chỉnh sửa thành công thông tin giảng viên ' . $message);
        } else {
            if (!$this->checkAVlecture) {
                return redirect()->back()->with('editError1', 'Thông tin không đúng định dạng');
            } else {
                return redirect()->back()->with('editError2', 'Trùng email');
            }
        }
    }
}
