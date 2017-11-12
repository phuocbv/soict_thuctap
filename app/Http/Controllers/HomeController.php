<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * show home page after login
     *
     * @return $this
     */
    public function home()
    {
        $notify = News::getNotify();
        $currentUser = $this->currentUser();
        $user = null;

        //phân quyền và lấy thông tin người dùng hiện tại
        switch ($currentUser->type) {
            case config('settings.role.admin'):
                $type = config('settings.role.admin');
                $user = $currentUser->admin;
                break;
            case config('settings.role.lecture'):
                $type = config('settings.role.lecture');
                $user = $currentUser->lecture;
                break;
            case config('settings.role.company'):
                $type = config('settings.role.company');
                $user = $currentUser->company;
                break;
            case config('settings.role.student'):
                $type = config('settings.role.student');
                $user = $currentUser->student;
                break;
            default:
                $user = $currentUser;
                $type = config('settings.role.social');
                break;
        }

        return view('home-user.users-home')->with([
            'notify' => $notify,
            'user' => $user,
            'type' => $type
        ]);
    }
}
