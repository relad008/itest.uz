<template>
    <div>
        <div class="container statistics">

            <i-navigation></i-navigation>
            
            <div class="animated fadeInUp">
                <div class="text-center">
                    <mb-tabs class="cab-nav cab-nav--tabs" ref="mbTabs">
                        <mb-tabs-menu v-for="(subject, index) in subjects" 
                                        :name="'tab-' + index"
                                        linkClass="cab-nav__link"
                                        class="cab-nav__item"
                                        :class="{'is-active':index == 1}"
                                        :key="subject.id"
                                        @tabClicked="initCarousel"
                                        >
                            {{ subject.name }}
                        </mb-tabs-menu>
                    </mb-tabs>
                </div>  <!-- /.text-center -->

                <div class="tab-content statistics__tabs-content">
                    <template v-for="(subject, index) in subjects">
                    <!-- <div class="tab-pane fade" :class="{'active show':index==1}" :id="'mistak-' + subject.index" role="tab" aria-labelledby="home-tab" :key="index"> -->
                        <!-- <div class="tabs-pane" :class="{'active':index==1}" :id="'tab-' + subject.index" :key="index"> -->
                        <mb-tabs-content :id="'tab-' + index" 
                                    :class="{'is-active':index == 1}"
                                    class="statistics__tabs-pane statistics__tabs-pane--inner"
                                    :key="subject.id">
                            <div class="statistics__accordion">
                                <template v-for="(question, i) in questions[index]">
                                    <v-collapse-group :key="i">
                                        <v-collapse-wrapper class="statistics__accordion-item" v-on:onStatusChange="activeClass">
                                            <div class="statistics__accordion-trigger" v-collapse-toggle>
                                                <span class="statistics__accordion-trigger-num">
                                                    {{ i }}.
                                                </span>
                                                <div class="statistics__accordion-trigger-info">
                                                    <div v-html="question.description"></div>
                                                    <div v-if="question.text">
                                                        <b v-html="question.text.name"></b>
                                                        <span v-html="question.text.text"></span>
                                                    </div>
                                                </div>
                                                <i class="icon-dropdown-arrow statistics__accordion-trigger-icon"></i>
                                            </div>  <!-- /.collapse-toggle -->
                                            <div class="statistics__accordion-inner"  v-collapse-content>
                                                <h5 class="font-semibold text pb-sm">{{ trans('cabinet.test.your_answer') }}:</h5>
                                                <div class="clr-block statistics__accordion-answer-wrap">
                                                    <div class="statistics__accordion-badge fail">
                                                        <span>{{ question.user_answer_symb }}</span>
                                                    </div>
                                                    <p class="statistics__accordion-answer" v-html="question.user_answer_text"></p>
                                                </div>
                                                <h5 class="font-semibold text pb-sm">{{ trans('cabinet.test.your_answer') }}:</h5>
                                                <div class="clr-block ">
                                                    <div class="statistics__accordion-badge success">
                                                        <span>{{ question.correct_answer_symb }}</span>
                                                    </div>
                                                    <p class="statistics__accordion-answer" v-html="question.correct_answer_text"></p>
                                                </div>
                                            </div>  <!-- /.collapse-content -->
                                        </v-collapse-wrapper>
                                    </v-collapse-group>
                                </template>

                            </div>  <!-- /.accordion -->

                        </mb-tabs-content>  <!-- /.tabs-content -->
                    </template>

                </div>  <!-- /.tab-content -->

                <div class="text-center pb-layout-xs pt-sm">
                    <router-link :to="'/'" class="btn btn--brand">{{ trans('cabinet.btn.back_to_stats') }}</router-link>
                </div>
            </div>

        </div>  <!-- /.container -->

    </div>
</template>

<script>
    import Tabs from '../components/tabs/tabs.vue'
    import TabsMenu from '../components/tabs/tabs-menu.vue'
    import TabsContent from '../components/tabs/tabs-content.vue'
    import VueCollapse from 'vue2-collapse'
    import { Carousel, Slide } from 'vue-carousel'

    export default {
        data() {
            return {
                subjects: [],
                questions: []
            }
        },
        created() {

            axios.get('/api/test/mistakes/' + this.$route.params.id).then((res) => {
                let data = res.data
                this.subjects = data.subjects
                this.questions = data.questions

                let _this = this

                setTimeout(() => {
                    this.$refs.mbTabs.init();
                });
            })  // axios
        },
        methods: {
            activeClass:function(e) {
                if(true == e.status){
                    return e.vm.nodes.toggle.className = "statistics__accordion-trigger v-collapse-toggler is-active";
                } else {
                    return e.vm.nodes.toggle.className = "statistics__accordion-trigger v-collapse-toggler";
                }
            },
            initCarousel() {
                window.dispatchEvent(new Event('resize'))
            }
        },
        components: {
            'mb-tabs': Tabs,
            'mb-tabs-menu': TabsMenu,
            'mb-tabs-content': TabsContent,
            Carousel,
            Slide
        }
    }
</script>