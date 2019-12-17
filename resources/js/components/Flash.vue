<template>
    <div class="alert alert-flash" :class="'alert-'+level" role="alert" v-show="show">
        {{ body }}
    </div>
</template>

<script>
    import Noty from 'noty';
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                level: 'alert',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on('flash', data => {
                this.flash(data);
            });

        },

        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    new Noty({
                        type: this.level,
                        theme: 'mint',
                        progressBar: true,
                        text: this.body,
                        layout: 'topRight',
                        timeout: 5000,
                    }).show();  
                }

            }        
        }
    }
</script>
