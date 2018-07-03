<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DanceClass;
use App\Plan;
use App\Quote;
use App\Event;
use App\Review;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['index','underConstruction']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function underConstruction() {
        return view('frontend.underConstruction');
    }



    public function index(){
        $school_id      = config('app.school_id');
        $danceClasses_c = DanceClass::where('active','=','yes')->orderBy('order_nr', 'asc')->get();
        $plan_front_c   = Plan::where('status','=','active')->where('front','=','yes')->get();
        $quote_c        = Quote::where('status','=','active')->where('school_id','=',$school_id)->get();
        $events_c       = Event::where('status','=','active')
                                ->where('school_id','=',$school_id)
                                ->whereDate('date', '>', Carbon::yesterday('Europe/London') )
                                ->orderBy('id')
                                ->orderBy('id', 'asc')
                                ->skip('0')
                                ->take('2')
                                ->get();

        $dateS = Carbon::now()->startOfMonth();
        $dateE = Carbon::now()->endOfMonth(); 
        $ev_this_month_c = Event::where('status','=','active')
                                ->where('school_id','=',$school_id)
                                ->whereBetween('date',[$dateS,$dateE])
                                ->get();

        $nr_of_details  = array();
        $nr_of_details2 = array();
        foreach ($plan_front_c as $plan_front_r) {
            $nr_xx_ex        = explode('|', $plan_front_r->details);
            $nr_of_details[] = count($nr_xx_ex);
        }
        $max_nr         = max($nr_of_details);
        $plan_nofront_c = Plan::where('status','=','active')->where('front','=','no')->get();
        foreach ($plan_nofront_c as $plan_nofront_r) {
            $nr_xx_ex2        = explode('|', $plan_nofront_r->details);
            $nr_of_details2[] = count($nr_xx_ex2);
        }
        $max_nr2        = max($nr_of_details2);
        $review_c       = Review::where('status','=','active')->where('school_id','=',$school_id)->skip('0')
                                ->take('3')->get();
        return view('frontend.welcome', compact('danceClasses_c','plan_front_c','plan_nofront_c','max_nr','max_nr2','quote_c','events_c','ev_this_month_c','review_c'));
    }

	//public function home(Request $request){
	//	return view('frontend.home');
	//}

    // load login and register
    //public function ajaxLoad(Request $request){

    public function ajaxLoad($what){
        return view('frontend.ajaxLoad');        
    }
}
