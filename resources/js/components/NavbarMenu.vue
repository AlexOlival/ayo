<template>
    <div class="flex flex-col">
        <div class="flex flex-row items-center cursor-pointer" @click="toggleMenu">
            <img class="h-8 w-8 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
            <p class="ml-3">{{ user.username }}</p>
        </div>
        <div slot="dropdown" class="bg-white shadow rounded border overflow-hidden absolute mt-10" v-show="menuVisible" v-cloak>
            <a href="#" class="no-underline block px-8 py-2 border-b bg-white hover:text-white hover:bg-peachy-pink whitespace-no-wrap" @click="logout">Logout</a>
        </div>
        <form method="POST" action="/logout" class="hidden" id="logout-form">
            <input type="hidden" name="_token" :value="this.token">
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
        methods: {
            toggleMenu() {
                this.menuVisible = !this.menuVisible;
            },
            logout() {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
