<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">{{ getPeriodName(period) }}</h2>
        </header>
        <paginate
            class="flex flex-wrap px-5 mb-6 items-center flex-col sm:flex-row md:flex-row lg:flex-row"
            name="items"
            :list="reminderList"
            :per="8"
        >
            <reminder v-for="reminder in paginated('items')" :key="reminder.id" :reminder="reminder" @click.native="openDetailModal(reminder)"></reminder>
        </paginate>
        <paginate-links class="flex justify-center" for="items" :show-step-links="true"></paginate-links>
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
                    return ['upcoming', 'tenDaysAfter', 'later'].indexOf(value) !== -1
                }
            },
            reminders: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                reminderList: this.reminders,
                paginate: ['items']
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
<style>
    ul {
        list-style-type: none;
        padding: 0;
    }

    .paginate-links li a {
        display: inline-block;
        height: 2em;
        margin: 0 8px;
        width: 2em;
        @apply .flex .flex-col .justify-center .text-center .rounded-full .text-peachy-pink .font-bold .cursor-pointer;
    }

    .paginate-links li a:hover {
        @apply .border-2 .border-peachy-pink;
    }

    .paginate-links.items .active a {
        @apply .text-white .bg-peachy-pink;
    }

    .paginate-links.items .disabled a {
        @apply .text-grey;
    }

    .paginate-links .disabled a:hover {
        @apply .border-0;
    }
</style>
