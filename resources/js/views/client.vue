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
						<span class="headline">GEMEENTE INFORMATIE</span>
					</v-card-title>
					<v-card-text>
						<v-container grid-list-md>
							<v-layout wrap>
								<v-flex xs12 sm12 md12>
									<h3>Contactgegevens</h3>
									<v-radio-group v-model="clientForm.gender" row :rules="genderRules">
								      	<v-radio label="Meneer" value="meneer"></v-radio>
								      	<v-radio label="Mevrouw" value="mevrouw"></v-radio>
								    </v-radio-group>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Voorletters</h3>
									<v-text-field v-model="clientForm.firstname" :rules="firstnameRules"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Achternaam</h3>
									<v-text-field v-model="clientForm.lastname" :rules="lastnameRules"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Email</h3>
									<v-text-field v-model="clientForm.email" :rules="emailRules"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Postcode</h3>
									<v-text-field v-model="clientForm.postcode" :rules="postcodeRules" @change="getAddress()"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Huisunummer</h3>
									<v-text-field v-model="clientForm.housenumber" :rules="housenumberRules" @change="getAddress()"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Telefoonnummer</h3>
									<v-text-field
									v-model="clientForm.telephone"
									:rules="telephoneRules"
									mask="##########">
									>
									</v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>IBAN rekeningnummer</h3>
									<v-text-field
									v-model="clientForm.banknumber"
									:rules="banknumberRules"
									mask="aa##aaaa##########"
									></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>Address</h3>
									<v-text-field v-model="clientForm.address" :rules="addressRules"></v-text-field>
								</v-flex>
								<v-flex xs12 sm12 md12>
									<h3>City</h3>
									<v-text-field v-model="clientForm.city" :rules="cityRules"></v-text-field>
								</v-flex>
							</v-layout>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-container>
							<v-layout justify-end>
								<v-btn dark color="primary" outline @click="onPrev">Terug</v-btn>
								<v-btn dark color="primary" @click="onSave()">VOLGENDE</v-btn>
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
					city: '',
				},
				defaultItem: {
					request_date: '',
				},

				genderRules: [
			        v => !!v || 'Gender is required',
			    ],
			    firstnameRules: [
			        v => !!v || 'First name is required',
			    ],
			    lastnameRules: [
			        v => !!v || 'Last name is required',
			    ],
			    postcodeRules: [
			        v => !!v || 'Postal code is required',
			    ],
			    housenumberRules: [
			        v => !!v || 'House number is required',
			    ],
			    telephoneRules: [
			        v => !!v || 'Telephone is required',
			        v => /^([0-9]{10}$)/.test(v) || 'Telephone has to be 10 digits',
			        
			    ],
			    banknumberRules: [
			        v => !!v || 'Bank number is required',
			        v => /^([a-zA-Z]{2}[0-9]{2}[a-zA-Z]{4}[0-9]{10}$)/.test(v) || 'Bank number is not valid',
			    ],
			    addressRules: [
			        v => !!v || 'Address is required',
			    ],
			    cityRules: [
			        v => !!v || 'City is required',
			    ],
			    emailRules: [
			        v => !!v || 'E-mail is required',
			        v => /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'Invalid E-mail'
			    ]
			}
		},

	    created(){
            this.init();
	    },

	    methods: {
	    	init(){
	    		axios.get('/api/fax/client/get')
		            .then(response => {
	                    if(response.data.gender)
	                    	this.clientForm.gender = response.data.gender;
	                    if(response.data.firstname)
	                    	this.clientForm.firstname = response.data.firstname;
	                    if(response.data.lastname)
	                    	this.clientForm.lastname = response.data.lastname;
	                    if(response.data.postcode)
	                    	this.clientForm.postcode = response.data.postcode;
	                    if(response.data.housenumber)
	                    	this.clientForm.housenumber = response.data.housenumber;
	                    if(response.data.telephone)
	                    	this.clientForm.telephone = response.data.telephone;
	                    if(response.data.email)
	                    	this.clientForm.email = response.data.email;
	                    if(response.data.banknumber)
	                    	this.clientForm.banknumber = response.data.banknumber;
	                    if(response.data.address)
	                    	this.clientForm.address = response.data.address;
	                    if(response.data.city)
	                    	this.clientForm.city = response.data.city;
		            }).catch(response => {
		            	console.log("error");
		            });
	    	},
	    	onPrev(){
	    		this.$router.push({
	    			name: 'general'
	    		})
	    	},
	    	onSave(){
	    		if (this.$refs.form.validate()) {
	    			let clientForm = new FormData();
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
                    axios.post('/api/fax/client/save', clientForm)
                    .then(response =>  {
			    		this.$emit("changeStep", 3);
			    		this.$router.push({
			    			name: 'sign'
			    		})
                    }).catch(error => {
                    	// this.$message({
                     //        type: 'error',
                     //        message: response.data.message
                     //    });
                    });
		    	}
	    	},
	    	getAddress(){
	    		if(this.clientForm.postcode != '' && this.clientForm.housenumber != ''){
	    			let addressForm = new FormData();
                    addressForm.append('postal', this.clientForm.postcode);
                    addressForm.append('house', this.clientForm.housenumber);
                    axios.post('/api/fax/post', addressForm)
                    .then(response =>  {
                    	if(response.data.status == 1){
                    		console.log(response.data);
                    		this.valid_address = true;
                    		this.clientForm.address = response.data.data.address;
                    		this.clientForm.city = response.data.data.city;
                    	}
                    }).catch(error => {
                    	// this.$message({
                     //        type: 'error',
                     //        message: response.data.message
                     //    });
                    });
	    		}
	    	}
	    }
  	}
</script>