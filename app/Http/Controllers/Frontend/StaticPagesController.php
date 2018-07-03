<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DanceClass;
use App\Text;
use App\Service;
use App\Event;
use App\Course;
use App\Blog;
use App\Contact;
use App\Teacher;
use App\Review;
use App\Newsletter;
// for email
use Illuminate\Support\Facades\Mail;
//use App\Mail\ContactMail;

class StaticPagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['danceClasses', 'events', 'eventsName', 'aboutUs','franchise', 'contact', 'danceClassName','storecontact','servicesName', 'services', 'timetable', 'blog', 'blogArticle', 'teachers', 'teachersName', 'reviews' ]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function danceClasses(){
        $danceClasses_c = DanceClass::where('active','=','yes')->orderBy('order_nr', 'asc')->get(); 
        return view('frontend.dance-classes', compact('danceClasses_c'));
    }

    public function danceClassName($name){
        $name = strtolower(str_replace('-', ' ', $name));
        $danceClass_r = DanceClass::where('active','=','yes')->where('name','=',$name)->first(); 
        return view('frontend.dance-class-name', compact('danceClass_r'));
    }

    public function blog(){
        $bloc_article_c = Blog::where('active','=','yes')->get(); 
        return view('frontend.blog', compact('bloc_article_c'));
    }

    public function blogArticle($name){
        $name = strtolower(str_replace('-', ' ', $name));
        $bloc_article_r = Blog::where('active','=','yes')->where('title','=',$name)->first(); 
        return view('frontend.blog-article', compact('bloc_article_r'));
    }

    public function events(){
        $school_id  = config('app.school_id');
        $events_c   = Event::where('school_id','=',$school_id)->get();
        return view('frontend.events', compact('events_c','school_id'));
    }

    public function eventsName($name){
        $name       = strtolower(str_replace('-', ' ', $name));
        $event_r    = Event::where('title','=',$name)->first(); 
        return view('frontend.event-name', compact('event_r'));
    }

    public function aboutUs(){
        $school_id  = config('app.school_id');
        $about_r    = Text::where('school_id','=', $school_id)->where('uid','=','about-us')->first();
        return view('frontend.about-us', compact('about_r'));
    }

    public function timetable(){
        $school_id  = config('app.school_id');
        $courses_c  = Course::where('school_id','=', $school_id)->get();
        return view('frontend.timetable', compact('courses_c'));
    }

    public function franchise(){
        return view('frontend.franchise');
    }

    public function services(){
        $school_id  = config('app.school_id');
        $service_c  = Service::where('school_id','=',$school_id)->where('status','=','active')->get();

        return view('frontend.services', compact('service_c'));
    }

    public function servicesName($name){
        $name      = strtolower(str_replace('-', ' ', $name));
        $service_r = Service::where('title','=',$name)->first(); 
        return view('frontend.service-name', compact('service_r'));
    }

    public function teachers(){
        $school_id  = config('app.school_id');
        $teacher_c  = Teacher::where('school_id','=',$school_id)->where('active','=','yes')->groupBy('user_id')->get();

        return view('frontend.teachers', compact('teacher_c'));
    }

    public function teachersName($name){
        $name      = strtolower(str_replace('-', ' ', $name));
        $teacher_r = Teacher::where('name','=',$name)->first();
        $course_array = array();
        $teacher_c = Teacher::where('name','=',$name)->get();
        foreach ($teacher_c as $teacher_p) {
            $course_array[] = $teacher_p->course_id;
        }
        $course_c  = Course::whereIn('id', $course_array)->get(); 
        return view('frontend.teacher-name', compact('teacher_r','course_c'));
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function storecontact(Request $request) {   
        
        $this->validate($request, [
            'name'          => 'required|max:255',
            'email'         => 'required',
            'description'   => 'required',
            'phone'         => 'required'
            
        ]);
        
        $contact                = new Contact;
        $contact->name          = $request->name;
        $contact->email         = $request->email;
        $contact->phone         = $request->phone;
        $contact->description   = $request->description;
        $contact->save(); 
            
        \Session::flash('flash_message','You have successfully send your contact details.');
     
        Mail::send('emails.new-contact', ['name' => $contact->name, 'email' => $contact->email, 'phone' => $contact->phone, 'description' => $contact->description ], function ($message) {
            $message->from('no.replay@latinlovedanceschool.com', 'LatinLove - new mail');
            $message->to('office@latinlovedanceschool.com')->subject('New mail via contact form');

        });


        return redirect()->route('contact');
    }

    
    public function storeNewsletter(Request $request) {   
        
        $this->validate($request, [
            'email'         => 'required'
        ]);

        $newsletter_r           = Newsletter::where('email','=',$request->email)->first();
        if(is_object($newsletter_r )) {
            \Session::flash('flash_message','You are already subscribed to our newsletter.');
        } else {
            $newsletter_r           = new Newsletter;
            $newsletter_r->email    = $request->email;
            $newsletter_r->status   = 'active';
            $newsletter_r->save(); 
            \Session::flash('flash_message','You have successfully subscribed to our newsletter.');
        }

        return redirect()->route('home');
    }


    public function reviews(){
        $school_id  = config('app.school_id');
        $review_c   = Review::where('status','=','active')->where('school_id','=',$school_id)->get();

        return view('frontend.reviews', compact('review_c'));
    }



}
