<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'streetAddress', 'address2', 'city',
        'state', 'zipCode', 'jobTitle', 'company', 'reason', 'phoneNumber', 'can_contact', 'countryCode', 'is_admin',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function formatPhoneNumber()
    {
        $new = strval($this->phoneNumber);
        $phone = ' ';
        $count = 0;
        for($i = 0; $i < 10; $i++){
            $phone .= $new[$i];
            if(($i+1) % 3 == 0 && $count < 2){
                $phone .= '-';
                $count++;
            }
        }

        return $phone;
    }

}
