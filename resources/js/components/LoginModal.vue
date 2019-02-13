<template>
    <modal name="login-modal">
        <form method="POST" @submit.prevent="login" @keydown="feedback = ''">
            <div>
                <label for="email">E-Mail Address</label>

                <div>
                    <input id="email" type="email" name="email" v-model="form.email" autofocus>
                </div>
            </div>

            <div>
                <label for="password">Password</label>

                <div>
                    <input id="password" type="password" name="password" v-model="form.password">
                </div>
            </div>

            <div>
                <label for="remember">Remember Me</label>

                <div>
                    <input id="remember" type="checkbox" name="remember" v-model="form.remember">
                </div>
            </div>

            <div>
                <p v-text="feedback"></p>
            </div>

            <div>
                <button type="submit" :disabled="loading">Login</button>
            </div>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false
                },
                loading: false,
                feedback: ''
            }
        },

        methods: {
            login() {
                this.loading = true;

                axios.post('/login', this.form)
                    .then(() => {
                        location.assign('/home');
                    })
                    .catch(() => {
                        this.loading = false;
                        this.feedback = "The credentials are incorrect, please try again.";
                    })
            }
        }
    }
</script>
