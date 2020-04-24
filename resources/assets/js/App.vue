<template>
	<div id="cabinet" class="relative">
		<router-view></router-view>
		<notifications 
			group="cabinet"
			classes="alert"
			position="top center"
		>
			<template>
				<div>
					<a class="close">
						x
						<i class="fa fa-fw fa-close"></i>
			        </a>
				</div>
			</template>
		</notifications>
		<preloader ref="preloader" v-if="loading"></preloader>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import preloader from './views/components/preloader'

export default {
	name: 'cabinet',
	computed: {
		...mapGetters([
			'loading'
		])
	},
	components: {
		preloader: preloader
	}
}
</script>
