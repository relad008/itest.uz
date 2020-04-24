webpackJsonp([18],{

/***/ 111:
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
      { staticClass: "profile container" },
      [
        _c("i-navigation"),
        _vm._v(" "),
        _c("div", { staticClass: "row animated fadeInUp" }, [
          _c(
            "div",
            { staticClass: "col-lg-3 col-md-4" },
            [
              _c(
                "div",
                { staticClass: "p-xl blocks-shadow rounded bg-white" },
                [
                  _c("p", { staticClass: "font-semibold mb-lg" }, [
                    _vm._v(_vm._s(_vm.theme))
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "tickets__info mb-md" }, [
                    _c("i", { staticClass: "icon-file-expected" }),
                    _vm._v(" "),
                    _c("div", [
                      _c("p", { staticClass: "text-sm" }, [
                        _vm._v(
                          _vm._s(_vm.trans("cabinet.tickets.last_message"))
                        )
                      ]),
                      _vm._v(" "),
                      _c("p", { staticClass: "text text-black" }, [
                        _vm._v(_vm._s(_vm.lastMessage))
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "tickets__info" }, [
                    _c("i", { staticClass: "icon-clock" }),
                    _vm._v(" "),
                    _c("div", [
                      _c("p", { staticClass: "text-sm" }, [
                        _vm._v(
                          _vm._s(_vm.trans("cabinet.tickets.created_date"))
                        )
                      ]),
                      _vm._v(" "),
                      _c("p", { staticClass: "text text-black" }, [
                        _vm._v(_vm._s(_vm.createdAt))
                      ])
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "router-link",
                {
                  staticClass:
                    "btn btn--brand btn--y-lg mt-xl mb-sm full-width text-center",
                  attrs: { to: "/tickets" }
                },
                [
                  _vm._v(
                    "\n                        Назад\n                    "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass:
                    "btn btn--danger btn--y-lg full-width text-center",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.closeTicket($event)
                    }
                  }
                },
                [
                  _vm._v(
                    "\n                        " +
                      _vm._s(_vm.trans("cabinet.tickets.close")) +
                      "\n                    "
                  )
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-lg-9 col-md-8" }, [
            _c("div", { staticClass: "tickets" }, [
              _c("div", { staticClass: "tickets__chat" }, [
                _c(
                  "div",
                  { staticClass: "tickets__chat-content js-message-display" },
                  [
                    _c(
                      "div",
                      { staticClass: "tickets__chat-fixed-wrap" },
                      _vm._l(_vm.messages, function(item, i) {
                        return _c(
                          "div",
                          {
                            key: i,
                            staticClass: "tickets__chat-answer",
                            class: {
                              "tickets__chat-answer--my":
                                _vm.loadedUser &&
                                item.user_id == _vm.loadedUser.id,
                              "tickets__chat-answer--others":
                                _vm.loadedUser &&
                                item.user_id != _vm.loadedUser.id
                            }
                          },
                          [
                            _c(
                              "p",
                              { staticClass: "tickets__chat-answer-date" },
                              [
                                _vm._v(
                                  _vm._s(item.user.name || "Deleted") +
                                    " - " +
                                    _vm._s(item.created_at)
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "p",
                              { staticClass: "tickets__chat-answer-text" },
                              [_vm._v(_vm._s(item.message))]
                            )
                          ]
                        )
                      })
                    )
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "tickets__chat-footer" }, [
                  _c("div", { staticClass: "form-group mb-0" }, [
                    _c(
                      "form",
                      {
                        on: {
                          submit: function($event) {
                            $event.preventDefault()
                            return _vm.sendMessage($event)
                          }
                        }
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c(
                              "md-field",
                              [
                                _c("label", [
                                  _vm._v(
                                    _vm._s(_vm.trans("cabinet.tickets.message"))
                                  )
                                ]),
                                _vm._v(" "),
                                _c("md-input", {
                                  model: {
                                    value: _vm.message,
                                    callback: function($$v) {
                                      _vm.message = $$v
                                    },
                                    expression: "message"
                                  }
                                })
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "input-group-btn-wrap" }, [
                              _c("button", { staticClass: "btn btn--brand" }, [
                                _vm._v(_vm._s(_vm.trans("cabinet.btn.send")))
                              ])
                            ])
                          ],
                          1
                        )
                      ]
                    )
                  ])
                ])
              ])
            ])
          ])
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true

if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-25a3598c", { render: render, staticRenderFns: staticRenderFns })
  }
}

/***/ }),

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_messages_vue__ = __webpack_require__(99);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_25a3598c_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_messages_vue__ = __webpack_require__(111);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_messages_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_25a3598c_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_messages_vue__["a" /* render */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_25a3598c_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_messages_vue__["b" /* staticRenderFns */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/views/ticket/messages.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-25a3598c", Component.options)
  } else {
    hotAPI.reload("data-v-25a3598c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 88:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = ticketList;
/* harmony export (immutable) */ __webpack_exports__["b"] = ticketCreate;
/* harmony export (immutable) */ __webpack_exports__["a"] = ticketClose;
/* harmony export (immutable) */ __webpack_exports__["e"] = ticketSend;
/* harmony export (immutable) */ __webpack_exports__["d"] = ticketMessages;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_request__ = __webpack_require__(7);


function ticketList(type, page, perPage) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'ticket/?type=' + type + '&page=' + page + '&per_page=' + perPage,
        method: 'get'
    });
}

function ticketCreate(data) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'ticket/',
        method: 'post',
        data: data
    });
}

function ticketClose(data) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'ticket/close',
        method: 'post',
        data: data
    });
}

function ticketSend(data) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'ticket/send',
        method: 'post',
        data: data
    });
}

function ticketMessages(id, page) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: 'ticket/' + id + '/messages/?page=' + page,
        method: 'get'
    });
}

/***/ }),

/***/ 99:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__api_ticket__ = __webpack_require__(88);
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
    data: function data() {
        return {
            theme: '',
            lastMessage: '',
            createdAt: '',

            message: null,
            messages: [],
            lastMessagePage: 1
        };
    },


    computed: {
        loadedUser: function loadedUser() {
            return this.$store.getters.user;
        }
    },

    created: function created() {
        this.openTicket(this.$route.params.id);
    },


    methods: {
        openTicket: function openTicket(id) {
            var _this = this;

            this.lastMessagePage = 1;
            this.messages = [];
            Object(__WEBPACK_IMPORTED_MODULE_0__api_ticket__["d" /* ticketMessages */])(id, this.lastMessagePage).then(function (res) {
                var data = res.data;
                _this.theme = data.theme;
                _this.lastMessage = data.last_message;
                _this.createdAt = data.created_at;
                _this.messages = data.messages.data.reverse();
                _this.$nextTick(function () {
                    _this.scrollToEnd();
                });
            });
        },
        sendMessage: function sendMessage() {
            var _this2 = this;

            Object(__WEBPACK_IMPORTED_MODULE_0__api_ticket__["e" /* ticketSend */])({
                ticket_id: this.$route.params.id,
                message: this.message
            }).then(function (res) {
                if (parseInt(res.data.status)) {
                    _this2.message = '';
                    _this2.messages.push(res.data.message);
                    _this2.$nextTick(function () {
                        _this2.scrollToEnd();
                    });
                }
            });
        },
        scrollToEnd: function scrollToEnd() {
            var container = this.$el.querySelector(".js-message-display");
            container.scrollTop = container.scrollHeight;
        },
        closeTicket: function closeTicket() {
            var _this3 = this;

            Object(__WEBPACK_IMPORTED_MODULE_0__api_ticket__["a" /* ticketClose */])({
                id: this.$route.params.id
            }).then(function (res) {
                if (res.data.status) {
                    _this3.$router.push('/tickets');
                }
            });
        }
    }
});

/***/ })

});