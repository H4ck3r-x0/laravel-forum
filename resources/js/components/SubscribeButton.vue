<template>
    <button :class="clasess" @click="subscribe">
        Subscribe
    </button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
          clasess() {
              return ['btn', this.active ? 'btn-primary' : 'btn-default'];
          }
        },

        methods: {
            subscribe() {
                axios[this.active ? 'delete' : 'post'](location.pathname + '/subscriptions');

                this.active = ! this.active;
            }
        }
    }
</script>
