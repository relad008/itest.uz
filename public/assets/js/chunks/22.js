webpackJsonp([22],{

/***/ 105:
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
      { staticClass: "payment container" },
      [
        _c("i-navigation"),
        _vm._v(" "),
        _c("div", { staticClass: "animated fadeInUp" }, [
          _c(
            "div",
            { staticClass: "clr-block pb-lg b-b" },
            [
              _c("p", { staticClass: "font-medium text-lg float-left" }, [
                _vm._v(_vm._s(_vm.trans("cabinet.payment.refill_budget")))
              ]),
              _vm._v(" "),
              _c(
                "router-link",
                {
                  staticClass: "link text float-right pt-xs",
                  attrs: { to: "/payment" }
                },
                [
                  _c("i", { staticClass: "icon-arrow-left text-sm mr-xs" }),
                  _vm._v(
                    "\n                    " +
                      _vm._s(
                        _vm.trans("cabinet.payment.back_to_subscription_choose")
                      ) +
                      "\n                "
                  )
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "payment__info" }, [
            _c(
              "p",
              { staticClass: "pb-sm" },
              [
                _c("i", { staticClass: "icon-subscribe mr-sm" }),
                _vm._v(" "),
                _c("span", { staticClass: "mr-xs" }, [
                  _vm._v(
                    _vm._s(_vm.trans("cabinet.payment.subscription_type")) +
                      ": "
                  ),
                  _c("span", { staticClass: "font-medium" }, [_vm._v("Super")])
                ]),
                _vm._v(" "),
                _c("router-link", { attrs: { to: "/payment" } }, [
                  _c("i", { staticClass: "icon-edit edit" })
                ])
              ],
              1
            ),
            _vm._v(" "),
            _c("p", [
              _c("i", { staticClass: "icon-money mr-sm" }),
              _vm._v(" "),
              _c("span", [
                _vm._v(_vm._s(_vm.trans("cabinet.payment.to_pay")) + " "),
                _c("span", { staticClass: "font-medium" }, [
                  _vm._v("199 000 " + _vm._s(_vm.trans("cabinet.soum")))
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "payment__card-wrap" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-4 col-sm-6" }, [
                _c("div", { staticClass: "payment__card" }, [
                  _c("img", {
                    staticClass: "payment__card-thumb",
                    attrs: { src: _vm.logoClick, alt: "Click" }
                  }),
                  _vm._v(" "),
                  _c("p", { staticClass: "font-medium text-lg pb-lg mb-xs" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.to_pay_via_click"))
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-lg mb-xs" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.click_number_binding"))
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group mb-lg" }, [
                    _c("input", {
                      staticClass: "input",
                      attrs: { type: "text" }
                    }),
                    _vm._v(" "),
                    _c("label", { staticClass: "label" }, [
                      _vm._v(_vm._s(_vm.trans("cabinet.payment.tel_number")))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-lg" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.click_button")))
                  ]),
                  _vm._v(" "),
                  _c("button", { staticClass: "btn btn--blue mb-lg" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.fill_by_click")))
                  ]),
                  _vm._v(" "),
                  _c("p", [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.click_instructions"))
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-4 col-sm-6" }, [
                _c("div", { staticClass: "payment__card" }, [
                  _c("img", {
                    staticClass: "payment__card-thumb",
                    attrs: { src: _vm.logoPayme, alt: "Payme" }
                  }),
                  _vm._v(" "),
                  _c("p", { staticClass: "font-medium text-lg pb-lg mb-xs" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.to_pay_via_payme"))
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-xl" }, [
                    _vm._v(
                      "\n                                " +
                        _vm._s(
                          _vm.trans("cabinet.payment.payme_instructions_1")
                        )
                    ),
                    _c("br"),
                    _vm._v(
                      "\n                                " +
                        _vm._s(
                          _vm.trans("cabinet.payment.payme_instructions_2")
                        )
                    ),
                    _c("br"),
                    _vm._v(
                      "\n                                " +
                        _vm._s(
                          _vm.trans("cabinet.payment.payme_instructions_3")
                        ) +
                        "\n                            "
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-lg" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.click_button")))
                  ]),
                  _vm._v(" "),
                  _c("button", { staticClass: "btn btn--brand" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.pay_payme")))
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-4 col-sm-6" }, [
                _c("div", { staticClass: "payment__card" }, [
                  _c("img", {
                    staticClass: "payment__card-thumb",
                    attrs: { src: _vm.logoPaynet, alt: "Paynet" }
                  }),
                  _vm._v(" "),
                  _c("p", { staticClass: "font-medium text-lg pb-lg mb-xs" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.to_pay_via_paynet")) +
                        ":"
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-lg" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.operator")) +
                        " itest.uz,"
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-lg" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.user_id")) + " "),
                    _c("span", { staticClass: "font-semibold" }, [
                      _vm._v("998903511255")
                    ]),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(
                      " " + _vm._s(_vm.trans("cabinet.payment.min_price")) + " "
                    ),
                    _c("br"),
                    _vm._v(
                      " " +
                        _vm._s(_vm.trans("cabinet.payment.to")) +
                        " 1 000 000 " +
                        _vm._s(_vm.trans("cabinet.soum"))
                    )
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "pb-xl" }, [
                    _vm._v(_vm._s(_vm.trans("cabinet.payment.click_button")))
                  ]),
                  _vm._v(" "),
                  _c("button", { staticClass: "btn btn--brand" }, [
                    _vm._v(
                      _vm._s(_vm.trans("cabinet.payment.take_from_balance"))
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
    require("vue-hot-reload-api")      .rerender("data-v-09d8d18a", { render: render, staticRenderFns: staticRenderFns })
  }
}

/***/ }),

/***/ 65:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_pay_vue__ = __webpack_require__(93);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_09d8d18a_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_pay_vue__ = __webpack_require__(105);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_cacheDirectory_true_presets_env_modules_false_targets_browsers_2_uglify_true_plugins_transform_object_rest_spread_transform_runtime_polyfill_false_helpers_false_syntax_dynamic_import_node_modules_vue_loader_lib_selector_type_script_index_0_pay_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_09d8d18a_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_pay_vue__["a" /* render */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_09d8d18a_hasScoped_false_optionsId_0_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_pay_vue__["b" /* staticRenderFns */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/views/dashboard/pay.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-09d8d18a", Component.options)
  } else {
    hotAPI.reload("data-v-09d8d18a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 93:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
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
            logoClick: '../images/logo-click.jpeg',
            logoPayme: '../images/logo-payme.svg',
            logoPaynet: '../images/logo-paynet.png'
        };
    },
    mounted: function mounted() {

        axios.get('/api/user').then(function (res) {
            console.log(res.data);
        });
    }
});

/***/ })

});