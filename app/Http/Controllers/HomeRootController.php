<?php

namespace App\Http\Controllers;

use App\Company;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class HomeRootController extends Controller
{
    /**
     * forget all session
     */
//    public function forgetSession()
//    {
//        $data = session()->all();
//        foreach ($data as $a => $value) {
//            session()->forget($a);
//        }
//    }

    /**
     * return page home not login
     *
     * @return $this
     */
    public function home()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $company = Company::all();
        $notify = News::getNotify();

        return view('home')->with([
            'notify' => $notify,
            'company' => $company
        ]);
    }

    public function detailNotify(Request $request)
    {
        $notifyID = $request->input('idNotify');
        $notify = News::getNotifyFID($notifyID);
        if (count($notify) == 0) {
            return redirect()->back();
        } else {
            return view('detail-notify')->with('notify', $notify);
        }
    }

    public function showNotify(Request $request)
    {
        $notifyID = $request->input('idNotify');
        $notify = News::getNotifyFID($notifyID);
        if (count($notify) == 0) {
            return redirect()->back();
        } else {
            return view('home-user.notify')->with([
                'notify' => $notify,
                'type' => 'social'
            ]);
        }
    }
    /**
     * lấy danh sách thông tin của công ty
     *
     * @return $this
     */
    public function getListCompany()
    {
        $student = $this->currentUser()->student;
        $type = 'social';
        $company = Company::all();//get all

        return view('home-user.company-cooperation-student')->with([
            'user' => $student,
            'company' => $company,
            'type' => $type
        ]);
    }

    public function showInforCompany(Request $request)
    {

    }
}
