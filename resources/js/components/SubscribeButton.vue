<template>
    <button :class="clasess" @click="subscribe">
        <i class="fas fa-bell"></i>
    </button>
</template>

<script>
    export default {
        props: ['active'],
        data() {
          return {
              status: this.active
          }
        },
        computed: {
          clasess() {
              return ['text-gray-600 focus:outline-none', this.status ? 'text-redFire' : 'text-gray-600'];
          }
        },

        methods: {
            subscribe() {
                axios[this.status ? 'delete' : 'post'](location.pathname + '/subscriptions');

                this.status = ! this.status;
                let state = this.status ?  'subscribed' : 'Unsbscibed';
                flash('You have ' + state + ' from this thread.');
            }
        }
    }
</script>
