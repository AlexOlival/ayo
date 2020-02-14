<template>
    <form method="POST"
          class="flex flex-col"
          @submit.prevent="$emit(event, form)"
          @keydown="clear($event.target.name)"
          novalidate>

        <div class="mb-6">
            <div class="text-left text-5xl font-black text-black">{{ title }}</div>
            <div v-if="subtitle" class="text-left text-xs text-grey-dark">
                {{ subtitle }}
            </div>
        </div>

        <div class="flex flex-row justify-between mb-6">
            <div class="w-full pr-2">
                <div class="flex justify-between">
                    <label class="font-semibold text-sm text-grey-dark" for="title">Title*</label>
                </div>
                <div>
                    <input
                        class="bg-grey-lighter rounded-lg focus:outline-none focus:border-grey focus:border-2 p-2 mt-2 w-full"
                        :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('title') }"
                        id="title"
                        type="text"
                        name="title"
                        v-model="form.title">
                </div>
                <span v-if="errors.hasOwnProperty('title')" v-text="errors.title[0]"
                      class="text-sm text-peachy-pink mt-1"/>
            </div>
            <div class="w-full pl-2">
                <div class="flex justify-between">
                    <label class="font-semibold text-sm text-grey-dark" for="notification_date">Date*</label>
                </div>
                <div>
                    <flat-pickr
                        class="bg-grey-lighter rounded-lg p-2 focus:outline-none focus:border-grey focus:border-2 mt-2 w-full"
                        :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('notification_date') }"
                        id="notification_date"
                        name="notification_date"
                        :config="{
                            enableTime: true,
                            minDate: new Date(),
                            defaultMinute: Math.ceil((new Date()).getMinutes() / 5) * 5
                        }"
                        @on-change="clear('notification_date')"
                        v-model="form.notification_date">
                    </flat-pickr>
                </div>
                <span v-if="errors.hasOwnProperty('notification_date')" v-text="errors.notification_date[0]"
                      class="text-sm text-peachy-pink mt-1"/>
            </div>
        </div>
        <div>
            <div class="flex justify-between">
                <label class="font-semibold text-sm text-grey-dark" for="people">Invite people to be reminded</label>
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
                    <template slot="option" slot-scope="user">
                        <div class="group flex flex-row items-center p-2 hover:bg-grey-lighter">
                            <img class="w-8 h-8 rounded-full" :src="user.avatar_path" alt="Avatar">
                            <span class="ml-4 text-peachy-pink group-hover:text-grey-dark">{{ user.username }}</span>
                        </div>
                    </template>
                </v-select>
            </div>
        </div>
        <div>
            <div class="flex justify-between">
                <label class="font-semibold text-sm text-grey-dark" for="description">Description</label>
                <span v-if="errors.hasOwnProperty('description')" v-text="errors.description[0]"
                      class="text-sm text-peachy-pink"/>
            </div>

            <div>
                <textarea
                    class="bg-grey-lighter rounded-xl p-2 resize-none min-h-48 focus:outline-none focus:border-grey focus:border-2 mb-4 mt-2 w-full"
                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('description') }"
                    id="description"
                    type="text"
                    name="description"
                    v-model="form.description">
                </textarea>
            </div>
        </div>
        <div v-if="!reminder" class="flex flex-row-reverse">
            <button class="rounded-lg px-8 py-4 bg-peachy-pink text-white font-bold w-1/3 mt-2"
                    @click="event = 'createReminder'" :disabled="submitting">Create</button>
        </div>
        <div v-else class="flex justify-end">
            <button class="rounded-full bg-grey-lighter text-black text-xl font-medium px-4 py-2 mr-4"
                    @click="event = 'closeEdit'" :disabled="submitting">Cancel</button>
            <button class="rounded-full bg-peachy-pink text-white text-xl font-medium px-4 py-2"
                    @click="event = 'editReminder'" :disabled="submitting">Save</button>
        </div>
    </form>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {
            flatPickr
        },
        props: ['title', 'subtitle', 'errors', 'reminder'],
        data() {
            return {
                form: {
                    title: this.reminder ? this.reminder.title : '',
                    notification_date: this.reminder ? this.reminder.notification_date : '',
                    description: this.reminder ? this.reminder.description : '',
                    guests: this.reminder ? this.reminder.guests : []
                },
                users: [],
                submitting: false,
                event: ''
            }
        },
        methods: {
            onSearch(search, loading) {
                loading(true);
                this.users = [];
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
                        console.log(response.data());
                        loading(false);
                    })
                    .catch(() => loading(false));
            }, 350),
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

    .v-select .vs__dropdown-option {
        padding: 0;
        background: #fff;
        /*color: #ff8a80;*/
    }

    .v-select .vs__selected-options {
        padding: 0.5em;
    }

    .v-select .vs__actions {
        padding: 1em;
    }
</style>
