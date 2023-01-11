<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = ['month', 'year', 'total_days_of_month', 'working_days_of_month', 'paid_leave_taken', 'unpaid_leave_taken', 'worked_days', 'user_id'];
    
    protected $appends = ['month_year_formatted'];

    protected function monthYearFormatted(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->month_year)->format('M, Y'),
        );
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
