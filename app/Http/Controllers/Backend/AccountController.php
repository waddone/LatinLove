<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Country;
use App\Subscription;
use App\Booking;
use App\Event;
use App\Course;
use App\DanceClass;
use App\Payment;
use App\Friend;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
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

    public function showResetForm(Request $request, $token = null) {
        $user_logat_r   = Auth::user();
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'user_logat_r' => $user_logat_r]
        );
    }

    public function showResetFormAccount(Request $request, $token = null) {
        $user_logat_r   = Auth::user();
        return view('auth.passwords.reset2')->with(
            ['token' => $token, 'email' => $request->email, 'user_logat_r' => $user_logat_r]
        );
    }

    public function defineAccount() {
        $user_logat_r   = Auth::user();
        $country_c      = Country::all();
        return view('backend.define-account', compact('country_c','user_logat_r'));
    }

    public function account() {
        
        $user_logat_r           = Auth::user();
        $school_id              = config('app.school_id');
        $events_c               = Event::where('school_id','=',$school_id)->whereDate('date', '>', date("Y-m-d H:i:s"))->get();
        $events_count           = Event::where('school_id','=',$school_id)->whereDate('date', '>', date("Y-m-d H:i:s"))->count();
        $students_count         = User::where('school_id','=',$school_id)
                                        ->where('courses_id', '!=','0')
                                        ->where('type', '!=','admin')
                                        ->where('type', '!=','superadmin')
                                        ->where('type', '!=','teacher')
                                        ->count();
        $students_count_no_sub  = User::where('school_id','=',$school_id)->where('courses_id', '=','0')->where('type', '!=','admin')->where('type', '!=','superadmin')->where('type', '!=','teacher')->count();
        $dance_groups_count     = Course::where('school_id','=',$school_id)->where('active', '=','yes')->count();
        $dance_classes_c        = DanceClass::where('school_id','=',$school_id)->where('active', '=','yes')->get();
        $dance_groups_c         = Course::where('school_id','=',$school_id)->where('active', '=','yes')->get();
        $students_c             = User::where('school_id','=',$school_id)->where('courses_id', '!=','0')->skip(0)->take(6)->get();
        $all_subscribed_users   = Subscription::whereDate('until_when', '>', date("Y-m-d H:i:s"))->where('status','=','active')->count();

        $female_count          = User::where('school_id','=',$school_id)->where('courses_id', '!=','0')->where('type', '!=','admin')->where('type', '!=','superadmin')->where('type', '!=','teacher')->where('gender', '=','female')->count();
        $male_count          = User::where('school_id','=',$school_id)->where('courses_id', '!=','0')->where('type', '!=','admin')->where('type', '!=','superadmin')->where('type', '!=','teacher')->where('gender', '=','male')->count();

        $start = new Carbon('first day of this month');
        $end   = new Carbon('last day of this month');

        $payment_this_month_r   = Payment::where('status','=','active')
                                            ->whereBetween('date', array($start, $end))
                                            ->sum('amount');

        return view('backend.account', compact('user_logat_r','events_c','events_count','students_count','students_count_no_sub','dance_groups_count','dance_classes_c','dance_groups_c','students_c','all_subscribed_users','payment_this_month_r','male_count','female_count' ));

    }

    public function completeProfile(Request $request) {

        $this->validate($request, [
            'name'          => 'required|max:255',
            'country'       => 'required|max:255',
            'gender'        => 'required'
        ]);

        $poza_name        = strtolower(str_replace(' ', '-', $request->name));

        $user_r                 = Auth::user();
        $user_r->name           = $request->name;
        $user_r->phone          = $request->phone;
        $user_r->country        = $request->country;
        $user_r->city           = $request->city;
        $user_r->zipcode        = $request->zipcode;
        $user_r->gender         = $request->gender;
        if(!isset($request->profile_image)) {
            $poza_path        = '';
        } else {
            $extension        = $request->profile_image->extension();
            $path             = $request->profile_image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('profile_image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
            $user_r->profile_image  = $poza_path;
        }


        $user_r->puncte = '60';
        $user_r->save();

        if($user_r->getProfileLevel() == '100%') {
            return redirect()->route('account');
        } else {
            return redirect()->route('define-account');
        }
        
    }

    public function joinCourses() {
        $user_logat_r   = Auth::user();
        $course_c       = Course::where('active','=','yes')->get();
        return view('backend.join-courses', compact('user_logat_r','course_c'));
    }
    
    public function joinEvents() {
        $user_logat_r   = Auth::user();
        //$events_c       = Event::where('status','=','active')
        //                        ->where('school_id','=',$school_id)
        //                        ->whereDate('date', '>', Carbon::yesterday('Europe/London') )
        //                        ->orderBy('id')
        //                        ->orderBy('id', 'asc')                                
        //                        ->get();

        return view('backend.join-events', compact('user_logat_r','events_c'));
    }

    public function earnPoints() {
        $user_logat_r   = Auth::user();
        return view('backend.earn-points', compact('user_logat_r'));
    }

    public function howItWorks() {
        $user_logat_r   = Auth::user();
        return view('backend.how-it-works', compact('user_logat_r'));
    }

    public function earnByReferral() {
        $user_logat_r   = Auth::user();
        return view('backend.earn-by-referral', compact('user_logat_r'));
    }

    public function addFriend(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'name'              => 'required',
            'status'            => 'required',
            'email'             => 'required'
        ]);

        $friend_r = Friend::where('email', '=', $request->email)->first();
        if(is_object($friend_r)) {
            \Session::flash('flash_message','The persone with this email is already register in our sistem.');
            return redirect()->route('earn-by-referral');
        } else {
            $frien_r             = new Friend();
            $frien_r->user_id    = $request->user_id;
            $frien_r->school_id  = $request->school_id;
            $frien_r->name       = $request->name; 
            $frien_r->status     = $request->status;
            $frien_r->email      = $request->email;
            $frien_r->save();

            \Session::flash('flash_message','Your friend is now register in our sistem, now you can send him a invitation.');
            return redirect()->route('earn-by-referral');
        }    
    }
    

    public function subscribe() {
        $user_logat_r   = Auth::user();
        return view('backend.subscribe', compact('user_logat_r'));
    }

    public function claimPrize() {
        $user_logat_r   = Auth::user();
        return view('backend.claim-prize', compact('user_logat_r'));
    }


    public function subscribePost(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'until_when'        => 'required',
            'starting_from'     => 'required' 
        ]);

        $user_logat_r                 = Auth::user();

        if($request->until_when == 1) { $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from))); }
        if($request->until_when == 2) { $until_when = date("Y-m-d", strtotime("+2 months", strtotime($request->starting_from))); }
        if($request->until_when == 3) { $until_when = date("Y-m-d", strtotime("+3 months", strtotime($request->starting_from))); }

        if($user_logat_r->Subscription()->exists() ) { 
            $subscribe_r              = Subscription::where('user_id','=',$request->user_id)->first();
            $subscribe_r->user_id     = $request->user_id;
            $subscribe_r->school_id   = $request->school_id;
            $subscribe_r->until_when  = $until_when;
            //$subscribe_r->first_time  = 'no';
            //$user_logat_r->puncte     = $user_logat_r->puncte + 60;
            if($request->until_when == 1) { $user_logat_r->puncte = $user_logat_r->puncte + 60;  }
            if($request->until_when == 2) { $user_logat_r->puncte = $user_logat_r->puncte + 120; }
            if($request->until_when == 3) { $user_logat_r->puncte = $user_logat_r->puncte + 180; }
        } else {
            $subscribe_r              = new Subscription();
            $subscribe_r->user_id     = $request->user_id;
            $subscribe_r->school_id   = $request->school_id;
            $subscribe_r->until_when  = $until_when;
            //$subscribe_r->first_time  = 'yes';
            //$user_logat_r->puncte     = 40;

            if($request->until_when == 1) { $user_logat_r->puncte = $user_logat_r->puncte + 40;  }
            if($request->until_when == 2) { $user_logat_r->puncte = $user_logat_r->puncte + 100; }
            if($request->until_when == 3) { $user_logat_r->puncte = $user_logat_r->puncte + 160; }
        }
        
        $subscribe_r->save();
        $user_logat_r->save();
        return redirect()->route('account');
        
    }


    public function addEventBooking(Request $request) {
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'payment'           => 'required',
            'event_id'          => 'required' 
        ]);

        $booking_r   = new Booking();
        $booking_r->user_id     = $request->user_id; 
        $booking_r->school_id   = $request->school_id;
        $booking_r->event_id    = $request->event_id;
        $booking_r->payment     = $request->payment;
        
        $event_r  = Event::where('id','=',$request->event_id)->first();
        $points   = 0;
        if($event_r->price == 'free') {
            $points = 0;
        } else {
            $points    = $event_r->price;
        }

        if($request->payment == 'cash') {
            $booking_r->payment_status  = 'inactive';

            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $payment_r->amount    = $event_r->price;
            $payment_r->currency  = $event_r->currency;
            $payment_r->status    = 'pending';
            $payment_r->type      = 'cash';
            $payment_r->date      = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'event';
            $payment_r->payment_for_id  = $event_r->id;
            $payment_r->subscription_id = $event_r->id;
            $payment_r->points          = $event_r->price;
            $payment_r->reference_nr = 'E'.$event_r->id.'U'.$request->user_id.'D'.date('Y-m-d');
            $payment_r->save();
        }
        if($request->payment == 'bank') {
            $booking_r->payment_status  = 'inactive';

            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $payment_r->amount    = $event_r->price;
            $payment_r->currency  = $event_r->currency;
            $payment_r->status    = 'pending';
            $payment_r->type      = 'bank';
            $payment_r->date      = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'event';
            $payment_r->payment_for_id  = $event_r->id;
            $payment_r->subscription_id = $event_r->id;
            $payment_r->points          = $event_r->price;
            $payment_r->reference_nr = 'E'.$event_r->id.'U'.$request->user_id.'D'.date('Y-m-d');
            $payment_r->save();
        }
        if($request->payment == 'paypall') {

            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $payment_r->amount    = $event_r->price;
            $payment_r->currency  = $event_r->currency;
            $payment_r->status    = 'active';
            $payment_r->type      = 'paypall';
            $payment_r->date      = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'event';
            $payment_r->payment_for_id  = $event_r->id;
            $payment_r->subscription_id = $event_r->id;
            $payment_r->points          = $event_r->price;
            $payment_r->reference_nr = 'EVENT'.$event_r->id.'USER'.$request->user_id.'DATE'.date('Y-m-d');
            $payment_r->save();

            $user_r   = User::where('id','=',$request->user_id)->first();
            $user_r->puncte = $user_r->puncte + $event_r->price;
            $user_r->save();
           
        }

        $booking_r->save();

        return redirect()->route('account');
    }

    public function aproveEventBooking(Request $request) {
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'event_id'          => 'required',
            'booking_id'        => 'required'
        ]);

        $booking_r   = Booking::where('id','=',$request->booking_id)
                                ->where('user_id','=',$request->user_id)
                                ->where('event_id','=',$request->event_id)
                                ->first();
        $booking_r->user_id     = $request->user_id; 
        $booking_r->school_id   = $request->school_id;
        $booking_r->event_id    = $request->event_id;
        $booking_r->payment_status  = 'active';
       
        $event_r  = Event::where('id','=',$request->event_id)->first();
        $points   = $event_r->price;
        $user_r   = User::where('id','=',$request->user_id)->first();
        $user_r->puncte = $user_r->puncte + $points;
        $user_r->save();
        $booking_r->save();

        $payment_r = Payment::where('payment_for','=','event')->where('payment_for_id','=',$request->event_id)->where('status','=','pending')->where('user_id','=',$request->user_id)->first();
        $payment_r->status = 'active';
        $payment_r->save();

        return redirect()->route('my-school-events');
    }

    public function bookNowCourse(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'course_id'         => 'required',
            'starting_from'     => 'required',
            'until_when'        => 'required',
            'payment_type'      => 'required'            
        ]);
     
        $user_logat_r = User::where('id','=',$request->user_id)->first();
        
        if($request->payment_type == 'bank') {
            
            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $course_r  = Course::where('id','=',$request->course_id)->first();
            $amount = '';
            $until_when = '';    

            if($request->until_when == '1d') { 
                $until_when = date("Y-m-d", strtotime("+1 day",  strtotime($request->starting_from)));
                $amount = 9;   
            }
            if($request->until_when == '1m') { 
                $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints();  
            }
            if($request->until_when == '2m') { 
                $until_when = date("Y-m-d", strtotime("+2 months",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints() * 2; 
            }
            if($request->until_when == '3m') { 
                $until_when = date("Y-m-d", strtotime("+3 months",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints() * 3; 
            }

            $payment_r->amount          = $amount;
            $payment_r->currency        = $course_r->GetPlanCurrency();
            $payment_r->status          = 'pending';
            $payment_r->type            = 'bank';
            $payment_r->date            = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'subscription'; 
            $payment_r->payment_for_id  = $course_r->id;
            $payment_r->reference_nr    = 'S'.$request->course_id.'U'.$request->user_id.'D'.date('Y-m-d');

            $subscription_r              = new Subscription();
            $subscription_r->user_id     = $request->user_id;
            $subscription_r->school_id   = $request->school_id;
            $subscription_r->course_id   = $request->course_id;
            $subscription_r->until_when  = $until_when;
            $subscription_r->first_time  = 'no';
            $subscription_r->status      = 'pending';

            $subscription_r->save();
            $payment_r->subscription_id  = $subscription_r->id;
            $payment_r->points           = $amount;
            $payment_r->save();
            // se verifica da ii dau din payment , dea active subscription sa dea active paymentul si sa-i bage punctele omului
            // se pune pending in datatable la join-curse
            return redirect()->route('account-join-courses');
        }
        if($request->payment_type == 'paypall') {

            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $course_r  = Course::where('id','=',$request->course_id)->first();
            $amount = '';
            $until_when = '';
            if($request->until_when == '1d') { 
                $until_when = date("Y-m-d", strtotime("+1 day",  strtotime($request->starting_from)));
                $amount = 9;   
            }
            if($request->until_when == '1m') { 
                $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints();  
            }
            if($request->until_when == '2m') { 
                $until_when = date("Y-m-d", strtotime("+2 months",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints() * 2; 
            }
            if($request->until_when == '3m') { 
                $until_when = date("Y-m-d", strtotime("+3 months",  strtotime($request->starting_from)));
                $amount = $course_r->GetPlanPoints() * 3; 
            }

            $payment_r->amount          = $amount;
            $payment_r->currency        = $course_r->GetPlanCurrency();
            $payment_r->status          = 'active';
            $payment_r->type            = 'paypall';
            $payment_r->date            = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'subscription'; 
            $payment_r->payment_for_id  = $course_r->id;
            $payment_r->reference_nr    = 'S'.$request->course_id.'U'.$request->user_id.'D'.date('Y-m-d');

            $subscription_r              = new Subscription();
            $subscription_r->user_id     = $request->user_id;
            $subscription_r->school_id   = $request->school_id;
            $subscription_r->course_id   = $request->course_id;
            $subscription_r->until_when  = $until_when;
            $subscription_r->first_time  = 'no';
            $subscription_r->status      = 'active';

            $subscription_r->save();
            $payment_r->subscription_id  = $subscription_r->id;
            $payment_r->points           = $amount;
            $payment_r->save();
            $user_logat_r->puncte        = $user_logat_r->puncte + $amount;
            $user_logat_r->save();


            // se verifica da ii dau din payment , dea active subscription sa dea active paymentul si sa-i bage punctele omului
            // se pune pending in datatable la join-curse
            return redirect()->route('account-join-courses');
        }
        if($request->payment_type == 'points') {
        
            $payment_r = new Payment();
            $payment_r->school_id = $request->school_id;
            $payment_r->user_id   = $request->user_id;
            $course_r  = Course::where('id','=',$request->course_id)->first();   
            $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from))); 
            $payment_r->amount          = $course_r->GetPlanPoints();  
            $payment_r->currency        = $course_r->GetPlanCurrency();
            $payment_r->status          = 'active';
            $payment_r->type            = 'points';
            $payment_r->date            = date('Y-m-d H:i:s');
            $payment_r->payment_for     = 'subscription'; 
            $payment_r->payment_for_id  = $course_r->id;
            $payment_r->reference_nr    = 'S'.$request->course_id.'U'.$request->user_id.'D'.date('Y-m-d');

            $subscription_r              = Subscription::where('course_id','=',$request->course_id)->where('user_id','=',$request->user_id)->orderBy('id', 'desc')->first();
            $subscription_r->until_when  = $until_when;
            $subscription_r->first_time  = 'no';
            $subscription_r->status      = 'active';
            $subscription_r->save();
            $payment_r->subscription_id  = $subscription_r->id;
            $payment_r->points           = $course_r->GetPlanPoints();
            $payment_r->save();
            $user_logat_r->puncte        = $user_logat_r->puncte - 600;
            $user_logat_r->save();
            // se verifica da ii dau din payment , dea active subscription sa dea active paymentul si sa-i bage punctele omului
            // se pune pending in datatable la join-curse
            return redirect()->route('account-join-courses');
        }


        exit();
        echo 'final';

        
    }


    public static function CourseInfoIdAc($course_idxxx) {
        
        $course_r = Course::where('id','=',$course_idxxx)->first();  
         
        return '<span class="normalDt">'.$course_r->planName().' - '.$course_r->level().' start: '.substr($course_r->started_on,0,10).' - end: '.substr($course_r->ended_on,0,10).'</span>';

    }
    

    public function sendInvitation(Request $request) {

        $this->validate($request, [
            'friend_id'         => 'required',
            'title'             => 'required',
            'description'       => 'required'
        ]);

        $friend_r   = Friend::where('id','=',$request->friend_id)->first();
        $title      = $request->title;
        $content    = $request->description;
        $user_name  = User::where('id','=',$friend_r->user_id)->first(); 
        
        Mail::send('emails.invitation', 
                    [
                    'title'     => $title, 
                    'content'   => $content, 
                    'name'      => $friend_r->name, 
                    'user_name' => $user_name->name
                    ], function ($message) use ($friend_r, $user_name) {

                    $message->from('no.replay@latinlovedanceschool.com', 'Invitation - LatinLoveDanceSchool');
                    $message->to($friend_r->email)->subject('Invitation from '.$user_name->name); 
        });

        $friend_r->status = 'sended';
        $friend_r->save();

        \Session::flash('flash_message','You have successfully send your invitation.');
     
        return redirect()->route('earn-by-referral');

    }

    public function addPointsReferrer(Request $request) {

        $this->validate($request, [
            'friend_id'         => 'required',
            'user_id'           => 'required',
            'points'            => 'required'
        ]);

        $friend_r               = Friend::where('id','=',$request->friend_id)->first();
        $friend_r->referrer     = 'success';
        $friend_r->save();

        $user_logat_r           = Auth::user();
        $user_logat_r->puncte   = $user_logat_r->puncte + $request->points;
        $user_logat_r->save();

        \Session::flash('flash_message','You have successfully add your points.');
     
        return redirect()->route('earn-by-referral');

    }

}
