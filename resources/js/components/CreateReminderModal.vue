<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="create-reminder-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('create-reminder-modal')"/>
        </div>
        <form method="POST"
              class="flex flex-col px-6 py-6"
              @submit.prevent="create"
              @keydown="clear($event.target.name)"
              novalidate>
            <div class="text-left text-5xl font-black text-black">Create a reminder</div>
            <div class="text-left text-xs text-grey-dark mb-6">
                Fields marked with an asterisk (*) are required.
            </div>
            <div>
                <div class="flex flex-row justify-between">
                    <div class="w-full pr-2">
                        <div class="flex justify-between">
                            <label class="label" for="title">Title*</label>
                            <span v-if="errors.hasOwnProperty('title')" v-text="errors.title[0]"
                                class="text-sm text-peachy-pink"></span>
                        </div>
                        <div>
                            <input
                                    class="input mb-4 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('title') }"
                                    id="title"
                                    type="text"
                                    name="title"
                                    v-model="form.title">
                        </div>
                    </div>
                    <div class="w-full pl-2">
                        <div class="flex justify-between">
                            <label class="label" for="notification_date">Date*</label>
                            <span v-if="errors.hasOwnProperty('notification_date')" v-text="errors.notification_date[0]"
                                class="text-sm text-peachy-pink"></span>
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
                </div>
                <div>
                    <div class="flex justify-between">
                        <label class="label" for="description">Description</label>
                        <span v-if="errors.hasOwnProperty('description')" v-text="errors.description[0]"
                                class="text-sm text-peachy-pink"></span>
                    </div>

                    <div>
                        <textarea
                                class="textarea mb-4 mt-2 w-full"
                                :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('description') }"
                                id="description"
                                type="text"
                                name="description"
                                v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between">
                        <label class="label" for="people">Invite people to be reminded</label>
                    </div>
                    <div>
                        <v-select class="mb-4 mt-2 w-full"
                                  multiple
                                  id="people"
                                  label="username"
                                  :filterable="false"
                                  @search="onSearch"
                                  :options="users"
                                  :reduce="user => user.id"
                                  v-model="form.guests">
                            <template slot="no-options">
                                <div class="text-grey-dark">
                                    start typing a username...
                                </div>
                            </template>
                        </v-select>
                    </div>
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <button class="button button-pink w-1/3 mt-2" type="submit" :disabled="submitting">Create</button>
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
                users: [],
                errors: {},
                submitting: false
            }
        },
        methods: {
            create() {
                this.submitting = true;

                this.form.notification_date += ':00';

                axios.post('/reminders', this.form)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((errors) => {
                        this.submitting = false;
                        this.errors = errors.response.data.errors;
                    })
            },
            onSearch(search, loading) {
                loading(true);
                this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                loading(true);

                axios.get('/search-users', {
                    params: {
                        q: search
                    }
                })
                    .then(response => {
                        vm.users = response.data;
                        loading(false);
                    })
                    .catch(() => {
                        loading(false);
                    })
            }, 350),
            clear(field) {
                if (this.errors.hasOwnProperty(field)) Vue.delete(this.errors, field);
            },
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

    .v-select .vs__dropdown-option {
        background: #fff;
        color: #ff8a80;
    }
</style>
