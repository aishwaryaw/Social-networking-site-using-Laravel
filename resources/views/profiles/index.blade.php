@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4">{{ $user->username }}</div>     
                </div>

                @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan

            </div>

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{$postsCount}} posts</strong></div>
                <div class="pr-5">
                <a style="text-decoration:none" href="/profile/{{  $user->id }}/followers">
                <span class="text-dark"><strong>{{$followersCount}} followers</strong></span>
                </a>
                </div>
                <div class="pr-5">
                <a style="text-decoration:none" href="/profile/{{ $user->id }}/following">
                <span class="text-dark"><strong>{{$followingCount}} following</strong></span>
                </a>
                </div>
                <follow-button-component user-id="{{ $user->id }}" follows="{{$follows}}" self="{{$self}}"></follow-button-component>
            </div>


            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
