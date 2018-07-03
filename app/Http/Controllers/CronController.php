<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Subscription;



class CronController extends Controller {
  
   public function updateUserStatus(){
        
        $user_c = User::all(); 
        foreach ($user_c as $user_r) {
            
            $subscription_r = Subscription::where('user_id','=',$user_r->id)->orderBy('id', 'desc')->first();

            if(!is_object($subscription_r)) {
                    $user_r->status = 'unsubscribed';
            } else {
                if( strtotime(date('Y-m-d H:i:s')) > strtotime($subscription_r->until_when) ) {
                    $user_r->status = 'unsubscribed';
                } else {
                    $user_r->status = 'subscribed';
                }
            }

            $user_r->save();

            echo 'done, user: '.$user_r->name.' is:'.$user_r->status.'<br/>';

        }
    }

}