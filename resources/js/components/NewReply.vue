<template>
    <div class="mt-8">
        <div v-if="signdIn">
            <div class="form-group">
                <VueTrix inputName="body" inputId="editor1" v-model="body" :placeholder="placeholder" ></VueTrix>
            </div>
            <button
                v-if="body !== ''"
                type="submit"
                class="mt-3 font-medium tracking-wide px-4 py-1 bg-secondary hover:bg-lightBlue rounded text-white focus:outline-none"
                @click="addReply">Send
            </button>
            <button
                v-else
                disabled
                type="submit"
                class="mt-3 font-medium disabled tracking-wide px-4 py-1 bg-gray-400 cursor-not-allowed rounded text-white focus:outline-none"
                @click="addReply">Send
            </button>
        </div>

    <p class="text-center text-muted" v-else>
        Please <a class="text-secondary" href="/login">Login</a> to participate in the forum.
    </p>

    </div>
</template>

<script>
    import VueTrix from "vue-trix";

    import Tribute from "tributejs";

    export default {
        props: ['endpoint'],
        components: { VueTrix },

        data() {
            return {
                body: '',
                placeholder: 'You have something to say?'
            }
        },

        mounted() {
            let tribute = new Tribute({
                trigger: '@',
                lookup: 'name',
                fillAttr: 'username',
                values: (text, cb) => {
                    this.getUsers(text, users => cb(users));
                }
            });
            tribute.attach(document.getElementsByClassName("trix-content"));
        },

        methods: {
            getUsers(text, cb) {
                let  URL = '/api/users';
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            let data = JSON.parse(xhr.responseText);
                            cb(data);
                        } else if (xhr.status === 403) {
                            cb([]);
                        }
                    }
                };
                xhr.open("GET", URL + "?name=" + text, true);
                xhr.send();
            },
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
