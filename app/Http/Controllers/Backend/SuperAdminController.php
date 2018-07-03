<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Franchise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class SuperAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('auth')->except(['danceClasses', 'events', 'aboutUs','franchise', 'contact']);
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function superAdminFirstPage() {
        $user_logat_r   = Auth::user();
        $user_c         = User::all();
        $franchise_c    = Franchise::all();
        return view('backend.admin-first-page', compact('user_c','franchise_c','user_logat_r'));
    }


    public function superAdminFranchise() {
        $user_logat_r         = Auth::user();
        $user_c               = User::all();
        $franchise_c          = Franchise::all();
        $franchise_location_c = Franchise::where('active', 'yes')->groupBy('city')->get();
        //$franchise_location_c = DB::table('franchises')->where('active', 'yes')->groupBy('city')->get();

        
                                                
        return view('backend.admin-franchise', compact('user_c','franchise_c','user_logat_r','franchise_location_c'));
    }

}
