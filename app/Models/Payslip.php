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
    
    protected $appends = ['month_year_formatted', 'gross_salary', 'basic_salary', 'hra_amount', 'medical_allowance', 'conveyance_allowance', 'special_allowance', 'total_gross', 'pf_employee', 'esi_employee', 'professional_tax', 'deduction_amount', 'net_salary'];

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
    
    public function basic_salary(){
        return round(($this->gross_salary() * (55/100)));
    }
    
    public function hra(){
        return round(($this->gross_salary() * (20/100)));
    }
    
    public function special_allowance(){
        return round(max(($this->gross_salary() - ($this->basic_salary() + $this->hra() + $this->allowance(1) + $this->allowance(2))), 0));
    }
    
    public function total_gross(){
        return round($this->gross_salary());
    }
    
    public function pf_employee(){
        return round(min($this->basic_salary(), 15000) * (12/100));
    }
    
    public function esi_employee(){
        return round($this->main_gross_salary() < 21000 ? $this->main_gross_salary() * (0.75/100) : 0);
    }
    
    public function professional_tax(){
        return round($this->main_gross_salary() >= 15000 ? $this->allowance(3) : 0);
    }
    
    public function deduction(){
        return round($this->pf_employee() + $this->esi_employee() + $this->professional_tax());
    }
    
    public function net_salary(){
        return round($this->gross_salary() - $this->deduction());
    }



    protected function grossSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->gross_salary(),
        );
    }
    
    protected function basicSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->basic_salary(),
        );
    }
    
    protected function hraAmount(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->hra(),
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
    
    protected function totalGross(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->total_gross(),
        );
    }
    
    protected function pfEmployee(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->pf_employee(),
        );
    }
    
    protected function esiEmployee(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->esi_employee(),
        );
    }
    
    protected function professionalTax(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->professional_tax(),
        );
    }
    
    protected function deductionAmount(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->deduction(),
        );
    }
    
    protected function netSalary(): Attribute
    {
        
        return new Attribute(
            get: fn () => $this->net_salary(),
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
