<?php

namespace App\Http\Controllers\Profile;

use App\Admin;
use App\Http\Controllers\SessionController;
use App\MyUser;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function adminChangePass()
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

        $myUserID = $adminSession->getAdminSession();

        return view('profile.admin-change-pass')->with([
            'myUserID' => $myUserID,
            'notify' => $notify,
            'user' => $admin,
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
            $userID = $session->getAdminSession();
            MyUser::changePassword($userID, $password);
            return redirect()->back()->with('changePasswordSuccess', '??i m?t kh?u thành công');
        } else {
            return redirect()->back()->with('changePasswordError', '??i m?t không thành công');
        }
    }
}
