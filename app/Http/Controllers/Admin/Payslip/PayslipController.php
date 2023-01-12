<?php

namespace App\Http\Controllers\Admin\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Models\Payslip;
use App\Models\CtcFixedItem;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PayslipController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists(),
        ]);
    }

    public function create() {
  
        $user = User::all();
        return view('pages.admin.payslip.create')->with([
            "user" => $user,
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function store(Request $req) {
        $rules = [
            'user_id' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','regex:/^[0-9\-]*$/','unique:payslips'],
            'total_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'working_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'paid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'unpaid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'worked_days' => ['required','regex:/^[0-9]*$/'],
        ];
        $messages = [
            'month_year.required' => 'Please enter the month & year !',
            'month_year.regex' => 'Please enter the valid month & year !',
            'user_id.required' => 'Please enter the employee !',
            'user_id.regex' => 'Please enter the valid employee !',
            'total_days_of_month.required' => 'Please enter the month & year !',
            'total_days_of_month.regex' => 'Please enter the valid month & year !',
            'working_days_of_month.required' => 'Please enter the working days of month !',
            'working_days_of_month.regex' => 'Please enter the valid working days of month !',
            'paid_leave_taken.required' => 'Please enter the paid leave taken !',
            'paid_leave_taken.regex' => 'Please enter the valid paid leave taken !',
            'unpaid_leave_taken.required' => 'Please enter the unpaid leave taken !',
            'unpaid_leave_taken.regex' => 'Please enter the valid unpaid leave taken !',
            'worked_days.required' => 'Please enter the worked days !',
            'worked_days.regex' => 'Please enter the valid worked days !',
        ];
        $validator = $req->validate($rules,$messages);

        $user = new Payslip;
        $user->month_year = $req->month_year;
        $user->user_id = $req->user_id;
        $user->total_days_of_month = $req->total_days_of_month;
        $user->working_days_of_month = $req->working_days_of_month;
        $user->paid_leave_taken = $req->paid_leave_taken;
        $user->unpaid_leave_taken = $req->unpaid_leave_taken;
        $user->worked_days = $req->worked_days;
        $result = $user->save();

        if($result){
            return redirect()->intended(route('payslip_view'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('payslip_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $country = Payslip::with(['User'])->findOrFail($id);
        $user = User::all();
        return view('pages.admin.payslip.edit')->with('country',$country)->with([
            "user" => $user,
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function update(Request $req, $id) {
        $user = Payslip::with(['User'])->findOrFail($id);
        $rules = [
            'user_id' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','regex:/^[0-9\-]*$/','unique:payslips,month_year,'.$id],
            'total_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'working_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'paid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'unpaid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'worked_days' => ['required','regex:/^[0-9]*$/'],
        ];
        $messages = [
            'month_year.required' => 'Please enter the month & year !',
            'month_year.regex' => 'Please enter the valid month & year !',
            'user_id.required' => 'Please enter the employee !',
            'user_id.regex' => 'Please enter the valid employee !',
            'total_days_of_month.required' => 'Please enter the month & year !',
            'total_days_of_month.regex' => 'Please enter the valid month & year !',
            'working_days_of_month.required' => 'Please enter the working days of month !',
            'working_days_of_month.regex' => 'Please enter the valid working days of month !',
            'paid_leave_taken.required' => 'Please enter the paid leave taken !',
            'paid_leave_taken.regex' => 'Please enter the valid paid leave taken !',
            'unpaid_leave_taken.required' => 'Please enter the unpaid leave taken !',
            'unpaid_leave_taken.regex' => 'Please enter the valid unpaid leave taken !',
            'worked_days.required' => 'Please enter the worked days !',
            'worked_days.regex' => 'Please enter the valid worked days !',
        ];
        $validator = $req->validate($rules,$messages);

        $user->month_year = $req->month_year;
        $user->user_id = $req->user_id;
        $user->total_days_of_month = $req->total_days_of_month;
        $user->working_days_of_month = $req->working_days_of_month;
        $user->paid_leave_taken = $req->paid_leave_taken;
        $user->unpaid_leave_taken = $req->unpaid_leave_taken;
        $user->worked_days = $req->worked_days;
        $result = $user->save();

        if($result){
            return redirect()->intended(route('payslip_edit',$user->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('payslip_edit',$user->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $user = Payslip::findOrFail($id);
        $user->forceDelete();
        return redirect()->intended(route('payslip_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Payslip::with(['User'])->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = Payslip::with(['User'])->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.payslip.list')->with('country', $country);
    }

    public function display($id) {
        $country = Payslip::with(['User'])->findOrFail($id);
        return view('pages.admin.payslip.display')->with('country',$country)->with([
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function excel(){
        return Excel::download(new UserExport, 'user.xlsx');
    }

    protected function allowance($id){
        try {
            //code...
            $ctcFixedItem = CtcFixedItem::findOrFail($id);
        } catch (\Throwable $th) {
            //throw $th;
            $ctcFixedItem = null;
        }

        return $ctcFixedItem;
    }

}