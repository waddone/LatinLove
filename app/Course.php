<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\School;
use App\DanceClass;
use App\Course;
use App\Teacher;
use App\Level;
use App\Plan;
use App\Subscription;

class Course extends Model {
    protected $table = 'courses';

    protected $fillable = [
        'dance_classes_id', 'school_id', 'level_id', 'started_on', 'ended_on', 'active', 'dates', 'hours'
    ];

    public function DanceClassName() {
        //$object = DanceClass::where('id','=', $this->dance_classes_id)->first();
        $object = Level::where('id','=', $this->level_id)->first();
        return $this->name;
    }

    public function PlanName() {
        //$object = DanceClass::where('id','=', $this->dance_classes_id)->first();
        $object = Plan::where('id','=', $this->plan_id)->first();
        return $object->name;
    }

    public function GetPlanPoints() {
        //$object = DanceClass::where('id','=', $this->dance_classes_id)->first();
        $object = Plan::where('id','=', $this->plan_id)->first();
        return $object->price;
    }

    public function GetPlanCurrency() {
        //$object = DanceClass::where('id','=', $this->dance_classes_id)->first();
        $object = Plan::where('id','=', $this->plan_id)->first();
        return $object->currency;
    }
    
    public function Level() {
        $object =  Level::where('id','=', $this->level_id)->first();
        return $object->name;
    }

    public function NumberOfSubscribedUsers() { 

    	return $nr_of_subscribed_users = Subscription::whereDate('until_when', '>', date("Y-m-d H:i:s"))
                                                ->where('status','=','active')
                                                ->where('course_id','=',$this->id)
                                                ->count();
    }

    public function NameOfSubscribedUsers() { 

        $sub_c = Subscription::whereDate('until_when', '>', date("Y-m-d H:i:s"))
                                                ->where('status','=','active')
                                                ->where('course_id','=',$this->id)
                                                ->get();
        $html = 'Students list for this course:<br/>';
        foreach ($sub_c as $sub_r) {
            $use_r = User::where('id','=',$sub_r->user_id)->first();
            $html .= $use_r->name.'<br/>';
        }
        return $html;
    }


    public function PlanCosts() { 
        $object = Plan::where('id','=', $this->plan_id)->first();
        return $object->price.' '.$object->currency;
    }

    public function Currency() { 
        $object = Plan::where('id','=', $this->plan_id)->first();
        return $object->currency;
    }

    public function Teacher() { 
        $object = Teacher::where('course_id','=', $this->id)->groupBy('user_id')->first();
        return $object->name;
    }

}
