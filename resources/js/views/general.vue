<template>
	<div class="page">
		<v-container justify-center>
			<v-form
			    ref="form"
			    v-model="valid"
			    lazy-validation
			>
				<v-card flat>
					<v-card-title>
					<span class="headline">ONTWIKKEL SERVER IXL</span>
					</v-card-title>
					<v-card-text>
						<v-container grid-list-md>
							<v-layout wrap>
								<v-flex xs12 sm12 md12>
									<h3>Gaat het om een aanvraag of bezwaarschrift</h3>
									<v-select
									v-model="generalForm.app_type"
									:items="app_types"
									persistent-hint
									return-object
									:rules="appRules"
									></v-select>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Kies hier wat er is aangevraagd</h3>
									<v-select
									v-model="generalForm.app_data"
									:items="app_data"
									item-text="value"
									item-value="index"
									persistent-hint
									return-object
									:rules="appDataRules"
									></v-select>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Kies hier wat er is aangevraagd</h3>
									<v-menu
									lazy
									:close-on-content-click="false"
									v-model="menu_request_date"
									transition="scale-transition"
									offset-y
									:nudge-right="40"
									max-width="290px"
									min-width="290px"
									>
										<v-text-field
										slot="activator"
										v-model="generalForm.request_date"
										prepend-icon="event"
										:rules="dateRules"
										>
										</v-text-field>
										<v-date-picker v-model="generalForm.request_date">
										</v-date-picker>
									</v-menu>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Heeft u een brief ontvangen dat er later wordt belist?</h3>
									<v-radio-group
									v-model="generalForm.letter_received"
									row
									:rules="letterRules">
								      	<v-radio label="Ja" value="yes" @change="showAlert(1)"></v-radio>
								      	<v-radio label="Nee" value="no" @change="showAlert(0)"></v-radio>
								    </v-radio-group>
								    <v-alert
								    v-if="alertShow == true"
								    :value="true"
								    color="info"
								    outline>
								    	U kunt gewoon doorgaan. Neem gerust contact op met ons als u zeker wilt weten dat u de gemeente niet te vroeg in gebreke stelt.
								    </v-alert>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Het kenmerk</h3>
									<v-text-field
									v-model="generalForm.subject"
									>
									</v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Selecteer hieronder de gemeente</h3>
									<v-autocomplete
									v-model="generalForm.municipality"
									:items="municipality_items"
									persistent-hint
									:rules="municipalityRules"
									@change="getMunicipality()"
									>
									</v-autocomplete>
								</v-flex>
								<div v-if="municipality">
									Faxnumber: {{ this.municipality.faxnumber }}<br>
									Emailadres: {{ this.municipality.email }}<br>
									Address: {{ this.municipality.address }}, {{ this.municipality.postal }}, {{ this.municipality.city }}
								</div>
							</v-layout>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-container>
							<v-layout justify-end>
								<v-btn dark color="primary" @click="onSave">VOLGENDE</v-btn>
							</v-layout>
						</v-container>
					</v-card-actions>
				</v-card>
			</v-form>
		</v-container>
	</div>
</template>

<script>
  	export default {
  		data () {
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
					municipality: '',
				},
				app_types: [
					"Aanvraag",
					"Bezwaarschrift"
				],
				app_data: [
					{
						index: 1,
						value: "Option 1",
					},
					{
						index: 2,
						value: "Option 2",
					},
					{
						index: 3,
						value: "Option 3",
					},
					{
						index: 4,
						value: "Option 4",
					},
				],
				municipalities: [],
				municipality: {},
				municipality_items: [],
			    appRules: [
			        v => !!v || 'Application Type is required',
			    ],
			    appDataRules: [
			        v => !!v || 'Application Data is required',
			    ],
			    municipalityRules: [
			        v => !!v || 'Municipality is required',
			    ],
			    letterRules: [
			        v => !!v || 'Letter is required',
			    ],
			}
		},
		computed: {
			dateRules() {
				const today = new Date();
				const rules = [];
				
				const rule = 
					v => !!v || 'Application Date is required';
				rules.push(rule);
				if(this.generalForm.app_type && Object.keys(this.generalForm.app_data).length){
					var selectedDate = new Date(this.generalForm.request_date);
					var unit = 0;
					var requiredDiff = 0;
					var dateDiff = 0;

					if(this.generalForm.app_type == 'Aanvraag') unit = 7;
					else if(this.generalForm.app_type == 'Bezwaarschrift') unit = 10;
					console.log(unit);
					requiredDiff = unit * this.generalForm.app_data.index;
					dateDiff = Math.ceil((today - selectedDate)/(1000 * 3600 * 24));
					const rule = 
						v => (Math.ceil((today - new Date(v)) /(1000 * 3600 * 24)) > requiredDiff) || `Time difference should be over ${requiredDiff}`
					rules.push(rule);
				}
				return rules;
			}
		},
	    created(){
            this.init();
	    },
	    methods: {
	    	init(){
	    		axios.get('/api/fax/general/get')
		            .then(response => {
		            	// console.log(response.data.app_data);
		            	if(response.data.app_type)
		                	this.generalForm.app_type = response.data.app_type;
		                if(response.data.app_data)
		                	this.generalForm.app_data = { index: parseInt(response.data.app_data) };
		                if(response.data.request_date)
		                	this.generalForm.request_date = response.data.request_date;
		                if(response.data.letter_received)
		                	this.generalForm.letter_received = response.data.letter_received;
		                if(response.data.subject)
		                	this.generalForm.subject = response.data.subject;
		                if(response.data.municipality)
		                	this.generalForm.municipality = response.data.municipality;
		                if(response.data.municipalities.municipalities)
		                	this.municipalities = response.data.municipalities.municipalities;
		                var i;
						for (i = 0; i < this.municipalities.length; i++) { 
						  	this.municipality_items.push(this.municipalities[i].name);
						}
				        this.getMunicipality();
		            }).catch(response => {
		            	console.log("error");
		            });
	    	},
	    	onSave(){
	    		// console.log(this.generalForm.app_data.index);
	    		// return false;
			    if (this.$refs.form.validate()) {
			    	let generalForm = new FormData();
                    generalForm.append('app_type', this.generalForm.app_type);
                    generalForm.append('app_data', this.generalForm.app_data.index);
                    generalForm.append('request_date', this.generalForm.request_date);
                    generalForm.append('letter_received', this.generalForm.letter_received);
                    generalForm.append('subject', this.generalForm.subject);
                    generalForm.append('municipality', this.generalForm.municipality);
                    axios.post('/api/fax/general/save', generalForm)
                    .then(response =>  {
			    		this.$emit("changeStep", 2);
			    		this.$router.push({
			    			name: 'client'
			    		})
                    }).catch(error => {
                    	// this.$message({
                     //        type: 'error',
                     //        message: response.data.message
                     //    });
                    });
		    	}
	    	},
	    	showAlert(truthy){
	    		if(truthy == 1)
	    			this.alertShow = true;
	    		else if(truthy == 0)
	    			this.alertShow = false;
	    	},
	    	getMunicipality(){
	    		var name = this.generalForm.municipality;
	    		var arrMatch = this.municipalities.filter(function(x){
	    			return x.name == name;
	    		});
	    		this.municipality = arrMatch[0];
	    	}
	    }
  	}
</script>