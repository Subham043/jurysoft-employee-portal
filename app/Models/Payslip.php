<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\CtcFixedItem;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = ['month', 'year', 'total_days_of_month', 'working_days_of_month', 'paid_leave_taken', 'unpaid_leave_taken', 'worked_days', 'user_id'];
    
    protected $appends = [
        'month_year_formatted',
        'gross_salary', 
        'gross_salary_arrears', 
        'basic_salary', 
        'basic_salary_arrears', 
        'hra_amount', 
        'hra_amount_arrears', 
        'medical_allowance', 
        'conveyance_allowance', 
        'medical_allowance_arrears', 
        'conveyance_allowance_arrears',
        'special_allowance', 
        'special_allowance_arrears', 
        'total_gross', 
        'total_gross_arrears', 
        'pf_employee', 
        'pf_employee_arrears', 
        'esi_employee', 
        'esi_employee_arrears', 
        'professional_tax', 
        'professional_tax_arrears', 
        'deduction_amount', 
        'deduction_amount_arrears', 
        'net_salary',
        'net_salary_arrears',
        'main_net_salary',
        'arrears_days'
    ];

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

    public function main_gross_salary(){
        return (int)$this->main_gross_salary;
    }
    
    public function gross_salary(){
        return round($this->main_gross_salary() - (($this->main_gross_salary()/(int)$this->working_days_of_month) * (int)$this->unpaid_leave_taken));
    }
    
    public function arrears_days(){
        if($this->allow_arrears==0){return 0;}
        return round((int)$this->working_days_of_month_arrears - (int)$this->unpaid_leave_taken_arrears);
    }
    
    public function gross_salary_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round((($this->main_gross_salary()/(int)Carbon::create($this->month_year)->firstOfMonth()->subMonth()->daysInMonth) * ((int)$this->arrears_days())));
    }
    
    public function basic_salary(){
        return round(($this->gross_salary() * (55/100)));
    }
    
    public function basic_salary_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(($this->gross_salary_arrears() * (55/100)));
    }
    
    public function hra(){
        return round(($this->gross_salary() * (20/100)));
    }
    
    public function hra_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(($this->gross_salary_arrears() * (20/100)));
    }
    
    public function special_allowance(){
        return round(max(($this->gross_salary() - ($this->basic_salary() + $this->hra() + $this->allowance(1) + $this->allowance(2))), 0));
    }
    
    public function medical_allowance_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(($this->allowance(1)/(int)Carbon::create($this->month_year)->firstOfMonth()->subMonth()->daysInMonth) * $this->arrears_days());
    }
    
    public function conveyance_allowance_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(($this->allowance(2)/(int)Carbon::create($this->month_year)->firstOfMonth()->subMonth()->daysInMonth) * $this->arrears_days());
    }
    
    public function special_allowance_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(max(($this->gross_salary_arrears() - ($this->basic_salary_arrears() + $this->hra_arrears() + $this->medical_allowance_arrears() + $this->conveyance_allowance_arrears())), 0));
    }
    
    public function total_gross(){
        return round($this->gross_salary());
    }
    
    public function total_gross_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round($this->gross_salary_arrears());
    }
    
    public function pf_employee(){
        return round(min($this->basic_salary(), 15000) * (12/100));
    }
    
    public function pf_employee_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round(min($this->basic_salary_arrears(), 15000) * (12/100));
    }
    
    public function esi_employee(){
        return round($this->main_gross_salary() < 21000 ? $this->main_gross_salary() * (0.75/100) : 0);
    }
    
    public function esi_employee_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round($this->main_gross_salary() < 21000 ? $this->main_gross_salary() * (0.75/100) : 0);
    }
    
    public function professional_tax(){
        return round($this->main_gross_salary() >= 15000 ? $this->allowance(3) : 0);
    }
    
    public function professional_tax_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round($this->main_gross_salary() >= 15000 ? $this->allowance(3) : 0);
    }
    
    public function deduction(){
        return round($this->pf_employee() + $this->esi_employee() + $this->professional_tax());
    }
    
    public function deduction_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round($this->pf_employee_arrears() + $this->esi_employee_arrears() + $this->professional_tax_arrears());
    }
    
    public function net_salary(){
        return round($this->gross_salary() - $this->deduction());
    }
    
    public function net_salary_arrears(){
        if($this->allow_arrears==0){return 0;}
        return round($this->gross_salary_arrears() - $this->deduction_arrears());
    }
    
    public function main_net_salary(){
        return round($this->net_salary() + $this->net_salary_arrears());
    }



    protected function grossSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->gross_salary(),
        );
    }
    
    protected function grossSalaryArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->gross_salary_arrears(),
        );
    }
    
    protected function medicalAllowanceArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->medical_allowance_arrears(),
        );
    }
    
    protected function conveyanceAllowanceArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->conveyance_allowance_arrears(),
        );
    }
    
    protected function arrearsDays(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->arrears_days(),
        );
    }
    
    protected function basicSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->basic_salary(),
        );
    }
    
    protected function basicSalaryArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->basic_salary_arrears(),
        );
    }
    
    protected function hraAmount(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->hra(),
        );
    }
    
    protected function hraAmountArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->hra_arrears(),
        );
    }
    
    protected function medicalAllowance(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->allowance(1),
        );
    }
   
    protected function conveyanceAllowance(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->allowance(2),
        );
    }
    
    protected function specialAllowance(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->special_allowance(),
        );
    }
    
    protected function specialAllowanceArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->special_allowance_arrears(),
        );
    }
    
    protected function totalGross(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->total_gross(),
        );
    }
    
    protected function totalGrossArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->total_gross_arrears(),
        );
    }
    
    protected function pfEmployee(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->pf_employee(),
        );
    }
    
    protected function pfEmployeeArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->pf_employee_arrears(),
        );
    }
    
    protected function esiEmployee(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->esi_employee(),
        );
    }
    
    protected function esiEmployeeArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->esi_employee_arrears(),
        );
    }
    
    protected function professionalTax(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->professional_tax(),
        );
    }
    
    protected function professionalTaxArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->professional_tax_arrears(),
        );
    }
    
    protected function deductionAmount(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->deduction(),
        );
    }
    
    protected function deductionAmountArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->deduction_arrears(),
        );
    }
    
    protected function netSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->net_salary(),
        );
    }

    protected function netSalaryArrears(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->net_salary_arrears(),
        );
    }
    
    protected function mainNetSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->main_net_salary(),
        );
    }

    protected function allowance($id){
        try {
            //code...
            $ctcFixedItem = CtcFixedItem::findOrFail($id);
            return (int)$ctcFixedItem->amount;
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }

    }

}
