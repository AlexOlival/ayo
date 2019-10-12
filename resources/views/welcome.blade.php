@extends('layouts.app')

@section('content')
    <div class="flex flex-row py-8 px-8 md:py-16 md:px-16 h-screen justify-center md:justify-start">
        <div class="flex flex-col justify-center bg-white max-w-xs rounded-lg overflow-hidden shadow-lg px-12 py-6">
            <img class="w-32 text-black" src="/img/ayo-04.svg" alt="Ayo">
            <div class=" py-4">
                <div class="homepage-card-text text-sm">
                    <p>Ayo helps you organize your time with mindful reminders. It's a breeze.</p>
                </div>
            </div>
            <div class=" py-4">
                <button class="w-full rounded-lg px-8 py-4 bg-peachy-pink text-white font-bold lg:py-5 sm:py-3" @click="$modal.show('register-modal')">
                    Get Started
                </button>

                <button class="w-full rounded-lg px-8 py-4 bg-grey-lighter text-black font-bold lg:py-5 mt-3 sm:py-3" @click="$modal.show('login-modal')">
                    Login
                </button>
            </div>
        </div>
    </div>

    @include('modals.login-modal')
    @include('modals.register-modal')
@endsection
