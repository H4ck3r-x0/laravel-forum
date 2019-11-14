<template>
    <div>
        <div v-if="signdIn">
            <div class="form-group">
            <textarea name="body"
                      id="body"
                      rows="3"
                      class="form-control"
                      placeholder="Have something to say?"
                      required
                      v-model="body"></textarea>
            </div>
            <button
                type="submit"
                class="btn btn-primary"
                @click="addReply">Send

            </button>
        </div>

    <p class="text-center text-muted" v-else>
        Please <a href="/login">sign in</a> to participate in the forum.
    </p>

    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: '',
            }
        },

        computed: {
          signdIn() {
              return window.App.signdIn;
          }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(response =>  {
                       this.body = '';

                       flash('Your Reply has been published.');

                        this.$emit('created', response.data);
                    });
            }
        }
    }
</script>
