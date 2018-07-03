<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Country;

class Booking extends Model {
    protected $table = 'bookings';


    public function userName() {
    	$user_r = User::where('id','=',$this->user_id)->first();
    	return $user_r->name;
    }

    public function userEmail() {
    	$user_r = User::where('id','=',$this->user_id)->first();
    	return $user_r->email;
    }

}
