<?php
namespace Teckipro\Admin\Traits;


use Illuminate\Http\Request;

use Illuminate\Validation\Rules\Password;


/**
 * Trait SubscriptionTrait
 *
 * Reference
 */
trait PasswordRules
{

    public static function check(){
        return [
            'required',
            /*
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
                */
        ];
    }

    public static function changePassword($email,$checkPasswordHistory=false){
        return [
            'required',
            /*
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
                */
        ];
    }

    public static function register($email){
        return [
            'required',
            /*
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
                */
        ];
    }

  
  

}
