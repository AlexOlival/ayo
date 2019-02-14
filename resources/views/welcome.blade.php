@extends('layouts.app')

@section('content')
    <div class="flex py-10 px-16 h-screen">
        <div class="bg-white rounded-lg shadow w-1/4 flex-col py-20 px-16 h-full">
            <div class="mt-32">
                <img src="/img/ayo-04.svg" alt="Ayo" class="w-32">
            </div>

            <div class="mt-16 text-xl tracking-normal leading-normal" style="color: #979797;">
                <p>Ayo helps you organize your time with mindful reminders, it's really simple.</p>
                <p>You gotta try it dawg!</p>
            </div>

            <div class="flex-col pt-16">
                <button class="w-full button-pink" @click="$modal.show('register-modal')">
                    Get Started
                </button>

                <button class="w-full button-white mt-6" @click="$modal.show('login-modal')">
                    Login
                </button>
            </div>
        </div>
    </div>
@endsection
