<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 26/11/2017
 * Time: 01:55
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureAssignCompany extends Model
{
    public $table = 'lecture_assign_company';

    protected $fillable = [
        'lecture_id', 'company_id'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
