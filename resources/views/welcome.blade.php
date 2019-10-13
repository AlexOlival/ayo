@extends('layouts.app')

@section('content')
    <div class="flex flex-row py-8 px-8 md:py-16 md:px-16 h-screen justify-center md:justify-start">
        <div class="flex flex-col justify-center max-w-xs overflow-hidden px-8 lg:ml-32">
            <img class="w-24 self-center" src="/img/ayo-04.svg" alt="Ayo">
            <div class="py-4">
                <div class="tracking-normal leading-normal text-white text-md text-center">
                    <p>Ayo helps you organize your time with mindful reminders. It's a breeze.</p>
                </div>
            </div>
            <div class="py-4">
                <button class="w-full rounded-lg px-8 py-3 sm:py-3 lg:py-3 bg-white text-peachy-pink font-bold shadow" @click="$modal.show('register-modal')">
                    Get Started
                </button>

                <p class="mt-8 text-white text-md">
                    Already have an account? <a href="#" class="font-bold text-white" @click="$modal.show('login-modal')">Login</a>
                </p>
            </div>
        </div>
    </div>

    @include('modals.login-modal')
    @include('modals.register-modal')
@endsection
