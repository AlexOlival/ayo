<template>
    <div class="px-2 w-full lg:w-1/4 md:w-1/2 sm:w-1/2">
        <div class="flex flex-col border-2 border-peachy-pink rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center">
                <p class="mr-16 text-lg" v-text="invite.title"></p>
                <div class="flex">
                    <button @click="refuse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0V0z"/>
                            <path fill="#ff8a80" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4 11H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                        </svg>
                    </button>
                    <button @click="accept">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0V0z"/>
                            <path fill="#689f38" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29L5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex mb-16">
                <time class="text-grey-dark text-xs"
                      :datetime="invite.pivot.created_at"
                      v-text="invite.pivot.human_readable_date"
                >
                </time>
            </div>
            <div class="flex">
                <img class="h-6 w-6 rounded-full mr-3" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                <img class="h-6 w-6 rounded-full mr-3" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
                <img class="h-6 w-6 rounded-full" src="https://cdn.flash.pt/images/2018-08/img_828x523$2018_08_22_11_45_38_153203_im_636786765242056305.png" alt="Avatar">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            invite: {
                type: Object,
                required: true
            }
        },
        methods: {
            refuse() {
                alert('Invitation Refused');
            },
            accept() {
                alert('Invitation Accepted');
            }
        }
    }
</script>
