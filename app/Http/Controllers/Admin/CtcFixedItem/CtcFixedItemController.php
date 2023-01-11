<?php

namespace App\Http\Controllers\Admin\CtcFixedItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\CtcFixedItem;
use Illuminate\Support\Facades\Validator;

class CtcFixedItemController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function medical_allowance_create() {
        try {
            //code...
            $ctcFixedItem = CtcFixedItem::findOrFail(1);
        } catch (\Throwable $th) {
            //throw $th;
            $ctcFixedItem = null;
        }
  
        return view('pages.admin.ctc_fixed_item.medical_allowance_create')->with([
            "ctcFixedItem" => $ctcFixedItem,
        ]);
    }

    public function medical_allowance_store(Request $req) {
        $rules = [
            'amount' => ['required','regex:/^[0-9\.]*$/'],
        ];
        $messages = [
            'amount.required' => 'Please enter the medical allowances amount !',
            'amount.regex' => 'Please enter the valid medical allowances amount !',
        ];
        $validator = $req->validate($rules,$messages);

        $ctcFixedItem = CtcFixedItem::updateOrCreate(['id'=>1],['amount'=>$req->amount]);

        if($ctcFixedItem){
            return redirect()->intended(route('medical_allowance_create'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('medical_allowance_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }
    
    public function conveyance_allowance_create() {
        try {
            //code...
            $ctcFixedItem = CtcFixedItem::findOrFail(2);
        } catch (\Throwable $th) {
            //throw $th;
            $ctcFixedItem = null;
        }
  
        return view('pages.admin.ctc_fixed_item.conveyance_allowance_create')->with([
            "ctcFixedItem" => $ctcFixedItem,
        ]);
    }

    public function conveyance_allowance_store(Request $req) {
        $rules = [
            'amount' => ['required','regex:/^[0-9\.]*$/'],
        ];
        $messages = [
            'amount.required' => 'Please enter the conveyance allowances amount !',
            'amount.regex' => 'Please enter the valid conveyance allowances amount !',
        ];
        $validator = $req->validate($rules,$messages);

        $ctcFixedItem = CtcFixedItem::updateOrCreate(['id'=>2],['amount'=>$req->amount]);

        if($ctcFixedItem){
            return redirect()->intended(route('conveyance_allowance_create'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('conveyance_allowance_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }
    
    public function professional_tax_create() {
        try {
            //code...
            $ctcFixedItem = CtcFixedItem::findOrFail(3);
        } catch (\Throwable $th) {
            //throw $th;
            $ctcFixedItem = null;
        }
  
        return view('pages.admin.ctc_fixed_item.professional_tax_create')->with([
            "ctcFixedItem" => $ctcFixedItem,
        ]);
    }

    public function professional_tax_store(Request $req) {
        $rules = [
            'amount' => ['required','regex:/^[0-9\.]*$/'],
        ];
        $messages = [
            'amount.required' => 'Please enter the professional tax amount !',
            'amount.regex' => 'Please enter the valid professional tax amount !',
        ];
        $validator = $req->validate($rules,$messages);

        $ctcFixedItem = CtcFixedItem::updateOrCreate(['id'=>3],['amount'=>$req->amount]);

        if($ctcFixedItem){
            return redirect()->intended(route('professional_tax_create'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('professional_tax_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

}