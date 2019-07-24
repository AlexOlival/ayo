<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">{{ period | capitalize }}</h2>
            <a href="#"
               class="text-sm text-peachy-pink no-underline"
               v-if="reminderCount > 4"
            >
                See all ({{ reminderCount }})
            </a>
        </header>
        <section class="flex flex-wrap px-5 items-center">
            <reminder v-for="reminder in reminders" :key="reminder.id" :reminder="reminder" @click.native="openDetailModal(reminder)"></reminder>
        </section>
    </section>
</template>

<script>
    import Reminder from "./Reminder";
    export default {
        components: {Reminder},
        props: {
            period: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['upcoming', 'nextWeek', 'month', 'later'].indexOf(value) !== -1
                }
            },
            reminders: {
                type: Object,
                required: true
            },
            reminderCount: {
                type: Number,
                required: true
            }
        },
        filters: {
            capitalize(value) {
                if (!value) return '';
                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        },
        methods: {
            openDetailModal(reminder) {
                this.$modal.show('show-reminder-modal', {reminder: reminder})
            }
        }
    }
</script>
