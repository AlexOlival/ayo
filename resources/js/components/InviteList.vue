<template>
    <section>
        <header class="flex justify-between px-5 items-center">
            <h2 class="font-semibold inline text-grey-dark py-4">Invites</h2>
            <a href="/expanded-invites"
               class="text-sm text-peachy-pink no-underline"
               v-if="numberOfInvites > 4"
            >
                See all ({{ numberOfInvites }})
            </a>
        </header>
            <section class="flex flex-wrap -mx-3 px-5 flex-col sm:flex-row md:flex-row lg:flex-row">
                <invite v-for="invite in invites" :key="invite.id" :invite="invite"/>
            </section>
    </section>
</template>

<script>
    import Invite from "./Invite";

    export default {
        components: {
            Invite
        },
        data() {
            return {
                invites: null,
                numberOfInvites: 0,
            }
        },
        mounted() {
            axios.get('/invites')
                .then((response) => {
                    this.invites = response.data.invites;
                    this.numberOfInvites = response.data.numberOfInvites;
                })
                .catch(error => console.log(error.response))
        },
    }
</script>
