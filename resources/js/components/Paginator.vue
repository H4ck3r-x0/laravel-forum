<template>
    <div v-if="shouldPaginate">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-show="prevUrl">
                    <a class="page-link" href="#" @click.prevent="page--">Previous</a>
                </li>
                <li class="page-item" v-show="nextUrl">
                    <a class="page-link" href="#" @click.prevent="page++">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
            }
        },

        watch: {
          dataSet() {
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;

          },

            page() {
              this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate(){
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('updated', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
