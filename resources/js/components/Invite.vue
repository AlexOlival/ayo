<template>
    <div class="px-3 w-5/6 md:w-1/2 lg:w-1/4">
        <div class="flex py-3 px-5 mb-4 invite-bg rounded-full">
            <div class="flex flex-col justify-around w-2/3">
                <p class="text-md text-grey-dark font-medium tracking-normal mb-1 truncate" v-text="invite.title"></p>
                <p class="text-xs text-grey-dark truncate">Invited by {{ invite.owner.username }}</p>
            </div>
            <div class="flex w-1/3 justify-end">
                <button @click="refuse" class="flex items-center cursor-pointer">
                    <img class="w-8" src="/img/refuse-icon.svg" alt="Ayo logo">
                </button>
                <button @click="accept" class="flex items-center ml-2 cursor-pointer">
                    <img class="w-8" src="/img/accept-icon.svg" alt="Ayo logo">
                </button>
            </div>
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
