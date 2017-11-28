<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_name', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function lecture()
    {
        return $this->hasOne(Lecture::class, 'user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function scopeFindUser($query, $data)
    {
        return $query->where('email', $data)
            ->orWhere('provider_id', $data);
    }

    public function scopeGetByInput($query, $data)
    {
        return $query->where($data);
    }
}
