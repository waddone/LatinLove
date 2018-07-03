<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\School;
use App\DanceClass;
use App\Course;
use App\Teacher;
use App\Level;
use App\Subscription;
use App\Booking;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    ////// daca adaugi campuri noi pentru user , trebuie sa pui in fillable si in RegisterController.php user:create
    protected $fillable = [
        'name', 'email', 'password', 'country', 'city' ,'zipcode', 'phone', 'profile_image', 'type', 'franciza', 'source', 'school_id', 'puncte','level', 'level_date', 'description', 'comments'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getProfileLevel() {

        $level = 50;
        if($this->phone != '') {
            $level = $level + 10;
        }
        if($this->city != '') {
            $level = $level + 10;
        }
        if($this->zipcode != '') {
            $level = $level + 10;
        }
        if($this->profile_image != '') {
            $level = $level + 10;
        }
        if($this->gender != '') {
            $level = $level + 10;
        }
        return $level.'%';
    }


    public function hasSchool() {
        $school = School::where('user_id','=', $this->id)->first();
        if(is_object($school )) {
            return true;
        } else {
            return false;
        }
    }


    public function returnSchoolId() {
        $school = School::where('user_id','=', $this->id)->first();
        return $school->id;
    }

    /// relationare dintre user si scoala, se optin date despre scoala userului respectiv
    /// se foloseste astfel in controlere : pentru optinearea obiectului cu care s-a facut relationarea il scoti asa :
    /// $user_logat_r->school ///// aici vei avea toate datele despre obiectul respectiv
    /// daca vrei sa optii un camp din obiectul relationat scoti asa :
    /// $this->school->name 
    /// daca se doreste relationarea dupa alta cheie se va stabili printr-un al doilea argument
    /// default cauta campul cu numele tabelei + _id  exemeplu in school cauta user_id
    /// exemeplu dupa alta cheie prestabilita de noi 
    /// return $this->hasOne('App\Phone', 'foreign_key');

    /// daca se doreste sa se faca o relationare dupa alta key inafara de id din modelul mama , se foloseste un al treilea argument 
    // return $this->hasOne('App\Phone', 'foreign_key', 'local_key');



    public function School() {
        return $this->hasOne('App\School');
    }


    public function DanceClasses() {
        return $this->hasMany('App\DanceClass');
    }

    public function DanceClassesActive() {
        return $this->hasMany('App\DanceClass')->where('active','=','yes');
    }


    public function DanceClassesCount() {
        return $this->hasMany('App\DanceClass')->where('active','=','yes')->count();
    }


    public function DanceCoursesActive() {
        return $this->hasMany('App\Course', 'school_id')->where('active','=','yes');
    }

    public function DanceCoursesCount() {

        return Course::where('school_id','=', $this->school_id )->count();

        //if()

        //return $this->hasMany('App\Course')->count();
    }

    /* nu e buna
    public function Teacher() {
        return $this->hasMany('App\Teacher');
    }
    */
    
    public function TeacherCount() {
        return $this->School->TeacherCount;
    }

    public function Subscription() {
        return $this->hasMany('App\Subscription', 'user_id')->orderBy('id', 'asc');
    }

    public function SubscriptionLast() {
        return $this->hasOne('App\Subscription', 'user_id')->orderBy('id', 'desc');
    }

    /*
    public function UserIsSubscribed() {
        if( is_object( $this->Subscription() ) ) {
            return 'yes';
        } else {
            return 'no';
        }
    }
    */

    public function avatar() {

        if($this->profile_image == '') {
            $avatar = url("/").'/resources/assets/images/noimage.png';
        } else {
            if($this->source == 'facebook_login') {
                $avatar = $this->profile_image;
            } else {
                $avatar = url('/').'/'.$this->profile_image;
            }
        }

        return $avatar;
    }


    public function CourseInfo() {
        $course_r = Course::where('id','=',$this->courses_id)->first();
        return '<span class="normalDt">'.$course_r->planName().' - '.$course_r->level().' start: '.substr($course_r->started_on,0,10).' - end: '.substr($course_r->ended_on,0,10).'</span>';
    }


    public function HasbookedThisEvent($event_id) {
        $booking_r = Booking::where('event_id','=',$event_id)->where('user_id','=',$this->id)->first();

        if(is_object($booking_r)) {
            return true;
        } else {
            return false;
        }

    }

    public function PercentagePoints() {
        $points = $this->puncte;
        $percentage =  ($points/600) * 100;
        return number_format((float)$percentage, 2, '.', '');
    }


    public function InfoAboutActiveSubscription() {
        if(sizeof($this->Subscription) >= 1) {
            foreach ($this->Subscription as $Subscription) {
                if (strtotime(date("Y-m-d H:i:s")) < strtotime($Subscription->until_when.' 00:00:00')) {
                    $course_r = Course::where('id','=',$Subscription->course_id)->first();
                    echo '<div style="font-size:14px;color:#000">Subscribed for '.$course_r->planName().', <br/><strong style="color:red;font-size:12px">until: '.$Subscription->until_when.'</strong></div><br/>';
                }
            }
        }
        // se reface astfel incat sa arate ultimul subscription per course
    }
    

}
