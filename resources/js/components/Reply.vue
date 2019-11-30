<template>
    <div :id="'reply-' + this.id " class="card mt-4 mb-4 shadow-sm bg-white rounded">
        <div class="card-header" :class="isBest ? 'bg-info' : 'bg-white'">
            <div class="level">
                <h6 class="flex-fill">
                    <img
                        class="mr-1 rounded-circle"
                        width="32"
                        height="32"
                        :src="reply.owner.avatar_path"
                        :alt="reply.owner.name">
                    <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name"></a>
                    <span class="text-muted" v-text="ago"></span>
                </h6>

                <div v-if="signdIn">
                    <favorite :reply="reply"></favorite>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group mb-0">
                        <textarea name="body" class="form-control" v-model="body" required></textarea>

                        <div class="d-flex mt-2">
                            <button type="submit" class="btn btn-sm btn-primary mr-1">
                                Update
                            </button>
                            <button type="button" class="btn btn-sm btn-link" @click="reset">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div v-else v-html="body"
                 @dblclick="authorize('owns', reply) ? editing = true : editing = false">
            </div>
        </div>


        <div class="card-footer d-flex" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-sm btn-secondary mr-1" @click="editing = true">
                    Edit
                </button>
                <button  class="btn btn-sm btn-danger" @click="destroy">
                    Delete
                </button>
            </div>
            <button v-show="! isBest"  class="btn btn-sm btn-info" style="margin-left: auto" @click="markBestReply"
                     v-if="authorize('owns', reply.thread)">
                Best Reply?
            </button>
        </div>
    </div>

</template>
<script>
    import Favorite from "./Favorite";
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            }
        },
        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body
                }) .catch(error => {
                   flash(error.response.data, 'danger');
                });

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.reply.id);

                this.$emit('deleted', this.reply.id);

            },

            markBestReply() {
                axios.post('/replies/' + this.reply.id + '/best');
                window.events.$emit('best-reply-selected', this.id);
            },

            reset() {
                this.body = this.reply.body;
                this.editing = false;
            }
        }
    }
</script>
