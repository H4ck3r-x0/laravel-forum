<template>
    <div>
    <div class="level">
        <h2 class="flex-fill">
            <img
                class="mr-1 rounded-circle"
                width="100"
                height="100"
                :src="avatar"
                :alt="user.name">
            <span v-text="user.name"></span>
        </h2>
    </div>
        <form v-if="canUpdate" method="POST"  enctype="multipart/form-data">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

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
                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>
