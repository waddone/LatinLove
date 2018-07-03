<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\School;
use App\Country;
use App\DanceClass;
use App\Course;
use App\Teacher;
use App\Level;
use App\Payment;
use App\Subscription;
use App\Text;
use App\Service;
use App\Plan;
use App\Event;
use App\Quote;
use App\Blog;
use App\Newsletter;
use App\Booking;
use App\Review;
use App\Currency;
use Illuminate\Support\Facades\Mail;
//use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class MyschoolController extends Controller
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

    public function mySchool() {
        $user_logat_r   = Auth::user();
        $country_c      = Country::all();
        $school_r       = School::where('user_id','=',$user_logat_r->id)->first();
        return view('backend.my-school', compact('user_logat_r', 'country_c', 'school_r'));
    }

    public function completeSchoolDetails(Request $request) {

        $this->validate($request, [
            'name'          => 'required|max:255',
            'country'       => 'required|max:255',
            'city'          => 'required|max:100',
            'address'       => 'required|max:255',
            'zipcode'       => 'required|max:20',
            'phone_1'       => 'required|max:255',
        ]);

        //$user_logat_r       = Auth::user();
        
        $school_r = School::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'user_id'   => $request->user_id,
                'name'      => $request->name,
                'country'   => $request->country,
                'city'      => $request->city,
                'address'   => $request->address,
                'zipcode'   => $request->zipcode,
                'phone_1'   => $request->phone_1,
                'phone_2'   => $request->phone_2,
                'phone_3'   => $request->phone_3,
            ]
        );
   
        return redirect()->route('my-school');
        
    }

    public function adminAboutUs() {
        $user_logat_r   = Auth::user();
        $school_r       = School::where('user_id','=',$user_logat_r->id)->first();
        $about_r        = Text::where('uid','=','about-us')->where('school_id','=',$school_r->id)->first();
        return view('backend.admin-about-us', compact('user_logat_r', 'about_r', 'school_r'));
    }

    public function adminAboutUsPost(Request $request) {

        $this->validate($request, [
            'text'          => 'required',
        ]);

        $poza_name = 'about-us';
        
        if(!isset($request->image)) {
            $poza_path        = $request->update;
        } else {
            $extension        = $request->image->extension();
            $path             = $request->image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
        }
        

        $text_r         = Text::where('uid','=',$request->uid)->where('school_id','=',$request->school_id)->first();
        $text_r->text   = $request->text;
        $text_r->image  = $poza_path;
        $text_r->save();
        
   
        return redirect()->route('admin-about-us');
        
    }

    public function adminQuotes() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        return view('backend.admin-quotes', compact('user_logat_r','school_id'));
    }

    public function adminQuotesPost(Request $request) {

        $this->validate($request, [
            'quote'         => 'required',
            'author'        => 'required',
            'status'        => 'required'
        ]);

        if($request->update != '') {
            $quote_r         = Quote::where('id','=',$request->update)->first();
        } else {
            $quote_r         = new Quote();
        }

        $quote_r->quote     = $request->quote;
        $quote_r->author    = $request->author;
        $quote_r->school_id = $request->school_id;
        $quote_r->status    = $request->status;
        $quote_r->save();
        
   
        return redirect()->route('admin-quotes');
        
    }

    public function danceClasses() {
        $user_logat_r   = Auth::user();
        //$dance_class_c  = DanceClass::where('user_id','=',$user_logat_r->id);
        //return view('backend.dance-classes', compact('user_logat_r', 'dance_class_c'));
        return view('backend.dance-classes', compact('user_logat_r'));
    }

    public function addDanceClass(Request $request) {

        $this->validate($request, [
            'name'          => 'required|max:255',
            'user_id'       => 'required|max:255',
            'description'   => 'required',
            'active'        => 'required|max:100'
        ]);

        //$user_logat_r       = Auth::user();
        // store
        // or 
        // save
    
        if($request->update) {
            $dance_class_r              = DanceClass::where('id','=',$request->update)->first();
            $dance_class_r->user_id     = $request->user_id;
            $dance_class_r->name        = $request->name;
            $dance_class_r->description = $request->description;
            $dance_class_r->active      = $request->active;
            $dance_class_r->order_nr    = $request->order_nr;
        } else {
            $dance_class_r              = new DanceClass();
            $dance_class_r->user_id     = $request->user_id;
            $dance_class_r->name        = $request->name;
            $dance_class_r->description = $request->description;
            $dance_class_r->active      = $request->active;
            $dance_class_r->order_nr    = $request->order_nr;
        }

        $poza_name        = strtolower(str_replace(' ', '-', $request->name));
        if(!isset($request->image)) {
            $poza_path = '';
            if($request->update) {
            $poza_path = $dance_class_r->image1;
            }

        } else {
            $extension        = $request->image->extension();
            $path             = $request->image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
        }
        
        $dance_class_r->image1 = $poza_path;
        $dance_class_r->save();
        /*
        $school_r = DanceClass::updateOrCreate(
            [
                'user_id'       => $request->user_id, 
                'name'          => $request->name, 
            ],
            [
                'user_id'       => $request->user_id,
                'name'          => $request->name,
                'description'   => $request->description,
                'active'        => $request->active
            ]
        );
        */
   
        return redirect()->route('my-school-dance-classes');
        
    }

    public function services() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        //$dance_class_c  = DanceClass::where('user_id','=',$user_logat_r->id);
        //return view('backend.dance-classes', compact('user_logat_r', 'dance_class_c'));
        return view('backend.services', compact('user_logat_r', 'school_id'));
    }

    public function addServices(Request $request) {

        $this->validate($request, [
            'title'         => 'required|max:255',
            'school_id'     => 'required',
            'description'   => 'required',
            'status'        => 'required',
        ]);

        $poza_name        = strtolower(str_replace(' ', '-', $request->title));

        if($request->update) {
            $service_r              = Service::where('id','=',$request->update)->first();
            $service_r->school_id   = $request->school_id;
            $service_r->title       = $request->title;
            $service_r->description = $request->description;
            $service_r->status      = $request->status;
        } else {
            $service_r              = new Service();
            $service_r->school_id   = $request->school_id;
            $service_r->title       = $request->title;
            $service_r->description = $request->description;
            $service_r->status      = $request->status;
        }

        if(!isset($request->image)) {
            $poza_path        = '';
        } else {
            $extension        = $request->image->extension();
            $path             = $request->image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
            $service_r->image  = $poza_path;
        }

        $service_r->save();   
        return redirect()->route('admin-services');
        
    }

    public function plans() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        $currency_c     = Currency::all();
        return view('backend.plans', compact('user_logat_r', 'school_id','currency_c'));
    }

    public function addPlan(Request $request) {
        $nrOfDetails = $request->nrOfDetails;
        $this->validate($request, [
            'name'          => 'required|max:255',
            'school_id'     => 'required',
            'status'        => 'required',
            'nrOfDetails'   => 'required',
            'type'          => 'required',
            'price'         => 'required',
            'currency'      => 'required',
            'front'         => 'required',
            'position'      => 'required',
        ]);

        $details_array = array();
        
        for($i=1;$i<=$nrOfDetails;$i++) {
            $dt = 'detail'.$i;
            $details_array[] = $request->$dt;
        }

        $details = implode('|', $details_array);
    
        if($request->update) {
            $plan_r  = Plan::where('id','=',$request->update)->first();
            $plan_r->name       = $request->name;
            $plan_r->school_id  = $request->school_id;
            $plan_r->status     = $request->status;
            $plan_r->type       = $request->type;
            $plan_r->price      = $request->price;
            $plan_r->currency   = $request->currency;
            $plan_r->details    = $details;
            $plan_r->front      = $request->front;
            $plan_r->position   = $request->position;
        } else {
            $plan_r             = new Plan;
            $plan_r->name       = $request->name;
            $plan_r->school_id  = $request->school_id;
            $plan_r->status     = $request->status;
            $plan_r->type       = $request->type;
            $plan_r->price      = $request->price;
            $plan_r->currency   = $request->currency;
            $plan_r->details    = $details;
            $plan_r->front      = $request->front;
            $plan_r->position   = $request->position;
        }

        $plan_r->save();
        return redirect()->route('admin-plans');
        
    }

    public function levels() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        return view('backend.levels', compact('user_logat_r', 'school_id'));
    }

    public function addLevel(Request $request) {

        $this->validate($request, [
            'name'          => 'required|max:255',
            'school_id'     => 'required',
            'status'        => 'required',
        ]);


        if($request->update) {
            $level_r                = Level::where('id','=',$request->update)->first();
            $level_r->name          = $request->name;
            $level_r->status        = $request->status;
            $level_r->school_id     = $request->school_id;
        } else {
            $level_r                = new Level();
            $level_r->name          = $request->name;
            $level_r->status        = $request->status;
            $level_r->school_id     = $request->school_id;
        }

        $level_r->save();   
        return redirect()->route('admin-levels');

    }

    public function danceCourses() {
        $user_logat_r   = Auth::user();
        $levels         = Level::all();
        $plans          = Plan::where('status','=','active')->get();
        return view('backend.dance-courses', compact('user_logat_r','levels','plans'));
    }


    
    public function addDanceCourses(Request $request) {
        $nrOfDates = $request->nrOfDates;
        $this->validate($request, [
            'school_id'         => 'required|max:255',
            'active'            => 'required|max:255',
            //'dance_classes_id'  => 'required|max:255',
            'level_id'          => 'required',
            'plan_id'           => 'required',
            'dateRangeCourse'   => 'required'
        ]);
       
        $date = explode(' - ', $request->dateRangeCourse);
        $started_on = $date['0'];
        $ended_on   = $date['1'];

        $dates_array             = array();
        $hours_array             = array();
        for($i=1;$i<=$nrOfDates;$i++) {
            $dt = 'selectRange'.$i;
            $hr = 'selectHour'.$i;
            $dates_array[] = $request->$dt;
            $hours_array[] = $request->$hr;
        }

        $dates = implode(',', $dates_array);
        $hours = implode(',', $hours_array);


        if($request->update) {
            $course = Course::where('id','=',$request->update)->first();
            $course->school_id  = $request->school_id;
            $course->level_id   = $request->level_id;
            $course->plan_id    = $request->plan_id;
            $course->active     = $request->active;
            $course->started_on = $started_on;
            $course->ended_on   = $ended_on;
            $course->dates      = $dates;
            $course->hours      = $hours;
            $course->save();
        } else {
            $course = new Course();
            $course->school_id  = $request->school_id;
            $course->level_id   = $request->level_id;
            $course->plan_id    = $request->plan_id;
            $course->active     = $request->active;
            $course->started_on = $started_on;
            $course->ended_on   = $ended_on;
            $course->dates      = $dates;
            $course->hours      = $hours;
            $course->save();
        }
        /*
        $school_r = Course::updateOrCreate(
            [
                //'dance_classes_id'   => $request->dance_classes_id, 
                'school_id'          => $request->school_id, 
                'level_id'           => $request->level_id, 
            ],
            [
                'school_id'          => $request->school_id,
                //'dance_classes_id'   => $request->dance_classes_id,
                'level_id'           => $request->level_id,
                'active'             => $request->active,
                'started_on'         => $started_on,
                'ended_on'           => $ended_on,
                'dates'              => $dates,
                'hours'              => $hours
            ]
        );
        */
   
        return redirect()->route('my-school-dance-courses');
        
    }


    public function mySchoolTeachers() {
        $user_logat_r   = Auth::user();
        $all_users      = User::all();
        $courses        = Course::where('active','=','yes')->get();
        return view('backend.teachers', compact('user_logat_r','all_users','courses'));
    }


    public function addSchoolTeachers(Request $request) {

        $this->validate($request, [
            'school_id'         => 'required|max:255',
            'user_id'           => 'required|max:255',
            'course_id'         => 'required'
        ]);

        $user_r     = User::where('id','=',$request->user_id)->first();

        if($request->update) {
            $teacher_r  = Teacher::where('id','=',$request->update)->first();
        } else {
            $teacher_r  = new Teacher();
        }
        $teacher_r->school_id = $request->school_id;
        $teacher_r->course_id = $request->course_id;
        $teacher_r->user_id   = $request->user_id;
        $teacher_r->name      = $user_r->name;
        $teacher_r->active    = $request->active;
        $teacher_r->save();

        $user_r->level = 'teacher';
        $user_r->type  = 'teacher';
        $user_r->save();
   
        return redirect()->route('my-school-teachers');
        
    }

    public function updateTeacherProfile(Request $request) {

        $this->validate($request, [
            
            'teacher_id'        => 'required',
            'description'       => 'required'
        ]);

        $user_r              = User::where('id','=',$request->teacher_id)->first();
        $poza_name           = strtolower(str_replace(' ', '-', $user_r->name));
        $user_r->description = $request->description;
        if(!isset($request->profile_image)) {
            $poza_path        = '';
        } else {
            $extension        = $request->profile_image->extension();
            $path             = $request->profile_image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('profile_image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
            $user_r->profile_image  = $poza_path;
        }
        $user_r->save();
   
        return redirect()->route('my-school-teachers');
        
    }


    public function mySchoolStudents() {
        $user_logat_r   = Auth::user();
        $school_id      = $user_logat_r->school->id;  
        $all_users      = User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')->get();    
        $levels         = Level::all();  
        $courses        = Course::where('active','=','yes')->get();


        $country_c      = Country::all();
        return view('backend.students', compact('user_logat_r', 'all_users','levels','country_c','courses'));
    }
    public function mySchoolRemovedStudents() {
        $user_logat_r   = Auth::user();
        $school_id      = $user_logat_r->school->id;  
        $all_users      = User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')->get();    
        $levels         = Level::all();  
        $courses        = Course::where('active','=','yes')->get();


        $country_c      = Country::all();
        return view('backend.removed-students', compact('user_logat_r', 'all_users','levels','country_c','courses'));
    }

    public function addSchoolStudent(Request $request) {

        $this->validate($request, [
            'school_id'         => 'required|max:255',
            'user_id'           => 'required',
            'course_id'         => 'required',
            'payment_type'      => 'required',
            'starting_from'     => 'required',
            'until_when'        => 'required'
        ]);

        $user          = User::where('id','=',$request->user_id)->first();
        $course_r      = Course::where('id','=',$request->course_id)->first();

        if($user->Subscription()->exists() ) { 
    
            $subscribe_r              = new Subscription();
            $subscribe_r->user_id     = $request->user_id;
            $subscribe_r->school_id   = $request->school_id;
            $subscribe_r->course_id   = $request->course_id;
            
            if($request->until_when == '1d') { 
                $until_when = date("Y-m-d", strtotime("+1 day",  strtotime($request->starting_from)));
                $user->puncte = $user->puncte + 9;   
                $amount = 9;  
            }
            if($request->until_when == '1m') { 
                $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from)));
                $user->puncte = $user->puncte + $course_r->GetPlanPoints();
                $amount = $course_r->GetPlanPoints(); 
            }
            if($request->until_when == '2m') { 
                $until_when = date("Y-m-d", strtotime("+2 months", strtotime($request->starting_from)));
                $user->puncte = $user->puncte + ($course_r->GetPlanPoints() * 2); 
                $amount = $course_r->GetPlanPoints() * 2;
            }
            if($request->until_when == '3m') { 
                $until_when = date("Y-m-d", strtotime("+3 months", strtotime($request->starting_from)));
                $user->puncte = $user->puncte + ($course_r->GetPlanPoints() * 3); 
                $amount = $course_r->GetPlanPoints() * 3;
            }

            $subscribe_r->until_when  = $until_when;
            $user->level              = $course_r->level();
            $user->level_date         = date("Y-m-d H:i:s", strtotime($request->starting_from));
            $user->courses_id         = $request->course_id;

        } else {
            $subscribe_r              = new Subscription();
            $subscribe_r->user_id     = $request->user_id;
            $subscribe_r->school_id   = $request->school_id;
            echo $subscribe_r->course_id   = $request->course_id;
            echo '<hr>';

            if($request->until_when == '1d') { 
                $until_when = date("Y-m-d", strtotime("+1 day",  strtotime($request->starting_from)));
                $user->puncte = 69;   
                $amount = 9;  
            }
            if($request->until_when == '1m') { 
                $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from)));
                $user->puncte = 60 + $course_r->GetPlanPoints(); 
                $amount = $course_r->GetPlanPoints(); 
            }
            if($request->until_when == '2m') { 
                $until_when = date("Y-m-d", strtotime("+2 months", strtotime($request->starting_from)));
                $user->puncte = 60 + ($course_r->GetPlanPoints() * 2); 
                $amount = $course_r->GetPlanPoints() * 2;
            }
            if($request->until_when == '3m') { 
                $until_when = date("Y-m-d", strtotime("+3 months", strtotime($request->starting_from)));
                $user->puncte = 60 + ($course_r->GetPlanPoints() * 3); 
                $amount = $course_r->GetPlanPoints() * 3;
            }

            $subscribe_r->until_when  = $until_when;
            $user->level              = $course_r->level();
            $user->level_date         = date("Y-m-d H:i:s", strtotime($request->starting_from));
            $user->courses_id         = $request->course_id;
        }
        $subscribe_r->status      = 'active';
        $subscribe_r->save();
        $user->save();
        $payment_r              = new Payment();
        $payment_r->user_id     = $request->user_id;
        $payment_r->school_id   = $request->school_id;
        $payment_r->type        = 'cash';
        $payment_r->amount      = $amount;
        $payment_r->payment_for    = 'subscription';
        $payment_r->payment_for_id = $subscribe_r->id;
        $payment_r->status      = 'active';
        $payment_r->details     = 'user payed his subscription on '.date("Y-m-d H:i:s").' for courses starting '.date("Y-m-d",strtotime($request->starting_from)).' until '.$until_when;
        $payment_r->date        = date("Y-m-d H:i:s");
        $payment_r->save();
   
        return redirect()->route('my-school-students');
        
    }

    public function addSchoolStudentNoAccount(Request $request) {

        $this->validate($request, [
            'user_name'         => 'required',
            'user_email'        => 'required',
            'user_phone'        => 'required',
            'country'           => 'required',
            'city'              => 'required',
            'gender'            => 'required',
            'zipcode'           => 'required',
            'school_id'         => 'required|max:255',
            'course_id'         => 'required',
            'payment_type'      => 'required',
            'starting_from'     => 'required'
        ]);

        $user                   = new User();
        $course_r               = Course::where('id','=',$request->course_id)->first();


        $user->name             = $request->user_name;
        $user->email            = $request->user_email;
        $user->phone            = $request->user_phone;
        $user->gender           = $request->gender;
        $user->country          = $request->country;
        $user->city             = $request->city;
        $user->zipcode          = $request->zipcode;
        $user->school_id        = $request->school_id;
        $user->level            = $course_r->level();
        $user->courses_id       = $request->course_id;
        $user->level_date       = date("Y-m-d H:i:s", strtotime($request->starting_from));
        $user->type             = 'none';
        $user->profile_image    = '';
        $user->franciza         = '';
        $user->source           = '';
        
        if($request->until_when == '1d') { 
                $until_when = date("Y-m-d", strtotime("+1 day",  strtotime($request->starting_from)));
                $user->puncte = 69;   
                $amount       = 9;  
            }
            if($request->until_when == '1m') { 
                $until_when = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from)));
                $user->puncte = 60 + $course_r->GetPlanPoints(); 
                $amount       = $course_r->GetPlanPoints(); 
            }
            if($request->until_when == '2m') { 
                $until_when = date("Y-m-d", strtotime("+2 months", strtotime($request->starting_from)));
                $user->puncte = 60 + ($course_r->GetPlanPoints() * 2); 
                $amount       = $course_r->GetPlanPoints() * 2;
            }
            if($request->until_when == '3m') { 
                $until_when = date("Y-m-d", strtotime("+3 months", strtotime($request->starting_from)));
                $user->puncte = 60 + ($course_r->GetPlanPoints() * 3); 
                $amount       = $course_r->GetPlanPoints() * 3;
            }

        $user->save();

        $subscribe_r              = new Subscription();
        $subscribe_r->user_id     = $user->id;
        $subscribe_r->course_id   = $request->course_id;
        $subscribe_r->school_id   = $request->school_id;
        $subscribe_r->until_when  = $until_when;  
        $subscribe_r->status      = 'active';  
        $subscribe_r->save();
        $payment_r              = new Payment();
        $payment_r->user_id     = $user->id;
        $payment_r->school_id   = $request->school_id;
        $payment_r->type        = 'cash';
        $payment_r->amount      = $amount;
        $payment_r->payment_for    = 'subscription';
        $payment_r->payment_for_id = $subscribe_r->id;
        $payment_r->status      = 'active';
        $payment_r->details     = 'user payed his subscription on '.date("Y-m-d H:i:s").' for courses starting '.date("Y-m-d",strtotime($request->starting_from)).' until '.$until_when;
        $payment_r->date        = date("Y-m-d H:i:s");
        $payment_r->save();
   
        return redirect()->route('my-school-students');
        
    }

    public function editSchoolStudent(Request $request) {

        $this->validate($request, [
            'user_name'         => 'required',
            'user_id'           => 'required',
            'user_email'        => 'required',
            'country'           => 'required',
            'gender'            => 'required',
            'school_id'         => 'required',
            'course_id'         => 'required'
        ]);

        $user             = User::where('id','=',$request->user_id)->first();
        $user->name       = $request->user_name;
        $user->email      = $request->user_email;
        $user->phone      = $request->user_phone;
        $user->country    = $request->country;
        $user->city       = $request->city;
        $user->zipcode    = $request->zipcode;
        $user->gender     = $request->gender;
        $user->school_id  = $request->school_id;
        $user->courses_id = $request->course_id;
        $user->save();
        return redirect()->route('my-school-students');
        
    }

    public function editSchoolStudentComments(Request $request) {

        $this->validate($request, [
            
            'user_id'           => 'required',

        ]);

        $user             = User::where('id','=',$request->user_id)->first();
        $user->comments   = $request->comments;
        $user->save();
        return redirect()->route('my-school-students');
        
    }

    public function updateStudentPayment(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required',
            'school_id'         => 'required',
            'starting_from'     => 'required',
            'course_id'         => 'required'
        ]);
        $user     = User::where('id','=',$request->user_id)->first();
        $course_r = Course::where('id','=',$request->course_id)->first();
        $activate_first_month_payment = 'nu';
        if($course_r->id == 1) {
            if($user->Subscription()->exists() ) { 
                $activate_first_month_payment = 'nu';
            } else {
                $activate_first_month_payment = 'da';
            }
        }
        

        if($request->until_when == '1d') { 
            $until_when     = date("Y-m-d", strtotime("+1 day",    strtotime($request->starting_from))); 
            $user->puncte   = $user->puncte + 9;   
            $amount         = 9;
        }
        if($request->until_when == '1m') { 
            $until_when     = date("Y-m-d", strtotime("+1 month",  strtotime($request->starting_from))); 
            $user->puncte   = $user->puncte + $course_r->GetPlanPoints();  
            $amount         = $course_r->GetPlanPoints(); 
            if($activate_first_month_payment == 'da') {
                $amount       = $amount - 20;
                $user->puncte = $user->puncte - 20;  
            } 
        }
        if($request->until_when == '2m') { 
            $until_when     = date("Y-m-d", strtotime("+2 months", strtotime($request->starting_from))); 
            $user->puncte   = $user->puncte + ($course_r->GetPlanPoints() * 2);  
            $amount         = $course_r->GetPlanPoints() * 2;
            if($activate_first_month_payment == 'da') {
                $amount       = $amount - 20;
                $user->puncte = $user->puncte - 20;  
            } 
        }
        if($request->until_when == '3m') { 
            $until_when     = date("Y-m-d", strtotime("+3 months", strtotime($request->starting_from))); 
            $user->puncte   = $user->puncte + ($course_r->GetPlanPoints() * 3);  
            $amount         = $course_r->GetPlanPoints() * 3;
            if($activate_first_month_payment == 'da') {
                $amount       = $amount - 20;
                $user->puncte = $user->puncte - 20;  
            } 
        }
        $user->level  = $course_r->level();
        $user->save();
        $subscribe_r              = new Subscription();
        $subscribe_r->user_id     = $user->id;
        $subscribe_r->school_id   = $request->school_id;
        $subscribe_r->until_when  = $until_when;    
        $subscribe_r->course_id   = $course_r->id;  
        $subscribe_r->status      = 'active';  
        $subscribe_r->save();
        $payment_r              = new Payment();
        $payment_r->user_id     = $request->user_id;
        $payment_r->school_id   = $request->school_id;
        $payment_r->type        = 'cash';
        $payment_r->amount      = $amount;
        $payment_r->currency    = config('app.currency');
        $payment_r->reference_nr = 'SUBSCRIPTION'.$course_r->id.'USER'.$request->user_id.'DATE'.date('Y-m-d');
        $payment_r->payment_for    = 'subscription';
        $payment_r->payment_for_id = $subscribe_r->id;
        $payment_r->status      = 'active';
        $payment_r->details     = 'user payed his subscription on '.date("Y-m-d H:i:s").' for courses starting '.date("Y-m-d",strtotime($request->starting_from)).' until '.$until_when;
        $payment_r->date        = date("Y-m-d H:i:s");
        $payment_r->save();
        
        return redirect()->route('my-school-students');
        
    }

    public function updateStudentPoints(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required',
            'puncte'            => 'required'
        ]);
        $user     = User::where('id','=',$request->user_id)->first();
        $user->puncte  = $request->puncte;
        $user->save();
        
        return redirect()->route('my-school-students');
        
    }

    public function removeStudent(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required'
        ]);
        $user          = User::where('id','=',$request->user_id)->first();
        $user->removed = 'yes';
        $user->save();
        
        return redirect()->route('my-school-students');
        
    }

    public function activateStudent(Request $request) {
        
        $this->validate($request, [
            'user_id'           => 'required'
        ]);
        $user          = User::where('id','=',$request->user_id)->first();
        $user->removed = NULL;
        $user->save();
        
        return redirect()->route('my-school-students');
        
    }

    public function mySchoolUsers() {
        $user_logat_r   = Auth::user();
        //if($user_logat_r->hasSchool() == true) {
        //    $school_id  = $user_logat_r->returnSchoolId();
        //}
        $school_id      = $user_logat_r->school->id;
        //$students_c     = User::where('school_id','=',$school_id)->get();
        
        return view('backend.users', compact('user_logat_r'));
    }

    public function mySchoolEvents() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');  
        $currency_c     = Currency::all();     
        return view('backend.events', compact('user_logat_r', 'school_id','currency_c'));
    }
    
    public function addEvents(Request $request) {

        $this->validate($request, [
            'school_id'         => 'required',
            'status'            => 'required',
            'title'             => 'required',
            'description'       => 'required',
            'place'             => 'required',
            'date'              => 'required',
            'hour'              => 'required'
        ]);

        $date = date("Y-m-d", strtotime($request->date));

        $free = $request->free;
        if($free == 'on') {
            $payment = 'free';
        } else {
            $payment  = 'all';
        }
    
        if($request->update) {
            $event_r                = Event::where('id','=',$request->update)->first();
            $event_r->school_id     = $request->school_id;
            $event_r->status        = $request->status; 
            $event_r->title         = $request->title; 
            $event_r->description   = $request->description; 
            $event_r->place         = $request->place; 
            $event_r->date          = $date; 
            $event_r->hour          = $request->hour;  
            $event_r->payment       = $payment; 
            $event_r->price         = $request->price; 
            $event_r->currency      = $request->currency;  
        } else {
            $event_r                = new Event();
            $event_r->school_id     = $request->school_id;
            $event_r->status        = $request->status; 
            $event_r->title         = $request->title; 
            $event_r->description   = $request->description; 
            $event_r->place         = $request->place; 
            $event_r->date          = $date; 
            $event_r->hour          = $request->hour; 
            $event_r->payment       = $payment; 
            $event_r->price         = $request->price; 
            $event_r->currency      = $request->currency;  
        }

        $poza_name        = strtolower(str_replace(' ', '-', $request->title));
        
        if(!isset($request->image)) {
            $poza_path        = '';
        } else {
            $extension        = $request->image->extension();
            $path             = $request->image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
            $event_r->image   = $poza_path;
        }
        
        $event_r->save();   
        return redirect()->route('my-school-events');
        
    }

    public function mySchoolPayments() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        
        return view('backend.payments', compact('user_logat_r'));
    }

    public function adminNewsletter() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        $course_c       = Course::where('school_id','=',$school_id)->where('active','=','yes')->get();

        return view('backend.newsletter', compact('user_logat_r','school_id','course_c'));
    }


    public function adminNewsletterPost(Request $request) {

        $this->validate($request, [
            'school_id'         => 'required',
            'list'              => 'required',
            'title'             => 'required',
            'description'       => 'required'
        ]);

        $school_id  = $request->school_id;
        $title      = $request->title;
        $content    = $request->description;
        $list       = $request->list;

        if($list == 'all') {
            $all_users_c1  = array();
            $all_users_c2  = array();
            $newsletter_c = Newsletter::where('school_id','=',$school_id)->where('status','=','active')->get();
            $user_c       = User::where('school_id','=',$school_id)->get();

            foreach ($newsletter_c as $newsletter_r) {
                $all_users_c1[] = $newsletter_r->email;                
            }

            foreach ($user_c as $user_r) {
                $all_users_c2[] = $user_r->email;
            }

            $users_mail_c = array_unique(array_merge($all_users_c1, $all_users_c2));
        }

        if($list == 'all-assigned') {
            $users_mail_c = array();
            $user_c       = User::where('school_id','=',$school_id)->where('courses_id','!=','0')->get();
            foreach ($user_c as $user_r) {
                $users_mail_c[] = $user_r->email;
            }
        }

        if($list == 'newsletter') {
            $users_mail_c = array();
            $newsletter_c = Newsletter::where('school_id','=',$school_id)->where('status','=','active')->get();
            foreach ($newsletter_c as $newsletter_r) {
                $users_mail_c[] = $newsletter_r->email;
            }
        }

        if(is_numeric($list)) {
            $users_mail_c = array();
            $user_c       = User::where('school_id','=',$school_id)->where('courses_id','=',$list)->get();
            foreach ($user_c as $user_r) {
                $users_mail_c[] = $user_r->email;
            }
        }
               
        Mail::send('emails.newsletter', ['title' => $title, 'content' => $content], function ($message) {
            $message->from('no.replay@latinlovedanceschool.com', 'Newsletter - LatinLoveDanceSchool');

            foreach ($users_mail_c as $users_mail_r) {
                $message->to($users_mail_r)->subject('Newsletter from LatinLoveDanceSchool');
            }

        });

        \Session::flash('flash_message','You have successfully send your contact details.');
     
        return redirect()->route('admin-newsletter');

    }


    public function blog() {
        $user_logat_r   = Auth::user();
        //$blog_c         = Blog::where('active','=','yes')->get();
        return view('backend.blog', compact('user_logat_r'));
    }

    public function addBlogArticle(Request $request) {

        $this->validate($request, [
            'title'         => 'required|max:255',
            'user_id'       => 'required|max:255',
            'school_id'     => 'required',
            'description'   => 'required',
            'active'        => 'required|max:100'
        ]);

    
        if($request->update) {
            $blog_r              = Blog::where('id','=',$request->update)->first();
            $blog_r->user_id     = $request->user_id;
            $blog_r->title       = $request->title;
            $blog_r->description = $request->description;
            $blog_r->school_id   = $request->school_id;
            $blog_r->active      = $request->active;
        } else {
            $blog_r              = new Blog();
            $blog_r->user_id     = $request->user_id;
            $blog_r->title       = $request->title;
            $blog_r->description = $request->description;
            $blog_r->school_id   = $request->school_id;
            $blog_r->active      = $request->active;
        }

        $poza_name        = strtolower(str_replace(' ', '-', $request->title));
        if(!isset($request->image)) {
            $poza_path = '';
            if($request->update) {
            $poza_path = $blog_r->image1;
            }

        } else {
            $extension        = $request->image->extension();
            $path             = $request->image->path();
            $poza_path        = 'resources/assets/uploads/'.$poza_name.'.'.$extension;
            $request->file('image')->move('resources/assets/uploads', $poza_name.'.'.$extension);
        }
        
        $blog_r->image1 = $poza_path;
        $blog_r->save();
       
        return redirect()->route('admin-blog');
        
    }

    public function reviews() {
        $user_logat_r   = Auth::user();
        $school_id      = config('app.school_id');
        $review_c       = Review::where('status','=','active')->where('school_id','=',$school_id)->get();
        return view('backend.reviews', compact('user_logat_r','review_c'));
    }

    public function addReview(Request $request) {

        $this->validate($request, [
            'post'          => 'required',
            'school_id'     => 'required',
            'status'        => 'required'
        ]);

        $post = str_replace('data-width="500"', 'data-width=""', $request->post);

        if($request->update) {
            $review_r              = Review::where('id','=',$request->update)->first();
            $review_r->post        = $post;
            $review_r->school_id   = $request->school_id;
            $review_r->status      = $request->status;
        } else {
            $review_r              = new Review();
            $review_r->post        = $post;
            $review_r->school_id   = $request->school_id;
            $review_r->status      = $request->status;
        }

        $review_r->save();
       
        return redirect()->route('admin-reviews');
        
    }
    

    public function activatePayment(Request $request) {

        $this->validate($request, [
            'payment_id'          => 'required'
        ]);

        $payment_r              = Payment::where('id','=',$request->payment_id)->first();

        if($payment_r->payment_for == 'subscription') {
            $subscription_r    = Subscription::where('id','=',$payment_r->subscription_id)->first();
            $subscription_r->status = 'active';
            $subscription_r->save();
        } 
        if($payment_r->payment_for == 'event') {
            $booking_r  = Booking::where('event_id','=',$payment_r->payment_for_id)->where('user_id','=',$payment_r->user_id)->where('payment_status','!=','active')->first();
            $booking_r->payment_status = 'active';
            $booking_r->save();
        } 

        $payment_r->status      = 'active';
        $payment_r->save();
        $subscription_r         = Subscription::where('id','=',$payment_r->subscription_id)->first();
        $subscription_r->status = 'active';
        $subscription_r->save();
        $user_r                 = User::where('id','=',$payment_r->user_id)->first();
        $user_r->puncte         = $user_r->puncte + $payment_r->points;
        $user_r->save();
   
        return redirect()->route('my-school-payments');
        
    }
    

}
