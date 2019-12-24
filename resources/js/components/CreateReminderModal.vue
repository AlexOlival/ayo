<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="create-reminder-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('create-reminder-modal')"/>
        </div>

        <reminder-form
            class="p-6"
            title="Create a reminder"
            subtitle="Fields marked with an asterisk (*) are required."
            :errors="errors"
            :reminder="reminderToCreate"
            @createReminder="create"
        />
    </modal>
</template>

<script>
    import ReminderForm from "./ReminderForm";

    export default {
        components: {ReminderForm},
        data() {
            return {
                reminderToCreate: null,
                errors: {},
            }
        },
        methods: {
            create(reminder) {
                reminder.notification_date += ':00';
                axios.post('/reminders', reminder)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((errors) => {
                        this.errors = errors.response.data.errors;
                    })
            }
        }
    }
</script>
