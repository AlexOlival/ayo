<template>
    <modal name="register-modal">
        <form method="POST" @submit.prevent="register" @keydown="feedback = ''">
            <div>
                <label for="username">Username</label>

                <div>
                    <input id="username" type="text" name="username" v-model="form.username" autofocus>
                </div>
            </div>

            <div>
                <label for="email">E-Mail Address</label>

                <div>
                    <input id="email" type="email" name="email" v-model="form.email">
                </div>
            </div>

            <div>
                <label for="password">Password</label>

                <div>
                    <input id="password" type="password" name="password" v-model="form.password">
                </div>
            </div>

            <div>
                <label for="password_confirmation">Password Confirmation</label>

                <div>
                    <input id="password_confirmation" type="password" name="password_confirmation" v-model="form.password_confirmation">
                </div>
            </div>

            <div>
                <p v-text="feedback"></p>
            </div>

            <div>
                <button type="submit" :disabled="loading">Register</button>
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
            }
        },

        methods: {
            register() {
                this.loading = true;

                axios.post('/register', this.form)
                    .then(() => {
                        location.assign('/home');
                    })
                    .catch(() => {
                        this.loading = false;
                        this.feedback = "Something went wrong, please try again.";
                    })
            }
        }
    }
</script>
