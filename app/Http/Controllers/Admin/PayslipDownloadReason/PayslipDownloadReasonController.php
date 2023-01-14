<?php

namespace App\Http\Controllers\Admin\PayslipDownloadReason;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\PayslipDownloadReason;
use App\Exports\PayslipDownloadReasonExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PayslipDownloadReasonController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
  
        return view('pages.admin.reason.create');
    }

    public function store(Request $req) {
        $validator = $req->validate([
            'reason' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ],
        [
            'reason.required' => 'Please enter the reason !',
            'reason.regex' => 'Please enter the valid reason !',
        ]);

        $country = new PayslipDownloadReason;
        $country->reason = $req->reason;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('payslip_download_reason_view'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('payslip_download_reason_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $country = PayslipDownloadReason::findOrFail($id);
        return view('pages.admin.reason.edit')->with('country',$country);
    }

    public function update(Request $req, $id) {
        $country = PayslipDownloadReason::findOrFail($id);
        $rules = array(
            'reason' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'reason.required' => 'Please enter the reason !',
            'reason.regex' => 'Please enter the valid reason !',
        );
        $validator = $req->validate($rules,$messages);

        $country->reason = $req->reason;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('payslip_download_reason_edit',$country->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('payslip_download_reason_edit',$country->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $country = PayslipDownloadReason::findOrFail($id);
        $country->delete();
        return redirect()->intended(route('payslip_download_reason_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = PayslipDownloadReason::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = PayslipDownloadReason::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.reason.list')->with('country', $country);
    }

    public function display($id) {
        $country = PayslipDownloadReason::findOrFail($id);
        return view('pages.admin.reason.display')->with('country',$country);
    }

    public function excel(){
        return Excel::download(new PayslipDownloadReasonExport, 'reason.xlsx');
    }

}