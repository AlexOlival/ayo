<nav class="shadow w-screen">
    <div class="container mx-auto flex flex-row items-center justify-between p-5">
        <div class="mt-1">
            <a href="{{ route('home') }}">
                <img class="w-16 text-black" src="/img/ayo-04.svg" alt="Ayo">
            </a>
        </div>

        <div class="flex flex-row">
            <a class="no-underline" href="{{ route('profile.show') }}">
                <div class="flex flex-row items-center cursor-pointer mr-3">
                    <img class="h-8 w-8 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                    <p class="ml-2 text-black">{{ auth()->user()->username }}</p>
                </div>
            </a>

            <form method="POST" action="/logout" id="logout-form">
                @csrf
                <div class="flex items-center cursor-pointer">
                    <button class="button button-logout" type="submit">Logout</button>
                </div>
            </form>
        </div>
    </div>
</nav>
