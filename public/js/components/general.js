webpackJsonp([2],{

/***/ 60:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(64)
/* template */
var __vue_template__ = __webpack_require__(65)
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
Component.options.__file = "resources/js/views/general.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-27cb7d8e", Component.options)
  } else {
    hotAPI.reload("data-v-27cb7d8e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 64:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
			valid: true,
			alertShow: false,
			menu_request_date: false,
			generalForm: {
				app_type: '',
				app_data: {},
				request_date: '',
				letter_received: '',
				subject: '',
				municipality: ''
			},
			app_types: ["Aanvraag", "Bezwaarschrift"],
			app_data: [{
				index: 1,
				value: "Option 1"
			}, {
				index: 2,
				value: "Option 2"
			}, {
				index: 3,
				value: "Option 3"
			}, {
				index: 4,
				value: "Option 4"
			}],
			municipalities: [],
			municipality: {},
			municipality_items: [],
			appRules: [function (v) {
				return !!v || 'Application Type is required';
			}],
			appDataRules: [function (v) {
				return !!v || 'Application Data is required';
			}],
			municipalityRules: [function (v) {
				return !!v || 'Municipality is required';
			}],
			letterRules: [function (v) {
				return !!v || 'Letter is required';
			}]
		};
	},

	computed: {
		dateRules: function dateRules() {
			var today = new Date();
			var rules = [];

			var rule = function rule(v) {
				return !!v || 'Application Date is required';
			};
			rules.push(rule);
			if (this.generalForm.app_type && Object.keys(this.generalForm.app_data).length) {
				var selectedDate = new Date(this.generalForm.request_date);
				var unit = 0;
				var requiredDiff = 0;
				var dateDiff = 0;

				if (this.generalForm.app_type == 'Aanvraag') unit = 7;else if (this.generalForm.app_type == 'Bezwaarschrift') unit = 10;
				console.log(unit);
				requiredDiff = unit * this.generalForm.app_data.index;
				dateDiff = Math.ceil((today - selectedDate) / (1000 * 3600 * 24));
				var _rule = function _rule(v) {
					return Math.ceil((today - new Date(v)) / (1000 * 3600 * 24)) > requiredDiff || 'Time difference should be over ' + requiredDiff;
				};
				rules.push(_rule);
			}
			return rules;
		}
	},
	created: function created() {
		this.init();
	},

	methods: {
		init: function init() {
			var _this = this;

			axios.get('/api/fax/general/get').then(function (response) {
				// console.log(response.data.app_data);
				if (response.data.app_type) _this.generalForm.app_type = response.data.app_type;
				if (response.data.app_data) _this.generalForm.app_data = { index: parseInt(response.data.app_data) };
				if (response.data.request_date) _this.generalForm.request_date = response.data.request_date;
				if (response.data.letter_received) _this.generalForm.letter_received = response.data.letter_received;
				if (response.data.subject) _this.generalForm.subject = response.data.subject;
				if (response.data.municipality) _this.generalForm.municipality = response.data.municipality;
				if (response.data.municipalities.municipalities) _this.municipalities = response.data.municipalities.municipalities;
				var i;
				for (i = 0; i < _this.municipalities.length; i++) {
					_this.municipality_items.push(_this.municipalities[i].name);
				}
				_this.getMunicipality();
			}).catch(function (response) {
				console.log("error");
			});
		},
		onSave: function onSave() {
			var _this2 = this;

			// console.log(this.generalForm.app_data.index);
			// return false;
			if (this.$refs.form.validate()) {
				var generalForm = new FormData();
				generalForm.append('app_type', this.generalForm.app_type);
				generalForm.append('app_data', this.generalForm.app_data.index);
				generalForm.append('request_date', this.generalForm.request_date);
				generalForm.append('letter_received', this.generalForm.letter_received);
				generalForm.append('subject', this.generalForm.subject);
				generalForm.append('municipality', this.generalForm.municipality);
				axios.post('/api/fax/general/save', generalForm).then(function (response) {
					_this2.$emit("changeStep", 2);
					_this2.$router.push({
						name: 'client'
					});
				}).catch(function (error) {
					// this.$message({
					//        type: 'error',
					//        message: response.data.message
					//    });
				});
			}
		},
		showAlert: function showAlert(truthy) {
			if (truthy == 1) this.alertShow = true;else if (truthy == 0) this.alertShow = false;
		},
		getMunicipality: function getMunicipality() {
			var name = this.generalForm.municipality;
			var arrMatch = this.municipalities.filter(function (x) {
				return x.name == name;
			});
			this.municipality = arrMatch[0];
		}
	}
});

/***/ }),

/***/ 65:
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
            "v-form",
            {
              ref: "form",
              attrs: { "lazy-validation": "" },
              model: {
                value: _vm.valid,
                callback: function($$v) {
                  _vm.valid = $$v
                },
                expression: "valid"
              }
            },
            [
              _c(
                "v-card",
                { attrs: { flat: "" } },
                [
                  _c("v-card-title", [
                    _c("span", { staticClass: "headline" }, [
                      _vm._v("ONTWIKKEL SERVER IXL")
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
                                  _c("h3", [
                                    _vm._v(
                                      "Gaat het om een aanvraag of bezwaarschrift"
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("v-select", {
                                    attrs: {
                                      items: _vm.app_types,
                                      "persistent-hint": "",
                                      "return-object": "",
                                      rules: _vm.appRules
                                    },
                                    model: {
                                      value: _vm.generalForm.app_type,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.generalForm,
                                          "app_type",
                                          $$v
                                        )
                                      },
                                      expression: "generalForm.app_type"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-flex",
                                { attrs: { xs12: "", sm12: "", md12: "" } },
                                [
                                  _c("h3", [
                                    _vm._v("Kies hier wat er is aangevraagd")
                                  ]),
                                  _vm._v(" "),
                                  _c("v-select", {
                                    attrs: {
                                      items: _vm.app_data,
                                      "item-text": "value",
                                      "item-value": "index",
                                      "persistent-hint": "",
                                      "return-object": "",
                                      rules: _vm.appDataRules
                                    },
                                    model: {
                                      value: _vm.generalForm.app_data,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.generalForm,
                                          "app_data",
                                          $$v
                                        )
                                      },
                                      expression: "generalForm.app_data"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-flex",
                                { attrs: { xs12: "", sm12: "", md12: "" } },
                                [
                                  _c("h3", [
                                    _vm._v("Kies hier wat er is aangevraagd")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "v-menu",
                                    {
                                      attrs: {
                                        lazy: "",
                                        "close-on-content-click": false,
                                        transition: "scale-transition",
                                        "offset-y": "",
                                        "nudge-right": 40,
                                        "max-width": "290px",
                                        "min-width": "290px"
                                      },
                                      model: {
                                        value: _vm.menu_request_date,
                                        callback: function($$v) {
                                          _vm.menu_request_date = $$v
                                        },
                                        expression: "menu_request_date"
                                      }
                                    },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          slot: "activator",
                                          "prepend-icon": "event",
                                          rules: _vm.dateRules
                                        },
                                        slot: "activator",
                                        model: {
                                          value: _vm.generalForm.request_date,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.generalForm,
                                              "request_date",
                                              $$v
                                            )
                                          },
                                          expression: "generalForm.request_date"
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("v-date-picker", {
                                        model: {
                                          value: _vm.generalForm.request_date,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.generalForm,
                                              "request_date",
                                              $$v
                                            )
                                          },
                                          expression: "generalForm.request_date"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-flex",
                                { attrs: { xs12: "", sm12: "", md12: "" } },
                                [
                                  _c("h3", [
                                    _vm._v(
                                      "Heeft u een brief ontvangen dat er later wordt belist?"
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "v-radio-group",
                                    {
                                      attrs: {
                                        row: "",
                                        rules: _vm.letterRules
                                      },
                                      model: {
                                        value: _vm.generalForm.letter_received,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.generalForm,
                                            "letter_received",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "generalForm.letter_received"
                                      }
                                    },
                                    [
                                      _c("v-radio", {
                                        attrs: { label: "Ja", value: "yes" },
                                        on: {
                                          change: function($event) {
                                            _vm.showAlert(1)
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("v-radio", {
                                        attrs: { label: "Nee", value: "no" },
                                        on: {
                                          change: function($event) {
                                            _vm.showAlert(0)
                                          }
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _vm.alertShow == true
                                    ? _c(
                                        "v-alert",
                                        {
                                          attrs: {
                                            value: true,
                                            color: "info",
                                            outline: ""
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n\t\t\t\t\t\t\t    \tU kunt gewoon doorgaan. Neem gerust contact op met ons als u zeker wilt weten dat u de gemeente niet te vroeg in gebreke stelt.\n\t\t\t\t\t\t\t    "
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-flex",
                                { attrs: { xs12: "", sm12: "", md12: "" } },
                                [
                                  _c("h3", [_vm._v("Het kenmerk")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    model: {
                                      value: _vm.generalForm.subject,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.generalForm,
                                          "subject",
                                          $$v
                                        )
                                      },
                                      expression: "generalForm.subject"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-flex",
                                { attrs: { xs12: "", sm12: "", md12: "" } },
                                [
                                  _c("h3", [
                                    _vm._v("Selecteer hieronder de gemeente")
                                  ]),
                                  _vm._v(" "),
                                  _c("v-autocomplete", {
                                    attrs: {
                                      items: _vm.municipality_items,
                                      "persistent-hint": "",
                                      rules: _vm.municipalityRules
                                    },
                                    on: {
                                      change: function($event) {
                                        _vm.getMunicipality()
                                      }
                                    },
                                    model: {
                                      value: _vm.generalForm.municipality,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.generalForm,
                                          "municipality",
                                          $$v
                                        )
                                      },
                                      expression: "generalForm.municipality"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _vm.municipality
                                ? _c("div", [
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\tFaxnumber: " +
                                        _vm._s(this.municipality.faxnumber)
                                    ),
                                    _c("br"),
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\tEmailadres: " +
                                        _vm._s(this.municipality.email)
                                    ),
                                    _c("br"),
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\tAddress: " +
                                        _vm._s(this.municipality.address) +
                                        ", " +
                                        _vm._s(this.municipality.postal) +
                                        ", " +
                                        _vm._s(this.municipality.city) +
                                        "\n\t\t\t\t\t\t\t"
                                    )
                                  ])
                                : _vm._e()
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
                                  attrs: { dark: "", color: "primary" },
                                  on: { click: _vm.onSave }
                                },
                                [_vm._v("VOLGENDE")]
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
    require("vue-hot-reload-api")      .rerender("data-v-27cb7d8e", module.exports)
  }
}

/***/ })

});