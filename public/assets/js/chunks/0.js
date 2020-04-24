webpackJsonp([0],{

/***/ 106:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      { staticClass: "container test" },
      [
        _c("i-navigation"),
        _vm._v(" "),
        _c("div", { staticClass: "test__wrap animated fadeInUp" }, [
          _c("div", { staticClass: "test__nav-wrap" }, [
            _c(
              "div",
              { staticClass: "test__nav" },
              _vm._l(_vm.subjects, function(subject, i) {
                return _c(
                  "a",
                  {
                    key: i,
                    staticClass: "test__nav-item",
                    class: { active: i == _vm.selectedSubjectNum },
                    on: {
                      click: function($event) {
                        _vm.setSubject(i)
                      }
                    }
                  },
                  [_vm._v(_vm._s(subject.name))]
                )
              })
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "test__list-wrap" }, [
            _c(
              "ul",
              { ref: "testList", staticClass: "test__list" },
              _vm._l(_vm.questions[_vm.selectedSubjectNum], function(
                question,
                questionNum
              ) {
                return _c(
                  "li",
                  {
                    key: questionNum,
                    staticClass: "test__list-item",
                    class: _vm.isSelectedQuestion(questionNum)
                  },
                  [
                    _c(
                      "a",
                      {
                        staticClass: "test__list-link",
                        attrs: { href: "" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            _vm.setQuestion(questionNum)
                          }
                        }
                      },
                      [_vm._v(_vm._s(questionNum))]
                    )
                  ]
                )
              })
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "test__info-wrap clr-block" }, [
          _c("div", { staticClass: "test__info test__info--left" }, [
            _c("i", { staticClass: "icon-question" }),
            _vm._v(" "),
            _c("span", { staticClass: "font-medium" }, [
              _vm._v(
                " " +
                  _vm._s(_vm.trans("cabinet.test.question")) +
                  " " +
                  _vm._s(_vm.selectedQuestionNum)
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "test__info test__info--right" }, [
            _c("i", { staticClass: "icon-clock" }),
            _vm._v(" "),
            _c("span", { staticClass: "font-regular" }, [
              _vm._v(
                " \n\t\t\t\t\t\t" +
                  _vm._s(_vm.trans("cabinet.test.left")) +
                  " \n\t\t\t\t\t\t"
              ),
              _c("span", { staticClass: "font-medium" }, [
                _vm._v(
                  _vm._s(_vm.timer.hour) +
                    " : " +
                    _vm._s(_vm.timer.min) +
                    " : " +
                    _vm._s(_vm.timer.sec)
                )
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _vm._l(_vm.selectedQuestions, function(question) {
          return _c(
            "div",
            { key: question.num, staticClass: "test__question" },
            [
              _c("div", {
                staticClass: "test__question-description",
                domProps: { innerHTML: _vm._s(question.description) }
              }),
              _vm._v(" "),
              _vm._l(_vm.answerMarks, function(mark, markKey) {
                return _c(
                  "div",
                  {
                    key: markKey,
                    staticClass: "test__question-answer",
                    on: {
                      click: function($event) {
                        _vm.checkAnswer(question.num, mark)
                      }
                    }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "test__question-answer-badge",
                        class: _vm.checkedMarkClass(question.num, mark)
                      },
                      [
                        _c("span", { staticClass: "absolute centered" }, [
                          _vm._v(_vm._s(mark))
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "test__question-answer-text",
                      domProps: { innerHTML: _vm._s(question[mark]) }
                    })
                  ]
                )
              })
            ],
            2
          )
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center py-layout-xs" }, [
          _c(
            "button",
            {
              staticClass: "btn btn--brand mr-sm mb-md-400",
              on: {
                click: function($event) {
                  _vm.nextQuestion()
                }
              }
            },
            [
              _vm._v(
                "\n\t\t\t\t\t" +
                  _vm._s(_vm.trans("cabinet.test.next_question")) +
                  "\n\t\t\t\t"
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn--danger",
              on: {
                click: function($event) {
                  _vm.finish()
                }
              }
            },
            [
              _vm._v(
                "\n\t\t\t\t\t" +
                  _vm._s(_vm.trans("cabinet.test.end_test")) +
                  "\n\t\t\t\t"
              )
            ]
          )
        ])
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true

if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4c40011d", { render: render, staticRenderFns: staticRenderFns })
  }
}

/***/ }),

/***/ 86:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = lastStatistics;
/* harmony export (immutable) */ __webpack_exports__["a"] = direction;
/* harmony export (immutable) */ __webpack_exports__["d"] = thematic;
/* harmony export (immutable) */ __webpack_exports__["b"] = getResult;
/* harmony export (immutable) */ __webpack_exports__["e"] = thematicSelect;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_request__ = __webpack_require__(5);


function lastStatistics() {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'test/statistics',
        method: 'get'
    });
}

function direction(type, sub1, sub2, sub3) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'test/' + type + '/' + sub1 + '/' + sub2 + '/' + sub3,
        method: 'get'
    });
}

function thematic(id) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'test/thematic/' + id,
        method: 'get'
    });
}

function getResult(data) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'test/get-result',
        method: 'post',
        data: data
    });
}

function thematicSelect() {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'test/thematic-select',
        method: 'get'
    });
}

/***/ }),

/***/ 9:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_demo_vue__ = __webpack_require__(95);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4c40011d_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_demo_vue__ = __webpack_require__(106);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__node_modules_vue_loader_lib_runtime_component_normalizer__ = __webpack_require__(2);
var disposed = false
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null

var Component = Object(__WEBPACK_IMPORTED_MODULE_2__node_modules_vue_loader_lib_runtime_component_normalizer__["a" /* default */])(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_demo_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4c40011d_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_demo_vue__["a" /* render */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4c40011d_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_demo_vue__["b" /* staticRenderFns */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/views/test/demo.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4c40011d", Component.options)
  } else {
    hotAPI.reload("data-v-4c40011d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 95:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__api_test__ = __webpack_require__(86);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
	props: ['type'],
	data: function data() {
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
			answerMarks: ['A', 'B', 'C', 'D'],
			answers: {},
			answeredCount: 0,
			timer: {
				hour: 0,
				min: 0,
				sec: 0
			},
			loading: false
		};
	},
	created: function created() {
		var _this = this;

		if (this.type == 'thematic') {
			Object(__WEBPACK_IMPORTED_MODULE_0__api_test__["d" /* thematic */])(this.$route.params.id).then(function (res) {
				if (res.data.status !== undefined && parseInt(res.data.status) == 0) {
					_this.$notify({
						group: 'cabinet',
						text: res.data.message,
						type: 'alert-danger',
						duration: 5000
					});
					_this.$router.push('/payment');
				} else {
					_this.initData(res.data);
					_this.initTimer();

					var qList = _this.$refs.testList;
					// 72 is the width of one testList item (element)
					qList.style.width = 72 * Object.keys(_this.questions[1]).length + "px";
				}
			});
		} else {
			if (this.$route.params.sub1 == 0 || this.$route.params.sub2 == 0) {
				// 
				this.$notify({
					group: 'cabinet',
					text: 'Перед прохождением теста выберите, пожалуйста, свое направление',
					type: 'alert-danger',
					duration: 4 * 1000
				});
				this.$router.push('/profile');
			} else {
				Object(__WEBPACK_IMPORTED_MODULE_0__api_test__["a" /* direction */])(this.type, this.$route.params.sub1, this.$route.params.sub2, this.$route.params.sub3).then(function (res) {
					if (res.data.status !== undefined && parseInt(res.data.status) == 0) {
						_this.$notify({
							group: 'cabinet',
							text: res.data.message,
							type: 'alert-danger',
							duration: 5000
						});
						_this.$router.push('/payment');
					} else {
						_this.initData(res.data);
						_this.initTimer();

						var qList = _this.$refs.testList;
						// 72 is the width of one testList item (element)
						qList.style.width = 72 * Object.keys(_this.questions[1]).length + "px";
					}
				});
			}
		}
	},

	methods: {
		initData: function initData(data) {
			this.questions = data.questions;
			this.noChat = data.noChat;
			this.sessionId = data.session_id;
			this.subjects = data.subjects;
			this.testSessions = data.testSessions;
			this.texts = data.texts;

			for (var subjectNum in this.questions) {
				var questionList = this.questions[subjectNum];
				var questionNums = Object.keys(questionList);
				if (this.questionCount == 0) {
					this.selectedSubjectNum = subjectNum;
					this.selectedQuestionNum = questionNums[0];
				}
				this.answers[subjectNum] = {};
				this.selectedQuestionNums[subjectNum] = questionNums[0];
				this.questionCounts[subjectNum] = questionNums.length;
				this.questionCount += questionNums.length;
			}

			this.setSubject(this.selectedSubjectNum);
		},
		initTimer: function initTimer() {
			var _this2 = this;

			this.timer.min = Math.round(1.4 * this.questionCount);
			if (this.timer.min > 60) {
				this.timer.hour = Math.floor(this.timer.min / 60);
				this.timer.min = this.timer.min % 60;
			}
			var runTimer = function runTimer() {
				setTimeout(function () {
					_this2.timer.sec--;
					if (_this2.timer.sec < 0) {
						_this2.timer.min--;
						_this2.timer.sec = 59;
					}
					if (_this2.timer.min < 0) {
						_this2.timer.hour--;
						_this2.timer.min = 59;
					}
					if (_this2.timer.hour <= 0 && _this2.timer.min <= 0 && _this2.timer.sec <= 0) {
						// this.finish(true)
					} else {
						runTimer();
					}
				}, 1000);
			};
			runTimer();
		},
		setSubject: function setSubject(num) {
			this.selectedSubjectNum = num;
			this.setQuestion(this.selectedQuestionNums[num]);
		},
		setQuestion: function setQuestion(num) {
			var questionsBySubject = this.questions[this.selectedSubjectNum];
			this.selectedQuestionNums[this.selectedSubjectNum] = num;
			var len = Object.keys(questionsBySubject).length;

			// If array of questions is empty, it will exit
			if (!len) {
				return;
			}

			this.selectedQuestionNum = num;
			this.selectedQuestions = [];
			var selectedQuestion = questionsBySubject[num];
			var start = num;
			var end = parseInt(start) + 1;

			if (selectedQuestion.text_id != 0) {
				start = 1;
				end = len;
			}

			for (var i = start; i < end; i++) {
				var question = questionsBySubject[i];
				if (question.text_id === selectedQuestion.text_id) {
					question.num = i;
					this.selectedQuestions.push(question);
				}
			}
		},
		checkAnswer: function checkAnswer(questionNum, answer) {
			if (!(questionNum in this.answers[this.selectedSubjectNum])) {
				this.answeredCount++;
			}
			this.answers[this.selectedSubjectNum][questionNum] = answer;
			if (this.selectedQuestions.length < 2) {
				this.nextQuestion();
			}
		},
		isSelectedQuestion: function isSelectedQuestion(num) {
			// return {
			// active: num == this.selectedQuestionNum ||
			// this.answers[this.selectedSubjectNum][num]
			// }
			if (num == this.selectedQuestionNum) {
				return { active: num == this.selectedQuestionNum };
			} else {
				return { answered: this.answers[this.selectedSubjectNum][num] };
			}
		},
		checkedMarkClass: function checkedMarkClass(questionNum, mark) {
			var subject = this.answers[this.selectedSubjectNum];
			var obj = {
				checked: questionNum in subject && subject[questionNum] == mark
			};
			return obj;
		},
		nextQuestion: function nextQuestion() {
			var newSelected = this.selectedQuestions[this.selectedQuestions.length - 1].num * 1 + 1;

			if (newSelected >= this.questionCounts[this.selectedSubjectNum]) {
				newSelected = 1;
			}

			var offset = newSelected - 1;

			for (var i = 1; i <= this.questionCounts[this.selectedSubjectNum]; i++) {
				var newNum = i + offset;
				if (newNum > this.questionCounts[this.selectedSubjectNum]) {
					offset = -i;
					newNum = 1;
				}

				if (!(newNum in this.answers[this.selectedSubjectNum])) {
					newSelected = newNum;
					break;
				}
			}

			if (this.questionCount == this.answeredCount) {
				console.log('finish');
				return;
			}

			if (Object.keys(this.answers[this.selectedSubjectNum]).length == this.questionCounts[this.selectedSubjectNum]) {
				var subjectNum = this.selectedSubjectNum * 1 + 1;
				if (subjectNum > Object.keys(this.questionCounts).length) {
					subjectNum = 1;
				}
				this.setSubject(subjectNum);
			} else {
				this.setQuestion(newNum);
			}
		},
		finish: function finish() {
			var _this3 = this;

			if (!this.loading) {
				this.loading = true;
				Object(__WEBPACK_IMPORTED_MODULE_0__api_test__["b" /* getResult */])({
					answers: this.answers,
					session_id: this.sessionId
				}).then(function (data) {
					_this3.loading = false;
					_this3.$router.push('/');
				});
			}
		}
	}
});

/***/ })

});