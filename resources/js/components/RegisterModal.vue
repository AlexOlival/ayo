<template>
    <modal height="auto" :adaptive="true" name="register-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('register-modal')"/>
        </div>
        <form
                class="flex flex-col px-6 py-6"
                method="POST"
                @submit.prevent="register"
                @keydown="feedback = ''"
        >
            <div class="text-left text-5xl font-black text-black">Welcome!</div>
            <div class="text-left text-xs text-grey-dark mb-6">
                Fill in the form in order to create an account.
            </div>

            <div>
                <label class="label" for="username">Username</label>
                <div>
                    <input
                            class="input mb-4 mt-2 w-full"
                            id="username"
                            type="text"
                            name="username"
                            v-model="form.username"
                            autofocus
                    >
                </div>
            </div>

            <div>
                <label class="label" for="email">E-mail</label>
                <div>
                    <input class="input mb-4 mt-2  w-full" id="email" type="email" name="email" v-model="form.email">
                </div>
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <div>
                    <input
                            class="input mb-4 mt-2 w-full"
                            id="password"
                            type="password"
                            name="password"
                            v-model="form.password"
                    >
                </div>
            </div>

            <div>
                <label class="label" for="password_confirmation">Password Confirmation</label>
                <div>
                    <input
                            class="input mb-4 mt-2 w-full"
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                    >
                </div>
            </div>

            <div>
                <p v-text="feedback"></p>
            </div>

            <div class="flex flex-row-reverse">
                <button class="button button-pink w-1/3 mt-2" type="submit" :disabled="loading">Join us</button>
            </div>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                loading: false,
                feedback: ''
            };
        },

        methods: {
            register() {
                this.loading = true;

                axios
                    .post('/register', this.form)
                    .then(() => {
                        location.assign('/home');
                    })
                    .catch(() => {
                        this.loading = false;
                        this.feedback = 'Something went wrong, please try again.';
                    });
            }
        }
    };
</script>
