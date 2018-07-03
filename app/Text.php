<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    protected $fillable = [
        'school_id', 'text', 'uid', 'image'
    ];
   
}
