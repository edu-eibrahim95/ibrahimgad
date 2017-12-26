<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Moment extends Model
{
    use CrudTrait;
    protected $table = 'moments';
    protected $fillable = ['title', 'caption', 'video'];
    public $timestamps = true;


}
