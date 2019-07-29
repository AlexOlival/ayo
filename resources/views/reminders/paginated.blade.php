@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col md:flex-row align-middle mt-10 mb-8 p-5">
            <a href="/home" class="text-lg text-peachy-pink no-underline">< Back</a>
        </header>
        <reminder-list-paginated period="{{ $period }}" :reminders="{{ json_encode($reminders) }}">
        </reminder-list-paginated>
    </div>

    @include('modals.show-reminder-modal')
@endsection
