<?php

namespace App\Http\Controllers;
use App\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index ()

    {
        $users=auth()->user()->following()->pluck('profiles.user_id');

        $posts=Post::whereIn('user_id',$users)->latest()->paginate(5);

        return view ('posts.index', compact('posts'));
    }

    public function __construct()
    {
        $this->middleware('auth'); //A user must be logged in, in order to post a picture
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
       $data= request()->validate(
           [
               'caption' => 'required',
               'title' => 'required',
               'image' =>    ['required', 'image'],

            ]);

//       dd($data);

        $imagePath = \request('image')->store('uploads','public');

        $image= Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
           'caption' => $data['caption'],
           'title' => $data['title'],
           'image' => $imagePath,
        ]);

        return redirect('/profile/'.auth()->user()->id);
    }


    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }

}
