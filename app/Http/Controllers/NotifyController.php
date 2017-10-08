<?php

namespace App\Http\Controllers;

use App\Admin;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotifyController extends Controller
{

    /**
     * hien thi danh sach tin tuc
     *
     * @return $this
     */
    public function listNotify()
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';

        /*
         * lay danh sach thong bao
         */
        $notify = News::listNotify();
        return view('manage-notify.list-notify')->with([
            'notify' => $notify,
            'user' => $admin,
            'type' => $type
        ]);
    }

    /**
     * chuyen trang tao tin tuc moi
     *
     * @return $this
     */
    public function createNotify()
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';

        /*
         * lay danh sach thong bao
         */
        return view('manage-notify.create-notify')->with([
            'user' => $admin,
            'type' => $type
        ]);
    }

    /**
     * them tin tuc moi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createNotifyForm(Request $request)
    {
        News::insert($request->input('title'), $request->input('content'), decrypt($request->input('adminID')));
        return redirect('manage-notify')->with('insertSuccess', 'thêm tin tức thành công');
    }

    /**
     * xoa tin tuc
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteNotifyForm(Request $request)
    {
        News::deleteNotify(decrypt($request->input('notifyID')));
        return redirect()->back()->with('deleteSuccess', 'đã xóa tin tức');
    }

    /**
     * xoa nhieu tin tuc
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteManyNotify(Request $request)
    {
        $notifyClass = $request->input('notifyClass');
        $arrNotifyID = explode(',', $notifyClass);
        if ($arrNotifyID[0] != null) {
            for ($i = 0; $i < count($arrNotifyID); $i++) {
                News::deleteNotify($arrNotifyID[$i]);
            }
            return redirect()->back()->with('deleteManySuccess', 'đã xóa tin tức đã chọn');
        } else {
            return redirect()->back();
        }
    }

    /**
     * chuyen trang chinh sua tin tuc
     *
     * @param Request $request
     * @return $this
     */
    public function editNotify(Request $request)
    {
        $adminSession = new  SessionController();
        $admin = Admin::getAdmin($adminSession->getAdminSession());
        $type = 'admin';
        $notifyID = decrypt($request->input('id'));
        /*
         * lay danh sach thong bao
         */
        if (News::checkNotify($notifyID)) {
            $notify = News::getNotifyFID($notifyID);
            return view('manage-notify.edit-notify')->with([
                'user' => $admin,
                'type' => $type,
                'notify' => $notify
            ]);
        } else {
            return redirect('manage-notify');
        }
    }

    /**
     * chinh sua thong tin tin tuc
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editNotifyForm(Request $request)
    {
        if (News::checkNotify(decrypt($request->input('notifyID')))) {
            News::updateNotify(decrypt($request->input('notifyID')), $request->input('title'), $request->input('content'));
            return redirect('manage-notify')->with('editSuccess', 'Chỉnh sửa thành công tin tức');
        } else {
            return redirect('manage-notify');
        }
    }
}
