<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount= Cache::remember(
            'count.posts.' .$user->id,
            now()->addSeconds(30),
            function  () use ($user)  {
                return $user->posts->count(); //callback
        });


        $followersCount=Cache::remember(
            'count.followers.' .$user->id,
            now()->addSeconds(30),
            function  () use ($user)  {
                return  $user -> profile-> followers-> count(); //callback
            });



        $followingCount=Cache::remember(
            'count.following.' .$user->id,
            now()->addSeconds(30),
            function  () use ($user)  {
                return $user -> following-> count(); //callback
            });
        //dd($follows);

        return view('profiles.index', compact('user','follows','postCount','followersCount','followingCount'));
    }

    public function edit(User  $user)
    {
        $this ->authorize('update', $user->profile);
        return view('profiles.edit',compact ('user'));
    }


    public function update(User $user)

    {

        $this ->authorize('update', $user->profile);

        $data= \request()->validate(
        [
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',

        ]);

        if (request ('image'))
        {
            $imagePath= request('image')->store('profile', 'public');

            $image = Image :: make(public_path("storage/{$imagePath}"))->fit(1000,1000);
            $image->save();
            $imageArray= ['image'=> $imagePath ]; //It is going continue an image but only if the image is requested
        }

        auth()->user()->profile->update(array_merge
        (
            $data,
            $imageArray ?? [] //The empty array will not override anything in the data
        ));


        return redirect("/profile/{$user->id}");
    }
}
 //array merge takes any number of array and appends them together.
