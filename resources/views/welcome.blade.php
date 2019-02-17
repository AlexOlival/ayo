@extends('layouts.app')

@section('content')
<div class="flex flex-row py-8 px-8 md:py-16 md:px-16 h-screen justify-center md:justify-start">
    <div class="flex flex-col justify-center bg-white max-w-xs rounded-sm overflow-hidden shadow-lg px-12 py-6">
        <img class="w-32 text-black" src="/img/ayo-04.svg" alt="Ayo">
        <div class=" py-4">
            <div class="homepage-card-text text-sm">
                <p>Ayo helps you organize your time with mindful reminders, it's really simple.</p>
                <p>You gotta try it dawg!</p>
            </div>
        </div>
        <div class=" py-4">
            <button class="w-full button button-pink lg:py-5 sm:py-3" @click="$modal.show('register-modal')">
                Get Started
            </button>

            <button class="w-full button button-white lg:py-5 mt-3 sm:py-3" @click="$modal.show('login-modal')">
                Login
            </button>
        </div>
    </div>
</div>
@endsection