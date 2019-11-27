<script>
    import Replies from "../components/Replies";
    import SubscribeButton from "../components/SubscribeButton";
    export default {

        props: ['thread'],

        components: { Replies, SubscribeButton },

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {
                    title: this.thread.title,
                    body: this.thread.body
                }
            }
        },

        methods: {
            update() {
                let uri = `/threads/${this.thread.channel}/${this.thread.slug}`;
                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.title = this.form.title;
                    this.body  = this.form.body;

                   flash('Your Thread has been updated.')
                });
            },

            resetForm() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                }
                this.editing = false;
            },

            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
                this.locked = ! this.locked;
            }
        }
    }
</script>
