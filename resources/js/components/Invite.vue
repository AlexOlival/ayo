<template>
    <div class="px-2 w-5/6 md:w-1/2 lg:w-1/4 cursor-pointer">
        <div class="card flex flex-row p-2 mb-4 hover:shadow-lg">
            <div class="w-1/3 flex items-center">
                <img class="w-16 h-16 rounded-full" :src="invite.owner.avatar_path" alt="">
            </div>
            <div class="flex flex-col justify-between w-2/3">
                <div class="items-start">
                    <p class="card-title" v-text="invite.title"></p>
                    <p class="text-grey-dark">{{ invite.owner.username }}</p>
                    <time class="text-grey-dark text-xs"
                          :datetime="invite.pivot.created_at"
                          v-text="invite.pivot.human_readable_date"
                    >
                    </time>
                </div>
                <div class="w-full flex justify-end">
                    <button @click="refuse">
                        <img class="w-12" src="/img/refuse-icon.svg" alt="Ayo logo">
                    </button>
                    <button @click="accept">
                        <img class="w-12" src="/img/accept-icon.svg" alt="Ayo logo">
                    </button>
                </div>
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
                alert('Invitation Refused');
            },
            accept() {
                alert('Invitation Accepted');
            }
        }
    }
</script>
