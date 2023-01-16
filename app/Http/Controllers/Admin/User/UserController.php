<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Support\Types\BloodType;
use App\Support\Types\AccountType;
use App\Support\Types\GenderType;
use App\Support\Types\RelationshipType;
use App\Support\Types\WorkStatusType;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Division;
use App\Models\EmployeeType;
use App\Models\ExitMode;
use App\Models\EmployeeBankDetail;
use App\Models\EmployeeEmergencyDetail;
use App\Models\EmployeeEmploymentDetail;
use App\Models\EmployeeJobDetail;
use App\Models\EmployeePersonalDetail;
use App\Models\Ctc;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
  
        return view('pages.admin.user.create')->with([
            "bloodType" => BloodType::lists(),
            "accountType" => AccountType::lists(),
            "genderType" => GenderType::lists(),
            "relationshipType" => RelationshipType::lists(),
            "workStatusType" => WorkStatusType::lists(),
            "exitMode" => ExitMode::all(),
            "department" => Department::all(),
            "designation" => Designation::all(),
            "division" => Division::all(),
            "employeeType" => EmployeeType::all(),
        ]);
    }

    public function store(Request $req) {
        $rules = [
            'first_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'last_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'userType' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users'],
            'phone' => ['required','regex:/^[0-9]*$/','unique:users'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'cpassword' => ['required_with:password|same:password'],
            'gender' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'dob' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'email_personal' => ['required','email'],
            'aadhar' => ['required','regex:/^[0-9]*$/'],
            'pan' => ['required','regex:/^[A-Z0-9]*$/'],
            'blood_group' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'current_address' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'permanent_address' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'department_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'division_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'designation_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'employee_type_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'date_of_join' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_d' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_m' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_y' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_d' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_m' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_y' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'bank_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'account_no' => ['required','regex:/^[0-9]*$/'],
            'ifsc' => ['required','regex:/^[A-Z0-9]*$/'],
            'account_type' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'phone_emergency' => ['required','regex:/^[0-9]*$/'],
            'relationship' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'work_status' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'exit_mode_id' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'exit_date' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ];
        $messages = [
            'first_name.required' => 'Please enter the first name !',
            'first_name.regex' => 'Please enter the valid first name !',
            'last_name.required' => 'Please enter the last name !',
            'last_name.regex' => 'Please enter the valid last name !',
            'userType.required' => 'Please enter the user type !',
            'userType.regex' => 'Please enter the valid user type !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
            'gender.required' => 'Please enter the gender !',
            'gender.regex' => 'Please enter the valid gender !',
            'dob.required' => 'Please enter the date of birth !',
            'dob.regex' => 'Please enter the valid date of birth !',
            'email_personal.required' => 'Please enter the personal email !',
            'email_personal.regex' => 'Please enter the valid personal email !',
            'aadhar.required' => 'Please enter the aadhar !',
            'aadhar.regex' => 'Please enter the valid aadhar !',
            'pan.required' => 'Please enter the pan !',
            'pan.regex' => 'Please enter the valid pan !',
            'blood_group.required' => 'Please enter the blood group !',
            'blood_group.regex' => 'Please enter the valid blood group !',
            'current_address.required' => 'Please enter the current address !',
            'current_address.regex' => 'Please enter the valid current address !',
            'permanent_address.required' => 'Please enter the permanent address !',
            'permanent_address.regex' => 'Please enter the valid permanent address !',
            'department_id.required' => 'Please enter the department !',
            'department_id.regex' => 'Please enter the valid department !',
            'designation_id.required' => 'Please enter the designation !',
            'designation_id.regex' => 'Please enter the valid designation !',
            'division_id.required' => 'Please enter the division !',
            'division_id.regex' => 'Please enter the valid division !',
            'employee_type_id.required' => 'Please enter the employee type !',
            'employee_type_id.regex' => 'Please enter the valid employee type !',
            'date_of_join.required' => 'Please enter the date of join !',
            'date_of_join.regex' => 'Please enter the valid date of join !',
            'no_of_training_days_d.required' => 'Please enter the no. of training days !',
            'no_of_training_days_d.regex' => 'Please enter the valid no. of training days !',
            'no_of_training_days_m.regex' => 'Please enter the valid no. of training months !',
            'no_of_training_days_y.regex' => 'Please enter the valid no. of training years !',
            'mou_duration_d.required' => 'Please enter the no. of mou duration in days !',
            'mou_duration_d.regex' => 'Please enter the valid no. of mou duration in days !',
            'mou_duration_m.regex' => 'Please enter the valid no. of mou duration in months !',
            'mou_duration_y.regex' => 'Please enter the valid no. of mou duration in years !',
            'bank_name.required' => 'Please enter the bank name !',
            'bank_name.regex' => 'Please enter the valid bank name !',
            'account_no.required' => 'Please enter the account number !',
            'account_no.regex' => 'Please enter the valid account number !',
            'ifsc.required' => 'Please enter the ifsc !',
            'ifsc.regex' => 'Please enter the valid ifsc !',
            'account_type.required' => 'Please enter the account type !',
            'account_type.regex' => 'Please enter the valid account type !',
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'phone_emergency.required' => 'Please enter the phone emergency !',
            'phone_emergency.regex' => 'Please enter the valid phone emergency !',
            'relationship.required' => 'Please enter the relationship !',
            'relationship.regex' => 'Please enter the valid relationship !',
            'work_status.required' => 'Please enter the work status !',
            'work_status.regex' => 'Please enter the valid work status !',
            'exit_mode_id.required' => 'Please enter the mode of exit !',
            'exit_mode_id.regex' => 'Please enter the valid mode of exit !',
            'exit_date.required' => 'Please enter the exit date !',
            'exit_date.regex' => 'Please enter the valid exit date !',
        ];
        if(!$req->no_of_training_days_d && !$req->no_of_training_days_m && !$req->no_of_training_days_y){
            $rules['no_of_training_days_d'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        if(!$req->mou_duration_d && !$req->mou_duration_m && !$req->mou_duration_y){
            $rules['mou_duration_d'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        if($req->work_status==2){
            $rules['exit_mode_id'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
            $rules['exit_date'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        $validator = $req->validate($rules,$messages);

        $user = new User;
        $user->first_name = $req->first_name;
        $user->last_name = $req->last_name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->userType = $req->userType;
        $user->status = $req->status==="on" ? 1 : 0;
        $user->password = Hash::make($req->password);
        $user->otp = rand(1000,9999);
        $result = $user->save();
        $user->jurysoft_id = $user->setJurysoftId();
        $result = $user->save();

        $employeePersonalDetail = new EmployeePersonalDetail;
        $employeePersonalDetail->gender = $req->gender;
        $employeePersonalDetail->dob = $req->dob;
        $employeePersonalDetail->email = $req->email_personal;
        $employeePersonalDetail->aadhar = $req->aadhar;
        $employeePersonalDetail->current_address = $req->current_address;
        $employeePersonalDetail->permanent_address = $req->permanent_address;
        $employeePersonalDetail->pan = $req->pan;
        $employeePersonalDetail->blood_group = $req->blood_group;
        $employeePersonalDetail->employee_id = $user->id;
        $employeePersonalDetail->save();

        $employeeBankDetail = new EmployeeBankDetail;
        $employeeBankDetail->bank_name = $req->bank_name;
        $employeeBankDetail->account_no = $req->account_no;
        $employeeBankDetail->ifsc = $req->ifsc;
        $employeeBankDetail->account_type = $req->account_type;
        $employeeBankDetail->employee_id = $user->id;
        $employeeBankDetail->save();
        
        $employeeEmergencyDetail = new EmployeeEmergencyDetail;
        $employeeEmergencyDetail->name = $req->name;
        $employeeEmergencyDetail->phone = $req->phone_emergency;
        $employeeEmergencyDetail->relationship = $req->relationship;
        $employeeEmergencyDetail->employee_id = $user->id;
        $employeeEmergencyDetail->save();
        
        $employeeEmploymentDetail = new EmployeeEmploymentDetail;
        $employeeEmploymentDetail->work_status = $req->work_status;
        if($req->work_status==2){
            $employeeEmploymentDetail->exit_mode_id = $req->exit_mode_id;
            $employeeEmploymentDetail->exit_date = $req->exit_date;
        }
        $employeeEmploymentDetail->employee_id = $user->id;
        $employeeEmploymentDetail->save();
        
        $employeeJobDetail = new EmployeeJobDetail;
        $employeeJobDetail->department_id = $req->department_id;
        $employeeJobDetail->division_id = $req->division_id;
        $employeeJobDetail->designation_id = $req->designation_id;
        $employeeJobDetail->employee_type_id = $req->employee_type_id;
        $employeeJobDetail->date_of_join = $req->date_of_join;
        $employeeJobDetail->no_of_training_days_d = $req->no_of_training_days_d;
        $employeeJobDetail->no_of_training_days_m = $req->no_of_training_days_m;
        $employeeJobDetail->no_of_training_days_y = $req->no_of_training_days_y;
        $employeeJobDetail->training_end_date = $req->training_end_date;
        $employeeJobDetail->date_of_regular = $req->date_of_regular;
        $employeeJobDetail->mou_duration_d = $req->mou_duration_d;
        $employeeJobDetail->mou_duration_m = $req->mou_duration_m;
        $employeeJobDetail->mou_duration_y = $req->mou_duration_y;
        $employeeJobDetail->employee_id = $user->id;
        $employeeJobDetail->save();

        if($result){
            return redirect()->intended(route('subadmin_view'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('subadmin_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $country = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail'])->findOrFail($id);
        return view('pages.admin.user.edit')->with('country',$country)->with([
            "bloodType" => BloodType::lists(),
            "accountType" => AccountType::lists(),
            "genderType" => GenderType::lists(),
            "relationshipType" => RelationshipType::lists(),
            "workStatusType" => WorkStatusType::lists(),
            "exitMode" => ExitMode::all(),
            "department" => Department::all(),
            "designation" => Designation::all(),
            "division" => Division::all(),
            "employeeType" => EmployeeType::all(),
        ]);
    }

    public function update(Request $req, $id) {
        $user = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail'])->findOrFail($id);
        $rules = array(
            'first_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'last_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'jurysoft_id' => ['required','regex:/^[a-zA-Z0-9\-]*$/'],
            'userType' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email'],
            'phone' => ['nullable','regex:/^[0-9]*$/'],
            'gender' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'dob' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'email_personal' => ['required','email'],
            'aadhar' => ['required','regex:/^[0-9]*$/'],
            'pan' => ['required','regex:/^[A-Z0-9]*$/'],
            'blood_group' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'current_address' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'permanent_address' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'department_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'division_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'designation_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'employee_type_id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'date_of_join' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_d' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_m' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'no_of_training_days_y' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_d' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_m' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'mou_duration_y' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'bank_name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'account_no' => ['required','regex:/^[0-9]*$/'],
            'ifsc' => ['required','regex:/^[A-Z0-9]*$/'],
            'account_type' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'phone_emergency' => ['required','regex:/^[0-9]*$/'],
            'relationship' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'work_status' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'exit_mode_id' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'exit_date' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'first_name.required' => 'Please enter the first name !',
            'first_name.regex' => 'Please enter the valid first name !',
            'last_name.required' => 'Please enter the last name !',
            'last_name.regex' => 'Please enter the valid last name !',
            'userType.required' => 'Please enter the user type !',
            'userType.regex' => 'Please enter the valid user type !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'password.regex' => 'Please enter the valid password !',
            'gender.required' => 'Please enter the gender !',
            'gender.regex' => 'Please enter the valid gender !',
            'dob.required' => 'Please enter the date of birth !',
            'dob.regex' => 'Please enter the valid date of birth !',
            'email_personal.required' => 'Please enter the personal email !',
            'email_personal.regex' => 'Please enter the valid personal email !',
            'aadhar.required' => 'Please enter the aadhar !',
            'aadhar.regex' => 'Please enter the valid aadhar !',
            'pan.required' => 'Please enter the pan !',
            'pan.regex' => 'Please enter the valid pan !',
            'blood_group.required' => 'Please enter the blood group !',
            'blood_group.regex' => 'Please enter the valid blood group !',
            'current_address.required' => 'Please enter the current address !',
            'current_address.regex' => 'Please enter the valid current address !',
            'permanent_address.required' => 'Please enter the permanent address !',
            'permanent_address.regex' => 'Please enter the valid permanent address !',
            'department_id.required' => 'Please enter the department !',
            'department_id.regex' => 'Please enter the valid department !',
            'designation_id.required' => 'Please enter the designation !',
            'designation_id.regex' => 'Please enter the valid designation !',
            'division_id.required' => 'Please enter the division !',
            'division_id.regex' => 'Please enter the valid division !',
            'employee_type_id.required' => 'Please enter the employee type !',
            'employee_type_id.regex' => 'Please enter the valid employee type !',
            'date_of_join.required' => 'Please enter the date of join !',
            'date_of_join.regex' => 'Please enter the valid date of join !',
            'no_of_training_days_d.required' => 'Please enter the no. of training days !',
            'no_of_training_days_d.regex' => 'Please enter the valid no. of training days !',
            'no_of_training_days_m.regex' => 'Please enter the valid no. of training months !',
            'no_of_training_days_y.regex' => 'Please enter the valid no. of training years !',
            'mou_duration_d.required' => 'Please enter the no. of mou duration in days !',
            'mou_duration_d.regex' => 'Please enter the valid no. of mou duration in days !',
            'mou_duration_m.regex' => 'Please enter the valid no. of mou duration in months !',
            'mou_duration_y.regex' => 'Please enter the valid no. of mou duration in years !',
            'bank_name.required' => 'Please enter the bank name !',
            'bank_name.regex' => 'Please enter the valid bank name !',
            'account_no.required' => 'Please enter the account number !',
            'account_no.regex' => 'Please enter the valid account number !',
            'ifsc.required' => 'Please enter the ifsc !',
            'ifsc.regex' => 'Please enter the valid ifsc !',
            'account_type.required' => 'Please enter the account type !',
            'account_type.regex' => 'Please enter the valid account type !',
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'phone_emergency.required' => 'Please enter the phone emergency !',
            'phone_emergency.regex' => 'Please enter the valid phone emergency !',
            'relationship.required' => 'Please enter the relationship !',
            'relationship.regex' => 'Please enter the valid relationship !',
            'work_status.required' => 'Please enter the work status !',
            'work_status.regex' => 'Please enter the valid work status !',
            'exit_mode_id.required' => 'Please enter the mode of exit !',
            'exit_mode_id.regex' => 'Please enter the valid mode of exit !',
            'exit_date.required' => 'Please enter the exit date !',
            'exit_date.regex' => 'Please enter the valid exit date !',
        );
        if($user->email!==$req->email){
            $rules['email'] = ['required','email','unique:users'];
        }
        if($user->jurysoft_id!==$req->jurysoft_id){
            $rules['jurysoft_id'] = ['required','regex:/^[a-zA-Z0-9\-]*$/','unique:users'];
        }
        if(!empty($req->phone) && $user->phone!==$req->phone){
            $rules['phone'] = ['required','regex:/^[0-9]*$/','unique:users'];
        }
        if(!empty($req->password)){
            $rules['cpassword'] = ['required_with:password|same:password'];
            $messages['cpassword.required'] = 'Please enter your confirm password !';
            $messages['cpassword.same'] = 'password & confirm password must be the same !';
        }
        if(!$req->no_of_training_days_d && !$req->no_of_training_days_m && !$req->no_of_training_days_y){
            $rules['no_of_training_days_d'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        if(!$req->mou_duration_d && !$req->mou_duration_m && !$req->mou_duration_y){
            $rules['mou_duration_d'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        if($req->work_status==2){
            $rules['exit_mode_id'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
            $rules['exit_date'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'];
        }
        $validator = $req->validate($rules,$messages);

        $user->first_name = $req->first_name;
        $user->last_name = $req->last_name;
        $user->jurysoft_id = $req->jurysoft_id;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->userType = $req->userType;
        $user->status = $req->status=="on" ? 1 : 0;
        if(!empty($req->password)){
            $user->password = Hash::make($req->password);
        }
        $result = $user->save();

        $employeePersonalDetail = EmployeePersonalDetail::where('employee_id', $user->id)->firstOrFail();
        $employeePersonalDetail->gender = $req->gender;
        $employeePersonalDetail->dob = $req->dob;
        $employeePersonalDetail->email = $req->email_personal;
        $employeePersonalDetail->aadhar = $req->aadhar;
        $employeePersonalDetail->current_address = $req->current_address;
        $employeePersonalDetail->permanent_address = $req->permanent_address;
        $employeePersonalDetail->pan = $req->pan;
        $employeePersonalDetail->blood_group = $req->blood_group;
        $employeePersonalDetail->save();

        $employeeBankDetail = EmployeeBankDetail::where('employee_id', $user->id)->firstOrFail();
        $employeeBankDetail->bank_name = $req->bank_name;
        $employeeBankDetail->account_no = $req->account_no;
        $employeeBankDetail->ifsc = $req->ifsc;
        $employeeBankDetail->account_type = $req->account_type;
        $employeeBankDetail->save();
        
        $employeeEmergencyDetail = EmployeeEmergencyDetail::where('employee_id', $user->id)->firstOrFail();
        $employeeEmergencyDetail->name = $req->name;
        $employeeEmergencyDetail->phone = $req->phone_emergency;
        $employeeEmergencyDetail->relationship = $req->relationship;
        $employeeEmergencyDetail->save();
        
        $employeeEmploymentDetail = EmployeeEmploymentDetail::where('employee_id', $user->id)->firstOrFail();
        $employeeEmploymentDetail->work_status = $req->work_status;
        if($req->work_status==2){
            $employeeEmploymentDetail->exit_mode_id = $req->exit_mode_id;
            $employeeEmploymentDetail->exit_date = $req->exit_date;
        }
        $employeeEmploymentDetail->save();
        
        $employeeJobDetail = EmployeeJobDetail::where('employee_id', $user->id)->firstOrFail();
        $employeeJobDetail->department_id = $req->department_id;
        $employeeJobDetail->division_id = $req->division_id;
        $employeeJobDetail->designation_id = $req->designation_id;
        $employeeJobDetail->employee_type_id = $req->employee_type_id;
        $employeeJobDetail->date_of_join = $req->date_of_join;
        $employeeJobDetail->no_of_training_days_d = $req->no_of_training_days_d;
        $employeeJobDetail->no_of_training_days_m = $req->no_of_training_days_m;
        $employeeJobDetail->no_of_training_days_y = $req->no_of_training_days_y;
        $employeeJobDetail->training_end_date = $req->training_end_date;
        $employeeJobDetail->date_of_regular = $req->date_of_regular;
        $employeeJobDetail->mou_duration_d = $req->mou_duration_d;
        $employeeJobDetail->mou_duration_m = $req->mou_duration_m;
        $employeeJobDetail->mou_duration_y = $req->mou_duration_y;
        $employeeJobDetail->save();

        if($result){
            return redirect()->intended(route('subadmin_edit',$user->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('subadmin_edit',$user->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->forceDelete();
        return redirect()->intended(route('subadmin_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail'])->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('jurysoft_id', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail'])->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.user.list')->with('country', $country);
    }

    public function display($id) {
        $country = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail', 'EmployeePicture'])->findOrFail($id);
        return view('pages.admin.user.display')->with('country',$country)->with([
            "bloodType" => BloodType::lists(),
            "accountType" => AccountType::lists(),
            "genderType" => GenderType::lists(),
            "relationshipType" => RelationshipType::lists(),
            "workStatusType" => WorkStatusType::lists(),
        ]);
    }

    public function excel(){
        return Excel::download(new UserExport, 'user.xlsx');
    }

    public function json(Request $req) {
        $rules = [
            'user_id' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','required','regex:/^[0-9\-]*$/'],
        ];
        $messages = [
            'user_id.required' => 'Please enter the employee id !',
            'user_id.regex' => 'Please enter the valid employee id !',
            'month_year.required' => 'Please enter the month & year !',
            'month_year.regex' => 'Please enter the valid month & year !',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        try {
            //code...
            $user = User::findOrFail($req->user_id);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["message"=>"employee not found"], 400);
        }

        try {
            //code...
            $ctc_count = Ctc::where('user_id', $req->user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $req->user_id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
                return response()->json(["employee_main_gross_salary"=>(int)$ctc->ctc], 200);
            }elseif($ctc_count>1 && $ctc_count<3){
                $ctc = Ctc::where('user_id', $req->user_id)->where('month_year','>=',$req->month_year.'-01')->orderBy('month_year', 'DESC')->limit(1)->first();
                if(!$ctc){
                    $ctc = Ctc::where('user_id', $req->user_id)->where('month_year',null)->orderBy('id', 'DESC')->limit(1)->first();
                }
                return response()->json(["employee_main_gross_salary"=>(int)$ctc->ctc], 200);
            }elseif($ctc_count>=3){
                $ctc = Ctc::where('user_id', $req->user_id)->orderBy('month_year', 'DESC')->get();
                $ctc_index = null;
                $test = true;
                $date1 = Carbon::create($req->month_year)->lastOfMonth()->format('Y-m-d');
                foreach ($ctc as $key => $value) {
                    # code...
                    if($value->month_year===null && $ctc_index===null && count($ctc)-1==$key ){
                        $ctc_index = $key;
                        return response()->json(["employee_main_gross_salary"=>(int)$ctc[$ctc_index]->ctc], 200);
                    }elseif($value->month_year!=null){
                        $date2 = Carbon::create($value->month_year)->format('Y-m-d');
                        if($date1<=$date2){
                            $ctc_index = $key;
                            continue;
                        }else{
                            $test = false;
                            continue;
                        }
                    }
                }
                return response()->json(["employee_main_gross_salary"=>(int)$ctc[$ctc_index]->ctc], 200);
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
            return $th;
            return response()->json(["message"=>"main gross salary not found! Kindly add ctc for the selected employee.", 'err'=>$th], 400);
        }
        if(!$ctc){
            return response()->json(["message"=>"main gross salary not found! Kindly add ctc for the selected employee."], 400);
        }

        
    }

    public function detail() {
        $country = User::with(['EmployeePersonalDetail', 'EmployeeBankDetail', 'EmployeeEmergencyDetail', 'EmployeeEmploymentDetail', 'EmployeeJobDetail', 'EmployeePicture'])->findOrFail(Auth::user()->id);
        return view('pages.admin.user.display')->with('country',$country)->with([
            "bloodType" => BloodType::lists(),
            "accountType" => AccountType::lists(),
            "genderType" => GenderType::lists(),
            "relationshipType" => RelationshipType::lists(),
            "workStatusType" => WorkStatusType::lists(),
        ]);
    }

}