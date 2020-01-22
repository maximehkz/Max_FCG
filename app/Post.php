<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = []; //Tells Laravel to not guard anything,problem is here


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
