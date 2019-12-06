<template>
    <div class="relative">
        <button @click="toggleMenu" class="relative z-10 block h-10 w-10 rounded-full overflow-hidden border-2 focus:outline-none focus:border-white">
            <img
                class="h-full w-full object-cover"
                width="100"
                height="100"
                :src="avatar"
                >
        </button>
        <button v-if="isOpen" @click="isOpen = false" tabindex="-1" class="fixed inset-0 h-full w-full cursor-default"></button>
        <div class="relative">
            <div v-show="isOpen" class="absolute right-0 z-10 w-48 mt-3 py-2 bg-white rounded-lg shadow">
                <a class="block px-4 py-2 hover:bg-primary" :href='/profiles/ + username '>
                    <i class="fas fa-user mr-1"></i> Profile
                </a>
                <a class="block px-4 py-2 hover:bg-primary" href="/logout" @click="logout">
                    <i class="fas fa-sign-out-alt mr-1"></i> Sign Out
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isOpen: false,
                name: window.App.user.name,
                username: window.App.user.username,
                avatar: window.App.user.avatar_path,
            }
        },

        created() {
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

        methods: {
            toggleMenu() {
              this.isOpen = ! this.isOpen;
            },
            logout(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
