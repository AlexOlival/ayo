<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">{{ getPeriodName(period) }}</h2>
            <a :href="`/expanded-reminders?period=${period}`"
               class="text-sm text-peachy-pink no-underline"
               v-if="reminderCount > 4"
            >
                See all ({{ reminderCount }})
            </a>
        </header>
        <section class="flex flex-wrap px-3 items-center flex-col sm:flex-row md:flex-row lg:flex-row">
            <reminder v-for="reminder in reminders" :key="reminder.id" :reminder="reminder" @click.native="openDetailModal(reminder)"/>
        </section>
    </section>
</template>

<script>
    import Reminder from "./Reminder";

    export default {
        components: {
            Reminder
        },
        props: {
            period: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['upcoming', 'tenDaysAfter', 'later'].indexOf(value) !== -1
                }
            },
            reminders: {
                required: true
            },
            reminderCount: {
                type: Number,
                required: true
            }
        },
        methods: {
            openDetailModal(reminder) {
                this.$modal.show('show-reminder-modal', {reminder: reminder})
            },
            getPeriodName(period) {
                switch (period) {
                    case 'upcoming':
                        return 'Upcoming 3 days';

                    case 'tenDaysAfter':
                        return 'In a while';

                    case 'later':
                        return 'Later';

                    default:
                        console.error(`Unknown period ${period}`);
                        break;
                }
            }
        }
    }
</script>
