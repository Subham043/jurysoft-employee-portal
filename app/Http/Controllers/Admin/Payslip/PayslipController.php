<?php

namespace App\Http\Controllers\Admin\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Models\Payslip;
use App\Models\PayslipDownloadReason;
use App\Models\PayslipDownload;
use App\Models\CtcFixedItem;
use App\Exports\PayslipExport;
use App\Exports\PayslipDownloadExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Pdf;
use Uuid;
use Storage;
use Carbon\Carbon;

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
            'max_month' => Carbon::now()->format('Y-m'),
        ]);
    }

    public function store(Request $req) {
        $rules = [
            'user_id' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','regex:/^[0-9\-]*$/'],
            'main_gross_salary' => ['required','regex:/^[0-9\-]*$/'],
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
            'main_gross_salary.required' => 'Please enter the main gross salary !',
            'main_gross_salary.regex' => 'Please enter the valid main gross salary !',
        ];

        $allow_arrears = false;
        $user = User::findOrFail($req->user_id);
        if($user->EmployeeJobDetail){
            $date_of_join = $user->EmployeeJobDetail->date_of_join;
            if(Carbon::create($date_of_join)->format('d')>=16){
                $d1 = Carbon::create($req->month_year)->firstOfMonth()->format('m-Y');
                $d2 = Carbon::create($date_of_join)->format('m-Y');
                $d3 = Carbon::create($date_of_join)->addMonth()->format('m-Y');
                if($d1==$d2){
                    return redirect()->intended(route('payslip_create'))->with('error_status', 'You cannot create payslip for '.Carbon::create($req->month_year)->firstOfMonth()->format('M, Y').', as the employee had joined the company on '.Carbon::create($date_of_join)->format('d M, Y'));
                }
                if($d1==$d3){
                    $allow_arrears = true;
                }
            }
        }

        if($allow_arrears){
            $rules['working_days_of_month_arrears'] = ['required','regex:/^[0-9]*$/'];
            $rules['unpaid_leave_taken_arrears'] = ['required','regex:/^[0-9]*$/'];
            $messages['working_days_of_month_arrears.required'] = 'Please enter the working days of month !';
            $messages['working_days_of_month_arrears.regex'] = 'Please enter the valid working days of month !';
            $messages['unpaid_leave_taken_arrears.required'] = 'Please enter the unpaid leave taken !';
            $messages['unpaid_leave_taken_arrears.regex'] = 'Please enter the valid unpaid leave taken !';
        }

        $validator = $req->validate($rules,$messages);

        $user = new Payslip;
        $user->main_gross_salary = $req->main_gross_salary;
        $user->month_year = $req->month_year;
        $user->user_id = $req->user_id;
        $user->total_days_of_month = $req->total_days_of_month;
        $user->working_days_of_month = $req->working_days_of_month;
        $user->paid_leave_taken = $req->paid_leave_taken;
        $user->unpaid_leave_taken = $req->unpaid_leave_taken;
        $user->worked_days = $req->worked_days;
        if($allow_arrears){
            $user->allow_arrears = 1;
            $user->working_days_of_month_arrears = $req->working_days_of_month_arrears;
            $user->unpaid_leave_taken_arrears = $req->unpaid_leave_taken_arrears;
        }else{
            $user->allow_arrears = 0;
            $user->working_days_of_month_arrears = 0;
            $user->unpaid_leave_taken_arrears = 0;
        }
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
            'max_month' => Carbon::now()->format('Y-m'),
        ]);
    }

    public function update(Request $req, $id) {
        $payslip = Payslip::with(['User'])->findOrFail($id);
        $rules = [
            'user_id' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','regex:/^[0-9\-]*$/'],
            'total_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'working_days_of_month' => ['required','regex:/^[0-9]*$/'],
            'paid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'unpaid_leave_taken' => ['required','regex:/^[0-9]*$/'],
            'worked_days' => ['required','regex:/^[0-9]*$/'],
            'month_year' => ['required','regex:/^[0-9\-]*$/'],
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
            'main_gross_salary.required' => 'Please enter the main gross salary !',
            'main_gross_salary.regex' => 'Please enter the valid main gross salary !',
        ];

        $allow_arrears = false;
        $user = User::findOrFail($req->user_id);
        if($user->EmployeeJobDetail){
            $date_of_join = $user->EmployeeJobDetail->date_of_join;
            if(Carbon::create($date_of_join)->format('d')>=16){
                $d1 = Carbon::create($req->month_year)->firstOfMonth()->format('m-Y');
                $d2 = Carbon::create($date_of_join)->format('m-Y');
                $d3 = Carbon::create($date_of_join)->addMonth()->format('m-Y');
                if($d1==$d2){
                    return redirect()->intended(route('payslip_create'))->with('error_status', 'You cannot create payslip for '.Carbon::create($req->month_year)->firstOfMonth()->format('M, Y').', as the employee had joined the company on '.Carbon::create($date_of_join)->format('d M, Y'));
                }
                if($d1==$d3){
                    $allow_arrears = true;
                }
            }
        }

        if($allow_arrears){
            $rules['working_days_of_month_arrears'] = ['required','regex:/^[0-9]*$/'];
            $rules['unpaid_leave_taken_arrears'] = ['required','regex:/^[0-9]*$/'];
            $messages['working_days_of_month_arrears.required'] = 'Please enter the working days of month !';
            $messages['working_days_of_month_arrears.regex'] = 'Please enter the valid working days of month !';
            $messages['unpaid_leave_taken_arrears.required'] = 'Please enter the unpaid leave taken !';
            $messages['unpaid_leave_taken_arrears.regex'] = 'Please enter the valid unpaid leave taken !';
        }

        $validator = $req->validate($rules,$messages);

        $payslip->month_year = $req->month_year;
        $payslip->main_gross_salary = $req->main_gross_salary;
        $payslip->user_id = $req->user_id;
        $payslip->total_days_of_month = $req->total_days_of_month;
        $payslip->working_days_of_month = $req->working_days_of_month;
        $payslip->paid_leave_taken = $req->paid_leave_taken;
        $payslip->unpaid_leave_taken = $req->unpaid_leave_taken;
        $payslip->worked_days = $req->worked_days;
        if($allow_arrears){
            $payslip->allow_arrears = 1;
            $payslip->working_days_of_month_arrears = $req->working_days_of_month_arrears;
            $payslip->unpaid_leave_taken_arrears = $req->unpaid_leave_taken_arrears;
        }else{
            $payslip->allow_arrears = 0;
            $payslip->working_days_of_month_arrears = 0;
            $payslip->unpaid_leave_taken_arrears = 0;
        }
        $result = $payslip->save();

        if($result){
            return redirect()->intended(route('payslip_edit',$payslip->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('payslip_edit',$payslip->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $user = Payslip::findOrFail($id);
        $user->forceDelete();
        return redirect()->intended(route('payslip_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = trim($request->input('search'));
            $country = Payslip::with(['User'])->where(function ($query) use ($search) {
                $query->where('total_days_of_month', 'like', '%' . $search . '%')
                      ->orWhere('worked_days', 'like', '%' . $search . '%')
                      ->orWhere('month_year', 'like', '%' . $search . '%');
            })->orWhereHas('User', function($q)  use ($search){
                $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('jurysoft_id', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        }elseif ($request->has('month_year')) {
            $month_year = $request->input('month_year');
            $country = Payslip::with(['User'])->where(function ($query) use ($month_year) {
                $query->where('month_year', $month_year);
            })->orderBy('id', 'DESC')->paginate(10);
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
        return Excel::download(new PayslipExport, 'payslip.xlsx');
    }
    
    public function pdf($id){
        $payslip = Payslip::with(['User'])->findOrFail($id);
        $uuid = Uuid::generate(4)->string;
        
        $data = [
            'payslip' => $payslip,
        ];
          
        $pdf = PDF::loadView('pdf.payslip', $data)->setPaper('a4', 'potrait');
        return $pdf->download($uuid.'.pdf');
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

    public function view_user(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Payslip::with(['User'])->where('user_id', Auth::user()->id)->where(function ($query) use ($search) {
                $query->where('total_days_of_month', 'like', '%' . $search . '%')
                      ->orWhere('worked_days', 'like', '%' . $search . '%')
                      ->orWhere('month_year', 'like', '%' . $search . '%');
            })->orWhereHas('User', function($q)  use ($search){
                $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('jurysoft_id', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        }elseif ($request->has('month_year')) {
            $month_year = $request->input('month_year');
            $country = Payslip::with(['User'])->where('user_id', Auth::user()->id)->where(function ($query) use ($month_year) {
                $query->where('month_year', $month_year);
            })->orderBy('id', 'DESC')->paginate(10);
        }else{
            $country = Payslip::with(['User'])->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.payslip.list')->with('country', $country);
    }

    public function display_user($id) {
        $country = Payslip::with(['User'])->where('user_id', Auth::user()->id)->findOrFail($id);
        return view('pages.admin.payslip.display')->with('country',$country)->with([
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function download_request_user_get($id) {
        $payslip = Payslip::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('pages.admin.payslip.download')->with('payslip',$payslip)->with([
            'reasons' => PayslipDownloadReason::all(),
        ]);
    }

    public function download_request_user_post(Request $req, $id) {
        $payslip = Payslip::with(['User'])->where('user_id', Auth::user()->id)->findOrFail($id);
        $rules = [
            'reason' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ];
        $messages = [
            'reason.required' => 'Please enter the reason !',
            'reason.regex' => 'Please enter the valid reason !',
        ];
        $validator = $req->validate($rules,$messages);

        $payslip_download = new PayslipDownload;
        $payslip_download->reason = $req->reason;
        $payslip_download->user_id = Auth::user()->id;
        $payslip_download->payslip_id = $id;
        $result = $payslip_download->save();

        $uuid = Uuid::generate(4)->string;

        $data = [
            'payslip' => $payslip,
        ];
          
        $pdf = PDF::loadView('pdf.payslip', $data)->setPaper('a4', 'potrait');
        $pdf->save(storage_path('app/public/payslip/').$uuid.'.pdf');

        if($result){
            return redirect()->intended(route('payslip_download', $uuid.'.pdf'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('payslip_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function download($file_name){
        return response()->download(Storage::path('/public/payslip/'.$file_name))->deleteFileAfterSend(true);
    }

    public function payslip_download_view(Request $request) {
        if ($request->has('search')) {
            $search = trim($request->input('search'));
            $country = PayslipDownload::with(['User', 'Payslip'])->where(function ($query) use ($search) {
                $query->where('reason', 'like', '%' . $search . '%');
            })->orWhereHas('User', function($q)  use ($search){
                $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('jurysoft_id', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        }elseif ($request->has('month_year')) {
            $month_year = $request->input('month_year');
            $country = PayslipDownload::with(['User', 'Payslip'])->orWhereHas('Payslip', function ($query) use ($month_year) {
                $query->where('month_year', $month_year);
            })->orderBy('id', 'DESC')->paginate(10);
        }else{
            $country = PayslipDownload::with(['User', 'Payslip'])->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.payslip.download_list')->with('country', $country);
    }

    public function excel_download(){
        return Excel::download(new PayslipDownloadExport, 'payslip_downloads.xlsx');
    }

}