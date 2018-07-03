<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id', 'school_id', 'until_when'
    ];

    public function User() {
        return $this->belongsTo('App\User');
    }


    public function UntilWhen() {
        return $this->until_when;
    }
}
