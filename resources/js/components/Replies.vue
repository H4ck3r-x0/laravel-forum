<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @updated="fetch"></paginator>

        <div v-if="$parent.locked">
            <p class="alert alert-info">This Thread has been locked, no more replies are allowed.</p>
        </div>

        <new-reply :endpoint="endpoint" @created="add" v-else></new-reply>
    </div>
</template>

<script>
    import Reply from "./Reply";
    import NewReply from "./NewReply";
    import collections from "../mixins/Collection";

    export default {

        components: { Reply, NewReply },

        mixins: [ collections ],

        data() {
            return {
                dataSet: false,
                endpoint: location.pathname + '/replies',
            }
        },

        created() {
          this.fetch();
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return location.pathname + '/replies?page=' + page;
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0, 0);
            }
        }
    }
</script>
