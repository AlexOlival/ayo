<template>
    <div class="px-2 w-5/6 md:w-1/2 lg:w-1/4 cursor-pointer">
        <div class="card flex flex-row p-2 mb-4 hover:shadow-lg">
            <div class="w-1/3 flex align-middle">
                <img class="w-16 h-16 rounded-full" :src="reminder.owner.avatar_path" alt="">
            </div>
            <div class="flex flex-col w-2/3">
                <div class="flex justify-between items-start">
                    <p class="card-title" v-text="reminder.title"></p>
                    <img class="w-6" src="favicon.ico" alt="Ayo logo">
                </div>
                <p class="text-black text-sm" v-text="reminder.notification_date"></p>
                <p class="text-grey-dark mt-4">{{ reminder.owner.username }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            reminder: {
                required: true
            }
        },
        methods: {}
    }
</script>
