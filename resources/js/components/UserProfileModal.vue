<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="user-profile-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" alt="Close" @click="$modal.hide('user-profile-modal')"/>
        </div>
        <div class="flex flex-col items-center">
            <profile-picture class="mt-12 mb-6"/>
            <div class="flex flex-col mb-16 items-center">
                <p class="text-5xl font-black text-black mb-2" v-text="user.username"/>
                <p class="text-md text-grey-dark" v-text="user.email"/>
            </div>
        </div>
    </modal>
</template>

<script>
    import ProfilePicture from "./ProfilePicture";

    export default {
        components: {
            ProfilePicture
        },
        data() {
            return {
                user: window.user
            }
        }
    }
</script>
