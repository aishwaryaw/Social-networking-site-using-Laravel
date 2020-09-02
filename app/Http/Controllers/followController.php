<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class followController extends Controller
{

    //used so that only authorize uer can visit the page
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store( User $user){

        //toggle is used to attach and detach the relationship between two models here it is user and profile
        return $user->profile->followers()->toggle(auth()->user());
        //return auth()->user()->following()->toggle($user->profile);

    }
}
