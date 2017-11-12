<?php

namespace App\Http\Controllers;

use App\Admin;
use App\ImageBanner;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class ImageBannerController extends Controller
{
    public function listImageBanner()
    {
        $admin = $this->currentUser()->admin;
        $type = 'admin';
        $imgBanner = ImageBanner::listImgBanner();
        return view('banner.list-img-banner')->with([
            'imgBanner' => $imgBanner,
            'user' => $admin,
            'type' => $type
        ]);
    }

    public function create()
    {
        $admin = $this->currentUser()->admin;
        $type = 'admin';

        return view('banner.create-img-banner')->with([
            'user' => $admin,
            'type' => $type
        ]);
    }

    public function createForm(Request $request)
    {
        $adminID = decrypt($request->input('adminID'));
        $file = Input::file('file');
        FileController::checkExtensionImage($file);
        $url = FileController::uploadFile($file);
        ImageBanner::addImageBanner($url, $request->input('nameDisplay'), 0, $adminID);
        return redirect('img-banner')->with('addSuccess', 'Thêm ảnh mới thành công');
    }

    public function editForm(Request $request)
    {
        ImageBanner::edit($request->input('nameDisplay'), $request->input('status'), decrypt($request->input('imgID')));
        return redirect('img-banner')->with('editSuccess', 'Đã chỉnh sửa ảnh banner');
    }

    /**
     * xoa mot anh banner
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteForm(Request $request)
    {
        $imgID = decrypt($request->input('imgID'));
        $img = ImageBanner::getImg($imgID);
        foreach ($img as $i) {
            if (is_file('public/' . $i->url)) {
                unlink('public/' . $i->url);//xoa anh duoi thu muc
            }
        }
        ImageBanner::deleteImg($imgID);//xoa ban ghi tren database
        return redirect('img-banner')->with('deleteSuccess', 'Đã xóa ảnh banner');
    }

    /**
     * xao nhieu anh banner
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteManyForm(Request $request)
    {
        $listID = $request->input('imgBannerClass');
        $arrID = explode(',', $listID);
        $length = count($arrID);
        for ($i = 0; $i < $length; $i++) {
            $img = ImageBanner::getImg($arrID[$i]);
            foreach ($img as $im) {
                if (is_file('public/' . $im->url)) {
                    unlink('public/' . $im->url);//xoa anh duoi thu muc
                }
            }
            ImageBanner::deleteImg($arrID[$i]);//xoa ban ghi tren database
        }
        return redirect('img-banner')->with('deleteSuccess', 'Đã xóa ảnh banner');
    }
}
