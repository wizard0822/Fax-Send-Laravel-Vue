webpackJsonp([3],{

/***/ 61:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(66)
/* template */
var __vue_template__ = __webpack_require__(67)
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
Component.options.__file = "resources/js/views/client.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fd3e17ec", Component.options)
  } else {
    hotAPI.reload("data-v-fd3e17ec", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 66:
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

/* harmony default export */ __webpack_exports__["default"] = ({
	data: function data() {
		return {
			valid: true,
			valid_address: false,
			clientForm: {
				gender: '',
				firstname: '',
				lastname: '',
				housenumber: '',
				postcode: '',
				email: '',
				telephone: '',
				banknumber: '',
				address: '',
				city: ''
			},
			defaultItem: {
				request_date: ''
			},

			genderRules: [function (v) {
				return !!v || 'Gender is required';
			}],
			firstnameRules: [function (v) {
				return !!v || 'First name is required';
			}],
			lastnameRules: [function (v) {
				return !!v || 'Last name is required';
			}],
			postcodeRules: [function (v) {
				return !!v || 'Postal code is required';
			}],
			housenumberRules: [function (v) {
				return !!v || 'House number is required';
			}],
			telephoneRules: [function (v) {
				return !!v || 'Telephone is required';
			}, function (v) {
				return (/^([0-9]{10}$)/.test(v) || 'Telephone has to be 10 digits'
				);
			}],
			banknumberRules: [function (v) {
				return !!v || 'Bank number is required';
			}, function (v) {
				return (/^([a-zA-Z]{2}[0-9]{2}[a-zA-Z]{4}[0-9]{10}$)/.test(v) || 'Bank number is not valid'
				);
			}],
			addressRules: [function (v) {
				return !!v || 'Address is required';
			}],
			cityRules: [function (v) {
				return !!v || 'City is required';
			}],
			emailRules: [function (v) {
				return !!v || 'E-mail is required';
			}, function (v) {
				return (/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'Invalid E-mail'
				);
			}]
		};
	},
	created: function created() {
		this.init();
	},


	methods: {
		init: function init() {
			var _this = this;

			axios.get('/api/fax/client/get').then(function (response) {
				if (response.data.gender) _this.clientForm.gender = response.data.gender;
				if (response.data.firstname) _this.clientForm.firstname = response.data.firstname;
				if (response.data.lastname) _this.clientForm.lastname = response.data.lastname;
				if (response.data.postcode) _this.clientForm.postcode = response.data.postcode;
				if (response.data.housenumber) _this.clientForm.housenumber = response.data.housenumber;
				if (response.data.telephone) _this.clientForm.telephone = response.data.telephone;
				if (response.data.email) _this.clientForm.email = response.data.email;
				if (response.data.banknumber) _this.clientForm.banknumber = response.data.banknumber;
				if (response.data.address) _this.clientForm.address = response.data.address;
				if (response.data.city) _this.clientForm.city = response.data.city;
			}).catch(function (response) {
				console.log("error");
			});
		},
		onPrev: function onPrev() {
			this.$router.push({
				name: 'general'
			});
		},
		onSave: function onSave() {
			var _this2 = this;

			if (this.$refs.form.validate()) {
				var clientForm = new FormData();
				clientForm.append('gender', this.clientForm.gender);
				clientForm.append('firstname', this.clientForm.firstname);
				clientForm.append('lastname', this.clientForm.lastname);
				clientForm.append('postcode', this.clientForm.postcode);
				clientForm.append('housenumber', this.clientForm.housenumber);
				clientForm.append('email', this.clientForm.email);
				clientForm.append('telephone', this.clientForm.telephone);
				clientForm.append('banknumber', this.clientForm.banknumber);
				clientForm.append('address', this.clientForm.address);
				clientForm.append('city', this.clientForm.city);
				axios.post('/api/fax/client/save', clientForm).then(function (response) {
					_this2.$emit("changeStep", 3);
					_this2.$router.push({
						name: 'sign'
					});
				}).catch(function (error) {
					// this.$message({
					//        type: 'error',
					//        message: response.data.message
					//    });
				});
			}
		},
		getAddress: function getAddress() {
			var _this3 = this;

			if (this.clientForm.postcode != '' && this.clientForm.housenumber != '') {
				var addressForm = new FormData();
				addressForm.append('postal', this.clientForm.postcode);
				addressForm.append('house', this.clientForm.housenumber);
				axios.post('/api/fax/post', addressForm).then(function (response) {
					if (response.data.status == 1) {
						console.log(response.data);
						_this3.valid_address = true;
						_this3.clientForm.address = response.data.data.address;
						_this3.clientForm.city = response.data.data.city;
					}
				}).catch(function (error) {
					// this.$message({
					//        type: 'error',
					//        message: response.data.message
					//    });
				});
			}
		}
	}
});

/***/ }),

/***/ 67:
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
                      _vm._v("GEMEENTE INFORMATIE")
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
                                  _c("h3", [_vm._v("Contactgegevens")]),
                                  _vm._v(" "),
                                  _c(
                                    "v-radio-group",
                                    {
                                      attrs: {
                                        row: "",
                                        rules: _vm.genderRules
                                      },
                                      model: {
                                        value: _vm.clientForm.gender,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.clientForm,
                                            "gender",
                                            $$v
                                          )
                                        },
                                        expression: "clientForm.gender"
                                      }
                                    },
                                    [
                                      _c("v-radio", {
                                        attrs: {
                                          label: "Meneer",
                                          value: "meneer"
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("v-radio", {
                                        attrs: {
                                          label: "Mevrouw",
                                          value: "mevrouw"
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
                                  _c("h3", [_vm._v("Voorletters")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.firstnameRules },
                                    model: {
                                      value: _vm.clientForm.firstname,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.clientForm,
                                          "firstname",
                                          $$v
                                        )
                                      },
                                      expression: "clientForm.firstname"
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
                                  _c("h3", [_vm._v("Achternaam")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.lastnameRules },
                                    model: {
                                      value: _vm.clientForm.lastname,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.clientForm,
                                          "lastname",
                                          $$v
                                        )
                                      },
                                      expression: "clientForm.lastname"
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
                                  _c("h3", [_vm._v("Email")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.emailRules },
                                    model: {
                                      value: _vm.clientForm.email,
                                      callback: function($$v) {
                                        _vm.$set(_vm.clientForm, "email", $$v)
                                      },
                                      expression: "clientForm.email"
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
                                  _c("h3", [_vm._v("Postcode")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.postcodeRules },
                                    on: {
                                      change: function($event) {
                                        _vm.getAddress()
                                      }
                                    },
                                    model: {
                                      value: _vm.clientForm.postcode,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.clientForm,
                                          "postcode",
                                          $$v
                                        )
                                      },
                                      expression: "clientForm.postcode"
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
                                  _c("h3", [_vm._v("Huisunummer")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.housenumberRules },
                                    on: {
                                      change: function($event) {
                                        _vm.getAddress()
                                      }
                                    },
                                    model: {
                                      value: _vm.clientForm.housenumber,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.clientForm,
                                          "housenumber",
                                          $$v
                                        )
                                      },
                                      expression: "clientForm.housenumber"
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
                                  _c("h3", [_vm._v("Telefoonnummer")]),
                                  _vm._v(" "),
                                  _c(
                                    "v-text-field",
                                    {
                                      attrs: {
                                        rules: _vm.telephoneRules,
                                        mask: "##########"
                                      },
                                      model: {
                                        value: _vm.clientForm.telephone,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.clientForm,
                                            "telephone",
                                            $$v
                                          )
                                        },
                                        expression: "clientForm.telephone"
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n\t\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t"
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
                                  _c("h3", [_vm._v("IBAN rekeningnummer")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: {
                                      rules: _vm.banknumberRules,
                                      mask: "aa##aaaa##########"
                                    },
                                    model: {
                                      value: _vm.clientForm.banknumber,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.clientForm,
                                          "banknumber",
                                          $$v
                                        )
                                      },
                                      expression: "clientForm.banknumber"
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
                                  _c("h3", [_vm._v("Address")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.addressRules },
                                    model: {
                                      value: _vm.clientForm.address,
                                      callback: function($$v) {
                                        _vm.$set(_vm.clientForm, "address", $$v)
                                      },
                                      expression: "clientForm.address"
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
                                  _c("h3", [_vm._v("City")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: { rules: _vm.cityRules },
                                    model: {
                                      value: _vm.clientForm.city,
                                      callback: function($$v) {
                                        _vm.$set(_vm.clientForm, "city", $$v)
                                      },
                                      expression: "clientForm.city"
                                    }
                                  })
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
                                  on: {
                                    click: function($event) {
                                      _vm.onSave()
                                    }
                                  }
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
    require("vue-hot-reload-api")      .rerender("data-v-fd3e17ec", module.exports)
  }
}

/***/ })

});