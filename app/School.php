<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Teacher;
use App\Event;

class School extends Model
{
    protected $table = 'schools';


    protected $fillable = [
        'user_id','name', 'country', 'city' , 'address', 'zipcode', 'phone_1', 'phone_2', 'phone_3'
    ];

    /// relationare inversa intre user si scoala
    /// return $this->belongsTo('App\User', 'foreign_key');
    /// return $this->belongsTo('App\User', 'foreign_key', 'other_key');
    /// usesage : 
    /// return $this->belongsTo('App\User')->withDefault([
    ///    'name' => 'Guest Author',
    /// ]);

    public function User() {
        return $this->belongsTo('App\User');
    }

    public function Teacher() {
        return $this->hasMany('App\Teacher');
    }



    public function Course() {
        return $this->hasMany('App\Course');
    }

    
    // se foloseste astfel $user_logat_r->School->TeacherCount()
    public function TeacherCount() {
        $c =  $this->hasMany('App\Teacher')->get();
        $x = 0;
        $ion = array();
        foreach ($c as $r) {
            $ion[] = $r->user_id;
        }

        $d = array_unique($ion);

        return count($d);
        
    }


    public function UserCount() {
        return $this->hasMany('App\User')->where('level','!=','admin')->where('level','!=','teacher')->where('level','!=','none')->where('removed','=', NULL)->count();
    }

    public function RemovedUserCount() {
        return $this->hasMany('App\User')->where('level','!=','admin')->where('level','!=','teacher')->where('level','!=','none')->where('removed','!=', NULL)->count();
    }

    public function EventCount() {
        return $this->hasMany('App\Event')->where('status','=','active')->where('date','>=',date('Y-m-d').' 00:00:00')->count();
    }

}
