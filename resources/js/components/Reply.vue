<template>
        <div :id="'reply-' + this.id " class="card mt-4 mb-4 shadow-sm bg-white rounded">
            <div class="card-header bg-white">
                <div class="level">
                    <h6 class="flex-fill">
                        <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a>
                        <span class="text-muted">said {{ data.created_at }}</span>
                    </h6>

                    <div v-if="signdIn">
                        <favorite :reply="data"></favorite>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group mb-0">
                        <textarea name="" class="form-control" v-model="body"></textarea>

                        <div class="d-flex mt-2">
                            <button type="button" class="btn btn-sm btn-primary mr-1" @click="update">
                                Update
                            </button>
                            <button type="button" class="btn btn-sm btn-link" @click="editing = false">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else v-text="body"
                     @dblclick="canUpdate ? editing = true : editing = false">
                </div>
        </div>


        <div class="card-footer d-flex" v-if="canUpdate">
            <button type="button" class="btn btn-sm btn-secondary mr-1" @click="editing = true">
                Edit
            </button>
            <button type="submit" class="btn btn-sm btn-danger" @click="destroy">
                Delete
            </button>
        </div>
        </div>

</template>
<script>
    import Favorite from "./Favorite";

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            };
        },

        computed: {
            signdIn() {
                return window.App.signdIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                   body: this.body
                });

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);

            }
        }
    }
</script>
