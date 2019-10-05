<template>
    <div class="flex px-6 py-3 mb-4 w-5/6 md:w-1/2 lg:w-1/4 cursor-pointer justify-between invite-bg rounded-full">
        <div class="flex flex-col justify-around invite-title">
            <p class="text-lg text-grey-dark font-medium tracking-normal mb-1" v-text="invite.title"></p>
            <p class="text-xs text-grey-dark">Invited by {{ invite.owner.username }}</p>
        </div>
        <div class="flex">
            <button @click="refuse" class="flex items-center">
                <img class="w-8" src="/img/refuse-icon.svg" alt="Ayo logo">
            </button>
            <button @click="accept" class="flex items-center ml-2">
                <img class="w-8" src="/img/accept-icon.svg" alt="Ayo logo">
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            invite: {
                type: Object,
                required: true
            }
        },
        methods: {
            refuse() {
                axios.patch('/refuse-invite/' + this.invite.id)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error(error.response.data);
                    });
            },
            accept() {
                axios.patch('/accept-invite/' + this.invite.id)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error(error.response.data);
                    });
            }
        }
    }
</script>

<style>
    .invite-bg {
        background-color: rgba(102, 147, 185, 0.1);
    }
</style>
