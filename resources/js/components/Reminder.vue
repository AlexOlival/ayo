<template>
    <div class="px-2 w-5/6 md:w-1/2 lg:w-1/4 cursor-pointer">
        <div class="card hover:shadow-lg">
            <div class="flex justify-between items-start">
                <p class="card-title" v-text="reminder.title"></p>
                <img class="w-6" src="favicon.ico" alt="Ayo logo">
            </div>
            <div class="flex mb-8">
                <p class="text-grey-dark text-sm" v-text="reminder.notification_date"></p>
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
