webpackJsonp([0],{

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(70)
/* template */
var __vue_template__ = __webpack_require__(71)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/views/thanks.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0111c808", Component.options)
  } else {
    hotAPI.reload("data-v-0111c808", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  }
});

/***/ }),

/***/ 71:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "page" },
    [
      _c(
        "v-container",
        { attrs: { "justify-center": "" } },
        [
          _c(
            "v-card",
            { attrs: { flat: "" } },
            [
              _c(
                "v-card-text",
                [
                  _c(
                    "v-container",
                    { attrs: { "grid-list-md": "" } },
                    [
                      _c(
                        "v-layout",
                        { attrs: { wrap: "" } },
                        [
                          _c(
                            "v-flex",
                            { attrs: { xs12: "", sm12: "", md12: "" } },
                            [
                              _c(
                                "p",
                                {
                                  staticStyle: {
                                    color: "#000000",
                                    "font-size": "18px"
                                  }
                                },
                                [
                                  _vm._v(
                                    " \n\t\t\t\t\t\t\tDe brief is onderweg naar de gemeente. U ontvangt binnen tien minuten een ontvangstbevestiging. Als dit niet het geval is of als u vragen heeft kunt u contact opnemen via: 036 5254774 of per mail via: support@beslisapp.nl. In de bijlagen vindt U de brieven welke naar de gemeente zijn verzonden.\n\t\t\t\t\t\t\t"
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "p",
                                {
                                  staticStyle: {
                                    color: "#000000",
                                    "font-size": "18px"
                                  }
                                },
                                [
                                  _vm._v(
                                    " Met vriendelijke groet, \n\t\t\t\t\t\t\t"
                                  ),
                                  _c("br"),
                                  _vm._v(" BESLISapp.")
                                ]
                              )
                            ]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0111c808", module.exports)
  }
}

/***/ })

});