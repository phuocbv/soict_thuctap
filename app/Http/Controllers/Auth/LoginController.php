<?php

namespace App\Http\Controllers\Auth;

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
        return  Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $data = $user->email ? $user->email : $user->id;
            $authUser = User::findUser($data)->first();

            if (!$authUser) {
                $dataUser = [
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'provider' => $provider,
                    'provider_id' => $user->id
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
        $param = $request->only('studentCode', 'grade');
        $rules = [
            'studentCode' => 'required',
            'grade' => 'required'
        ];
        $validate = Validator::make($param, $rules);

        if ($validate->fails()) {
            return $this->responseJson([
                'status' => 'error',
                'messages' => 'Mã số sinh viên hoặc khóa trống.',
                'data' => []
            ]);
        }

        //tìm student
        $student = Student::where([
            'msv' => $param['studentCode'],
            'grade' => $param['grade']
        ])->first();

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
}
