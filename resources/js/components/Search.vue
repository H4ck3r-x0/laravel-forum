<template>
    <ais-instant-search :class-names="{'ais-InstantSearch':''}" :search-client="searchClient" index-name="threads" :routing="routing">
        <ais-search-box autofocus  :class-names="{'ais-SearchBox-input': 'form-control'}" />
        <ais-refinement-list attribute="channel.name" />
        <ais-hits>
            <div slot="item" slot-scope="{ item }">
                <a :href="item.path">
                    <ais-highlight attribute="title" :hit="item" />
                </a>
                <div v-text="item.body"></div>
            </div>
        </ais-hits>
        <ais-pagination  />
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';
    import { history } from 'instantsearch.js/es/lib/routers';
    import { simple } from 'instantsearch.js/es/lib/stateMappings';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    '1DCNI5T8A8',
                    '9de0b6b63ca29921ebd60cf07767abbf'
                ),
                routing: {
                    router: history(),
                    stateMapping: simple(),
                },
            };
        },

    };
</script>

