<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    protected $attributes = ['access_token' => NULL];
    protected $fillable = ['facebook_id', 'access_token'];
}
