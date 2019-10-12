<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="login-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('login-modal')"/>
        </div>
        <form method="POST"
              class="flex flex-col px-6 py-6"
              @submit.prevent="login"
              @keydown="clear($event.target.name)"
              novalidate
        >
            <div class="text-left text-5xl font-black text-black">Welcome Back!</div>
            <div class="text-left text-xs text-grey-dark mb-6">
                Fill in your credentials to login.
            </div>
            <div>
                <div class="flex justify-between">
                    <label class="label" for="email">E-mail</label>
                    <span v-if="errors.hasOwnProperty('email')" v-text="errors.email[0]" class="text-sm text-peachy-pink"></span>
                </div>

                <div>
                    <input
                            class="input mb-4 mt-2 w-full"
                            :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('email') }"
                            id="email"
                            type="email"
                            name="email"
                            v-model="form.email"
                    >
                </div>
            </div>

            <div>
                <div class="flex justify-between">
                    <label class="label" for="password">Password</label>
                    <span v-if="errors.hasOwnProperty('password')" v-text="errors.password[0]" class="text-sm text-peachy-pink"></span>
                </div>
                <div>
                    <input
                            class="input mb-6 mt-2 w-full"
                            :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('password') }"
                            id="password"
                            type="password"
                            name="password"
                            v-model="form.password"
                    >
                </div>
            </div>

            <div class="flex flex-row align-items-center">
                <label class="label" for="remember">Remember Me</label>

                <div class="ml-1">
                    <input id="remember" type="checkbox" name="remember" v-model="form.remember">
                </div>
            </div>

            <div class="flex flex-row-reverse">
                <button class="rounded-lg px-8 py-4 bg-peachy-pink text-white font-bold w-1/3 mt-2" type="submit" :disabled="loading">Login</button>
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
                errors: {}
            }
        },

        methods: {
            login() {
                this.loading = true;

                axios.post('/login', this.form)
                    .then(() => {
                        location.assign('/home');
                    })
                    .catch((errors) => {
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
