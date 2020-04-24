<template>
	<li class="tabs-menu__item" :data-id="name" @click="onClick">
		<a :class="linkClass">
			<slot></slot>
		</a>
	</li>
</template>

<script>
	export default {
		props: ['name', 'linkClass'],
		data() {
			return {

			}
		},
		methods: {
			onClick() {
				this.$emit('tabClicked')
			}
		}
	}
</script>