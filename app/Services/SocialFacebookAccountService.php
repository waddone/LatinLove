<?php

namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService {
    
    public function createOrGetUser(ProviderUser $providerUser) {
        
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email'    		=> $providerUser->getEmail(),
                    'name'     		=> $providerUser->getName(),
                    'password' 		=> md5(rand(1,10000)),
                    'school_id' 	=> env('SCHOOL_ID'),
                    'source'		=> 'facebook_login',
                    'type'			=> 'client',
                    'puncte'		=> '60',
                    'profile_image' => $providerUser->getAvatar()
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}