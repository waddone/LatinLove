<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\School;
use App\Country;
use App\DanceClass;
use App\Course;
use App\Teacher;
use App\Level;
use App\Payment;
use App\Subscription;
use App\Text;
use App\Service;
use App\Plan;
use App\Event;
use App\Quote;
use App\Newsletter;

use Illuminate\Support\Facades\Auth;


class MailController extends Controller {
  
   public function TestMail(Request $request) {
        $user_logat_r   = Auth::user();
        return view('backend.test-mail', compact('user_logat_r'));
    }


   public function TestMailPost(Request $request) {
        $title = $request->input('title');
        $content = $request->input('description');

        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message)
        {

            $message->from('no.replay@latinlovedanceschool.com', 'latin');

            $message->to('adrianvasilescu@windowslive.com');

        });

        return response()->json(['message' => 'Request completed']);
    }

}