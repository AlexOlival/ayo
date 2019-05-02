@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col md:flex-row md:justify-between align-middle mt-10 mb-8 p-5">
            <h1 class="font-semibold inline text-black py-4">Reminders</h1>
            <button class="button button-pink" @click="$modal.show('create-reminder-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="align-middle">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path fill="#fff" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                </svg>
                <span class="ml-2">New reminder</span>
            </button>
        </header>
        @includeWhen($userHasInvites, 'invites.index')
        <section>
            @if($userHasReminders)
                <reminder-list></reminder-list>
            @else
                <h5>No upcoming reminders, create one! (inserir bUtãum?)</h5>
            @endif
        </section>
    </div>

    @include('modals.create-reminder-modal')
@endsection
