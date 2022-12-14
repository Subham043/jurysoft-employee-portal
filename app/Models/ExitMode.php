<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ExitMode extends Model
{
    use HasFactory;
    protected $table = "exit_modes";

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
    
    public function EmployeeEmploymentDetail()
    {
        return $this->hasMany('App\Models\EmployeeEmploymentDetail', 'exit_mode_id');
    }
}
