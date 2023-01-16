<?php

namespace App\Exports;

use App\Models\Payslip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayslipExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'EMPLOYEE',
            'PAYSLIP MONTH & YEAR',
            'TOTAL DAYS OF MONTH',
            'WORKING DAYS OF MONTH',
            'PAID LEAVE TAKEN',
            'UNPAID LEAVE TAKEN',
            'WORKED DAYS',
            'MAIN GROSS SALARY',
            'GROSS SALARY FOR THAT MONTH',
            'BASIC SALARY',
            'HRA',
            'MEDICAL ALLOWANCE',
            'CONVEYANCE ALLOWANCE',
            'SPECIAL ALLOWANCE',
            'TOTAL GROSS',
            'EPF',
            'ESI',
            'PROFESSIONAL TAX',
            'TOTAL DEDUCTION',
            'NET SALARY',
            'Created_at',
        ];
    } 
    public function map($payslip): array
    {

         return[
             $payslip->id,
             $payslip->User ? $payslip->User->full_name.'~'.$payslip->User->jurysoft_id : '',
             $payslip->month_year_formatted,
             $payslip->total_days_of_month,
             $payslip->working_days_of_month,
             $payslip->paid_leave_taken,
             $payslip->unpaid_leave_taken,
             $payslip->worked_days,
             $payslip->main_gross_salary,
             $payslip->gross_salary,
             $payslip->basic_salary,
             $payslip->hra_amount,
             $payslip->medical_allowance,
             $payslip->conveyance_allowance,
             $payslip->special_allowance,
             $payslip->total_gross,
             $payslip->pf_employee,
             $payslip->esi_employee,
             $payslip->professional_tax,
             $payslip->deduction_amount,
             $payslip->net_salary,
             $payslip->created_at,
         ];
    }
    public function collection()
    {
        return Payslip::with(['User'])->get();
    }
}
