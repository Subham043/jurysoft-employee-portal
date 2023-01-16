<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\CtcFixedItem;

class Ctc extends Model
{
    use HasFactory;

    protected $table = 'ctcs';
    protected $appends = ['month_year_formatted', 'month_year_unformatted'];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    protected function monthYearFormatted(): Attribute
    {
        return new Attribute(
            get: fn () => $this->month_year ? Carbon::parse($this->month_year)->format('M, Y') : null,
        );
    }
    
    protected function monthYearUnformatted(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->month_year)->format('Y-m'),
        );
    }


}
