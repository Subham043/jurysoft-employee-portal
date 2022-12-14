<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class EmployeeType extends Model
{
    use HasFactory;
    protected $table = "employee_types";

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }

    public function CreatedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function EmployeeJobDetail()
    {
        return $this->hasMany('App\Models\EmployeeJobDetail', 'employee_type_id');
    }
}
