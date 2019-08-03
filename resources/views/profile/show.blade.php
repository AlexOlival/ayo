@extends('layouts.app')

@section('content')
    <div class="container mx-auto flex flex-col justify-center items-center h-full mt-10">
        <profile-picture></profile-picture>
        <p class="text-3xl sm:text-4xl mt-6"> {{ auth()->user()->username }}</p>
        <p class="text-grey-dark text-xl sm:text-xl mt-6"> {{ auth()->user()->email }}</p>
        <a class="button button-logout no-underline mt-10" href="{{ route('home') }}">Back</a>
    </div>
@endsection
