<template>
    <div>
        <VueTrix inputId="body" :inputName="name" v-model="editorContent" :placeholder="placeholder"></VueTrix>
    </div>
</template>

<script>
    import VueTrix from "vue-trix";

    export default {
        props: ['name', 'value', 'placeholder'],
        data() {
            return {
                editorContent: this.value,
            }
        },

        methods: {
            updateBodyContent(value) {
                this.$emit("body-changed", value);
            }
        },
        watch: {
            editorContent: {
                handler: "updateBodyContent"
            }
        }
    }
</script>
