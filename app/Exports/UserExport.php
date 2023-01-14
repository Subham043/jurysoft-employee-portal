<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Support\Types\UserType;
use App\Support\Types\BloodType;
use App\Support\Types\AccountType;
use App\Support\Types\GenderType;
use App\Support\Types\RelationshipType;
use App\Support\Types\WorkStatusType;

class UserExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'First Name',
            'Last Name',
            'Full Name',
            'Company Email',
            'Personal Phone',
            'User Type',
            'Status',
            'Gender',
            'Date of Birth',
            'Personal Email',
            'Aadhar No',
            'PAN No',
            'Blood Group',
            'Current Address',
            'Permanent Address',
            'Bank Name',
            'Bank Account No',
            'IFSC Code',
            'Account Type',
            'Department',
            'Division',
            'Employee Type',
            'Designation',
            'Date Of Join',
            'Training End Date',
            'Date Of Regular',
            'Created_at',
        ];
    } 
    public function map($user): array
    {
        $bloodType = BloodType::lists();
        $accountType = AccountType::lists();
        $genderType = GenderType::lists();
        $userType = UserType::lists();

         return[
             $user->jurysoft_id,
             $user->first_name,
             $user->last_name,
             $user->full_name,
             $user->email,
             $user->phone,
             $userType[$user->userType],
             $user->status==1 ? 'Active' : 'Inactive',
             $genderType[$user->EmployeePersonalDetail->gender],
             $user->EmployeePersonalDetail->dob,
             $user->EmployeePersonalDetail->email,
             $user->EmployeePersonalDetail->aadhar,
             $user->EmployeePersonalDetail->pan,
             $bloodType[$user->EmployeePersonalDetail->blood_group],
             $user->EmployeePersonalDetail->current_address,
             $user->EmployeePersonalDetail->permanent_address,
             $user->EmployeeBankDetail->bank_name,
             $user->EmployeeBankDetail->account_no,
             $user->EmployeeBankDetail->ifsc,
             $accountType[$user->EmployeeBankDetail->account_type],
             $user->EmployeeJobDetail->Department ? $user->EmployeeJobDetail->Department->name : '',
             $user->EmployeeJobDetail->Division ? $user->EmployeeJobDetail->Division->name : '',
             $user->EmployeeJobDetail->EmployeeType ? $user->EmployeeJobDetail->EmployeeType->name : '',
             $user->EmployeeJobDetail->Designation ? $user->EmployeeJobDetail->Designation->name : '',
             $user->EmployeeJobDetail->date_of_join,
             $user->EmployeeJobDetail->training_end_date,
             $user->EmployeeJobDetail->date_of_regular,
             $user->created_at,
         ];
    }
    public function collection()
    {
        return User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail', 'EmployeePicture'])->get();
    }
}
