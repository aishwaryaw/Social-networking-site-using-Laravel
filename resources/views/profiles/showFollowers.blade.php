@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($followers as $follower)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $follower->id }}">
                    <img src="{{ $follower->profile->profileImage() }}" class="w-100">
                   
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $follower->id }}">
                            <span class="text-dark">{{ $follower->username }}</span>

                        </a>
                    </span>
                    </p>
                </div>
            </div>
        </div>
    @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $followers->links() }}
            </div>
        </div>
</div>
@endsection