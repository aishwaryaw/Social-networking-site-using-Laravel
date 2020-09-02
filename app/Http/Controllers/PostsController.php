<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Posts;

class PostsController extends Controller
{

    //only authenticated users can see these pages
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        //to get user ids of the all the users who are following the authenticated user
        $users = auth()->user()->following->pluck('user_id');

        //to get posts of all the users who are following the authenticated user
        $posts = Posts::whereIn('user_id', $users)->with('user')->latest()->paginate(1);

        return view('posts.index', compact('posts'));

    }


    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption'=>'required',
            'image'=>['required', 'image']
        ]);

        $imagePath =  request('image')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
        $image->save();

        auth()->user()->posts()->create( [

            'caption'=> $data['caption'],
            'image'=> $imagePath

    ]);

        return redirect('/profile/'.auth()->user()->id);
    }

    public function show(\App\Posts $post){

        //below two lines are for follow unfollow button on the post details page i.e. posts.show.blade.php page
        $self = (auth()->user()->id == $post->user->id)  ? true : false;

        $follows = auth()->user() ? auth()->user()->following->contains($post->user->profile->id) : false;


       return view('posts.show' , compact('post','self','follows'));
    }
//or

    // public function show($post){

      //  $post = Posts::findorfail($post);
    //     return view('posts.show' ,[
    //          'post'=> $post
    //      ]);
    //  }
}
