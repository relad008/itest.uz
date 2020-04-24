<template>
    <div>
        <div class="container">

            <i-navigation></i-navigation>
			
			<div class="animated fadeInUp">
	            <p class="text-lg mb-lg pb-xs">{{ trans('cabinet.test.choose_category') }}</p>
				
				<div class="accordion test__accordion">

					<v-collapse-group v-for="(theme, i) in themes" :key="i">
		            	<v-collapse-wrapper class="test__accordion-item" v-on:onStatusChange="activeClass">

		                    <div class="test__accordion-trigger" v-collapse-toggle>
		                    	<div class="test__accordion-wrap test__accordion-wrap--first">
		                        	<div class="test__accordion-floated">
			                            <p class="test__accordion-info">
				                            <i class="icon-arrow-right"></i> {{ theme.name }}
				                        </p>
				                        <p class="test__accordion-subtitle">подтем: {{ theme.list.length }}</p>
		                            </div>
		                            <router-link :to="'/thematic/' + theme.id" class="btn btn--blue btn--x-lg test__accordion-btn">{{ trans('cabinet.btn.start_test') }}</router-link>
		                        </div>	<!-- /.test__accordion-wrap -->
		                    </div>  <!-- /.collapse-toggle -->

		                    <div class="test__accordion-inner test__accordion-inner--first" v-collapse-content v-if="theme.list.length > 0">
		                    	<i-collapse :list="theme.list"></i-collapse>
		                    </div>  <!-- /.collapse-content -->
						</v-collapse-wrapper>
					</v-collapse-group>

	            </div>  <!-- /.accordion -->
			</div>
			
        </div>	<!-- /.container -->
    </div>
</template>

<script>
	import VueCollapse from 'vue2-collapse'
	import iCollapse from '../components/collapse/collapse'
	Vue.use(VueCollapse)
	import { thematicSelect } from '@/api/test'

    export default {
        data() {
            return {
            	themes: [],
            }
		},
		created() {
			thematicSelect().then(res => {
				this.themes = res.data;
			})
		},
		mounted() {
		},
        methods: {
        	activeClass(e) {
			    if(true == e.status){
			        return e.vm.nodes.toggle.className = "test__accordion-trigger v-collapse-toggler is-active";
			    }else{
			        return e.vm.nodes.toggle.className = "test__accordion-trigger v-collapse-toggler";
			    }
			},
			checkForClass() {
				// for (var i = 0; i < this.parentCollapseWraps.length; i++) {
				// 	this.parentCollapseWraps[i]
				// }
			}
        }
    }
</script>