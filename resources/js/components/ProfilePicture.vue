<template>
    <div class="flex flex-col items-center">
        <div class="h-32 w-32 sm:h-32 sm:w-32 rounded-full border-4 sm:border-4 border-peachy-pink relative cursor-pointer"
             @click="openUploadPrompt">
            <div class="ml-20 w-10 h-10 bg-peachy-pink absolute flex justify-end rounded">
                <img class="h-4 w-4" src="/img/pencil-white.svg">
            </div>
            <img v-if="!hasNoAvatar" class="h-full w-full absolute" :src="avatar" alt="Avatar">
            <div v-else>
                <div class="h-full w-full absolute bg-peachy-pink rounded-full"></div>
                <div class="h-full w-full flex flex-col justify-center items-center absolute">
                    <p class="text-xs text-center text-white">Upload a new profile photo</p>
                    <p class="text-2xs text-center text-white">(max: 200px x 200px)</p>
                </div>
            </div>
        </div>

        <span class="mt-2 text-xl font-light text-red" v-if="errors.hasOwnProperty('avatar')" v-text="errors.avatar[0]"></span>

        <form class="hidden" method="POST" enctype="multipart/form-data">
            <input type="file" id="avatarInput" name="avatar" accept="image/*" @change="onAvatarUploaded">
        </form>
    </div>
</template>

<script>
    export default {
        computed: {
            hasNoAvatar() {
                // let test = this.avatar.split('/');
                // return test[test.length - 1] === 'default.svg';

                return true
            }
        },

        data() {
            return {
                avatar: window.user.avatar_path,
                errors: {}
            }
        },

        methods: {
            openUploadPrompt() {
                document.getElementById('avatarInput').click();
            },

            onAvatarUploaded(e) {
                if (! e.target.files.length) return;

                let avatar = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(avatar);

                reader.onload = e => {
                    this.avatar = e.target.result;
                };

                this.persist(avatar);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/users/${this.user.id}/avatars`, data)
                    .then(() => {
                        this.errors = {}
                    })
                    .catch((errors) => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>
