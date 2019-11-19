<template>
    <li class="dropdown" v-if="notifications.length">
        <a class="nav-link dropdown-toggle" href="#"   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" v-for="notification in notifications">
            <a class="dropdown-item"
               :href="notification.data.link"
               @click="markAsRead(notification)"
               v-text="notification.data.message">
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + '/notifications')
            .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            }
        }
    }
</script>
