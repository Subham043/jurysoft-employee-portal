<?php

namespace App\Exports;

use App\Models\PayslipDownload;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayslipDownloadExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Download ID',
            'Employee ID',
            'Employee',
            'Payslip Month & Year',
            'Reason',
            'Created_at',
        ];
    } 
    public function map($payslip): array
    {

         return[
             $payslip->id,
             $payslip->User ? $payslip->User->jurysoft_id : '',
             $payslip->User ? $payslip->User->full_name : '',
             $payslip->Payslip ? $payslip->Payslip->month_year_formatted : '',
             $payslip->PayslipDownloadReason ? $payslip->PayslipDownloadReason->reason : '',
             $payslip->created_at,
         ];
    }
    public function collection()
    {
        return PayslipDownload::with(['User', 'Payslip', 'PayslipDownloadReason'])->get();
    }
}
