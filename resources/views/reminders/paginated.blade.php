@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col md:flex-row md:justify-between align-middle mt-10 mb-8 p-5">
            <h1 class="font-semibold inline text-black py-4">Reminders</h1>
        </header>
        <reminder-list-paginated period="{{ $period }}" :reminders="{{ json_encode($reminders) }}">
        </reminder-list-paginated>
    </div>

    @include('modals.show-reminder-modal')
@endsection
