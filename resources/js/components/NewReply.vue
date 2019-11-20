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
                v-if="body !== ''"
                type="submit"
                class="btn btn-primary"
                @click="addReply">Send
            </button>
            <button
                v-else
                disabled
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
                if (this.body === '') {
                    flash('Reply body is required', 'danger');
                    return false;
                }
                axios.post(this.endpoint, { body: this.body })
                    .then(response =>  {
                       this.body = '';

                       flash('Your Reply has been published.');

                        this.$emit('created', response.data);
                    })
                    .catch(onerror => {
                        flash(onerror.response.data, 'danger');
                    });
            }
        }
    }
</script>
