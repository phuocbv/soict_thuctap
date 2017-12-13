<?php

namespace App\Http\Controllers\Course;

use App\Company;
use App\CompanyInternShipCourse;
use App\Http\Controllers\SessionController;
use App\InternShipCourse;
use App\InternShipGroup;
use App\News;
use App\StudentInternShipCourse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CompanyInCourseController extends Controller
{
    public function companyRegister()
    {
        $company = $this->currentUser()->company;
        $type = 'company';
        $companyID = $company->id;

        /*
         * lay danh sach khoa thuc tap trong nam hien tai
         */
        //$arrCourse = array();
        $nowDate = date('Y-m-d');
        $nowMonth = (int)date('m', strtotime($nowDate));
        //$year = 0;
        if ($nowMonth >= 7 && $nowMonth <= 12) {
            $year = (int)date('Y', strtotime($nowDate));
        } else {
            $year = (int)date('Y', strtotime($nowDate)) - 1;
        }
        $inCourse = InternShipCourse::getCourseFollowYear($year);
        return view('manage-register.company-register')->with([
            'companyID' => $companyID,
            'inCourse' => $inCourse,
            'user' => $company,
            'type' => $type
        ]);
    }

    /**
     * cong ty dang ky tham gia vao khoa thuc tap
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyRegisterForm(Request $request)
    {
        $courseID = decrypt($request->input('courseIDAdd'));
        $companyID = decrypt($request->input('companyIDAdd'));
        if (CompanyInternShipCourse::checkCompanyInternShipCourse($companyID, $courseID)) {
            CompanyInternShipCourse::insert($companyID, $courseID, $request->input('quantityAdd'), $request->input('requireSkillAdd'), $request->input('hrName'));
            return redirect()->back()->with('companyRegisterSuccess', 'Tham gia thành công');
        } else {
            return redirect()->back()->with('companyRegisterError', 'Công ty đã tham gia');
        }
    }

    /**
     * edit thông tin khi đã tham gia khóa thực tập
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyEditRegisterForm(Request $request)
    {
        $courseID = decrypt($request->input('courseIDEdit'));
        $companyID = decrypt($request->input('companyIDEdit'));
        CompanyInternShipCourse::updateStudentQuantity($companyID, $courseID, $request->input('quantityEdit'));
        CompanyInternShipCourse::updateRequireSkill($companyID, $courseID, $request->input('requireSkillEdit'));
        CompanyInternShipCourse::updateHrName($companyID, $courseID, $request->input('hrName'));
        return redirect()->back()->with('companyEditRegisterSuccess', 'Chỉnh sửa thành công');
    }

    /**
     * delete xóa việc đăng ký của công ty
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyDeleteRegisterForm(Request $request)
    {
        $courseID = decrypt($request->input('courseIDDelete'));
        $companyID = decrypt($request->input('companyIDDelete'));
        CompanyInternShipCourse::deleteCompanyInCourse($companyID, $courseID);
        return redirect()->back()->with('companyDeleteRegisterSuccess', 'Đã xóa đăng ký');
    }

    /**
     *chinh sua ten nguoi quan ly thuc tap cua cong ty
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyUpdateHrName(Request $request)
    {
        $courseID = decrypt($request->input('courseIDEdit'));
        $companyID = decrypt($request->input('companyIDEdit'));
        CompanyInternShipCourse::updateHrName($companyID, $courseID, $request->input('hrName'));
        return redirect()->back()->with('companyEditRegisterSuccess', 'Chỉnh sửa thành công');
    }


    /**
     * giao nhiem vu cho sinh vien
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignWork(Request $request)
    {
        $studentID = decrypt($request->input('studentID'));
        $courseID = decrypt($request->input('courseID'));
        StudentInternShipCourse::updateAssignWork($studentID, $courseID, $request->input('assignWork'));
        return redirect()->back()->with('assignWorkSuccess', 'Giao nhiệm vụ thành công cho sinh viên');
    }

    /**
     * giao nhiem vu cho nhieu sinh vien
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignWorkMany(Request $request)
    {
        $arrGroup = $request->input('groupID');
        $work = $request->input('assignWork');
        $groupID = explode(',', $arrGroup);
        $length = count($groupID);
        for ($i = 0; $i < $length; $i++) {
            $group = InternShipGroup::getGroupFGroup($groupID[$i]);
            foreach ($group as $g) {
                StudentInternShipCourse::updateAssignWork($g->student_id, $g->internship_course_id, $work);
            }
        }
        return redirect()->back()->with('assignWorkSuccess', 'Giao nhiệm vụ thành công cho sinh viên');
    }
}
