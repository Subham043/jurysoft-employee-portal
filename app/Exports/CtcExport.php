<?php

namespace App\Exports;

use App\Models\Ctc;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CtcExport implements FromCollection,WithHeadings,WithMapping
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'Employee ID',
            'Employee',
            'Main Gross Salary',
            'CTC Termination Month & Year',
            'Created_at',
        ];
    } 
    public function map($ctc): array
    {

         return[
             $ctc->id,
             $ctc->User ? $ctc->User->jurysoft_id : '',
             $ctc->User ? $ctc->User->full_name : '',
             $ctc->ctc,
             $ctc->month_year_formatted,
             $ctc->created_at,
         ];
    }

    public function collection()
    {
        return Ctc::with(['User'])->where('user_id', $this->user_id)->get();
    }
}
