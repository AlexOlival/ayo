<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="delete-user-modal">
        <div class="flex justify-end">
            <img class="p-2 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('delete-user-modal')"/>
        </div>
        <form method="POST" id="delete-form" :action="`/users/${userId}`" class="flex flex-col px-6 py-6" @submit.prevent="deleteUser()">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" :value="token">
            <div class="text-left text-5xl font-black text-black">Are you sure?</div>
            <div class="text-left text-base text-grey-dark mb-6">
                This will permanently delete your account and reminders.
            </div>

            <div class="flex flex-row-reverse">
                <button class="button button-pink w-1/4 mt-2" @click.prevent="$modal.hide('delete-user-modal')">No</button>
                <button class="button button-red w-1/4 mt-2 mr-4" type="submit">Yes</button>
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

        data() {
            return {
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            deleteUser() {
                document.getElementById('delete-form').submit();
            }
        }
    }
</script>
