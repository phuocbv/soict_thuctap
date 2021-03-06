<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 26/11/2017
 * Time: 01:52
 */

namespace App\Http\Controllers\Course;


use App\Company;
use App\CompanyInternShipCourse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\InternShipGroup;
use App\Lecture;
use App\LectureInternShipCourse;
use App\StudentInternShipCourse;
use App\StudentTmp;
use App\User;
use Illuminate\Http\Request;
use App\InternShipCourse;
use App\LectureAssignCompany;
use FontLib\TrueType\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class AssignLectureController extends Controller
{
    /**
     * hiển thị danh sách kì thực tập
     */
    public function showListInternship()
    {
        $admin = $this->currentUser()->admin;
        $type = 'admin';
        $listAssignLecture = LectureAssignCompany::all();
        $listCompany = Company::all();
        $listIdCompanyReject = $listAssignLecture->lists('company_id')->unique();
        //lay danh sach cong ty chua duoc phan cong

//        $list = $listCompany->reject(function ($item, $key) use ($listIdCompanyReject){
//            return $listIdCompanyReject->contains($item->id);
//        });
        $list = Company::all();

        //$list = LectureInternShipCourse::all();
        $listLecture = Lecture::all();
        $listCourse = InternShipCourse::orderBy('course_term', 'DESC')->get();

        return view('manage-internship-course.list-course-assign-lecture')->with([
            'user' => $admin,
            'type' => $type,
            'listAssignLecture' => $listAssignLecture,
            'listCompany' => $list,
            'listLecture' => $listLecture,
            'listCourse' => $listCourse,
        ]);
    }

   /* public function assignLectureToCompany(Request $request)
    {
        $file = $request->file('file');

        $listLectureAssignCompany = collect();
        if (FileController::checkExtension($file)) {
            Excel::load($file, function ($reader) use ($listLectureAssignCompany){
                $reader->each(function ($sheet) use ($listLectureAssignCompany){
                    $allRow = $sheet->all();
                    if (count($allRow) > 0) {
                        $sheet->first();
                        $sheet->each(function ($row) use ($listLectureAssignCompany){
                            $row = $row->toArray();
                            $rules = array(
                                'emaillecture' => 'required',
                                'emailcompany' => 'required',
                            );
                            $validator = Validator::make($row, $rules);
                            if (!$validator->fails()) {
                                $listLectureAssignCompany->push($row);
                            }
                        });
                    }
                });
            });
        }

        //insert từng bản ghi vào trong database
        foreach ($listLectureAssignCompany as $item) {
            $userLecture = User::getByInput([
                'email' => $item['emaillecture'],
                'type' => config('settings.role.lecture')
            ])->first();
            $userCompany = User::getByInput([
                'email' => $item['emailcompany'],
                'type' => config('settings.role.company')
            ])->first();

            //check tồn tại lecture và company
            if ($userCompany->company && $userLecture->lecture) {
                $listLectureAssignCompany = LectureAssignCompany::where([
                    'company_id' => $userCompany->company->id
                ])->first();
                if ($listLectureAssignCompany) {
                    $listLectureAssignCompany->delete();
                }
                LectureAssignCompany::create([
                    'lecture_id' => $userLecture->lecture->id,
                    'company_id' => $userCompany->company->id
                ]);
            }
        }

        return redirect()->back()->with([
            'flash_message' => 'Phân công thành công',
            'flash_level' => 'success',
        ]);
    }*/

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignLectureToCompany(Request $request)
    {

        $file = $request->file('file');

        //đọc file excel
        $listLectureAssignCompany = collect();
        if (FileController::checkExtension($file)) {
            Excel::load($file, function ($reader) use ($listLectureAssignCompany){
                $reader->each(function ($sheet) use ($listLectureAssignCompany){
                    $allRow = $sheet->all();
                    if (count($allRow) > 0) {
                        $sheet->first();
                        $sheet->each(function ($row) use ($listLectureAssignCompany){
                            $row = $row->toArray();
                            $rules = array(
                                'email_lecture' => 'required',
                                'name_lecture' => 'required',
                                'email_company' => 'required',
                                'name_company' => 'required',
                                'count_student_default' => 'required'
                            );
                            $validator = Validator::make($row, $rules);
                            if (!$validator->fails()) {
                                $listLectureAssignCompany->push($row);
                            }
                        });
                    }
                });
            });
        }

        $param = $request->only('courseId');

        //insert từng bản ghi vào trong database
        foreach ($listLectureAssignCompany as $item) {
            $userLecture = User::getByInput([
                'email' => $item['email_lecture'],
                'type' => config('settings.role.lecture')
            ])->first();
            //nếu chưa tồn tại thì tạo mới
            if (!$userLecture) {
                //tao tai khoan giảng viên trong bang users
                $userLecture = User::create([
                    'user_name' => $item['email_lecture'],
                    'email' => $item['email_lecture'],
                    'type' => config('settings.role.lecture'),
                    'password' => bcrypt($item['email_lecture'])
                ]);

                //lưu thông tin giảng vien trong table lecture
                Lecture::create([
                    'name' => $item['name_lecture'],
                    'user_id' => $userLecture['id']
                ]);
            }

            //cho giang vien tham gia
            if (LectureInternShipCourse::checkLectureInternShipCourse($userLecture->lecture->id, $param['courseId'])) {
                LectureInternShipCourse::insertLectureInternShipCourse($userLecture->lecture->id, $param['courseId']);
            }

            //lấy user la công ty
            $userCompany = User::getByInput([
                'email' => $item['email_company'],
                'type' => config('settings.role.company')
            ])->first();

            //check company ton tai
            if (!$userCompany) {
                //tao tai khoan trong bang users
                $userCompany = User::create([
                    'user_name' => $item['email_company'],
                    'email' => $item['email_company'],
                    'type' => config('settings.role.company'),
                    'password' => bcrypt($item['email_company'])
                ]);
                //tao tai khoan trong bang table company
                Company::create([
                    'name' => $item['name_company'],
                    'hr_name' => $item['hr_name'],
                    'hr_mail' => $item['hr_mail'],
                    'hr_phone' => $item['hr_phone'],
                    'user_id' => $userCompany['id'],
                    'count_student_default' => $item['count_student_default']
                ]);
            } else {
                //nếu có công ty đăng kí rồi thì cập nhâp số lượng sinh viên mặc định
                $company = $userCompany->company;
                $company->count_student_default = $item['count_student_default'];
                $company->save();
            }

            //cho công ty tham gia
            if (CompanyInternShipCourse::checkCompanyInternShipCourse($userCompany->company->id, $param['courseId'])) {
//                CompanyInternShipCourse::insertCompanyInternShipCourse($userCompany->company->id, $param['courseId'],
//                    $userCompany->company->count_student_default);
                CompanyInternShipCourse::create([
                    'company_id' => $userCompany->company->id,
                    'internship_course_id' => $param['courseId'],
                    'student_quantity' => $userCompany->company->count_student_default,
                    'hr_name' => $item['hr_name']
                ]);
            }

            //kiểm tra tồn tại
            $lectureAssignCompany = LectureAssignCompany::where([
                'lecture_id' => $userLecture->lecture->id,
                'company_id' => $userCompany->company->id,
                'internship_course_id' => $param['courseId']
            ])->first();

            //nếu chưa tồn tại thì thêm phân công
            if (!$lectureAssignCompany) {
                LectureAssignCompany::create([
                    'lecture_id' => $userLecture->lecture->id,
                    'company_id' => $userCompany->company->id,
                    'internship_course_id' => $param['courseId'],
//                    'price' => $item['price']
                ]);
            } else {
                $lectureAssignCompany->price = $item['price'];
                $lectureAssignCompany->save();
            }
        }

        return redirect()->back()->with([
            'flash_message' => 'Phân công thành công',
            'flash_level' => 'success',
        ]);
    }

    /**
     * phân công bằng tay từng giảng viên
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignLecture(Request $request)
    {
        $param = $request->only('lectureId', 'companyId');
        $rules = [
            'lectureId' => 'required',
            'companyId' => 'required'
        ];
        $validator = Validator::make($param, $rules);

        //check null
        if ($validator->fails()) {
            return redirect()->back()->with([
                'flash_message' => 'Phân công lỗi',
                'flash_level' => 'danger',
            ]);
        }

        $lecture = Lecture::find($param['lectureId']);

        $companies = Company::whereIn('id', $param['companyId'])->get();
        
        //check tồn tại lecture và company
        if (!$companies || !$lecture) {
            return redirect()->back()->with([
                'flash_message' => 'Không tìm thấy giảng viên hoặc công ty',
                'flash_level' => 'danger',
            ]);
        }

        //duyet tung cong ty
        foreach ($companies as $company) {
            $listLectureAssignCompany = LectureAssignCompany::where([
                'company_id' => $company['id']
            ])->first();

            //nếu có thì cập nhập không thì tạo mới
            if ($listLectureAssignCompany) {
                $listLectureAssignCompany->lecture_id = $lecture->id;
                $listLectureAssignCompany->save();
            } else {
                LectureAssignCompany::create([
                    'lecture_id' => $lecture->id,
                    'company_id' => $company->id
                ]);
            }
        }

        return redirect()->back()->with([
            'flash_message' => 'Phân công giảng viên thành công',
            'flash_level' => 'success',
        ]);
    }

    /**
     * delete assign
     *
     * @param Request $request
     */
    public function deleteAssign(Request $request)
    {
        $param = $request->only('internshipGroupId');
        $internshipGroup = InternShipGroup::find($param['internshipGroupId']);
        if (!$internshipGroup) {
            return $this->responseJson( [
                'status' => 'error',
                'data' => null,
                'messages' => 'Sinh viên chưa được phân công'
            ]);
        }
        $studentInternShipCourse = StudentInternShipCourse::where([
            'student_id' => $internshipGroup->student_id,
            'internship_course_id' => $internshipGroup->internship_course_id
        ])->first();
        //tao một bản ghi trong bảng student_tmp
        $data = StudentTmp::create([
            'msv' => $studentInternShipCourse->student->msv,
            'course_term' => $internshipGroup->interShipCourse->course_term,
            'status' => 0,
            'subject' =>$studentInternShipCourse->subject
        ]);
        //xóa student internship course
        $studentInternShipCourse->delete();
        //xóa internship group
        $internshipGroup->delete();
        return $this->responseJson( [
            'status' => 'success',
            'data' => [
                'studentTmp' => $data
            ],
            'messages' => 'Xóa phân công thành công'
        ]);
    }

    public function deleteLectureAssignCompany(Request $request)
    {
        $param = $request->only('id');
        $lectureAssignCompany = LectureAssignCompany::find($param['id']);
        $company = Company::find($lectureAssignCompany->company->id);

        if (!$lectureAssignCompany) {
            return $this->responseJson( [
                'status' => 'error',
                'data' => null,
                'messages' => 'Giảng viên chưa được phân công'
            ]);
        }

        $lectureAssignCompany->delete();
        return $this->responseJson( [
            'status' => 'success',
            'data' => [
                'company' => $company
            ],
            'messages' => 'Xóa phân công thành công'
        ]);
    }

    /**
     * show modal edit assign lecture to company
     */
    public function showDialogEditAssign(Request $request)
    {
        $param = $request->only('lectureAssignCompanyId');
        $lectureAssignCompany = LectureAssignCompany::find($param['lectureAssignCompanyId']);

        if (!$lectureAssignCompany) {
            return $this->responseJson( [
                'status' => 'error',
                'data' => null,
                'messages' => 'không tìm thấy phân công'
            ]);
        }
        $listLecture = Lecture::whereNotIn('id', [$lectureAssignCompany->lecture_id])->get();

        return view('elements.show-edit-assign-lecture')->with([
            'listLecture' => $listLecture,
            'lectureAssignCompany' => $lectureAssignCompany
        ]);
    }

    public function changeAssignLectureToCompany(Request $request)
    {
        $param = $request->only('lectureAssignCompanyId', 'lectureId', 'companyId');
        $lectureAssignCompany = LectureAssignCompany::find($param['lectureAssignCompanyId']);

        $listGroup = InternShipGroup::where([
            'internship_course_id' => $lectureAssignCompany->internship_course_id,
            'lecture_id' => $lectureAssignCompany->lecture_id,
            'company_id' => $lectureAssignCompany->company_id
        ])->get();

        //tìm khóa học
        $course = $lectureAssignCompany->internshipCourse;
        $status = $course->status;
        //thay đổi giảng viên trong bảng phân công


        //kiểm tra xem giảng viên đã tham gia kỳ thực tập đó chưa
        $lectureInternshipCourse = LectureInternShipCourse::where([
            'internship_course_id' => $lectureAssignCompany->internship_course_id,
            'lecture_id' => $param['lectureId']
        ])->get();

        //nếu chưa tham gia thì cho giảng viên tham gia
        if (count($lectureInternshipCourse) == 0) {
            LectureInternShipCourse::create([
                'internship_course_id' => $lectureAssignCompany->internship_course_id,
                'lecture_id' => $param['lectureId']
            ]);
        }

        $lectureAssignCompany->lecture_id = $param['lectureId'];
        $lectureAssignCompany->save();

       // dd([$listGroup, $param, $lectureAssignCompany]);

        //cập nhập giảng viên
        foreach ($listGroup as $item) {
            $item->lecture_id = $param['lectureId'];
            $item->save();
        }

        return redirect()->back()->with([
            'flash_message' => 'Đã thay thế giảng viên',
            'flash_level' => 'success'
        ]);
    }
}