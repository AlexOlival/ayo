<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">{{ period | capitalize }}</h2>
            <a href="#"
               class="text-sm text-peachy-pink no-underline"
               v-if="numberOfReminders > 4"
            >
                See all ({{ numberOfReminders }})
            </a>
        </header>
        <section class="flex flex-wrap px-5 -mx-2 items-center">
            <reminder v-for="reminder in reminders" :key="reminder.id" :reminder="reminder"></reminder>
        </section>
    </section>
</template>

<script>
    import Reminder from "./Reminder";
    export default {
        props: {
            period: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['upcoming', 'nextWeek', 'month', 'later'].indexOf(value) !== -1
                }
            }
        },
        components: {Reminder},
        data() {
            return {
                reminders: null,
                numberOfReminders: 0,
            }
        },
        mounted() {
            axios.get('/reminders?period=' + this.period)
                .then((response) => {
                    this.reminders = response.data;
                    this.numberOfReminders = response.data.length;
                });
        },

        filters: {
            capitalize(value) {
                if (!value) return '';
                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        }
    }
</script>
