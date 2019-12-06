<template>
    <div class="relative">
        <button @click="toggleMenu" class="relative z-10 block h-10 w-10 rounded-full overflow-hidden focus:outline-none focus:border-white">
            <i class="fas fa-bell fa-lg " :class="classes"></i>
        </button>
        <button v-if="isOpen" @click="isOpen = false" tabindex="-1" class="fixed inset-0 h-full w-full cursor-default"></button>
        <div v-show="isOpen" class="absolute z-30 w-64 mt-2 -right-3 mr-8 py-2 bg-white rounded-lg shadow" v-for="notification in notifications">
            <a class="block text-sm p-3  hover:bg-primary"
               :href="notification.data.link"
               @click="markAsRead(notification)"
               v-text="notification.data.message">
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isOpen: false,
                notifications: false
            }
        },

        created() {
            axios.get("/profiles/" + window.App.user.username + '/notifications')
            .then(response => this.notifications = response.data);
            this.toggleEscape();
        },

        computed: {
          classes() {
              return this.notifications.length ?  'text-redFire' : 'text-gray-600';
          }
        },

        methods: {
            toggleEscape() {
                const handelEscape = (e) => {
                    if (e.key === 'Esc' || e.key === 'Escape') {
                        this.isOpen = false;
                    }
                }
                document.addEventListener('keydown', handelEscape);

                this.$once('hook:beforeDestroy', () => {
                    document.removeEventListener('keydown', handelEscape);
                });
            },
            toggleMenu() {
                this.isOpen = ! this.isOpen;
            },
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.username + '/notifications/' + notification.id);
            }
        }
    }
</script>
