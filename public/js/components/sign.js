webpackJsonp([1],{

/***/ 62:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(68)
/* template */
var __vue_template__ = __webpack_require__(69)
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
Component.options.__file = "resources/js/views/sign.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0c6f9a88", Component.options)
  } else {
    hotAPI.reload("data-v-0c6f9a88", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 68:
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

/* harmony default export */ __webpack_exports__["default"] = ({
	data: function data() {
		return {
			sign_mode: 0,
			sign_img: ''
		};
	},
	created: function created() {
		this.init();
	},


	methods: {
		init: function init() {},
		onPrev: function onPrev() {
			this.$router.push({
				name: 'client'
			});
		},
		previewMedia: function previewMedia(e) {
			var _this = this;

			var files = e.target.files || e.dataTransfer.files;
			if (!files.length) return;
			var signForm = new FormData();
			signForm.append('mode', 2);
			signForm.append('media', $('#media')[0].files[0]);
			axios.post('/api/fax/uploadSign', signForm).then(function (response) {
				_this.sign_img = "/assets/signatures/" + response.data.name;
			}).catch(function (error) {});
		},
		removeImg: function removeImg() {
			this.sign_img = '';
		},
		resetSign: function resetSign() {
			this.$refs.signaturePad.clearSignature();
		},
		selectMode: function selectMode(mode) {
			this.sign_mode = mode;
		},
		onSave: function onSave() {
			var _this2 = this;

			if (this.sign_mode == 1) {
				var _$refs$signaturePad$s = this.$refs.signaturePad.saveSignature(),
				    isEmpty = _$refs$signaturePad$s.isEmpty,
				    data = _$refs$signaturePad$s.data;

				if (isEmpty) {
					alert('empty');
					return false;
				}
				var signForm = new FormData();
				signForm.append('mode', this.sign_mode);
				signForm.append('sign', data);
				axios.post('/api/fax/publish', signForm).then(function (response) {
					console.log(response.data.result);
					if (response.data.result == "success") {
						_this2.$emit("changeStep", 4);
						_this2.$router.push({
							name: 'thanks'
						});
					} else if (response.data.result == "fail") {
						_this2.$emit("changeStep", 1);
						_this2.$router.push({
							name: 'general'
						});
					}
				}).catch(function (error) {});
			} else if (this.sign_mode == 2) {
				if (this.sign_img == '') {
					alert('image not found');
					return false;
				}
				var _signForm = new FormData();
				_signForm.append('mode', 2);
				_signForm.append('media', $('#media')[0].files[0]);
				axios.post('/api/fax/publish', _signForm).then(function (response) {
					console.log(response.data.result);
					if (response.data.result == "success") {
						_this2.$emit("changeStep", 4);
						_this2.$router.push({
							name: 'thanks'
						});
					} else if (response.data.result == "fail") {
						_this2.$emit("changeStep", 1);
						_this2.$router.push({
							name: 'general'
						});
					}
				}).catch(function (error) {});
			}
		}
	}
});

/***/ }),

/***/ 69:
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
              _c("v-card-title", [
                _c("span", { staticClass: "headline" }, [
                  _vm._v("DE OVEREENKOMST")
                ])
              ]),
              _vm._v(" "),
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
                                    "font-size": "18px",
                                    padding: "20px",
                                    "background-color": "#eee"
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n\t\t\t\t\t\t\t\tDe hoogte van de boete is 20,- euro per dag voor de eerste 14 dagen. 30,- euro per dag voor de 14 dagen daarna en 40,- euro per dag voor de 14 dagen daarna. De totale dwangsom bedraagt maximaal 1260,- euro. "
                                  ),
                                  _c("br"),
                                  _c("br"),
                                  _vm._v(
                                    '\n\n\t\t\t\t\t\t\t\tMet het tekenen van deze overeenkomst geeft u toestemming aan de gemeente om de verschuldigde boete over te maken op het rekeningnummer van ons kantoor. Vijftig procent van de ontvangen boete wordt binnen twee weken na ontvangst overgemaakt op uw rekeningnummer: "ba99QQQQ999999" Voor onze service betaald u vijftig procent van de te ontvangen dwangsom. Buro Bezwaar en Beroep zorgt er ook voor dat er beroep wordt aangetekend als de weigert te beslissen.'
                                  ),
                                  _c("br"),
                                  _c("br"),
                                  _vm._v(
                                    "\n\n\t\t\t\t\t\t\t\tUw gegevens worden alleen gebruikt voor het afhandelen ingebrekestelling \n\t\t\t\t\t\t\t"
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-flex",
                            { attrs: { xs12: "", sm12: "", md12: "" } },
                            [
                              _c(
                                "v-btn",
                                {
                                  staticStyle: { "margin-left": "0" },
                                  attrs: {
                                    color: "success",
                                    outline: _vm.sign_mode == 2
                                  },
                                  on: {
                                    click: function($event) {
                                      _vm.selectMode(1)
                                    }
                                  }
                                },
                                [_vm._v("HANDTEKENING MET DE MUIS OF VINGER")]
                              ),
                              _vm._v(" "),
                              _c(
                                "label",
                                {
                                  staticClass: "v-btn success",
                                  class: {
                                    "v-btn--outline": _vm.sign_mode === 1
                                  },
                                  on: {
                                    click: function($event) {
                                      _vm.selectMode(2)
                                    }
                                  }
                                },
                                [
                                  _c("input", {
                                    staticStyle: { display: "none" },
                                    attrs: {
                                      type: "file",
                                      name: "media",
                                      id: "media"
                                    },
                                    on: { change: _vm.previewMedia }
                                  }),
                                  _vm._v(
                                    "\n\t\t\t\t\t            UPLOAD EEN AFBEELDING MET UW HANDTEKENING\n\t\t\t\t\t        "
                                  )
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-flex",
                            { attrs: { xs12: "", sm12: "", md12: "" } },
                            [
                              _vm.sign_mode == 1
                                ? _c(
                                    "div",
                                    {
                                      staticStyle: {
                                        border: "solid 1px gray",
                                        height: "300px"
                                      }
                                    },
                                    [
                                      _c("VueSignaturePad", {
                                        ref: "signaturePad",
                                        attrs: { height: "300px" }
                                      }),
                                      _vm._v(" "),
                                      _c(
                                        "v-btn",
                                        {
                                          staticStyle: {
                                            "margin-left": "0",
                                            "margin-top": "28px"
                                          },
                                          attrs: { color: "" },
                                          on: {
                                            click: function($event) {
                                              _vm.resetSign()
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "HANDTEKENING OPNIEUW PLAATSEN"
                                          )
                                        ]
                                      )
                                    ],
                                    1
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.sign_mode == 2
                                ? _c(
                                    "div",
                                    {
                                      staticStyle: {
                                        border: "solid 1px gray",
                                        height: "300px"
                                      }
                                    },
                                    [
                                      _vm.sign_mode == 2
                                        ? [
                                            _c("img", {
                                              staticClass: "img-responsive",
                                              staticStyle: {
                                                "max-width": "200px",
                                                "max-height": "280px"
                                              },
                                              attrs: { src: _vm.sign_img }
                                            })
                                          ]
                                        : _vm._e()
                                    ],
                                    2
                                  )
                                : _vm._e()
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
              ),
              _vm._v(" "),
              _c(
                "v-card-actions",
                [
                  _c(
                    "v-container",
                    [
                      _c(
                        "v-layout",
                        { attrs: { "justify-end": "" } },
                        [
                          _c(
                            "v-btn",
                            {
                              attrs: {
                                dark: "",
                                color: "primary",
                                outline: ""
                              },
                              on: { click: _vm.onPrev }
                            },
                            [_vm._v("Terug")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              attrs: { dark: "", color: "primary" },
                              on: { click: _vm.onSave }
                            },
                            [_vm._v("Volgende")]
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
    require("vue-hot-reload-api")      .rerender("data-v-0c6f9a88", module.exports)
  }
}

/***/ })

});