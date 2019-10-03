<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">Invites</h2>
        </header>
        <paginate
            class="flex flex-wrap px-5 mb-6 items-center flex-col sm:flex-row md:flex-row lg:flex-row"
            name="items"
            :list="inviteList"
            :per="8"
        >
            <invite v-for="invite in paginated('items')" :key="invite.id" :invite="invite"></invite>
        </paginate>
        <paginate-links class="flex justify-center" for="items" :show-step-links="true"></paginate-links>
    </section>
</template>

<script>
    import Invite from "./Invite";

    export default {
        components: {Invite},
        props: {
            invites: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                inviteList: this.invites,
                paginate: ['items']
            }
        }
    }
</script>
<style>
    ul {
        list-style-type: none;
        padding: 0;
    }

    .paginate-links li a {
        display: inline-block;
        height: 2em;
        margin: 0 8px;
        width: 2em;
        @apply .flex .flex-col .justify-center .text-center .rounded-full .text-peachy-pink .font-bold .cursor-pointer;
    }

    .paginate-links li a:hover {
        @apply .border-2 .border-peachy-pink;
    }

    .paginate-links.items .active a {
        @apply .text-white .bg-peachy-pink;
    }

    .paginate-links.items .disabled a {
        @apply .text-grey;
    }

    .paginate-links .disabled a:hover {
        @apply .border-0;
    }
</style>
