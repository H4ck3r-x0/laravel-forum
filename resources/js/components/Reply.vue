<template>
    <div :id="'reply-' + this.id " 
    :class="isBest ? 'border-2 border-green-400 rounded-lg shadow' : ''"
    class="mt-6 hover:bg-gray-100 px-4 py-4 rounded">
        <div class="flex">
            <img
                :class="! isBest ? '' : 'border-2 border-green-400 border-solid'"
                class="w-12 h-12 mr-2 rounded-full"
                :src="reply.owner.avatar_path"
                :alt="reply.owner.name">
            <div class="flex flex-col">
                <a
                    class="text-gray-800 font-bold leading-relaxed hover:underline"
                    :href="'/profiles/' + reply.owner.username"
                    v-text="reply.owner.name">
                </a>
                <span class="text-xs text-gray-500" v-text="ago"></span>
            </div>
            <div class="flex flex-row ml-5">
                <div v-if="authorize('owns', reply)">
                    <button class="text-secondary mr-3 focus:outline-none" @click="editing = true">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button  class="text-redFire focus:outline-none" @click="destroy">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            <div class="ml-auto">
                <div class="flex flex-row items-center">
                       <button 
                        v-show="! isBest"  
                        class="btn btn-sm btn-info mr-3 bg-bestReply text-bestReplyDark py-1 px-3 rounded-full font-semibold focus:outline-none" 
                        style="margin-left: auto" 
                        @click="markBestReply"
                        v-if="authorize('owns', reply.thread)">
                        Best answer
                    </button>
                    <div v-if="signdIn">
                        <favorite :reply="reply"></favorite>
                    </div>                    
                </div>
            </div>
        </div>
        <div
        v-html="body" 
        class="reply_body mt-6 font-medium text-gray-800 font-semibold leading-relaxed tracking-wide">
        </div>
    </div>
</template>

<script>
    import Favorite from "./Favorite";
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

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
