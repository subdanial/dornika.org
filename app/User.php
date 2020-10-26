<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Internetcode\LaravelUserSettings\Traits\HasSettingsTrait;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, HasSettingsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'username', 'avatar',
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

    // Relations
    
    /**
     * Get the clients for the user.
     */
    public function clients()
    {
        return $this->hasMany('App\Client');
    }
    
    /**
     * Get the clients for the user.
     */
    public function f_prices()
    {
        return $this->hasMany('App\FPrice');
    }

    /**
     * Get the carts for the user.
     */
    public function carts()
    {
        return $this->hasMany('App\Cart');
    }
}
