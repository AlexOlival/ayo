@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col md:flex-row md:justify-between align-middle mt-10 mb-8 p-5">
            <h1 class="font-semibold inline text-black py-4">Reminders</h1>
            <button class="button button-pink">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="align-middle">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path fill="#fff" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                </svg>
                <span class="ml-2">New reminder</span>
            </button>
        </header>
        <section>
            <header class="flex justify-between px-10 items-center mb-2">
                <h2 class="font-medium text-grey-dark text-lg">Invites</h2>
                <a href="#" class="text-sm text-peachy-pink no-underline">See all (5)</a>
            </header>
            <section class="flex flex-wrap px-5 -mx-2 items-center">
                @foreach([1, 2, 3, 4] as $item)
                    <div class="px-2 w-full lg:w-1/4 md:w-1/2 sm:w-1/2">
                        <div class="flex flex-col border-2 border-peachy-pink rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center">
                                <p class="mr-16 text-lg">Reminder title</p>
                                <div class="flex ">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0z"/>
                                            <path fill="#ff8a80" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4 11H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                                        </svg>
                                    </button>
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0z"/>
                                            <path fill="#689f38" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29L5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex mb-16">
                                <time class="text-grey-dark text-xs" datetime="{{ now()->subDay() }}">{{ now()->subDay()->diffForHumans() }}</time>
                            </div>
                            <div class="flex">
                                <img class="h-6 w-6 rounded-full mr-3" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                                <img class="h-6 w-6 rounded-full mr-3" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                                <img class="h-6 w-6 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        </section>
        <section></section>
    </div>
@endsection
