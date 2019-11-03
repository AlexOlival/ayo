<template>
    <modal :classes="'rounded-lg bg-white max-w-1/2'" height="auto" :adaptive="true" name="show-reminder-modal" @before-open="beforeOpen">
        <div v-if="reminder">
            <div class="flex justify-end">
                <img class="pr-8 pt-8 cursor-pointer" src="/img/ic-close.svg" @click="$modal.hide('show-reminder-modal')"/>
            </div>
            <div class="flex flex-col px-10">
                <div class="text-5xl text-black font-bold mb-4">{{ reminder.title }}</div>
                <div class="flex flex-row mb-4">
                    <span class="text-2xl mr-2">{{ reminder.human_readable_notification_date }}</span>
                    <span class="text-2xl text-grey-dark">{{ reminder.notification_date }}</span>
                </div>
                <div class="mb-4" v-if="reminder.guests.length !== 0">
                    <p class="text-grey-dark text-xl mb-4">People</p>
                    <div class="flex mb-4" v-if="reminder.guests.length !== 0">
                        <div class="flex bg-grey-lighter rounded-full w-36 items-center p-1 mr-2" v-for="guest in reminder.guests" :key="guest.id">
                            <img class="h-10 w-10" :src="guest.avatar_path" alt="Avatar">
                            <span class="truncate" v-text="guest.username"></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mb-6" v-if="reminder.description">
                    <span class="text-grey-dark text-xl mb-2">Description</span>
                    <span class="bg-grey-lighter rounded-xl p-2">{{ reminder.description }}</span>
                </div>
                <div class="flex justify-end pb-6 mt-2">
                    <div class="flex items-center" @click="window.alert('edit')">
                        <img class="cursor-pointer h-4 mr-1" src="/img/delete.svg"/>
                        <a class="text-sm font-semibold text-grey-dark underline mr-8 cursor-pointer">DELETE</a>
                    </div>
                    <div class="flex items-center" @click="window.alert('edit')">
                        <img class="cursor-pointer h-4 mr-1" src="/img/pencil.svg"/>
                        <a class="text-sm font-semibold text-grey-dark underline cursor-pointer">EDIT</a>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                reminder: null
            }
        },
        methods: {
            beforeOpen(event) {
                this.reminder = event.params.reminder;
            }
        }
    }
</script>
