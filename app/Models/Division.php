<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Division extends Model
{
    use HasFactory;

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
        return $this->hasMany('App\Models\EmployeeJobDetail', 'division_id');
    }
}
