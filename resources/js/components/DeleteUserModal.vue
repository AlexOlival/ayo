<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="delete-user-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('delete-user-modal')"/>
        </div>
        <form method="POST" class="flex flex-col px-6 py-6" @submit.prevent="deleteUser()">
            <div class="text-left text-5xl font-black text-black">Are you sure?</div>
            <div class="text-left text-base text-grey-dark mb-6">
                This will permanently delete your account and reminders.
            </div>

            <div class="flex flex-row-reverse">
                <button class="button button-pink w-1/4 mt-2" @click="$modal.hide('delete-user-modal')">No, go back.</button>
                <button class="button button-red w-1/4 mt-2 mr-4" type="submit">Yes, delete my account.</button>
            </div>
        </form>
    </modal>
</template>

<script>
    export default {
        props: {
            userId: {
                type: Number,
                required: true
            }
        },

        methods: {
            deleteUser() {
                axios.delete(`/users/${this.userId}`);
                window.location.href = '/';
            }
        }
    }
</script>
