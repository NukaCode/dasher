<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use NukaCode\Users\Models\User as BaseUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseUser implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, SoftDeletes;
}
