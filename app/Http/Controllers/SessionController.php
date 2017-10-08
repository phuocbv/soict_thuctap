<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class SessionController extends Controller
{
    /**
     * get student session (this is id user with type=student)
     *
     * @return mixed
     */
    public function getStudentSession()
    {
        $studentSession = decrypt(session()->get('studentLogin'));
        return $studentSession;
    }

    /**
     * get lecture session (this is id user with type=lecture)
     *
     * @return mixed
     */
    public function getLectureSession()
    {
        $lectureSession = decrypt(session()->get('lectureLogin'));
        return $lectureSession;
    }

    /**
     * get Company session (this is id user with type=company)
     *
     * @return mixed
     */
    public function getCompanySession()
    {
        $companySession = decrypt(session()->get('companyLogin'));
        return $companySession;
    }

    /**
     * get Admin session (this is id user with type=admin)
     *
     * @return mixed
     */
    public function getAdminSession()
    {
        $adminSession = decrypt(session()->get('adminLogin'));
        return $adminSession;
    }
}
