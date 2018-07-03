<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DanceClass extends Model
{
    protected $table = 'dance_classes';


    protected $fillable = [
        'name', 'description', 'user_id', 'active', 'order_nr'
    ];

}
