<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="register-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('register-modal')"/>
        </div>
        <transition name="slide">
            <form
                    class="flex flex-col p-6"
                    method="POST"
                    @submit.prevent="register"
                    @keydown="clear($event.target.name)"
                    novalidate
                    v-if="!registered"
            >
                <div class="text-left text-5xl font-black text-black">Welcome!</div>
                <div class="text-left text-xs text-grey-dark mb-6">
                    Fill in the form in order to create an account.
                </div>

                <div>
                    <div class="flex justify-between">
                        <label class="label" for="username">Username</label>
                        <span v-if="errors.hasOwnProperty('username')" v-text="errors.username[0]" class="text-sm text-peachy-pink"></span>
                    </div>
                    <div>
                        <input
                                class="input mb-4 mt-2 w-full"
                                :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('username') }"
                                id="username"
                                type="text"
                                name="username"
                                v-model="form.username"
                                autofocus
                        >
                    </div>
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
                                class="input mb-4 mt-2 w-full"
                                :class="{ 'border-2 border-peachy-pink' : errors.hasOwnProperty('password') }"
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

                <div class="flex flex-row-reverse">
                    <button class="rounded-lg px-8 py-4 bg-peachy-pink text-white font-bold w-1/3 mt-2" type="submit" :disabled="submitDisabled">Join us</button>
                </div>
            </form>

            <div v-else class="flex flex-col items-center justify-center p-6">
                <h2 class="text-center text-black">Verify your account</h2>
                <p class="text-xl text-center text-black my-4">A confirmation email was sent to your email address.</p>
                <img class="w-12 m-4" src="/img/email-icon.svg" alt="Ayo">
            </div>
        </transition>
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
                errors: {},
                registered: false
            };
        },

        computed: {
            submitDisabled() {
                return this.loading || Object.keys(this.errors).length > 0;
            }
        },

        methods: {
            register() {
                this.loading = true;

                axios
                    .post('/register', this.form)
                    .then(() => {
                        this.registered = true;
                    })
                    .catch((errors) => {
                        this.loading = false;
                        this.errors = errors.response.data.errors;
                    });
            },

            clear(field) {
                if (this.errors.hasOwnProperty(field)) Vue.delete(this.errors, field);
            }
        }
    };
</script>

<style>
    .slide-leave-active,
    .slide-enter-active {
        transition: 1s;
    }

    .slide-enter {
        transform: translate(100%, 0);
        z-index: 1;
    }

    .slide-leave-to {
        transform: translate(-100%, 0);
        z-index: 0;
        position: absolute;
    }
</style>
