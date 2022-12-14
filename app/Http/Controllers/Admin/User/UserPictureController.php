<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Models\EmployeePicture;
use Illuminate\Support\Facades\Validator;
use Storage;
use Uuid;

class UserPictureController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function picture_display($employee_id) {
        $user = User::findOrFail($employee_id);
        
        try {
            $employeePicture = EmployeePicture::where('employee_id', $employee_id)->first();
        } catch (\Throwable $th) {
            $employeePicture = null;
        }

        return view('pages.admin.user.picture')->with([
            "user" => $user,
            "employeePicture" => $employeePicture,
        ]);
    }

    public function picture_save(Request $req, $employee_id) {
        $employee = User::findOrFail($employee_id);

        $rules = [
            'image' => ['required','image','mimes:jpeg,png,jpg,webp'],
        ];
        $messages = [
            'image.image' => 'Please enter a valid image !',
            'image.mimes' => 'Please enter a valid image !',
        ];
        $validator = $req->validate($rules,$messages);

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();

            $req->image->storeAs('public/upload/images',$newImage);
            $employeePicture = EmployeePicture::updateOrCreate(
                ['employee_id' => $employee_id],
                ['images' => $newImage]
            );
            if($employeePicture){
                return redirect()->intended(route('subadmin_picture_display', $employee_id))->with('success_status', 'Data Stored successfully.');
            }else{
                return redirect()->intended(route('subadmin_picture_display', $employee_id))->with('error_status', 'Something went wrong. Please try again');
            }
        }

    }

}