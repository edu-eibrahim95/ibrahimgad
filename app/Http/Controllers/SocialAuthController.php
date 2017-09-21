<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;



class SocialAuthController extends Controller
{
    public function redirect()
    {
    	$accessToken = 'EAAE8eff4LWwBAIibqoZA2tZAbrYSVHNZB2vsrPyZB7A5X0khHtmIhXVDpgBZAAdS6vlI6ZANQRs7lilDayNkhk6KkEjyuxCuMk0wZAfXDMxxHaZAxKetTF52x2JM01Er6b1s0dzbeR27OVrnI3kqWKSpDCBst8i3IVnlpUWQex6E0qg94vZBl8LP2ikt5SnSpIc0ZD';
        return Socialite::driver('facebook')->scopes([
            'email', 'user_managed_groups'
        ])->userFromToken($accessToken)->getGroups();   
    }   

    public function callback()
    {
        // when facebook call us a with token   
    }
}
