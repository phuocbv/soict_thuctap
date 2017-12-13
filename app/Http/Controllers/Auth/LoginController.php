<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\User;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Validator;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user-login');
    }

    public function redirectToProvider($provider)
    {
        return  Socialite::driver($provider)->scopes([
            'email',
            'user_birthday',
            'publish_actions',
            'publish_pages',
            'manage_pages',
            'user_friends',
                'user_managed_groups'
        ])->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $data = $user->email ? $user->email : $user->id;
            session([ACCESS_TOKEN_SOCIAL => $user->token]);

            if (Auth::check()) {
                return redirect()->route('student.registerInternship', [

                ]);
            }

            $authUser = User::findUser($data)->first();

            if (!$authUser) {
                $dataUser = [
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'type' => config('settings.role.social')
                ];

                $authUser = User::create($dataUser);
            }

            if (!$authUser->parent_id) {
                Auth::login($authUser, true);
            } else{
                Auth::login($authUser->parent, true);
            }
        } catch (\Exception $e) {
            return redirect('auth/' . $provider);
        }

        return redirect()->route('home');
    }

    /**
     * hàm kiểm tra có phải là sinh viên không
     *
     * @param Request $request
     */
    public function validateStudent(Request $request)
    {
        $param = $request->only('studentCode', 'grade', 'nameStudent');
        $rules = [
            'studentCode' => 'required',
            'grade' => 'required',
            'nameStudent' => 'required'
        ];
        $validate = Validator::make($param, $rules);

        if ($validate->fails()) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Chưa nhập đủ thông tin.',
                'data' => []
            ]);
        }

        //tìm student
        $student = Student::where([
            'msv' => $param['studentCode'],
            'grade' => $param['grade']
        ])->where('name', 'LIKE', $param['nameStudent'])->first();

        if (!$student) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Không tìm thấy sinh viên.',
                'data' => []
            ]);
        }

        //nếu tồn tại user thì set parent_id cho tài khoản hiện tại và login bằng user này
        $user = $student->user;
        $currentUser = Auth::user();
        $currentUser->parent_id = $user->id;
        $currentUser->save();
        Auth::logout();
        Auth::login($user, true);

        return $this->responseJson([
            'status' => 'success',
            'messages' => '',
            'data' => []
        ]);
    }

    public function validateCompany(Request $request)
    {
        $param = $request->only('nameCompany', 'email', 'phone');
        $rules = [
            'nameCompany' => 'required',
            'email' => 'required',
//            'phone' => 'required'
        ];
        $validate = Validator::make($param, $rules);

        if ($validate->fails()) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Chưa nhập đủ thông tin.',
                'data' => []
            ]);
        }

        $user = User::where(['email' => $param['email']])->first();

        if (!$user) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Không tìm thấy công ty.',
                'data' => []
            ]);
        }

        $company = $user->company;

        if (strtoupper($company->name) != strtoupper($param['nameCompany'])) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Xác thực sai.',
                'data' => []
            ]);
        }

        //nếu tồn tại user thì set parent_id cho tài khoản hiện tại và login bằng user này
        $currentUser = Auth::user();
        $currentUser->parent_id = $user->id;
        $currentUser->save();
        Auth::logout();
        Auth::login($user, true);

        return $this->responseJson([
            'status' => 'success',
            'messages' => '',
            'data' => []
        ]);
    }

    public function demo(Request $request)
    {
        dd($request->session()->get(ACCESS_TOKEN_SOCIAL));
    }


}
