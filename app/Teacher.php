<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\School;
use App\Course;

class Teacher extends Model
{
    protected $table = 'teachers';


    protected $fillable = [
        'user_id','school_id','course_id','name','active'
    ];


    public function User() {
    	return $this->belongsTo('App\User');
    }


    public function School() {
    	return $this->belongsTo('App\School');
    }


    public function Description() {
        $user_r = User::where('id','=',$this->user_id)->first();
        return $user_r->description;
    }


    public function ProfileImg() {
        $user_r = User::where('id','=',$this->user_id)->first();
        return $user_r->profile_image;
    }

    public function Name() {
        $user_r = User::where('id','=',$this->user_id)->first();
        return $user_r->name;
    }

    public function danceClAssesIn() { 
        $div = '';
        $teachers_c = self::where('user_id','=',$this->user_id)->get();
        foreach ($teachers_c as $teachers_r) {
            $course_r = Course::where('id','=',$teachers_r->course_id)->first();
            $div .= $course_r->PlanName().'<span class="hidden-xs"> - '.$course_r->Level().' - start: '.substr($course_r->started_on, 0, 10).' - end: '.substr($course_r->ended_on, 0, 10).'</span><br>';
        }
        return $div;
    }

    
}
