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
    /**
     * show form change password of admin
     *
     * @return $this
     */
    public function adminChangePass()
    {
        $admin = $this->currentUser()->admin;
        $myUserID = $this->currentUser()->id;
        $type = 'admin';

        return view('profile.admin-change-pass')->with([
            'myUserID' => $myUserID,
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
            return redirect()->back()->with('changePasswordSuccess', '??i m?t kh?u th�nh c�ng');
        } else {
            return redirect()->back()->with('changePasswordError', '??i m?t kh�ng th�nh c�ng');
        }
    }
}
