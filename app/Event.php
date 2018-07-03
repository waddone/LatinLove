<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';


    public function EventInProgres() {

    	$eventDate = date(substr($this->date, 0,10).' '.$this->hour.':00');

    	if(strtotime(date('Y-m-d H:i:s')) >= strtotime($eventDate) ) {
    		return false;
    	} else {
    		return true;
    	}
    }

}
