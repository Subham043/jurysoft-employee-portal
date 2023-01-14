<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PayslipDownloadReason extends Model
{
    use HasFactory;
    protected $table = 'payslip_download_reasons';
}
