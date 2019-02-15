@extends('layouts.app')

@section('content')
<div class="flex py-10 px-16 h-screen lg:justify-start sm:justify-center">
    <div class="flex flex-col justify-center bg-white max-w-xs rounded overflow-hidden shadow-lg px-6 py-6">
        <img class="w-32" src="/img/ayo-04.svg" alt="Ayo">
        <div class=" py-4">
            <div class="homepage-card-text lg:text-xl sm:text-base">
                <p>Ayo helps you organize your time with mindful reminders, it's really simple.</p>
                <p>You gotta try it dawg!</p>
            </div>
        </div>
        <div class=" py-4">
            <button class="w-full button-pink lg:py-5 sm:py-3" @click="$modal.show('register-modal')">
                Get Started
            </button>

            <button class="w-full button-white mt-6 lg:py-5 sm:py-3" @click="$modal.show('login-modal')">
                Login
            </button>
        </div>
    </div>
</div>
@endsection