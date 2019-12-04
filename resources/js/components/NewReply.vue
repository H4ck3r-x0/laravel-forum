<template>
    <div>
        <div v-if="signdIn">
            <div class="form-group">
                <VueTrix inputName="body" inputId="editor1" v-model="body" :placeholder="placeholder" ></VueTrix>
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
    import Trix from "./Trix";
    import Tribute from "tributejs";

    export default {
        props: ['endpoint'],
        components: { Trix },

        data() {
            return {
                body: '',
                placeholder: 'You have something to say?'
            }
        },

        created() {

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
