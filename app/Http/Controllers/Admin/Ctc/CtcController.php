<?php

namespace App\Http\Controllers\Admin\Ctc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\Ctc;
use App\Models\User;
use App\Models\CtcFixedItem;
use App\Exports\CtcExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CtcController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create($user_id) {
        $user = User::findOrFail($user_id);
        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }

        return view('pages.admin.ctc.create')->with([
            'user' => $user,
            'ctc' => $ctc,
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function store(Request $req, $user_id) {
        $user = User::findOrFail($user_id);
        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }
        
        $rules = [
            'main_gross_salary' => ['required','regex:/^[0-9\.]*$/'],
        ];
        $messages = [
            'main_gross_salary.required' => 'Please enter the main gross salary !',
            'main_gross_salary.regex' => 'Please enter the valid main gross salary !',
        ];

        if($ctc){
            $rules['month_year'] = ['required','regex:/^[0-9\-]*$/'];
            $messages['month_year.required'] = 'Please enter the month & year !';
            $messages['month_year.regex'] = 'Please enter the valid month & year !';
        }

        $validator = $req->validate($rules,$messages);

        $country = new Ctc;
        $country->ctc = $req->main_gross_salary;
        $country->user_id = $user_id;
        $result = $country->save();

        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }

        if($ctc){
            $ctc->month_year = Carbon::create($req->month_year)->lastOfMonth()->format('Y-m-d');
            $ctc->save();
        }

        if($result){
            return redirect()->intended(route('ctc_view', $user_id))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('ctc_create', $user_id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($user_id, $id) {
        $country = Ctc::findOrFail($id);
        $user = User::findOrFail($user_id);
        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->where('id', '<>', $id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
                if($ctc->id==$id){
                    $ctc = null;
                }
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }
        return view('pages.admin.ctc.edit')->with('country',$country)->with([
            'user' => $user,
            'ctc' => $ctc,
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function update(Request $req, $user_id, $id) {
        $country = Ctc::findOrFail($id);
        $user = User::findOrFail($user_id);
        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->where('id', '<>', $id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
                if($ctc->id==$id){
                    $ctc = null;
                }
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }
        
        $rules = [
            'main_gross_salary' => ['required','regex:/^[0-9\.]*$/'],
        ];
        $messages = [
            'main_gross_salary.required' => 'Please enter the main gross salary !',
            'main_gross_salary.regex' => 'Please enter the valid main gross salary !',
        ];

        if($ctc){
            $rules['month_year'] = ['required','regex:/^[0-9\-]*$/'];
            $messages['month_year.required'] = 'Please enter the month & year !';
            $messages['month_year.regex'] = 'Please enter the valid month & year !';
        }

        $validator = $req->validate($rules,$messages);
        
        $country->ctc = $req->main_gross_salary;
        $country->user_id = $user_id;
        $result = $country->save();

        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->where('id', '<>', $id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
                if($ctc->id==$id){
                    $ctc = null;
                }
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }

        if($ctc){
            $ctc->month_year = Carbon::create($req->month_year)->lastOfMonth()->format('Y-m-d');
            $ctc->save();
        }

        if($result){
            return redirect()->intended(route('ctc_edit',[$user_id, $country->id]))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('ctc_edit',[$user_id, $country->id]))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($user_id, $id){
        $user = User::findOrFail($user_id);
        $country = Ctc::findOrFail($id);
        $country->delete();
        return redirect()->intended(route('ctc_view', $user_id))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request, $user_id) {
        $user = User::findOrFail($user_id);
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Ctc::with('User')->where('user_id', $user_id)->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10);
        }elseif ($request->has('month_year')) {
            $month_year = $request->input('month_year');
            $country = Ctc::with('User')->where('user_id', $user_id)->where(function ($query) use ($month_year) {
                $query->where('month_year', Carbon::create($month_year)->lastOfMonth()->format('Y-m-d'));
            })->paginate(10);
        }else{
            $country = Ctc::with('User')->where('user_id', $user_id)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.ctc.list')->with('country', $country)->with('user', $user);
    }

    public function display($user_id, $id) {
        $country = Ctc::findOrFail($id);
        $user = User::findOrFail($user_id);
        try {
            //code...
            $ctc_count = Ctc::where('user_id', $user_id)->count();
            if($ctc_count==1){
                $ctc = Ctc::where('user_id', $user_id)->where('id', '<>', $id)->orderBy('id', 'DESC')->limit(1)->firstOrFail();
            }elseif($ctc_count>1){
                $ctc = Ctc::where('user_id', $user_id)->orderBy('id', 'DESC')->offset(1)->limit(1)->firstOrFail();
                if($ctc->id==$id){
                    $ctc = null;
                }
            }else{
                $ctc = null;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $ctc = null;
        }
        $country = Ctc::findOrFail($id);
        return view('pages.admin.ctc.display')->with('country',$country)->with([
            'user' => $user,
            'ctc' => $ctc,
            "medical_allowance" => $this->allowance(1),
            "conveyance_allowance" => $this->allowance(2),
            "professional_tax" => $this->allowance(3),
        ]);
    }

    public function excel($user_id){
        $user = User::findOrFail($user_id);
        return Excel::download(new CtcExport($user_id), 'ctc.xlsx');
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