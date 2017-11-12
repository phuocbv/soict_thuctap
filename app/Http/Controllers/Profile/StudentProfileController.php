<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use App\MyUser;
use App\News;
use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class StudentProfileController extends Controller
{
    public function __construct()
    {
        $this->checkAVStudent = false;
        $this->checkMSVEmail = false;
    }

    /**
     * show form profile of student
     *
     * @return $this
     */
    public function studentProfile()
    {
        $student = $this->currentUser()->student;
        $type = 'student';

        return view('profile.student-profile')->with([
            'user' => $student,
            'type' => $type
        ]);
    }

    public function editProfile(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'english' => 'required',
            'phone' => 'required|regex:/(0)[0-9]/|min:10|max:11',
            'birthday' => 'required',
            'programingSkill' => 'required',
            'programingSkillBest' => 'required',
        );
        $validator = Validator::make($input, $rules);
        if (!$validator->fails()) {
            $yearCurrent = (int)date('Y');
            $yearBirthday = (int)date('Y', strtotime($request->input('birthday')));
            if ($yearCurrent - $yearBirthday > 18) {
                $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                Student::updateProfile(decrypt($request->input('id')), $request->input('english'),
                    $request->input('phone'), $birthday,
                    $request->input('programingSkill'), $request->input('programingSkillBest'));
                return redirect()->back()->with('updateSuccess', 'Thông tin cá nhân đã được cập nhật');
            } else {
                return redirect()->back()->with('errorBirthday', 'sinh viên phải nhiều hơn 18 tuổi');
            }
        } else {
            return redirect()->back()->with('errorPhone', 'Số điện thoại không hợp lệ');
        }
    }

    /**
     * show form change password of student
     *
     * @return $this
     */
    public function studentChangePass()
    {
        $student = $this->currentUser()->student;
        $type = 'student';
        //$myUserID = $studentSession->getStudentSession();

        return view('profile.student-change-pass')->with([
            'user' => $student,
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
            $userID = $session->getStudentSession();
            MyUser::changePassword($userID, $password);
            return redirect()->back()->with('changePasswordSuccess', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('changePasswordError', 'Đổi mật không thành công');
        }
    }

    public function adminEditStudent(Request $request)
    {
        $password = $request->input('password');
        if ($password == "") {
            $input = $request->all();
            $rules = array(
                'msv' => 'required',
                'email' => 'required|email',
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                $this->checkAVStudent = true;
                $msv = $request->input('msv');
                $email = $request->input('email');
                $myUserID = decrypt($request->input('myUserID'));
                $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                if (MyUser::checkUserNameEdit($myUserID, $msv) && MyUser::checkEmailEdit($myUserID, $email)) {
                    $this->checkMSVEmail = true;
                    MyUser::updateUser($myUserID, $msv, $email);
                    $studentID = Student::getStudentID($myUserID);
                    Student::adminUpdateProfile($studentID, trim($request->input('fullName')),
                        $request->input('grade'), $request->input('programingUniversity'),
                        $msv, $request->input('phone'), $birthday,
                        $request->input('programingSkill'), $request->input('programingSkillBest'), $request->input('english'));
                }
            }
        } else {
            $input = $request->all();
            $rules = array(
                'msv' => 'required',
                'password' => 'required|min:6',
                'email' => 'required|email',
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                $this->checkAVStudent = true;
                $msv = $request->input('msv');
                $email = $request->input('email');
                $myUserID = decrypt($request->input('myUserID'));
                $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                if (MyUser::checkUserNameEdit($myUserID, $msv) && MyUser::checkEmailEdit($myUserID, $email)) {
                    $this->checkMSVEmail = true;
                    MyUser::updateUser($myUserID, $msv, $email);
                    MyUser::changePassword($myUserID, $password);
                    $studentID = Student::getStudentID($myUserID);
                    Student::adminUpdateProfile($studentID, trim($request->input('fullName')),
                        $request->input('grade'), $request->input('programingUniversity'),
                        $msv, $request->input('phone'), $birthday,
                        $request->input('programingSkill'), $request->input('programingSkillBest'), $request->input('english'));
                }
            }
        }
        $message = $request->input('fullName');
        if ($this->checkAVStudent && $this->checkMSVEmail) {
            return redirect()->back()->with('editSuccess', 'chỉnh sửa thành công thông tin sinh viên' . $message);
        } else {
            if (!$this->checkAVStudent) {
                return redirect()->back()->with('editError1', 'Thông tin không đúng định dạng');
            } else {
                return redirect()->back()->with('editError2', 'Trùng mã sinh viên hoặc email');
            }
        }
    }
}
