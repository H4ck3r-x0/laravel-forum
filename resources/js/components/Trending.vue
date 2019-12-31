<template>
	<div>
		
	</div>
</template>

<script>
	export default {
		props: ['trending'],

		data() {
			return {
				trendingThreads: JSON.parse(this.trending)
			}
		}

	}
</script>