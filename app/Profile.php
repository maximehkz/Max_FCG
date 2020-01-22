<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded = []; //This is disabling mass assignment

    public function profileImage()
    {
        $imagePath=($this->image) ? $this->image: 'profile/G2BEyzM1YadlXga5z8nvf2RUpilZldA7LUASdTRy.png';
        return  '/storage/'.$imagePath;
    }

    public function followers ()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }


}


