<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    public function studentInternshipCourse()
    {
        return $this->belongsTo(StudentInternShipCourse::class, 'subject', 'subject');
    }
}
