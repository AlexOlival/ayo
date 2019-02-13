@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <button @click="$modal.show('login-modal')">Login</button>

            <button @click="$modal.show('register-modal')">Register</button>
        </div>

        <div class="content">
            <div class="title m-b-md">
                Ayo
            </div>
        </div>
    </div>
@endsection
