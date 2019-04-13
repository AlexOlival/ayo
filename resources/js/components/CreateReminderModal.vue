<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="create-reminder-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('create-reminder-modal')"/>
        </div>
        <form method="POST"
              class="px-6 py-6"
              @submit.prevent="create"
              @keydown="clear($event.target.name)"
              novalidate
        >
            <div class="text-left text-5xl font-black text-black">Create a reminder</div>
            <div class="flex flex-row">
                <div class="flex-auto">
                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="title">Title</label>
                            <span v-if="errors.hasOwnProperty('title')" v-text="errors.title[0]" class="text-sm text-peachy-pink"></span>
                        </div>

                        <div>
                            <input
                                    class="input mb-4 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('title') }"
                                    id="title"
                                    type="title"
                                    name="title"
                                    v-model="form.title"
                            >
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between">
                            <label class="label" for="notification_date">Date</label>
                            <span v-if="errors.hasOwnProperty('notification_date')" v-text="errors.notification_date[0]" class="text-sm text-peachy-pink"></span>
                        </div>
                        <div>
                            <input
                                    class="input mb-6 mt-2 w-full"
                                    :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('notification_date') }"
                                    id="notification_date"
                                    type="date"
                                    name="notification_date"
                                    v-model="form.notification_date"
                            >
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
                <div class="flex-auto">
                    <div class="flex flex-row align-items-center">
                        <label class="label" for="remember">Remember Me</label>

                        <div class="ml-1">
                            <input id="remember" type="checkbox" name="remember" v-model="form.remember">
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
    export default {
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
