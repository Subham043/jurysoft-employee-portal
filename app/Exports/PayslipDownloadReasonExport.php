<?php

namespace App\Exports;

use App\Models\PayslipDownloadReason;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayslipDownloadReasonExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'Reason',
            'Created_at',
        ];
    } 
    public function map($payslip): array
    {

         return[
             $payslip->id,
             $payslip->reason,
             $payslip->created_at,
         ];
    }
    public function collection()
    {
        return PayslipDownloadReason::all();
    }
}
