<?php

namespace App\Http\Controllers;

use App\Admin;
use App\MyFunction;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;

class MyFunctionController extends Controller
{
    public function listFunction()
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';

        //lay cac thong bao
        $notify = News::listNotify();

        //lay cac he dao tao
        $learningPrograming = MyFunction::learningPrograming();
        $academy = MyFunction::academy();
        return view('function.list-function')->with([
            'learningPrograming' => $learningPrograming,
            'academy' => $academy,
            'notify' => $notify,
            'user' => $admin,
            'type' => $type
        ]);
    }

    /**
     * them bo mon moi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAcademy(Request $request)
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $adminID = "";
        foreach ($admin as $a) {
            $adminID = $a->id;
        }
        MyFunction::insert($request->input('academy'), 2, $adminID);
        return redirect()->back()->with('addAcademy', 'Đã thêm một bộ môn mới');
    }

    /**
     * them he dao tao moi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addLearningPrograming(Request $request)
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $adminID = "";
        foreach ($admin as $a) {
            $adminID = $a->id;
        }
        MyFunction::insert($request->input('learningPrograming'), 1, $adminID);
        return redirect()->back()->with('addLearningPrograming', 'Đã thêm một hệ đào tạo mới');
    }

    /**
     * doi ten he dao tao
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editLearnProgram(Request $request)
    {
        $learnID = decrypt($request->input('learnID'));
        MyFunction::updateData($learnID, $request->input('learnProgram'));
        return redirect()->back()->with('updateLearn', 'Đã đổi tên một hệ đào tạo');
    }

    /**
     * doi ten bo mon
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editAcademy(Request $request)
    {
        $academyID = decrypt($request->input('academyID'));
        MyFunction::updateData($academyID, $request->input('academy'));
        return redirect()->back()->with('updateAcademy', 'Đã đổi tên một bộ môn');
    }

    /**
     * xoa he dao tao
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteLearn(Request $request)
    {
        $learnID = decrypt($request->input('learnID'));
        MyFunction::deleteData($learnID);
        return redirect()->back()->with('deleteLearn', 'Đã xóa kế một hệ đào tạo');
    }

    /**
     * xoa bo mon
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAcademy(Request $request)
    {
        $academyID = decrypt($request->input('academyID'));
        MyFunction::deleteData($academyID);
        return redirect()->back()->with('deleteAcademy', 'Đã xóa một bộ môn');
    }

    public function deleteMany(Request $request)
    {
        if (isset($_POST['manyAcademy'])) {
            $dataID = explode(',', $request->input('academyID'));
            $length = count($dataID);
            for ($i = 0; $i < $length; $i++) {
                MyFunction::deleteData($dataID[$i]);
            }
            return redirect()->back()->with('deleteManyAcademy', 'Xóa các bộ môn đã chọn');
        } else {
            $dataID = explode(',', $request->input('learnID'));
            $length = count($dataID);
            for ($i = 0; $i < $length; $i++) {
                MyFunction::deleteData($dataID[$i]);
            }
            return redirect()->back()->with('deleteManyLearn', 'Xóa các hệ đào tạo đã chọn');

        }
    }
}
