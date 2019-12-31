<template>
    <div class="flex w-full ml-4 mt-2 items-center">
    <label 
    class="w-48 flex flex-col items-center rounded-lg py-1 px-1 tracking-wide uppercase border cursor-pointer hover:text-gray-700">
        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
        </svg>
        <span class="mt-2 text-sm leading-normal">Select an avatar</span>
        <input type='file' class="hidden" accept="image/*" @change="onChange">
    </label>
</div>
    <!-- <input type="file" accept="image/*" @change="onChange"> -->
</template>

<script>
    export default {
        methods: {
            onChange(e) {
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => {
                    let src = e.target.result;
                    this.$emit('loaded', { src, file });
                };
            }
        }
    }
</script>
