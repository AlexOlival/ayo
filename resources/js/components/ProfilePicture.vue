<template>
    <div class="flex flex-col items-center">
        <div class="group h-48 w-48 sm:h-96 sm:w-96 rounded-full border-4 sm:border-8 border-peachy-pink relative overflow-hidden cursor-pointer"
             @click="openUploadPrompt">
            <img v-if="!isDefaultAvatar" class="h-full w-full absolute z-10 group-hover:opacity-25" :src="avatar" alt="Avatar">
            <div class="h-full w-full absolute bg-peachy-pink z-0"></div>
            <div class="h-full w-full flex flex-col justify-center items-center absolute z-20" :class="!isDefaultAvatar ? 'invisible group-hover:visible' : ''">
                <img class="h-10 w-10 sm:h-16 sm:w-16" src="/img/ic-add-photo.svg" alt="">
                <p class="text-sm text-center sm:text-2xl text-white font-bold">Upload a new profile photo</p>
            </div>
        </div>

        <span class="mt-2 text-xl font-light text-red" v-if="errors.hasOwnProperty('avatar')" v-text="errors.avatar[0]"></span>

        <form class="hidden" method="POST" enctype="multipart/form-data">
            <input type="file" id="avatarInput" name="avatar" accept="image/*" @change="onAvatarUploaded">
        </form>

        <button class="button button-pink w-1/2 mt-6" @click="openUploadPrompt">
            Upload a new photo
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },

        computed: {
            isDefaultAvatar() {
                let test = this.avatar.split('/');
                return test[test.length - 1] === 'default.svg';
            }
        },

        data() {
            return {
                avatar: this.user.avatar_path,
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
