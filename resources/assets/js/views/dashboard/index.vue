<template>
    <div>
        <div class="container statistics">
            
            <i-navigation></i-navigation>

            <template v-if="testSession">

                <div class="statistics-info animated fadeInUp">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="statistics__card">
                                <p class="text-center pb-sm">
                                    <span class="title">{{ testSession.total_ball }}</span>
                                    <i class="icon-like icon-lg"></i>
                                </p>
                                <p class="font-medium text-lg pb-lg">{{ trans('cabinet.stats.last_score') }}</p>
                                <p class="statistics__card-item">
                                    <span>{{ trans('cabinet.stats.speed') }}</span>
                                    <span>{{ testSession.speed }}</span>
                                </p>
                                <p class="statistics__card-item">
                                    <span>{{ trans('cabinet.stats.max_score') }}</span>
                                    <span>{{ bestSession.total_ball }}</span>
                                </p>
                                <p class="statistics__card-item">
                                    <span>{{ trans('cabinet.stats.best_speed') }}</span>
                                    <span>{{ bestSession.speed }}</span>
                                </p>
                            </div>  <!-- /.statistics__card -->
                        </div>  <!-- /.col-md-4 -->
                        <div class="col-md-4">
                            <div class="statistics__card">
                                <p class="text-center pb-sm">
                                    <span class="title">{{ testSession.total_correct }}</span>
                                    <i class="icon-check"></i>
                                </p>
                                <p class="font-medium text-lg pb-lg">{{ trans('cabinet.stats.right_answers') }}</p>
                                <p v-for="(subject, index) in subjects" :key="index" class="statistics__card-item">
                                    <span>{{ subject.name }}</span>
                                    <span>{{ param(testSession, 'correct_count', index) }}</span>
                                </p>
                            </div>  <!-- /.statistics__card -->
                        </div>  <!-- /.col-md-4 -->
                        <div class="col-md-4">
                            <div class="statistics__card">
                                <p class="text-center pb-sm">
                                    <span class="title">
                                        {{ (testSession.total_questions - testSession.total_correct) || 0 }}
                                    </span>
                                    <i class="icon-stop"></i>
                                </p>
                                <p class="font-medium text-lg pb-lg">{{ trans('cabinet.stats.wrong_answers') }}</p>
                                <p v-for="(subject, index) in subjects" :key="index" class="statistics__card-item">
                                    <span>{{ subject.name }}</span>
                                    <span>{{ param(testSession, 'questions_count', index) - param(testSession, 'correct_count', index) }}</span>
                                </p>
                            </div>  <!-- /.statistics__card -->
                        </div>  <!-- /.col-md-4 -->
                    </div>  <!-- /.row -->
                </div>  <!-- /.statistics -->
                
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
                        <!-- <div class="tabs-pane statistics__tabs-pane" :class="{'active':index==1}" :id="'tab-' + index"> -->
                        <mb-tabs-content :id="'tab-' + index" 
                                        :class="{'is-active':index == 1}"
                                        class="statistics__tabs-pane"
                                        :key="subject.id">
                            <carousel :perPageCustom="[[100, 1], [420, 2], [600, 3], [1200, 4]]"
                                        :paginationEnabled="false"
                                        class="slider"
                                        ref="tempCarousel">
                                <slide v-for="(section, i) in answerSections[index]" 
                                        :key="i" 
                                        class="slider-item"
                                        :ref="'slide' + i">
                                    <table class="statistics__table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th v-for="symbol in symbols" :key="symbol">{{ symbol }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(answer, j) in answerSections[index][i]" :key="j">
                                                <th>{{ j }}</th>
                                                <th v-for="symbol in symbols" :key="symbol">
                                                    <span v-if="answer['answer'] == symbol" :class="{'mark correct': answer['correct'] == symbol, 'mark mistake': answer['correct'] != symbol}"></span>
                                                    <span v-else class="mark"></span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </slide>    <!-- /.slide -->
                            </carousel> <!-- /.slider -->
                        </mb-tabs-content>  <!-- /.tabs-content -->
                    </template>

                </div>  <!-- /.tab-content -->

                <div class="text-center py-layout-xs">
                    <router-link :to="'mistakes/' + testSession.id " class="btn btn--brand">{{ trans('cabinet.stats.work_on_mistakes') }}</router-link>
                </div>
            </template>
            
            <template v-else>
                
                <div class="no-content">
                    <img :src="noContentImage" class="no-content__thumb">
                    <div class="no-content__wrap">
                        <p class="mb-md">
                            {{ trans('cabinet.greetings') }}, {{ user.name }}!<br>
                            <span v-html="trans('cabinet.no_tests_yet')"></span>
                        </p>
                        <router-link to="/demo-select" class="btn btn--brand">{{ trans('cabinet.btn.start_test') }}</router-link>
                    </div>
                </div>  <!-- /.no-content -->

            </template>

        </div>  <!-- /.container -->

    </div>
</template>

<script>
    import Tabs from '../components/tabs/tabs.vue'
    import TabsMenu from '../components/tabs/tabs-menu.vue'
    import TabsContent from '../components/tabs/tabs-content.vue'
    import VueCollapse from 'vue2-collapse'
    import { Carousel, Slide } from 'vue-carousel'
    import { mapGetters } from 'vuex'
    import { lastStatistics } from '@/api/test'

    export default {
        data() {
            return {
                noContentImage: '../assets/images/no-tests.svg',
                subjects: [],
                testSession: {

                },
                bestSession: {

                },
                answerSections: {
                    1: [],
                    2: [],
                    3: []
                },
                symbols: ['A', 'B', 'C', 'D'],
            }
        },
        computed: {
            ...mapGetters(['user']),
        },
        created() {
            lastStatistics().then((res) => {
                let data = res.data
                this.subjects = data.subjects
                this.answerSections = data.answer_sections
                this.testSession = data.test_session
                this.bestSession = data.best_session
                
                setTimeout(() => {
                    this.$refs.mbTabs.init();
                });

            })  // axios
        },
        methods: {
            param (testSession, pName, subjNum, qNum) {
                let name = pName + '_' + subjNum
                if (qNum) {
                    name += '_' + qNum
                }

                return testSession[name];
            },

            activeClass:function(e){
                if(true == e.status){
                    return e.vm.nodes.toggle.className = "statistics__accordion-trigger v-collapse-toggler is-active";
                }else{
                    return e.vm.nodes.toggle.className = "statistics__accordion-trigger v-collapse-toggler";
                }
            },

            initCarousel() {
                window.dispatchEvent(new Event('resize'));
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