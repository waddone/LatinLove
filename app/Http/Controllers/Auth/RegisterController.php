<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected $redirectTo = '/account/define-account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    //return view('account',compact('user')); 
    //daca vrei sa adaugi chestii in formular care option din db dai search dypa registersUsers din vendor // acolo ie indexul
    // 

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'country'   => 'required|max:255',
            'school_id' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'country'           => $data['country'],
            'city'              => '',
            'zipcode'           => '',
            'profile_image'     => '',
            'school_id'         => $data['school_id'],
            'phone'             => '',
            'type'              => 'client',
            'puncte'            => '60',
            'status'            => 'unsubscribed',
            'level'             => 'beginner',
            'level_data'        => date("Y-m-d H:i:s"),
            'franciza'          => '', 
            'source'            => '',


        ]);
    }
}
