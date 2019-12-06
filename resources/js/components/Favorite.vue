<template>
    <button type="submit" class="focus:outline-none" :class="classes" @click="toggle">
        <i class="fas fa-heart fa-1x"></i>
        <span v-text="favoritesCount"></span> Likes
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited,
            }
        },

        computed: {

            classes() {
                return ['text-gray-600 ', this.isFavorited ? 'text-redFire' : 'text-gray-600']
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                this.isFavorited ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);

                this.isFavorited = true;
                this.favoritesCount++;
            },

            destroy() {
                axios.delete(this.endpoint);

                this.isFavorited = false;
                this.favoritesCount--;
            }
        }
    }
</script>
