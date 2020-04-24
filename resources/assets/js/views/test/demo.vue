<template>
    <div>
        <div class="container test">

            <i-navigation></i-navigation>
			
			<div class="test__wrap animated fadeInUp">
				<div class="test__nav-wrap">
					<div class="test__nav">
						<!-- Tabs navigation -->
						<a class="test__nav-item" v-for="(subject, i) in subjects" :key="i" :class="{'active' : i == selectedSubjectNum}" @click="setSubject(i)">{{ subject.name }}</a>
						<!-- <a class="test__nav-item" :class="{'active' : 2 == selectedSubjectNum}" @click="setSubject(2)">English</a>
						<a class="test__nav-item" :class="{'active' : 3 == selectedSubjectNum}" @click="setSubject(3)">Ona tili</a> -->
					</div>
				</div>	<!-- /.test__nav-wrap -->
				<div class="test__list-wrap">
					<ul class="test__list" ref="testList">
						<li v-for="(question, questionNum) in questions[selectedSubjectNum]"
							:key="questionNum"
							:class="isSelectedQuestion(questionNum)"
							class="test__list-item"
						>
							<a href="" 
								@click.prevent = setQuestion(questionNum)
								class="test__list-link"
							>{{ questionNum }}</a>
						</li> 
					</ul>	<!-- /.test__list -->
				</div>
			</div>	<!-- /.test__wrap -->

			<div class="test__info-wrap clr-block">
				<div class="test__info test__info--left">
					<i class="icon-question"></i>
					<span class="font-medium"> {{ trans('cabinet.test.question') }} {{ selectedQuestionNum }}</span>
				</div>	<!-- /.test__info .test__info--left -->
				<div class="test__info test__info--right">
					<i class="icon-clock"></i>
					<span class="font-regular"> 
						{{ trans('cabinet.test.left') }} 
						<span class="font-medium">{{ timer.hour }} : {{ timer.min }} : {{ timer.sec }}</span>
					</span>
				</div>	<!-- /.test__info .test__info--right -->
			</div>	<!-- /.test__info-wrap -->

			<div class="test__question" v-for="question in selectedQuestions" :key="question.num">
				<div class="test__question-description" v-html="question.description"></div>
				<div class="test__question-answer" v-for="(mark, markKey) in answerMarks" 
					:key="markKey"
					@click="checkAnswer(question.num, mark)"
				>
					<div class="test__question-answer-badge"
						:class="checkedMarkClass(question.num, mark)"
					>
						<span class="absolute centered">{{ mark }}</span>
					</div>
					<div class="test__question-answer-text" v-html="question[mark]"></div>
				</div>
			</div>

			<div class="text-center py-layout-xs">
				<button class="btn btn--brand mr-sm mb-md-400" @click="nextQuestion()">
					{{ trans('cabinet.test.next_question') }}
				</button>
				<button class="btn btn--danger" @click="finish()">
					{{ trans('cabinet.test.end_test') }}
				</button>
			</div>

		</div>
	</div>
</template>

<script>
	import { thematic, direction, getResult } from '@/api/test'
    export default {
		props: ['type'],
		data() {
			return {
				selectedSubjectNum: 1,
				selectedQuestionNum: 1,
				selectedQuestionNums: {
					1: 1,
					2: 1,
					3: 1
				},
				selectedQuestions: [],
				questions: [],
				questionCounts: [],
				questionCount: 0,
				noChat: true,
				sessionId: null,
				subjects: [],
				testSessions: [],
				texts: [],
				answerMarks: ['A','B','C','D'],
				answers: {},
				answeredCount: 0,
				timer: {
					hour: 0,
					min: 0,
					sec: 0
				},
				loading: false
			}
		},
        created() {
			if (this.type == 'thematic') {
				thematic(this.$route.params.id)
					.then((res) => {
						if (res.data.status !== undefined && parseInt(res.data.status) == 0) {
							this.$notify({
								group: 'cabinet',
								text: res.data.message,
								type: 'alert-danger',
								duration: 5000
							})
							this.$router.push('/payment')
						} else {
							this.initData(res.data)
							this.initTimer()
							
							let qList = this.$refs.testList
							// 72 is the width of one testList item (element)
							qList.style.width = (72 * Object.keys(this.questions[1]).length) + "px"
						}
					})
			} else {
				if (this.$route.params.sub1 == 0 ||
					this.$route.params.sub2 == 0
				) {
					// 
					this.$notify({
						group: 'cabinet',
						text: 'Перед прохождением теста выберите, пожалуйста, свое направление',
						type: 'alert-danger',
						duration: 4 * 1000
					})
					this.$router.push('/profile')
				} else {
					direction(this.type, this.$route.params.sub1, this.$route.params.sub2, this.$route.params.sub3).then((res) => {
						if (res.data.status !== undefined && parseInt(res.data.status) == 0) {
							this.$notify({
								group: 'cabinet',
								text: res.data.message,
								type: 'alert-danger',
								duration: 5000
							})
							this.$router.push('/payment')
						} else {
							this.initData(res.data)
							this.initTimer()

							let qList = this.$refs.testList
							// 72 is the width of one testList item (element)
							qList.style.width = (72 * Object.keys(this.questions[1]).length) + "px"
						}
					})
				}
			}
		},
		methods: {
			initData(data) {
				this.questions = data.questions
				this.noChat = data.noChat
				this.sessionId = data.session_id
				this.subjects = data.subjects
				this.testSessions = data.testSessions
				this.texts = data.texts

				for (let subjectNum in this.questions) {
					const questionList = this.questions[subjectNum]
					const questionNums = Object.keys(questionList)
					if(this.questionCount == 0)
					{
						this.selectedSubjectNum=subjectNum;
						this.selectedQuestionNum=questionNums[0];
					}
					this.answers[subjectNum] = {}
					this.selectedQuestionNums[subjectNum] = questionNums[0]
					this.questionCounts[subjectNum] = questionNums.length
					this.questionCount += questionNums.length
				}
				
				this.setSubject(this.selectedSubjectNum)
			},

			initTimer() {
				this.timer.min = Math.round(1.4 * this.questionCount)
				if (this.timer.min > 60) {
					this.timer.hour = Math.floor(this.timer.min / 60)
					this.timer.min = this.timer.min % 60;
				}
				const runTimer = () => {
					setTimeout(() => {
						this.timer.sec--;
						if (this.timer.sec < 0)
						{
							this.timer.min--;
							this.timer.sec = 59
						}
						if (this.timer.min < 0)
						{
							this.timer.hour--;
							this.timer.min = 59
						}
						if (this.timer.hour <= 0 && this.timer.min <= 0 && this.timer.sec <= 0) {
							// this.finish(true)
						} else {
							runTimer()
						}
					}, 1000)
				}
				runTimer()
			},

			setSubject(num) {
				this.selectedSubjectNum = num
				this.setQuestion(this.selectedQuestionNums[num]);
			},

			setQuestion(num) {
				const questionsBySubject = this.questions[this.selectedSubjectNum]
				this.selectedQuestionNums[this.selectedSubjectNum] = num
				const len = Object.keys(questionsBySubject).length

				// If array of questions is empty, it will exit
				if (!len) {
					return
				}

				this.selectedQuestionNum = num
				this.selectedQuestions = []
				const selectedQuestion = questionsBySubject[num]
				let start = num
				let end = parseInt(start) + 1

				if (selectedQuestion.text_id != 0) {
					start = 1
					end = len
				}

				for (let i = start; i < end; i++) {
					let question = questionsBySubject[i]
					if (question.text_id === selectedQuestion.text_id) {
						question.num = i
						this.selectedQuestions.push(question)
					}
				}
			},

			checkAnswer(questionNum, answer) {
				if (!(questionNum in this.answers[this.selectedSubjectNum])) {
					this.answeredCount++
				}
				this.answers[this.selectedSubjectNum][questionNum] = answer
				if(this.selectedQuestions.length < 2) {
					this.nextQuestion();
				}
			},

			isSelectedQuestion(num) {
				// return {
					// active: num == this.selectedQuestionNum ||
								   // this.answers[this.selectedSubjectNum][num]
				// }
					if (num == this.selectedQuestionNum) {
						return {active: num == this.selectedQuestionNum}
					}
					else {
						return {answered: this.answers[this.selectedSubjectNum][num]}
					}
			},

			checkedMarkClass(questionNum, mark) {
				const subject = this.answers[this.selectedSubjectNum]
				const obj = {
					checked: questionNum in subject && subject[questionNum] == mark
				}
				return obj
			},

			nextQuestion() {
				let newSelected = this.selectedQuestions[this.selectedQuestions.length-1].num * 1 + 1;
				
				if (newSelected >= this.questionCounts[this.selectedSubjectNum]) {
					newSelected = 1
				}

				let offset = newSelected - 1

				for (let i = 1; i <= this.questionCounts[this.selectedSubjectNum]; i++) {
					var newNum = i + offset
					if (newNum > this.questionCounts[this.selectedSubjectNum]) {
						offset = -i
						newNum = 1
					}

					if (!(newNum in this.answers[this.selectedSubjectNum])) {
						newSelected = newNum
						break
					}
				}

				if (this.questionCount == this.answeredCount) {
					console.log('finish')
					return
				}
				
				if (Object.keys(this.answers[this.selectedSubjectNum]).length == this.questionCounts[this.selectedSubjectNum]) {
					let subjectNum = this.selectedSubjectNum * 1 + 1
					if (subjectNum > Object.keys(this.questionCounts).length) {
						subjectNum = 1
					}
					this.setSubject(subjectNum)
				} else {
					this.setQuestion(newNum)
				}
			},

			finish() {
				if (!this.loading) {
					this.loading = true
					getResult({
						answers: this.answers,
						session_id: this.sessionId
					}).then((data) => {
						this.loading = false
						this.$router.push('/')
					})
				}
			}
		}
    }
</script>

