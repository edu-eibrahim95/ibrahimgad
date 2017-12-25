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

    public function setVideoAttribute($value)
    {
        $attribute_name = "video";
        $disk = "public";
        $destination_path = "uploads/moments/";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
