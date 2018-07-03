<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\School;
use App\Country;
use App\DanceClass;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class TestController extends Controller
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

  
    public function hasOne() {


        $user_logat_r   = Auth::user();
        /*
        echo '<pre>';
            print_r($user_logat_r);
        echo '</pre>';
        */
        //$user_logat_r     = User::where('id','=','8');
        echo '<pre>';
            print_r($user_logat_r->school->name);
        echo '</pre>';

    }

     public function hasMany() {
        $user_logat_r   = Auth::user();
        /*
        echo '<pre>';
            print_r($user_logat_r->DanceClasses);
        echo '</pre>';
        */
        foreach ($user_logat_r->DanceClasses as $userDanceClasses_r) {
            echo $userDanceClasses_r->name;
            echo '<br/>';
        }
    }
    

}
