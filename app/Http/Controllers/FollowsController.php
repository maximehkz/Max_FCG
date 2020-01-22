<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //To follow someone you need to be logged in
    }


    public function store (User $user)
    {
        return auth()->user()->following()->toggle($user->profile);

    }
}
