<template>
    <div class="group h-48 w-48 sm:h-96 sm:w-96 rounded-full border-4 sm:border-8 border-peachy-pink relative overflow-hidden cursor-pointer">
        <img class="h-full w-full absolute z-10 group-hover:opacity-25" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
        <div class="h-full w-full absolute bg-peachy-pink z-0"></div>
        <div class="h-full w-full flex flex-col justify-center items-center absolute z-20 invisible group-hover:visible" @click="">
            <img class="h-10 w-10 sm:h-16 sm:w-16" src="/img/ic-add-photo.svg" alt="">
            <p class="text-sm text-center sm:text-2xl text-white font-bold">Upload a new profile photo</p>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
        }
    }
</script>
