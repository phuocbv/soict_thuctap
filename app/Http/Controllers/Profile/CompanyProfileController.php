<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use App\MyUser;
use App\News;
use App\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CompanyProfileController extends Controller
{
    public function __construct()
    {
        $this->errorSum = "";
    }

    /**
     * return company-profile page
     *
     * @return $this
     */
    public function companyProfile()
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

        return view('profile.company-profile')->with([
            'notify' => $notify,
            'user' => $company,
            'type' => $type
        ]);
    }

    public function editProfile(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'address' => 'required',
            'birthday' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'description' => 'required',
        );
        $validator = Validator::make($input, $rules);
        if (!$validator->fails()) {
            $timeCurrent = time();
            $timeBirthday = strtotime($request->input('birthday'));
            $file = $request->file('logo');
            if ($file == null) {
                if ($timeCurrent - $timeBirthday > 0) {
                    $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                    Company::updateProfileNotLogo(decrypt($request->input('id')), $request->input('address'),
                        $birthday, $request->input('email'),
                        $request->input('phone'), $request->input('description'));
                } else {
                    if ($timeCurrent - $timeBirthday < 0) {
                        $this->errorSum = $this->errorSum . 'Không đúng (Công ty chưa thành lập)';
                    }
                }
                if ($this->errorSum == "") {
                    return redirect()->back()->with('updateSuccess', 'Thông tin cá nhân đã được cập nhật');
                } else {
                    return redirect()->back()->with('errorSum', $this->errorSum);
                }
            } else {
                if ($timeCurrent - $timeBirthday > 0) {
                    $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
                    //xoa file cu di
                    $company = Company::getCompanyFollowID(decrypt($request->input('id')));
                    foreach ($company as $c) {
                        if (is_file('public/' . $c->logo)) {
                            unlink('public/' . $c->logo);
                        }
                    }
                    $url = FileController::uploadFile($file);
                    Company::updateProfile(decrypt($request->input('id')), $request->input('address'),
                        $birthday, $request->input('email'),
                        $request->input('phone'), $url, $request->input('description'));
                } else {
                    if ($timeCurrent - $timeBirthday < 0) {
                        $this->errorSum = $this->errorSum . 'Không đúng (Công ty chưa thành lập)';
                    }
                }
                if ($this->errorSum == "") {
                    return redirect()->back()->with('updateSuccess', 'Thông tin cá nhân đã được cập nhật');
                } else {
                    return redirect()->back()->with('errorSum', $this->errorSum);
                }
            }
        } else {
            return redirect()->back()->with('errorPhone', 'Chưa nhập đủ thông tin');
        }
    }

    public function companyChangePass()
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

        $myUserID = $companySession->getCompanySession();

        return view('profile.company-change-pass')->with([
            'myUserID' => $myUserID,
            'notify' => $notify,
            'user' => $company,
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
            $userID = $session->getCompanySession();
            MyUser::changePassword($userID, $password);
            return redirect()->back()->with('changePasswordSuccess', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('changePasswordError', 'Đổi mật không thành công');
        }
    }

    public function adminEditCompany(Request $request)
    {
        $myUserID = decrypt($request->input('myUserID'));
        $name = trim($request->input('name'));
        $email = trim($request->input('email'));
        $password = $request->input('password');
        $address = $request->input('address');
        $birthday = date('Y-m-d H:i:s', strtotime($request->input('birthday')));
        $emailHR = $request->input('emailHR');
        $phone = $request->input('phone');
        $logo = $request->file('logo');
        $description = $request->input('description');
        $input = $request->all();
        if ($password == "") {
            $rules = array(
                'name' => 'required',
                'email' => 'required|email',
                'emailHR' => 'email'
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                return $this->updateSub($myUserID, $name, $email, $address, $birthday, $emailHR, $phone, $logo, $description);
            } else {
                return redirect()->back()->with('errorValidate', 'Dữ liệu không hợp lệ');
            }
        } else {
            $rules = array(
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'emailHR' => 'email'
            );
            $validator = Validator::make($input, $rules);
            if (!$validator->fails()) {
                if ($logo == null) {
                    if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email)
                        && Company::checkNameEdit($myUserID, $name)
                    ) {
                        MyUser::changePassword($myUserID, $password);
                    }
                } else {
                    if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email)
                        && Company::checkNameEdit($myUserID, $name)
                    ) {
                        MyUser::changePassword($myUserID, $password);
                    }
                }
                return $this->updateSub($myUserID, $name, $email, $address, $birthday, $emailHR, $phone, $logo, $description);
            } else {
                return redirect()->back()->with('errorValidate', 'Dữ liệu không hợp lệ');
            }
        }
    }

    public function updateSub($myUserID, $name, $email, $address, $birthday, $emailHR, $phone, $logo, $description)
    {
        if ($logo == null) {
            if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email) && Company::checkNameEdit($myUserID, $name)) {
                MyUser::updateUser($myUserID, $email, $email);
                $company = Company::getCompany($myUserID);
                $companyID = $company->first()->id;
                Company::updateCompanyNotLogo($companyID, $name, $address, $birthday, $emailHR, $phone, $description);
                return redirect()->back()->with('updateSuccess', 'Chỉnh sửa thông tin thành công cho công ty' . $name);
            } else {
                if (!MyUser::checkUserNameEdit($myUserID, $email)) {
                    return redirect()->back()->with('errorUsername', 'Trùng tên đăng nhập');
                }
                if (!MyUser::checkEmailEdit($myUserID, $email)) {
                    return redirect()->back()->with('errorEmail', 'Trùng email');
                }
                if (!Company::checkNameEdit($myUserID, $name)) {
                    return redirect()->back()->with('errorName', 'Trùng tên công ty khác trong hệ thống');
                }
            }
        } else {
            if (MyUser::checkUserNameEdit($myUserID, $email) && MyUser::checkEmailEdit($myUserID, $email)
                && Company::checkNameEdit($myUserID, $name)
            ) {
                MyUser::updateUser($myUserID, $email, $email);
                $company = Company::getCompany($myUserID);
                $companyID = $company->first()->id;
                $company = Company::getCompanyFollowID($companyID);
                foreach ($company as $c) {
                    if (is_file('public/' . $c->logo)) {
                        unlink('public/' . $c->logo);
                    }
                }
                $url = FileController::uploadFile($logo);
                Company::updateCompanyHasLogo($companyID, $name, $address, $birthday, $emailHR, $phone, $description, $url);
                return redirect()->back()->with('updateSuccess', 'Chỉnh sửa thông tin thành công cho công ty' . $name);
            } else {
                if (!MyUser::checkUserNameEdit($myUserID, $email)) {
                    return redirect()->back()->with('errorUsername', 'Trùng tên đăng nhập');
                }
                if (!MyUser::checkEmailEdit($myUserID, $email)) {
                    return redirect()->back()->with('errorUsername', 'Trùng email');
                }
                if (!Company::checkNameEdit($myUserID, $name)) {
                    return redirect()->back()->with('errorName', 'Trùng tên công ty khác trong hệ thống');
                }
                if (!FileController::checkExtension($logo)) {
                    return redirect()->back()->with('errorLogo', 'Không đúng định dạng file ảnh');
                }
            }
        }
    }
}
