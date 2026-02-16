<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_name', 'rating', 'comment'];
    public $timestamps = true;
}
