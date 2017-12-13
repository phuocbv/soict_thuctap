<?php

namespace App\Http\Controllers\Course;

use App\Company;
use App\CompanyInternShipCourse;
use App\Http\Controllers\FileController;
use App\InternShipCourse;
use App\InternShipGroup;
use App\Lecture;
use App\LectureAssignCompany;
use App\LectureInternShipCourse;
use App\MyUser;
use App\Student;
use App\StudentInternShipCourse;
use App\StudentTmp;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AssignController extends Controller
{
    private $arrTransition = [];

    public function __construct()
    {
        $this->checkExtention = false;
        $this->checkForm = false;
        $this->checkRow = false;
        $this->arrTransition = array();
        $this->countSign1 = 0;
        $this->countSign2 = 0;
        $this->countSign3 = 0;
        $this->checkAssignAdditional = false;
    }

//    public function assignForm(Request $request)
//    {
//        $courseID = decrypt($request->input('courseID'));
//        $file = $request->file('file');
//        $choseLecture = $request->input('choseLecture');
//        /*lay course_term cua khoa thuc tap*/
//        $course = InternShipCourse::getInCourse($courseID);
//        $courseTerm = "";
//        foreach ($course as $c) {
//            $courseTerm = $c->course_term;
//        }
//        /*insert giang vien vao lecture_internship_course*/
//        if (count($choseLecture) > 0) {
//            foreach ($choseLecture as $cl) {
//                if (LectureInternShipCourse::checkLectureInternShipCourse($cl, $courseID)) {
//                    LectureInternShipCourse::insertLectureInternShipCourse($cl, $courseID);
//                }
//            }
//
//            //neu chon giang vien mới tham gia thì phải thêm các công ty của họ vào danh sách tham gia
//            $listCompany = LectureAssignCompany::whereIn('lecture_id', $choseLecture)->get();
//            $allCompany = collect();
//
//            //chỉ lấy những công ti thuộc giảng viên mà có tham gia phụ trách
//            $listCompany->each(function ($value, $key) use ($allCompany) {
//                $allCompany->push($value->company);
//            });
//
//            //chèn thêm công ty vào danh sách công ty tham gia
//            foreach ($allCompany as $alc) {
//                if (CompanyInternShipCourse::checkCompanyInternShipCourse($alc->id, $courseID)) {
//                    CompanyInternShipCourse::insertCompanyInternShipCourse($alc->id, $courseID, $alc->count_student_default);
//                }
//            }
//        }
//
//        /*kiem tra file dau vao va chuyen sang arrTransition*/
//        if (FileController::checkExtension($file)) {
//            $this->checkExtention = true;
//            Excel::load($file, function ($reader) {
//                $reader->each(function ($sheet) {
//                    $allRow = $sheet->all();//dem so dong cua moi sheet
//                    if (count($allRow) > 0) {//neu row >0 moi cho chay
//                        $this->checkRow = true;
//                        $firstRow = $sheet->first();
//                        if (isset($firstRow['msv']) && isset($firstRow['name']) && isset($firstRow['grade']) && isset($firstRow['program_university'])) {
//                            $this->checkForm = true;
//                            $sheet->each(function ($row) {
//                                $input = array(
//                                    'msv' => $row->msv,
//                                    'name' => $row->name,
//                                    'grade' => $row->grade,
//                                    'program_university' => $row->program_university,
//                                    'subject' => $row->subject
//                                );
//                                $rules = array(
//                                    'msv' => 'required',
//                                    'name' => 'required',
//                                    'grade' => 'required',
//                                    'program_university' => 'required',
//                                    'subject' => 'required'
//                                );
//                                $validator = Validator::make($input, $rules);
//                                if (!$validator->fails()) {
//                                    array_push($this->arrTransition, $row);
//                                }
//                            });
//                        }
//                    }
//                });
//            });
//        }
//        //them tai khoan cho nguoi chua co tai khoan
//        $this->addNewUser($this->arrTransition);
//        //dd($this->arrTransition);
//        /*lấy danh sách sinh viên đã đăng ký. day co the bao gom cac sinh vien bi loai do chua dang ky hoc tap*/
//        $studentInCourse = StudentInternShipCourse::getSICFCourseID($courseID);
//        $arrStudent = array();
//        foreach ($studentInCourse as $sic) {
//            $student = Student::getStudentFollowID($sic->student_id);
//            foreach ($student as $s) {
//                $arrStudent[] = $s;
//            }
//        }
//
//        $arrQue = array();//danh sach sinh vien co ten trong arrTransition nhung chua dang ky. cho vao cho phan cong sau
//        $arrRegister = array();//danh sach sinh vien dang ky hop le
//        $arrDanger = array();//danh sach sinh vien khong co ten trong arrTransition nhung dang ky. cho vao canh cao
//        $arrRegisterTmp = array();
//        foreach ($this->arrTransition as $at) {
//            $count = 0;
//            foreach ($arrStudent as $as) {
//                if (trim($at->msv) == $as->msv) {
//                    $count++;
//                }
//            }
//            if ($count == 0) {
//                $arrQue[] = $at;
//            } else {
//                $arrRegisterTmp[] = $at;
//            }
//        }
//        foreach ($arrStudent as $as) {
//            $count = 0;
//            $subject = "";
//            foreach ($arrRegisterTmp as $arT) {
//                if ($as->msv == trim($arT->msv)) {
//                    $count++;
//                    $subject = $arT->subject;
//                }
//            }
//            if ($count == 0) {
//                $arrDanger[] = $as;
//            } else {
//                $arrRegister[] = $as->id . '*' . $subject;
//            }
//        }
//        //update filed subject in studen_internship_course
//        $this->updateSubject($arrRegister, $courseID);
//        // cho danh sách các student không đăng kí nhưng có trong danh sách vào bảng hàng đợi với status là 0 : hang đợi
//        $this->insertStudentQue($arrQue, $courseTerm);
//        //thêm những sinh viên không có trong danh sách mà đăng kí vào trong bảng tạm và có status là 1 : cảnh cáo
//        $this->insertStudentDanger($arrDanger, $courseTerm);
//        //xóa sinh viên khi không có trong danh sách mà đăng kí
//        $this->deleteRegisterInvalid($arrDanger, $courseID);
//
//        /*tim cong ty con slot va cho sinh vien dang trong bang chờ phân công vào đó vao do*/
//        $companyInCourse = CompanyInternShipCourse::getCompanyInCourse($courseID);
//
//        //phân công cho những sinh viên không đăng kí mà có trong danh sách
//        foreach ($companyInCourse as $cic) {
//            $studentTmpQue = StudentTmp::getStudentTmp($courseTerm, 0);
//            foreach ($studentTmpQue as $stq) {
//                $countStudent = InternShipGroup::countStudentInCompany($cic->company_id, $courseID);
//                if (!CompanyInternShipCourse::checkRegisterFull($countStudent, $cic->student_quantity)) {
//                    $studentID = Student::getStudentIDFMsv($stq->msv);
//                    StudentInternShipCourse::insertSICHasSubject($studentID, $courseID, $stq->subject);
//                    InternShipGroup::insertGroup($studentID, $courseID, $cic->company_id);
//                    StudentTmp::deleteStudentTmp($stq->id);//xóa trong bảng hàng đợi
//                }
//            }
//        }
//
//        /*xu ly phan cong giang vien vao cong ty*/
//        /*dem so cong ty da tham gia, dem so giang vien da tham gia*/
//
//        //lay cac cong ty da co sinh vien dang ky
//        //để phân công giáo viên
//        $companyCourseTmp = CompanyInternShipCourse::getCompanyInCourse($courseID);
//        $companyCourse = array();//lưu danh sách công ty đã có sinh viên đăng ký
//        foreach ($companyCourseTmp as $ctmp) {
//            if (InternShipGroup::countStudentInCompany($ctmp->company_id, $courseID) != 0) {
//                $companyCourse[] = $ctmp;
//            }
//        }
//
//        //phân công giáo viên cho sinh viên
//        foreach ($companyCourse as $item) {
//            $company = Company::find($item->company_id);
//            if ($company->lectureAssignCompany) {
//                InternShipGroup::updateLecture($company->id, $courseID, $company->lectureAssignCompany->lecture->id);
//            }
//        }
//
//        //lấy danh sách giảng viên tham gia
//        //$lectureCourse = LectureInternShipCourse::getLectureInCourse($courseID);
//
////        $countCompany = count($companyCourse);
////        $countLecture = count($lectureCourse);
////        $lengthCompany = count($companyCourse);
////        $lengthLecture = count($lectureCourse);
//
//        //do đã phân công sinh viên cho cong ty, giờ chỉ phân công giảng viên phụ trách công ty
////        if ($countCompany > $countLecture) {
////            $countAssign = (int)($countCompany / $countLecture);
////            for ($i = 0; $i < $lengthLecture; $i++) {
////                $countBreak = 0;
////                for ($j = $this->countSign1; $j < $lengthCompany; $j++) {
////                    InternShipGroup::updateLecture($companyCourse[$j]->company_id, $courseID, $lectureCourse[$i]->lecture_id);
////                    $this->countSign1++;
////                    $countBreak++;
////                    if ($countBreak == $countAssign) {
////                        break;
////                    }
////                }
////            }
////            if ($this->countSign1 < $countCompany) {
////                for ($k = $this->countSign1; $k < $lengthCompany; $k++) {
////                    for ($h = $this->countSign2; $h < $lengthLecture; $h++) {
////                        InternShipGroup::updateLecture($companyCourse[$k]->company_id, $courseID, $lectureCourse[$h]->lecture_id);
////                        $this->countSign2++;
////                        break;
////                    }
////                }
////            }
////        } else {
////            for ($k = 0; $k < $lengthCompany; $k++) {
////                for ($h = $this->countSign3; $h < $lengthLecture; $h++) {
////                    InternShipGroup::updateLecture($companyCourse[$k]->company_id, $courseID, $lectureCourse[$h]->lecture_id);
////                    $this->countSign3++;
////                    break;
////                }
////            }
////        }
//
//        /*cap nhat trang thai cua khoa thuc tap*/
//        InternShipCourse::updateStatus($courseID);
//        return redirect()->back()->with('assignSuccess', 'Phân công thành công');
//    }

    public function assignForm(Request $request)
    {
        $courseID = decrypt($request->input('courseID'));
        $file = $request->file('file');

//        /*lay course_term cua khoa thuc tap*/
        $course = InternShipCourse::getInCourse($courseID)->first();
        $courseTerm = $course->course_term;
        $listStudent = collect();

        /*kiem tra file dau vao va chuyen sang arrTransition*/
        if (FileController::checkExtension($file)) {
            Excel::load($file, function ($reader) use ($listStudent) {
                $reader->each(function ($sheet) use ($listStudent) {
                    $allRow = $sheet->all();
                    if (count($allRow) > 0) {
                        $sheet->first();
                        $sheet->each(function ($row) use ($listStudent) {
                            $input = array(
                                'mssv' => $row->mssv,
                                'name_student' => $row->name_student,
                                'class' => $row->class,
                                'grade' => $row->grade,
                                'program_university' => $row->program_university,
                                'subject' => $row->subject,
                                'class_code' => $row->class_code
                            );
                            $rules = array(
                                'mssv' => 'required',
                                'name_student' => 'required',
                                'class' => 'required',
                                'grade' => 'required',
                                'program_university' => 'required',
                                'subject' => 'required',
                                'class_code' => 'required'
                            );
                            $validator = Validator::make($input, $rules);
                            if (!$validator->fails()) {
                                $listStudent->push($row);
                            }
                        });
                    }
                });
            });
        }

        //them tai khoan cho nguoi chua co tai khoan
        $this->addUserStudent($listStudent);

        /*
         * lấy danh sách sinh viên đã đăng ký. day co the bao gom cac sinh vien bi loai do chua dang ky hoc tap
         * nếu sinh viên đăng kí thì có trang bảng student_internship_course
        */
        $studentInCourse = StudentInternShipCourse::getSICFCourseID($courseID);
        $arrStudent = array();
        foreach ($studentInCourse as $sic) {
            $student = Student::getStudentFollowID($sic->student_id);
            foreach ($student as $s) {
                $arrStudent[] = $s;
            }
        }

        $arrQue = array();//danh sach sinh vien co ten trong arrTransition nhung chua dang ky. cho vao cho phan cong sau
        $arrRegister = array();//danh sach sinh vien dang ky hop le
        $arrDanger = array();//danh sach sinh vien khong co ten trong arrTransition nhung dang ky. cho vao canh cao
        $arrRegisterTmp = array();
        foreach ($listStudent as $item) {
            $count = 0;
            foreach ($arrStudent as $as) {
                if (trim($item->mssv) == $as->msv) {
                    $count++;
                }
            }
            if ($count == 0) {
                $arrQue[] = $item;
            } else {
                $arrRegisterTmp[] = $item;
            }
        }
        foreach ($arrStudent as $as) {
            $count = 0;
            $subject = "";
            foreach ($arrRegisterTmp as $arT) {
                if ($as->msv == trim($arT->mssv)) {
                    $count++;
                    $subject = $arT->subject;
                }
            }
            if ($count == 0) {
                $arrDanger[] = $as;
            } else {
                $arrRegister[] = $as->id . '*' . $subject;
            }
        }
        //update filed subject in studen_internship_course
        $this->updateSubject($arrRegister, $courseID);
        // cho danh sách các student không đăng kí nhưng có trong danh sách vào bảng hàng đợi với status là 0 : hang đợi
        $this->insertStudentQue($arrQue, $courseTerm);
        //thêm những sinh viên không có trong danh sách mà đăng kí vào trong bảng tạm và có status là 1 : cảnh cáo
        $this->insertStudentDanger($arrDanger, $courseTerm);
        //xóa sinh viên khi không có trong danh sách mà đăng kí
        $this->deleteRegisterInvalid($arrDanger, $courseID);

        /*
         * tim cong ty con slot va cho sinh vien dang trong bang chờ phân công vào đó vao do
         * danh sach cong ty da dang ki
         */
        $companyInCourse = CompanyInternShipCourse::where('internship_course_id', '=', $courseID)->get();
        foreach ($companyInCourse as $cic) {
            //phân công cho những sinh viên không đăng kí mà có trong danh sách
            $studentTmpQue = StudentTmp::getStudentTmp($courseTerm, 0);
            foreach ($studentTmpQue as $stq) {
                $countStudent = InternShipGroup::countStudentInCompany($cic->company_id, $courseID);
                if (!CompanyInternShipCourse::checkRegisterFull($countStudent, $cic->student_quantity)) {
                    $studentId = Student::getStudentIDFMsv($stq->msv);
                    StudentInternShipCourse::insertSICHasSubject($studentId, $courseID, $stq->subject);
                    InternShipGroup::insertGroup($studentId, $courseID, $cic->company_id);
                    StudentTmp::deleteStudentTmp($stq->id);//xóa trong bảng hàng đợi
                }
            }
        }

        /*xu ly phan cong giang vien vao cong ty*/
        /*dem so cong ty da tham gia, dem so giang vien da tham gia*/

        //lay cac cong ty da đăng kí tham gia thực tập
        //để phân công giáo viên, các công ty đã tham gia
        $companyCourseTmp = CompanyInternShipCourse::getCompanyInCourse($courseID);
        $companyCourse = array();//lưu danh sách công ty đã có sinh viên đăng ký
        foreach ($companyCourseTmp as $ctmp) {
            if (InternShipGroup::countStudentInCompany($ctmp->company_id, $courseID) != 0) {
                $companyCourse[] = $ctmp;
            }
        }

        //phân công giáo viên cho sinh viên
        foreach ($companyCourse as $item) {
            //đếm số giáo viên được phân công quản lí công ty
            $listLectureId = LectureAssignCompany::where([
                'company_id' => $item->company_id,
                'internship_course_id' => $courseID
            ])->lists('lecture_id')->unique();
            $countLecture = count($listLectureId);
            //trong trường hợp có lớn hơn 1 giáo viên phụ trách
            if ($countLecture > 1) {
                //số lượng sinh viên được phân trong 1 công ty
                $countStudentInCompany = InternShipGroup::countStudentInCompany($item->company_id, $courseID);
                //danh sach phan cong sinh viên cua 1 cong ty tại kỳ được chọn
                $listInternshipGroup = InternShipGroup::where([
                    'internship_course_id' => $courseID,
                    'company_id' => $item->company_id
                ])->get();
                $partion = floor($countStudentInCompany / $countLecture);

                //trường hợp đủ 5 sinh viên trở lên cho mỗi giáo viên
                //mỗi giáo viên min sinh viên là 5
                if ($partion >= 5) {
                    $l = 0;
                    //phân sinh viên trung bình cho mỗi giảng viên
                    foreach ($listLectureId as $key => $lectureId) {
                        for ($i = $l; $i < count($listInternshipGroup); $i++) {
                            $listInternshipGroup[$i]->lecture_id = $lectureId;
                            $listInternshipGroup[$i]->save();
                            $l++;
                            if ($l % $partion == 0) break;
                        }
                    }


                } else {//trường hợp không dủ 5 sinh viên cho mỗi giảng viên
                    $partion = cell($countStudentInCompany / 5);
                    $l = 0;
                    for ($i = 0; $i < $partion; $i++) {
                        for ($j = $l; $j < count($listInternshipGroup); $j++) {
                            $listInternshipGroup[$i]->lecture_id = $listLectureId[$i];
                            $listInternshipGroup[$i]->save();
                            $l++;
                            if ($l % 5 == 0) break;
                        }
                    }
                }

                //kiểm tra những sinh viên còn sót chưa phân công giáo viên
                $list = InternShipGroup::where([
                    'internship_course_id' => $courseID,
                    'lecture_id' => ''
                ])->get();

                foreach ($list as $item) {
                    $item->lecture_id = $listLectureId->first();
                    $item->save();
                }
            } else {
                $company = Company::find($item->company_id);
                InternShipGroup::updateLecture($company->id, $courseID, $company->lectureAssignCompany->first()->lecture->id);
            }
        }

        //lấy danh sách giảng viên tham gia
        //$lectureCourse = LectureInternShipCourse::getLectureInCourse($courseID);

//        $countCompany = count($companyCourse);
//        $countLecture = count($lectureCourse);
//        $lengthCompany = count($companyCourse);
//        $lengthLecture = count($lectureCourse);

        //do đã phân công sinh viên cho cong ty, giờ chỉ phân công giảng viên phụ trách công ty
//        if ($countCompany > $countLecture) {
//            $countAssign = (int)($countCompany / $countLecture);
//            for ($i = 0; $i < $lengthLecture; $i++) {
//                $countBreak = 0;
//                for ($j = $this->countSign1; $j < $lengthCompany; $j++) {
//                    InternShipGroup::updateLecture($companyCourse[$j]->company_id, $courseID, $lectureCourse[$i]->lecture_id);
//                    $this->countSign1++;
//                    $countBreak++;
//                    if ($countBreak == $countAssign) {
//                        break;
//                    }
//                }
//            }
//            if ($this->countSign1 < $countCompany) {
//                for ($k = $this->countSign1; $k < $lengthCompany; $k++) {
//                    for ($h = $this->countSign2; $h < $lengthLecture; $h++) {
//                        InternShipGroup::updateLecture($companyCourse[$k]->company_id, $courseID, $lectureCourse[$h]->lecture_id);
//                        $this->countSign2++;
//                        break;
//                    }
//                }
//            }
//        } else {
//            for ($k = 0; $k < $lengthCompany; $k++) {
//                for ($h = $this->countSign3; $h < $lengthLecture; $h++) {
//                    InternShipGroup::updateLecture($companyCourse[$k]->company_id, $courseID, $lectureCourse[$h]->lecture_id);
//                    $this->countSign3++;
//                    break;
//                }
//            }
//        }

        /*cap nhat trang thai cua khoa thuc tap*/
        InternShipCourse::updateStatus($courseID);
        return redirect()->back()->with('assignSuccess', 'Phân công thành công');
    }


    public function assignFinish(Request $request)
    {
        $courseID = decrypt($request->input('courseID'));
        $file = $request->file('file');

//        /*lay course_term cua khoa thuc tap*/
        $course = InternShipCourse::getInCourse($courseID)->first();
        $courseTerm = $course->course_term;
        $listAssign = collect();

        /*kiem tra file dau vao va chuyen sang arrTransition*/
        if (FileController::checkExtension($file)) {
            Excel::load($file, function ($reader) use ($listAssign) {
                $reader->each(function ($sheet) use ($listAssign) {
                    $allRow = $sheet->all();
                    if (count($allRow) > 0) {
                        $sheet->first();
                        $sheet->each(function ($row) use ($listAssign) {
                            $input = array(
                                'email_lecture' => $row->email_lecture,
                                'name_lecture' => $row->name_lecture,
                                'email_company' => $row->email_company,
                                'name_company' => $row->name_company,
                                'mssv' => $row->mssv,
                                'name_student' => $row->name_student,
                                'class' => $row->class,
                                'grade' => $row->grade,
                                'program_university' => $row->program_university,
                                'subject' => $row->subject,
                                'class_code' => $row->class_code
                            );
                            $rules = array(
                                'email_lecture' => 'required',
                                'name_lecture' => 'required',
                                'email_company' => 'required',
                                'name_company' => 'required',
                                'mssv' => 'required',
                                'name_student' => 'required',
//                                'class' => 'required',
//                                'grade' => 'required',
//                                'program_university' => 'required',
//                                'subject' => 'required',
//                                'class_code' => 'required'
                            );
                            $validator = Validator::make($input, $rules);
                            if (!$validator->fails()) {
                                $listAssign->push($row);
                            }
                        });
                    }
                });
            });
        }
        //check ton tai cua lecture, cua cong ty, sinh vien
        //neu chua co thi them vao

        $listArrayCompany = collect([]);//chứa id các công ty tham gia thực tập
        $listArrayLecture = collect([]);//chưa id các giảng viên tham gia thực tập
        $listArrayStudent = collect([]);//chưa id các sinh viên tham gia thực tập
        $course = InternShipCourse::find($courseID);

        foreach ($listAssign as $item) {
            //kiem tra ton tai giang vien
            $userLecture = $this->addUserLectureFinish($item, $courseID);
            $listArrayLecture->push($userLecture->lecture->id);
            //kiem tra ton tai cong ty
            $userCompany = $this->addUserCompanyFinish($item, $courseID);
            $listArrayCompany->push($userCompany->company->id);
            //kiem tra ton tai sinh vien
            $userStudent = $this->addUserStudentFinish($item, $courseID);
            $listArrayStudent->push($userStudent->student->id);
            //xem đã có phân công chưa
            $assign = InternShipGroup::where([
                'internship_course_id' => $courseID,
                'student_id' => $userStudent->student->id
            ])->first();

            //kiểm tra đã có phân công công ty cho giảng viên
            $assignLecture = LectureAssignCompany::where([
                'lecture_id' => $userLecture->lecture->id,
                'company_id' => $userCompany->company->id
            ])->first();
            //thêm phân công
            if (!$assignLecture) {
                LectureAssignCompany::create([
                    'lecture_id' => $userLecture->lecture->id,
                    'company_id' => $userCompany->company->id,
                    'internship_course_id' => $courseID
                ]);
            }
            //trong trường hợp đã phân công cho sinh viên
            //thì chỉ cập nhập lại giảng viên và công ty
            if ($assign) {
                $assign->company_id = $userCompany->company->id;
                $assign->lecture_id = $userLecture->lecture->id;
                $assign->save();
            } else {//trong trường hợp chưa có phân công thì thêm mới phân công
                InternShipGroup::create([
                    'student_id' => $userStudent->student->id,
                    'company_id' => $userCompany->company->id,
                    'lecture_id' => $userLecture->lecture->id,
                    'internship_course_id' => $courseID
                ]);
                //cập nhập số sinh viên tối đa của công ty
            }

            //xóa trong bảng tam
            $studentTmp = StudentTmp::where([
                'msv' => $item->mssv,
                'course_term' => $course->course_term
            ])->first();
            if ($studentTmp) {
                $studentTmp->delete();
            }
        }

        //danh sách những sinh viên không có trong file excel
        //hoặc không có trong danh sách phân công
        $listStudentNotAssign = InternShipGroup::where(['internship_course_id' => $courseID])
            ->whereNotIn('student_id', $listArrayStudent->unique())->get();
        //xóa những sinh vien không được phân trong bảng internship_group và bảng student_internship_course
        foreach ($listStudentNotAssign as $item) {
            //xoa trong bang tam
            StudentTmp::deleteStudentTmp2($item->student->msv, $course->course_term);
            $sic = StudentInternShipCourse::where([
                'student_id' => $item->student_id,
                'internship_course_id' => $courseID
            ])->first();
            //chen lai voi status la -1
            StudentTmp::insert($item->student->msv, $course->course_term, strtoupper($sic->subject), -1);
            //xóa sinh viên trong bảng sinh viên đăng kí tham gia thực tập
            StudentInternShipCourse::deleteSIC($item->student_id, $courseID);
            //xóa phân công thực tập của sinh viên
            InternShipGroup::deleteGroup($item->student_id, $courseID);
        }

        //lấy danh sách những giang viên không được phân công trong file excel
        // mà lại có trong bảng phân công của kì dó
        $listLectureNotAssign = LectureInternShipCourse::where(['internship_course_id' => $courseID])
            ->whereNotIn('lecture_id', $listArrayLecture->unique())->get();
        foreach ($listLectureNotAssign as $item) {
            $item->delete();
        }

        //lấy dánh sách công ty không có trong file excel
        //nhưng lại có trong bảng tham gia thực tập
        $listCompanyNotAssign = CompanyInternShipCourse::where(['internship_course_id' => $courseID])
            ->whereNotIn('company_id', $listArrayCompany->unique())->get();
        foreach ($listCompanyNotAssign as $item) {
            $item->delete();
        }
        //cập nhập trạng thái
        InternShipCourse::updateStatus($courseID);
        return redirect()->back()->with('assignSuccess', 'Phân công thành công');
    }

    /**
     * chức năng phân công thủ cong từng người một
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAssignStudent(Request $request)
    {
        $param = $request->only('msv', 'nameStudent', 'grade', 'companyId', 'courseId', 'subject', 'program_university');
        $email = trim($param['msv']) . '@student.hust.edu.vn';
        $courseId = decrypt($param['courseId']);

        $company = Company::find($param['companyId']);

        //check cong ty
        if (!$company) {
            return redirect()->back()->with('error', 'Công ty không tồn tại');
        }

        //check phân công giảng viên
        if (!$company->lectureAssignCompany) {
            return redirect()->back()->with('error', 'Công ty chưa được phân công giảng viên');
        }

        //check tồn tại tài khoản
        $user = MyUser::where([
            'user_name' => $param['msv'],
            'email' => $email
        ])->first();


        //lây các giảng viên được phân công cho công ty đó
        $listLectureAssignCompany = LectureAssignCompany::where([
            'internship_course_id' => $courseId,
            'company_id' => $company->id
        ])->get();
        $lid = '';
        //trong truong hợp công ty có lớn hơn 2 giảng viên phụ trách
        if (count($listLectureAssignCompany) > 1) {
            $listCount = collect();
            //đếm số lượng sinh viên mỗi giảng viên phụ trách trong cong ty
            $listLectureAssignCompany->each(function ($value) use ($listCount, $courseId) {
                //dem so sinh vien cua moi giang vien duoc phan
                $count = InternShipGroup::where([
                    'internship_course_id' => $courseId,
                    'lecture_id' => $value->lecture_id
                ])->count();
                //luu vao danh sach
                $listCount->push([
                    'count' => $count,
                    'lectureId' => $value->lecture_id
                ]);
            });
            //lấy giảng viên có số lượng sinh viên ít nhất
            $listCount = $listCount->sortByDesc('count');
            $min = $listCount->first()['count'];
            $lectureId = $listCount->first()['lectureId'];
            //tim số lượng giảng viên được phân công ít nhất thì phân sinh viên cho giảng viên đó
            foreach ($listCount as $item) {
                if ($item['count'] < $min && $item['count'] >= 5) {
                    $min = $item['count'];
                    $lectureId = $item['lectureId'];
                }
            }
            $lid = $lectureId;
        } else {//trường hợp chỉ có 1 giảng viên phụ trách
            $lid = $listLectureAssignCompany->first()->lecture_id;
        }

        //lay lecture da phan cong cho cong ty
        $lecture = Lecture::find($lid);

        //trường hợp mã số sinh viên đã có tài khoản
        if ($user) {
            //kiểm tra tài khoản này đã được phân công chưa
            $studentInternshipCourse =  StudentInternShipCourse::checkSI($user->student->id, $courseId);
            //da phan cong
            if (!$studentInternshipCourse) {
                return redirect()->back()->with('error', 'Sinh viên này đã được phân công');
            }
            $internshipCourse = InternShipCourse::find($courseId);
            $checkMSVCourseTerm = StudentTmp::checkMSVCourseTerm($param['msv'], $internshipCourse->course_term);
            //nếu tôn tại trong bảng StudentTmp thì phân công lại và xóa đi
            if (!$checkMSVCourseTerm) {
                StudentTmp::deleteStudentTmp2($param['msv'], $internshipCourse->course_term);
            }

            //them vao bang dang ki thuc tap cua sinh vien
            StudentInternShipCourse::insertSICHasSubject($user->student->id, $courseId, strtoupper($param['subject']));

            //cap nhat so luong sinh vien tiep nhan cua cong ty
            $quantity = CompanyInternShipCourse::getQuantity($param['companyId'], $courseId);
            $countStudent = InternShipGroup::countStudentInCompany($param['companyId'], $courseId);

            //trong trường hợp vượt quá số lượng sinh viên tối da thì phải tăng quantity lên 1
            if ($countStudent == $quantity) {
                CompanyInternShipCourse::updateStudentQuantity($param['companyId'], $courseId, $quantity + 1);
            }

            //phân công giang viên cho sinh viên
            InternShipGroup::insertGroupAddLectureID($user->student->id, $lecture->id, $param['companyId'], $courseId);
            return redirect()->back()->with('assignAdditionSuccess', 'Thêm phân công thành công');
        }

        $user = [
            'msv' => $param['msv'],
            'grade' => $param['grade'],
            'program_university' => $param['program_university'],
            'name' => $param['nameStudent']
        ];

        //theem nguoi dung moi
        $this->addOneNewUser($user);

        //lấy lại user sau khi thêm mới
        $user = MyUser::where([
            'user_name' => $param['msv'],
            'email' => $email
        ])->first();

        //them vao bang dang ki thuc tap cua sinh vien
        StudentInternShipCourse::insertSICHasSubject($user->student->id, $courseId, strtoupper($param['subject']));

        //cap nhat so luong sinh vien tiep nhan cua cong ty
        $quantity = CompanyInternShipCourse::getQuantity($param['companyId'], $courseId);
        $countStudent = InternShipGroup::countStudentInCompany($param['companyId'], $courseId);

        //trong trường hợp vượt quá số lượng sinh viên tối da thì phải tăng quantity lên 1
        if ($countStudent == $quantity) {
            CompanyInternShipCourse::updateStudentQuantity($param['companyId'], $courseId, $quantity + 1);
        }

        InternShipGroup::insertGroupAddLectureID($user->student->id, $lecture->id, $param['companyId'], $courseId);
        return redirect()->back()->with('assignAdditionSuccess', 'Thêm phân công thành công');
    }

    /**
     *them một nguoi dung chua co tai khoan khi phan cong
     * @param $arrTran
     */
    public function addOneNewUser($student)
    {
        $email = trim($student['msv']) . '@student.hust.edu.vn';
        MyUser::insertUser(trim($student['msv']), $email, trim($student['msv']), 'student');
        $userId = MyUser::getID($student['msv']);
        Student::insertStudent(trim($student['name']), $student['grade'], $student['program_university'], trim($student['msv']), $userId);
    }

    /**
     *them nguoi dung chua co tai khoan khi phan cong
     * @param $arrTran
     */
    public function addNewUser($arrTran)
    {
        foreach ($arrTran as $at) {
            $email = trim($at->msv) . '@student.hust.edu.vn';
            if (MyUser::checkUsername(trim($at->msv)) && MyUser::checkEmail($email)) {
                MyUser::insertUser(trim($at->msv), $email, trim($at->msv), 'student');
                $userId = MyUser::getID($at->msv);
                Student::insertStudent(trim($at->name), $at->grade, $at->program_university, trim($at->msv), $userId);
            }
        }
    }

    public function addUserStudent($listStudent)
    {
        foreach ($listStudent as $item) {
            $email = trim($item->mssv) . config('settings.email');
            //check xem co ton tại user_name hoặc email không
            if (MyUser::checkUsername(trim($item->mssv)) && MyUser::checkEmail($email)) {
                $user = MyUser::create([
                    'user_name' => trim($item->mssv),
                    'email' => $email,
                    'password' => bcrypt(trim($item->mssv)),
                    'type' => config('settings.role.student')
                ]);
                Student::create([
                    'msv' => $item->mssv,
                    'name' => $item->name_student,
                    'grade' => $item->grade,
                    'class' => $item->class,
                    'program_university' => $item->program_university,
                    'user_id' => $user->id
                ]);
            }
        }
    }

    /**
     * kiểm tra tài khoản giảng viên
     * nếu chưa có thì tạo và cho giảng viên tham gia
     * nếu có rồi thì kiểm tra xem đã tham gia chưa
     * nếu chưa tham gia thì cho tham gia khóa học truyền vào
     *
     * @param $lecture
     * @param $courseId
     * @return static
     */
    public function addUserLectureFinish($lecture, $courseId)
    {
        $user = User::where([
            'user_name' => trim($lecture->email_lecture),
            'email' => trim($lecture->email_lecture),
        ])->first();
        if (!$user) {
            $user = MyUser::create([
                'user_name' => trim($lecture->email_lecture),
                'email' => trim($lecture->email_lecture),
                'password' => bcrypt(trim($lecture->email_lecture)),
                'type' => config('settings.role.lecture')
            ]);
            $l = Lecture::create([
                'name' => trim($lecture->name_lecture),
                 'user_id' => $user->id
            ]);
            LectureInternShipCourse::create([
                'lecture_id' => $l->id,
                'internship_course_id' => $courseId
            ]);
        } else {
            //kiểm tra xem tham gia thực tập chưa
            $lectureInternShipCourse = LectureInternShipCourse::where([
                'lecture_id' => $user->lecture->id,
                'internship_course_id' => $courseId
            ])->first();
            //nêu chưa được tham gia thì cho tham gia
            if (!$lectureInternShipCourse) {
                LectureInternShipCourse::create([
                    'lecture_id' => $user->lecture->id,
                    'internship_course_id' => $courseId
                ]);
            }
        }
        return $user;
    }

    /**
     * kiểm tra đã có tài khoản của công ty chưa
     * nếu chưa có thì tạo mới và cho vào danh sách tham gia thực tập
     * nếu có mà không có trong danh sách tham gia thực tập thì cũng cho vào
     * chỉ mới có thêm vào danh sách đằng kí chứ chưa có trong danh sách phân công
     *
     * @param $company
     * @param $courseId
     * @return static
     */
    public function addUserCompanyFinish($company, $courseId)
    {
        $user = User::where([
            'user_name' => trim($company->email_company),
            'email' => trim($company->email_company),
        ])->first();
        if (!$user) {
            $user = MyUser::create([
                'user_name' => trim($company->email_company),
                'email' => trim($company->email_company),
                'password' => bcrypt(trim($company->email_company)),
                'type' => config('settings.role.company')
            ]);
            $c = Company::create([
                'name' => $company->name_company,
                'count_student_default' => config('settings.count_student_default'),
                'user_id' => $user->id,
                'hr_name' => $company->hr_name,
                'hr_mail' => $company->hr_mail,
                'hr_phone' => $company->hr_phone
            ]);
            CompanyInternShipCourse::create([
                'internship_course_id' => $courseId,
                'company_id' => $c->id,
                'student_quantity' =>  config('settings.count_student_default'),
                'hr_name' => $company->hr_name
            ]);
        } else {
            //kiểm tra xem tham gia thực tập chưa
            $companyInternShipCourse = CompanyInternShipCourse::where([
                'company_id' => $user->company->id,
                'internship_course_id' => $courseId
            ])->first();
            //nêu chưa được tham gia thì cho tham gia
            if (!$companyInternShipCourse) {
                CompanyInternShipCourse::create([
                    'internship_course_id' => $courseId,
                    'company_id' => $user->company->id,
                    'student_quantity' =>  config('settings.count_student_default'),
                    'hr_name' => $company->hr_name
                ]);
            }
        }
        return $user;
    }

    /**
     *
     * mới cho thêm vào tạo tài khoản và danh sách đăng kí
     * chưa có trong phần phân công
     *
     * @param $student
     * @param $courseId
     * @return static
     */
    public function addUserStudentFinish($student, $courseId)
    {
        $email = trim($student->mssv) . config('settings.email');
        $user = User::where([
            'user_name' => trim($student->mssv),
            'email' => trim($email),
        ])->first();
        //kiểm tra xem đã có tài khoản hay chưa
        if (!$user) {
            //tao tai khoan
            $user = MyUser::create([
                'user_name' => trim($student->mssv),
                'email' => trim($email),
                'password' => bcrypt(trim($student->mssv)),
                'type' => config('settings.role.student')
            ]);
            $s = Student::create([
                'msv' => $student->mssv,
                'name' => $student->name_student,
                'grade' => $student->grade,
                'class' => $student->class,
                'program_university' => $student->program_university,
                'user_id' => $user->id
            ]);
            //cho vao danh sach thuc tap
            StudentInternShipCourse::create([
                'student_id' => $s->id,
                'internship_course_id' => $courseId,
                'subject' => strtoupper($student->subject),
                'class_code' => $student->class_code
            ]);
        } else {
            //kiểm tra xem tham gia thực tập chưa
            $studentInternShipCourse = StudentInternShipCourse::where([
                'student_id' => $user->student->id,
                'internship_course_id' => $courseId,
            ])->first();
            //nêu chưa được tham gia thì cho tham gia
            if (!$studentInternShipCourse) {
                //cho vao danh sach thuc tap
                StudentInternShipCourse::create([
                    'student_id' => $user->student->id,
                    'internship_course_id' => $courseId,
                    'subject' => strtoupper($student->subject),
                    'class_code' => $student->class_code
                ]);
            } else {
                $studentInternShipCourse->subject = strtoupper($student->subject);
                $studentInternShipCourse->class_code = $student->class_code;
                $studentInternShipCourse->save();
            }
        }
        return $user;
    }

    /**
     * them mon hoc cho sinh vien.
     * mon hoc duoc lay theo danh sach sinh vien da dang ky
     *
     * @param $arrRegister
     * @param $courseID
     */
    public function updateSubject($arrRegister, $courseID)
    {
        $length = count($arrRegister);
        for ($i = 0; $i < $length; $i++) {
            list($studentID, $subject) = explode("*", $arrRegister[$i]);
            StudentInternShipCourse::updateSubject($studentID, $courseID, $subject);
        }
    }

    /**
     * them sinh vien co trong arrTransision nhung khong co ten trong bang dang ky
     * vao bang student_tmp de cho phan cong sau
     * những sinh viên có trong file excel nhưng không đăng ký
     * có status = 0
     *
     * @param $arrQue
     * @param $courseTerm
     */
    public function insertStudentQue($arrQue, $courseTerm)
    {
        /*insert sinh vien vao bang tam cho phan cong*/
        foreach ($arrQue as $aq) {
            StudentTmp::deleteStudentTmp2(trim($aq->mssv), $courseTerm);
            StudentTmp::insert(trim($aq->mssv), $courseTerm, $aq->subject, 0);
        }
    }

    /**
     * them nhung sinh vien khong co ten trong arrTransition nhung da dang ky. Nhung sinh vien nay se bi xoa dang ky
     * va cho canh cao
     * những sinh viên không có trong file excel nhưng mà đăng ký => cho vào danh sách cảnh cáo
     * có status  = -1
     *
     * @param $arrDanger
     * @param $courseTerm
     */
    public function insertStudentDanger($arrDanger, $courseTerm)
    {
        /*insert sinh vien vao bang tam chờ cảnh cáo*/
        foreach ($arrDanger as $ad) {
            StudentTmp::deleteStudentTmp2(trim($ad->msv), $courseTerm);
            StudentTmp::insert(trim($ad->msv), $courseTerm, "", -1);
        }
    }

    /**
     * xoa sinh vien khong co ten trong arrTransition nhung lai dang ky
     *
     * @param $arrDanger
     * @param $courseID
     */
    public function deleteRegisterInvalid($arrDanger, $courseID)
    {
        foreach ($arrDanger as $ad) {
            $student = Student::getStudentFMSV(trim($ad->msv));
            foreach ($student as $s) {
                StudentInternShipCourse::deleteSIC($s->id, $courseID);
                InternShipGroup::deleteGroup($s->id, $courseID);
            }
        }
    }

    /**
     * trong truong hop het cho
     * thi phai them sinh vien vao 1 cong ty còn chỗ
     * va tang so luong sinh vien max cua moi cong ty
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignAdditional(Request $request)
    {
        $studentID = $request->input('studentID');
        $courseID = $request->input('courseID');
        $companyID = $request->input('chooseCompany');

        $studentName = "";
        $msv = "";
        $courseTerm = "";
        $subject = "";

        $company = Company::find($companyID);
        if (!$company) {
            return redirect()->back()->with('error', 'Công ty không tồn tại');
        }

        //check phân công giảng viên
        if (!$company->lectureAssignCompany) {
            return redirect()->back()->with('error', 'Công ty chưa được phân công giảng viên');
        }

        //lây các giảng viên được phân công cho công ty đó
        $listLectureAssignCompany = LectureAssignCompany::where([
            'internship_course_id' => $courseID,
            'company_id' => $companyID
        ])->get();
        $lid = '';
        //trong truong hợp công ty có lớn hơn 2 giảng viên phụ trách
        if (count($listLectureAssignCompany) > 1) {
            $listCount = collect();
            //đếm số lượng sinh viên mỗi giảng viên phụ trách trong cong ty
            $listLectureAssignCompany->each(function ($value) use ($listCount, $courseID) {
                //dem so sinh vien cua moi giang vien duoc phan
                $count = InternShipGroup::where([
                    'internship_course_id' => $courseID,
                    'lecture_id' => $value->lecture_id
                ])->count();
                //luu vao danh sach
                $listCount->push([
                    'count' => $count,
                    'lectureId' => $value->lecture_id
                ]);
            });
            //lấy giảng viên có số lượng sinh viên ít nhất
            $listCount = $listCount->sortByDesc('count');
            $min = $listCount->first()['count'];
            $lectureId = $listCount->first()['lectureId'];
            //tim số lượng giảng viên được phân công ít nhất thì phân sinh viên cho giảng viên đó
            foreach ($listCount as $item) {
                if ($item['count'] < $min && $item['count'] >= 5) {
                    $min = $item['count'];
                    $lectureId = $item['lectureId'];
                }
            }
            $lid = $lectureId;
        } else {//trường hợp chỉ có 1 giảng viên phụ trách
            $lid = $listLectureAssignCompany->first()->lecture_id;
        }

        //lay lecture da phan cong cho cong ty
        $lecture = Lecture::find($lid);

        /*
         * kiem tra dau vao vi ton tai input hidden. xem co sinh vien, cong ty, khoa thuc tap nhu vay khong
         */
        if (Student::checkStudent($studentID) && InternShipCourse::checkCourseFollowID($courseID) && Company::checkCompany($companyID)) {
            if (StudentInternShipCourse::checkSI($studentID, $companyID) && !CompanyInternShipCourse::checkCompanyInternShipCourse($companyID, $courseID)) {
                $this->checkAssignAdditional = true;
                $student = Student::getStudentFollowID($studentID);
                $course = InternShipCourse::getInCourse($courseID);
                foreach ($student as $s) {
                    $studentName = $s->name;
                    $msv = $s->msv;
                }
                foreach ($course as $c) {
                    $courseTerm = $c->course_term;
                }

                //them student_internship_course
                $studentTmp = StudentTmp::getStudentTmpFMC($msv, $courseTerm);
                foreach ($studentTmp as $stmp) {
                    $subject = $stmp->subject;
                }

                //them vào phân công cho sinh viên
                StudentInternShipCourse::insertSICHasSubject($studentID, $courseID, $subject);

                //xoa sinh vien trong bang cho phan cong di
                StudentTmp::deleteStudentTmp2($msv, $courseTerm);

                //cap nhat so luong sinh vien tiep nhan cua cong ty
                $quantity = CompanyInternShipCourse::getQuantity($companyID, $courseID);
               // CompanyInternShipCourse::updateStudentQuantity($companyID, $courseID, $quantity + 1);
                $countStudent = InternShipGroup::countStudentInCompany($companyID, $courseID);

                //trong trường hợp vượt quá số lượng sinh viên tối da thì phải tăng quantity lên 1
                if ($countStudent == $quantity) {
                    CompanyInternShipCourse::updateStudentQuantity($companyID, $courseID, $quantity + 1);
                }

                //chèn vào bảng phân công insertGroup
                InternShipGroup::insertGroupAddLectureID($studentID, $lecture->id, $companyID, $courseID);
            }
        }
        if ($this->checkAssignAdditional) {
            return redirect()->back()->with('assignAdditionSuccess', 'Phân công thành công cho sinh viên' . $studentName);
        } else {
            return redirect()->back()->with('errorAddition', 'Lỗi phân công');
        }
    }

    /**
     * show modal assign student again
     *
     * @param Request $request
     * @return string
     */
    public function showModalAssignStudentAgain(Request $request)
    {
        $param = $request->only('internship_group_id');
        $internshipGroup = InternShipGroup::find($param['internship_group_id']);
        //lấy danh sách công ty đã tham gia không phải công ty hiện tại
        $listCompany = CompanyInternShipCourse::where([
            'internship_course_id' => $internshipGroup->internship_course_id
        ])->whereNotIn('company_id', [$internshipGroup->company_id])->get();

//        $listCompany->each( function ($value) use ($internshipGroup) {
//            $value['count_student_attend'] = InternShipGroup::where([
//                'company_id' => $value->company_id,
//                'internship_course_id' => $internshipGroup->internship_course_id
//            ])->count();
//        });

        $htmlListCompany = '<option>Chọn công ty</option>';
        foreach ($listCompany as $item) {
            $htmlListCompany .= '<option value="' . $item->company->id . '">' . $item->company->name . '</option>';
        }

        //kiểm tra tồn xem có tồn tại phân công không
        if (!$internshipGroup) {
            return $this->responseJson([
                'status' => 'error',
                'data' => [],
                'messages' => [],
            ]);
        }

        return $this->responseJson([
            'status' => 'success',
            'data' => [
                'internshipGroup' => $internshipGroup,
                'student' => $internshipGroup->student,
                'listCompanyAttend' => $listCompany,
                'htmlListCompany' => $htmlListCompany
            ],
            'messages' => [],
        ]);
    }

    /**
     * phân công lại khi không thỏa mãn
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignStudentAgain(Request $request)
    {
        $param = $request->only('internshipGroup', 'companyId');
        $internshipGroup = InternShipGroup::find($param['internshipGroup']);
        //nếu không thấy phân công
        if (!$internshipGroup) {
            return redirect()->back()->with('error', 'Chưa phân công nên không thay đổi được');
        }
        $company = Company::find($param['companyId']);
        //không tồn tại công ty
        if (!$company) {
            return redirect()->back()->with('error', 'Không tồn tại công ty');
        }
        $listLectureAssignCompany = LectureAssignCompany::where([
            'internship_course_id' => $internshipGroup->internship_course_id,
            'company_id' => $company->id
        ])->get();
        //trong truong hợp công ty có lớn hơn 2 giảng viên phụ trách
        if (count($listLectureAssignCompany) > 1) {
            $listCount = collect();
            //đếm số lượng sinh viên mỗi giảng viên phụ trách trong cong ty
            $listLectureAssignCompany->each(function ($value) use ($listCount, $internshipGroup) {
                //dem so sinh vien cua moi giang vien duoc phan
                $count = InternShipGroup::where([
                    'internship_course_id' => $internshipGroup->internship_course_id,
                    'lecture_id' => $value->lecture_id
                ])->count();
                //luu vao danh sach
                $listCount->push([
                    'count' => $count,
                    'lectureId' => $value->lecture_id
                ]);
            });
            $listCount = $listCount->sortByDesc('count');
            //lấy giảng viên có số lượng sinh viên ít nhất
            $min = $listCount->first()['count'];
            $lectureId = $listCount->first()['lectureId'];
            //tim số lượng giảng viên được phân công ít nhất thì phân sinh viên cho giảng viên đó
            foreach ($listCount as $item) {
                if ($item['count'] < $min && $item['count'] >= 5) {
                    $min = $item['count'];
                    $lectureId = $item['lectureId'];
                }
            }
            $internshipGroup->lecture_id = $lectureId;
        } else {//trường hợp chỉ có 1 giảng viên phụ trách
            $internshipGroup->lecture_id = $listLectureAssignCompany->first()->lecture_id;
        }
        $internshipGroup->company_id = $company->id;
        $internshipGroup->save();
        return redirect()->back()->with('assignAdditionSuccess', 'Thay đổi thành công');
    }
}
