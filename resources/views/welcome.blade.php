@extends('layouts.app')

@section('content')
    <div class="flex py-10 px-16 h-screen lg:justify-start sm:justify-center">
        <div class="homepage-card lg:min-w-96 sm:min-w-1/2">
            <div>
                <img class="lg:w-32 sm:w-24" src="/img/ayo-04.svg" alt="Ayo">
            </div>

            <div class="homepage-card-text lg:text-xl sm:text-base lg:mt-16 sm:mt-8">
                <p>Ayo helps you organize your time with mindful reminders, it's really simple.</p>
                <p>You gotta try it dawg!</p>
            </div>

            <div class="flex-col lg:pt-16 sm:pt-8">
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
