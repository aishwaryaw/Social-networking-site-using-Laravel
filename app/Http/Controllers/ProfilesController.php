<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findorfail($user);

        $self = (auth()->user()->id == $user->id)  ? true : false;

        $follows = auth()->user() ? auth()->user()->following->contains($user->profile->id) : false;

        //caching
        $postsCount = Cache::remember(
            'count.posts.'.$user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->posts->count();
            });

        $followersCount = Cache::remember(
            'followers.count.'.$user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->profile->followers->count();
            }
        );

        $followingCount = Cache::remember(
            'following.count.'.$user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->following->count();
            });

        return view('profiles.index',compact('user','follows','self','postsCount','followersCount','followingCount' ));
      
    }

    public function show(User $user)
    {

        if(\Request::is('*/following'))
        {
            $users = $user->following->pluck('user_id');//return profile

            $followings = User::whereIn('id',$users)->paginate(2);//return user
         
            return view('profiles.showFollowing',compact('followings'));

        }

        else if(\Request::is('*/followers'))
        {
            $users = $user->profile->followers->pluck('id');//return user

            $followers = User::whereIn('id',$users)->paginate(2);//return user
            //$followers = Profile::whereIn('user_id,$users)->paginate(2);//return profile
            //  <img src="{{$follower->profileImage()}}"class="w-100">
            //  <span class="text-dark">{{ $follower->user->username }}</span>
         
            return view('profiles.showFollowers',compact('followers'));

        }
        
    }

    public function edit(User $user){

        
        $this->authorize('update', $user->profile);

       return view('profiles.edit', compact('user'));

    }

    public function update(User $user){

        $this->authorize('update', $user->profile); //so that any other unauthorized user can't update the profile

        $data = request()-> validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => 'image',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect('/profile/'.$user->id);
        //or return redirect("/profile/{$user->id}");
 
     }
 
}
