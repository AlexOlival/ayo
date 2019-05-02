<template>
    <div class="px-2 w-full lg:w-1/4 md:w-1/2 sm:w-1/2">
        <div class="flex flex-col border-2 border-peachy-pink rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center">
                <p class="mr-8 text-lg" v-text="reminder.title"></p>
                <img src="favicon.ico" alt="">
            </div>
            <div class="flex mb-8">
                <p class="text-grey-dark text-sm" v-text="reminder.notification_date"></p>
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
            reminder: {
                required: true
            }
        },
        methods: {

        }
    }
</script>
