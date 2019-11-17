<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="user-profile-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('user-profile-modal')"/>
        </div>
        <div class="flex flex-col items-center">
            <profile-picture class="mt-12 mb-6"></profile-picture>
            <div class="flex flex-col mb-16 items-center">
                <p class="text-5xl font-black text-black" v-text="user.username"></p>
                <p class="text-md text-grey-dark" v-text="user.email"></p>
            </div>
        </div>
    </modal>
</template>

<script>
    import ProfilePicture from "./ProfilePicture";

    export default {
        components: {ProfilePicture},
        data() {
            return {
                user: window.user
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
                        console.log(response.data())
                        loading(false);
                    })
                    .catch(() => {
                        loading(false);
                    });
            }, 350),
            clear(field) {
                if (this.errors.hasOwnProperty(field)) Vue.delete(this.errors, field);
            },
        }
    }
</script>
