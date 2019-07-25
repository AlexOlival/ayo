<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="show-reminder-modal" @before-open="beforeOpen">
        <div v-if="reminder">
            <div class="flex justify-end">
                <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('show-reminder-modal')"/>
            </div>
            <div class="flex flex-col px-6 py-6">
                <div class="text-left text-4xl font-black text-black mb-1">{{ reminder.title }}</div>
                <div class="text-left text-3xl text-black mb-8">{{ reminder.human_readable_notification_date }} <span class="text-2xl text-grey-dark">{{ reminder.notification_date }}</span></div>
                <div>{{ reminder.description }}</div>
                <div v-if="reminder.guests.length !== 0">HAS GUESTS</div>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                reminder: null
            }
        },
        methods: {
            beforeOpen(event) {
                this.reminder = event.params.reminder;
            }
        }
    }
</script>