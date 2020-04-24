<template>
    <div class="test__accordion-nested">
        <div class="test__accordion-wrap" v-for="(theme, i) in list" :key="i" v-if="theme.list.length == 0">
            <div class="test__accordion-floated">
                <p class="test__accordion-info">
                    <i class="test__accordion-info-icon"></i>{{ theme.name }}
                </p>
                <p class="test__accordion-subtitle">подтем: {{ theme.list.length }}</p>
            </div>
            <router-link :to="'/thematic/' + theme.id" class="btn btn--blue btn--x-lg test__accordion-btn">Начать тест</router-link>
        </div>	<!-- /.test__accordion-wrap -->
        
        <v-collapse-wrapper v-for="(theme, i) in list" :key="i" v-if="theme.list.length > 0" class="test__accordion-item" v-on:onStatusChange="activeClass">
            <div class="test__accordion-trigger" v-collapse-toggle>
                <div class="test__accordion-wrap">
                    <div class="test__accordion-floated">
                        <p class="test__accordion-info">
                            <i class="icon-arrow-right"></i>{{ theme.name }}
                        </p>
                        <p class="test__accordion-subtitle">подтем: {{ theme.list.length }}</p>
                    </div>
                    <router-link :to="'/thematic/' + theme.id" class="btn btn--blue btn--x-lg test__accordion-btn">Начать тест</router-link>
                </div>	<!-- /.test__accordion-wrap -->
            </div>  <!-- /.collapse-trigger -->

            <div class="test__accordion-inner" v-collapse-content>
                <i-collapse :list="theme.list"></i-collapse>
            </div>	<!-- /.collapse-content -->
        </v-collapse-wrapper>

    </div>	<!-- /.test__accordion-wrap-nested -->
</template>

<script>
    import iCollapse from './collapse'
    export default {
        props: {
            list: {
                type: Array,
                required: true
            }
        },
        watch: {
            
        },
        data () {
            return {
                
            }
        },
        methods: {
            activeClass:function(e){
			    if(true == e.status){
			        return e.vm.nodes.toggle.className = "test__accordion-trigger v-collapse-toggler is-active";
			    }else{
			        return e.vm.nodes.toggle.className = "test__accordion-trigger v-collapse-toggler";
			    }
			},
        }
    }
</script>
