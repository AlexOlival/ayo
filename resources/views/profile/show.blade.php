@extends('layouts.app')

@section('content')
    <div class="container mx-auto flex flex-col justify-center items-center h-full mt-10">
        <img class="h-96 w-96 rounded-full border-8 border-peachy-pink" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
        <p class="text-4xl mt-6"> {{ auth()->user()->username }}</p>
        <p class="text-grey-dark text-xl mt-6"> {{ auth()->user()->email }}</p>
        <a class="button button-logout no-underline mt-10" href="{{ route('home') }}">Back</a>
    </div>
@endsection