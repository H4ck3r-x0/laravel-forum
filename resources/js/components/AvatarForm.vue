<template>
    <div>
    <div class="flex mb-5">
        <div class="flex items-center">
            <img
                class="rounded-full w-32 h-32"
                :src="avatar"
                :alt="user.name">

            <div class="flex flex-col">
                <span v-text="user.name" class="ml-4 text-2xl font-medium text-gray-800"></span>
                <span class="ml-4 text-xs text-gray-600">Member Since {{ago}}</span>       
                <form v-if="canUpdate" method="POST"  enctype="multipart/form-data">
                    <image-upload name="avatar" @loaded="onLoad"></image-upload>
                </form>          
            </div>           
        </div>
    </div>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';
    import moment from 'moment';

    export default {
        props: ['user'],

        components: { ImageUpload },

        data() {
          return {
              avatar: this.user.avatar_path,
          }
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },
            ago() {
                return moment(this.user.created_at).fromNow();
            }
        },

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/api/users/${this.user.username}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>
