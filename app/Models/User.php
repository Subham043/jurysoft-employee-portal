<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'jurysoft_id'];

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }
    
    // protected function jurysoftId(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => 'Jurysoft-'.$this->id,
    //     );
    // }

    public function setJurysoftId(){
        if(strlen(strval($this->id))>=3){
            return 'JS-'.$this->id;
        }else{
            return 'JS0'.$this->id;
        }
    }

    public function Ctc()
    {
        return $this->hasMany('App\Models\Ctc', 'user_id');
    }
    
    public function DepartmentCreated()
    {
        return $this->hasMany('App\Models\Department', 'user_id');
    }
    
    public function DivisionCreated()
    {
        return $this->hasMany('App\Models\Division', 'user_id');
    }
    
    public function DesignationCreated()
    {
        return $this->hasMany('App\Models\Designation', 'user_id');
    }
    
    public function EmployeeTypeCreated()
    {
        return $this->hasMany('App\Models\EmployeeType', 'user_id');
    }
    
    public function ExitModeCreated()
    {
        return $this->hasMany('App\Models\ExitMode', 'user_id');
    }
    
    public function EmployeeEmploymentDetail()
    {
        return $this->hasOne('App\Models\EmployeeEmploymentDetail', 'employee_id');
    }
    
    public function EmployeeEmploymentDetailCreated()
    {
        return $this->hasMany('App\Models\EmployeeEmploymentDetail', 'user_id');
    }
    
    public function EmployeeJobDetail()
    {
        return $this->hasOne('App\Models\EmployeeJobDetail', 'employee_id');
    }
    
    public function EmployeeJobDetailCreated()
    {
        return $this->hasMany('App\Models\EmployeeJobDetail', 'user_id');
    }
    
    public function EmployeePersonalDetail()
    {
        return $this->hasOne('App\Models\EmployeePersonalDetail', 'employee_id');
    }
    
    public function EmployeePersonalDetailCreated()
    {
        return $this->hasMany('App\Models\EmployeePersonalDetail', 'user_id');
    }
    
    public function EmployeeEmergencyDetail()
    {
        return $this->hasOne('App\Models\EmployeeEmergencyDetail', 'employee_id');
    }
    
    public function EmployeeEmergencyDetailCreated()
    {
        return $this->hasMany('App\Models\EmployeeEmergencyDetail', 'user_id');
    }
    
    public function EmployeeBankDetail()
    {
        return $this->hasOne('App\Models\EmployeeBankDetail', 'employee_id');
    }
    
    public function EmployeeBankDetailCreated()
    {
        return $this->hasOne('App\Models\EmployeeBankDetail', 'user_id');
    }
    
    public function EmployeePicture()
    {
        return $this->hasOne('App\Models\EmployeePicture', 'employee_id');
    }
    
    public function EmployeePictureCreated()
    {
        return $this->hasOne('App\Models\EmployeePicture', 'user_id');
    }
}
