<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\CtcFixedItem;

class PayslipDownload extends Model
{
    use HasFactory;

    protected $table = 'payslip_downloads';

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function Payslip()
    {
        return $this->belongsTo('App\Models\Payslip', 'payslip_id');
    }


}
