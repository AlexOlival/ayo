@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col md:flex-row align-middle mt-10 mb-8 p-5">
            <a href="{{ route('home') }}" class="text-lg text-peachy-pink no-underline">< Back</a>
        </header>
        <invite-list-paginated :invites="{{ json_encode($invites) }}">
        </invite-list-paginated>
    </div>
@endsection
