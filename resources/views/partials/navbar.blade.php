<nav class="shadow">
    <div class="container mx-auto flex flex-row items-center justify-between p-5">
        <div class="mt-1">
            <img class="w-16 text-black" src="/img/ayo-04.svg" alt="Ayo">
        </div>
        <div class="flex flex-row items-center">
            <img class="h-8 w-8 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Goucha">
            <p class="ml-3">{{ auth()->user()->username }}</p>
        </div>
    </div>
</nav>