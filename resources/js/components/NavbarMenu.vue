<template>
    <div class="flex flex-row" @mouseover="menuVisible = true" @mouseleave="menuVisible = false">
        <div class="flex flex-row items-center cursor-pointer">
            <img class="h-8 w-8 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
            <p class="ml-3 text-black">{{ user.username }}</p>
        </div>

        <form method="POST" action="/logout" id="logout-form">
            <input type="hidden" name="_token" :value="this.token">
            <div class="flex items-center cursor-pointer">
                <button class="button button-logout" type="submit">Logout</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                menuVisible: false,
                token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
    }
</script>
