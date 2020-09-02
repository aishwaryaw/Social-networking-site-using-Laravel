@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($followings as $following)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $following->id }}">
                    <img src="{{ $following->profile->profileImage() }}" class="w-100">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $following->id }}">
                            <span class="text-dark">{{ $following->username }}</span>
                        </a>
                    </span>
                    </p>
                </div>
            </div>
        </div>
    @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $followings->links() }}
            </div>
        </div>
</div>
@endsection