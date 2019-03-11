<template>
    <section>
        <header class="flex justify-between px-10 items-center mb-2">
            <h2 class="font-medium text-grey-dark text-lg">Invites</h2>
            <a href="#"
               class="text-sm text-peachy-pink no-underline"
               v-if="numberOfInvites > 4"
            >
                See all ({{ numberOfInvites }})
            </a>
        </header>
        <section class="flex flex-wrap px-5 -mx-2 items-center">
            <invite v-for="invite in invites" :key="invite.id" :invite="invite"></invite>
        </section>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                invites: null,
                numberOfInvites: 0,
            }
        },
        mounted() {
            axios.get('/invites')
                .then((response) => {
                    this.invites = response.data;
                    this.numberOfInvites = response.data.length;
                });
        },
    }
</script>
