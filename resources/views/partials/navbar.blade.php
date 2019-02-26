    <div class="container mx-auto flex flex-row items-center justify-between p-5">
        <div class="mt-1">
            <img class="w-16 text-black" src="/img/ayo-04.svg" alt="Ayo">
        </div>
        <navbar-menu :user="{{ Auth::user() }}"></navbar-menu>
    </div>
</nav>