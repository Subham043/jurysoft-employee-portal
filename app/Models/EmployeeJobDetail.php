<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class EmployeeJobDetail extends Model
{
    use HasFactory;
    protected $table = "employee_job_details";

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
    
    public function Employee()
    {
        return $this->belongsTo('App\Models\User', 'employee_id');
    }
    
    public function Department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
    
    public function Division()
    {
        return $this->belongsTo('App\Models\Division', 'division_id');
    }
    
    public function Designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }
    
    public function EmployeeType()
    {
        return $this->belongsTo('App\Models\EmployeeType', 'employee_type_id');
    }
}
