<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="create-reminder-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('create-reminder-modal')"/>
        </div>
        <form method="POST"
              class="flex flex-col px-6 py-6"
              @submit.prevent="create"
              @keydown="clear($event.target.name)"
              novalidate
        >
            <div class="text-left text-5xl font-black text-black">Create a reminder</div>
            <div class="text-left text-xs text-grey-dark mb-6">
                Fields marked with an asterisk (*) are required.
            </div>
            <div class="flex flex-row">
                <div class="flex-auto mr-2">
                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="title">Title*</label>
                            <span v-if="errors.hasOwnProperty('title')" v-text="errors.title[0]" class="text-sm text-peachy-pink"></span>
                        </div>

                        <div>
                            <input
                                    class="input mb-4 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('title') }"
                                    id="title"
                                    type="text"
                                    name="title"
                                    v-model="form.title"
                            >
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="notification_date">Date*</label>
                            <span v-if="errors.hasOwnProperty('notification_date')" v-text="errors.notification_date[0]" class="text-sm text-peachy-pink"></span>
                        </div>
                        <div>
                            <flat-pickr
                                    class="input mb-6 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('notification_date') }"
                                    id="notification_date"
                                    name="notification_date"
                                    :config="{ enableTime: true, minDate: new Date() }"
                                    @on-change="clear('notification_date')"
                                    v-model="form.notification_date">
                            </flat-pickr>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="title">Description</label>
                            <span v-if="errors.hasOwnProperty('description')" v-text="errors.description[0]" class="text-sm text-peachy-pink"></span>
                        </div>

                        <div>
                            <textarea
                                    class="textarea mb-4 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('description') }"
                                    id="description"
                                    type="text"
                                    name="description"
                                    v-model="form.description"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="flex-auto ml-2">
                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="people">People</label>
                        </div>

                        <div>
                            <input
                                    class="input mb-4 mt-2 w-full"
                                    id="people"
                                    type="search"
                                    name="people"
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <button class="button button-pink w-1/3 mt-2" type="submit" :disabled="loading">Create</button>
            </div>
        </form>
    </modal>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {flatPickr},
        data() {
            return {
                form: {
                    title: '',
                    notification_date: '',
                    description: '',
                    guests: []
                },
                loading: false,
                errors: {}
            }
        },

        methods: {
            create() {
                this.loading = true;

                this.form.notification_date += ':00';

                axios.post('/reminders', this.form)
                    .then(() => {
                        // close modal
                    })
                    .catch((errors) => {
                        // close modal
                        this.loading = false;
                        this.errors = errors.response.data.errors;
                    })
            },

            clear(field) {
                if (this.errors.hasOwnProperty(field)) Vue.delete(this.errors, field);
            }
        }
    }
</script>

<style>
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange,
    .flatpickr-day.selected.inRange,
    .flatpickr-day.startRange.inRange,
    .flatpickr-day.endRange.inRange,
    .flatpickr-day.selected:focus,
    .flatpickr-day.startRange:focus,
    .flatpickr-day.endRange:focus,
    .flatpickr-day.selected:hover,
    .flatpickr-day.startRange:hover,
    .flatpickr-day.endRange:hover,
    .flatpickr-day.selected.prevMonthDay,
    .flatpickr-day.startRange.prevMonthDay,
    .flatpickr-day.endRange.prevMonthDay,
    .flatpickr-day.selected.nextMonthDay,
    .flatpickr-day.startRange.nextMonthDay,
    .flatpickr-day.endRange.nextMonthDay {
        background: #ff8a80;
        -webkit-box-shadow: none;
        box-shadow: none;
        color: #fff;
        border-color: #ff8a80;
    }
</style>
