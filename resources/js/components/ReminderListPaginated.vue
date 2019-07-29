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
                    return ['upcoming', 'nextWeek', 'month', 'later'].indexOf(value) !== -1
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
                        return 'Upcoming';

                    case 'nextWeek':
                        return 'Next Week';

                    case 'month':
                        return 'This Month';

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

    li {
        display: inline-block;
        margin: 0 10px;
    }

    .paginate-list {
        width: 159px;
        margin: 0 auto;
        text-align: left;
    }

    .paginate-list li {
        display: block;
    }

    .paginate-list li::before {
        content: '⚬ ';
        font-weight: bold;
        color: slategray;
    }

    .paginate-links.items {
        user-select: none;
    }

    .paginate-links.items a {
        @apply .border-2 .border-white .text-peachy-pink .font-bold .p-3 .rounded-full .text-xl .cursor-pointer;
    }

    .paginate-links.items a:hover {
        @apply .border-peachy-pink;
    }

    .paginate-links.items .active a {
        @apply .text-white .font-bold .bg-peachy-pink .border-peachy-pink;
    }

    .paginate-links.items .next::before {
        content: ' | ';
        margin-right: 13px;
        color: #ddd;
    }

    .paginate-links.items .disabled a {
        @apply .cursor-default .border-white;
    }
</style>
