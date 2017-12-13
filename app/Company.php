<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $table = 'company';

    protected $fillable = [
        'name', 'user_id', 'count_student_default', 'hr_name', 'hr_mail', 'hr_phone'
    ];

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }

    public function internShipGroup()
    {
        return $this->hasMany('App\InternShipGroup', 'company_id');
    }

    public function companyInternShipCourse()
    {
        return $this->hasMany('App\CompanyInternShipCourse', 'company_id');
    }

    public function lectureAssignCompany()
    {
        return $this->hasMany(LectureAssignCompany::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * get company
     *
     * @param $idUser
     * @return mixed
     */
    public static function getCompany($idUser)
    {
        $company = Company::where('user_id', '=', $idUser)->get();
        return $company;
    }

    /**
     * insert company
     *
     * @param $name
     * @param $userID
     */
    public static function insertCompany($name, $userID)
    {
        $company = new Company();
        $company->name = $name;
        $company->user_id = $userID;
        $company->save();
    }

    /**
     * kiem tra trung ten cong ty
     *
     * @param $nameCompany
     * @return bool
     */
    public static function checkNameCompany($nameCompany)
    {
        $check = Company::where('name', '=', $nameCompany)->get()->count();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * edit company profile
     *
     * @param $id
     * @param $address
     * @param $birthday
     * @param $email
     * @param $phone
     * @param $description
     * @param $requireSkill
     */
    public static function updateProfile($id, $address, $birthday, $email, $phone, $logo, $description)
    {
        $company = Company::find($id);
        $company->address = $address;
        $company->birthday = $birthday;
        $company->hr_mail = $email;
        $company->hr_phone = $phone;
        $company->logo = $logo;
        $company->description = $description;
        $company->save();
    }

    public static function updateProfileNotLogo($id, $address, $birthday, $email, $phone, $description)
    {
        $company = Company::find($id);
        $company->address = $address;
        $company->birthday = $birthday;
        $company->hr_mail = $email;
        $company->hr_phone = $phone;
        $company->description = $description;
        $company->save();
    }


    /**
     * get all company
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allCompany()
    {
        $company = Company::all();
        return $company;
    }

    /**
     * get company follow id
     *
     * @param $companyID
     * @return mixed
     */
    public static function getCompanyFollowID($companyID)
    {
        $company = Company::where('id', '=', $companyID)->get();
        return $company;
    }

    /**
     * kiem tra su ton tai cua cong ty
     *
     * @param $companyID
     * @return bool
     */
    public static function checkCompany($companyID)
    {
        $check = count(Company::getCompanyFollowID($companyID));
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * cap nhat diem danh gia trung binh cua cong ty
     *
     * @param $companyID
     * @param $pointVote
     */
    public static function updatePointVote($companyID, $pointVote)
    {
        $company = Company::find($companyID);
        $company->point_vote = $pointVote;
        $company->save();
    }

    /**
     * kiem tra trung ten cong ty khi admin chinh sua thong tin cong ty
     *
     * @param $myUserID
     * @param $name
     * @return bool
     */
    public static function checkNameEdit($myUserID, $name)
    {
        $company = Company::where('user_id', '<>', $myUserID)->get();
        $check = true;
        foreach ($company as $c) {
            if ($c->name == $name) {
                $check = false;
                break;
            }
        }
        return $check;
    }

    public static function updateCompanyNotLogo($id, $name, $address, $birthday, $emailHR, $phone, $description)
    {
        $find = Company::find($id);
        $find->name = $name;
        $find->address = $address;
        $find->birthday = $birthday;
        $find->hr_mail = $emailHR;
        $find->hr_phone = $phone;
        $find->description = $description;
        $find->save();
    }

    public static function updateCompanyHasLogo($id, $name, $address, $birthday, $emailHR, $phone, $description, $url)
    {
        $find = Company::find($id);
        $find->name = $name;
        $find->address = $address;
        $find->birthday = $birthday;
        $find->hr_mail = $emailHR;
        $find->hr_phone = $phone;
        $find->description = $description;
        $find->logo = $url;
        $find->save();
    }

    /**
     * xoa cong ty
     *
     * @param $companyID
     */
    public static function deleteCompany($companyID)
    {
        $find = Company::find($companyID);
        $find->delete();
    }

    /**
     * lay cac cong ty con lai
     *
     * @param $companyID
     * @return mixed
     */
    public static function getCompanyContain($companyID)
    {
        $company = Company::where('id', '<>', $companyID)->get();
        return $company;
    }
}
