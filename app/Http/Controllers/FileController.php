<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    /**
     * check file extension (return true if xlsx or xls)
     *
     * @param $file
     * @return bool
     */
    public static function checkExtension($file)
    {
        $extension = $file->getClientOriginalExtension();
        if ($extension == 'xlsx' || $extension == 'xls') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check extension image
     *
     * @param $file
     * @return bool
     */
    public static function checkExtensionImage($file)
    {
        $extension = $file->extension();
        if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * upload file and return url
     *
     * @param $file
     * @return string
     */
    public static function uploadFile($file)
    {
        $fileName = time() . '.' . $file->getClientOriginalName();
        $url = 'file_upload' . '/' . $fileName;
        $file->move('public/file_upload', $fileName);
        chmod('public/file_upload' . '/' . $fileName, 0755);
        return $url;
    }
}
