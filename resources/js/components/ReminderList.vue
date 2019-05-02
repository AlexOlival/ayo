<template>
    <section>
        <header class="flex justify-between px-10 items-center mb-2">
            <h2 class="font-semibold inline text-grey-dark py-4">Upcoming</h2>
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
        components: {Reminder},
        data() {
            return {
                reminders: null,
                numberOfReminders: 0,
            }
        },
        mounted() {
            axios.get('/reminders')
                .then((response) => {
                    this.reminders = response.data;
                    this.numberOfReminders = response.data.length;
                });
        },
    }
</script>
