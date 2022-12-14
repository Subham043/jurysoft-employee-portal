<?php

namespace App\Http\Controllers\Admin\Designation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\Designation;
use App\Exports\DesignationExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DesignationController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
  
        return view('pages.admin.designation.create');
    }

    public function store(Request $req) {
        $validator = $req->validate([
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
        ],
        [
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
        ]);

        $country = new Designation;
        $country->name = $req->name;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('designation_view'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('designation_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $country = Designation::findOrFail($id);
        return view('pages.admin.designation.edit')->with('country',$country);
    }

    public function update(Request $req, $id) {
        $country = Designation::findOrFail($id);
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
        );
        $validator = $req->validate($rules,$messages);

        $country->name = $req->name;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('designation_edit',$country->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('designation_edit',$country->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $country = Designation::findOrFail($id);
        $country->delete();
        return redirect()->intended(route('designation_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Designation::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = Designation::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.designation.list')->with('country', $country);
    }

    public function display($id) {
        $country = Designation::findOrFail($id);
        return view('pages.admin.designation.display')->with('country',$country);
    }

    public function excel(){
        return Excel::download(new DesignationExport, 'designation.xlsx');
    }

}