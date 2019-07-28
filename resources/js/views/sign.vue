<template>
	<div class="page">
		<v-container justify-center>
			<v-card flat>
				<v-card-title>
				<span class="headline">DE OVEREENKOMST</span>
				</v-card-title>
				<v-card-text>
					<v-container grid-list-md>
						<v-layout wrap>
							<v-flex xs12 sm12 md12>
								<p style="font-size: 18px; padding: 20px; background-color: #eee;">
									De hoogte van de boete is 20,- euro per dag voor de eerste 14 dagen. 30,- euro per dag voor de 14 dagen daarna en 40,- euro per dag voor de 14 dagen daarna. De totale dwangsom bedraagt maximaal 1260,- euro. <br><br>

									Met het tekenen van deze overeenkomst geeft u toestemming aan de gemeente om de verschuldigde boete over te maken op het rekeningnummer van ons kantoor. Vijftig procent van de ontvangen boete wordt binnen twee weken na ontvangst overgemaakt op uw rekeningnummer: "ba99QQQQ999999" Voor onze service betaald u vijftig procent van de te ontvangen dwangsom. Buro Bezwaar en Beroep zorgt er ook voor dat er beroep wordt aangetekend als de weigert te beslissen.<br><br>

									Uw gegevens worden alleen gebruikt voor het afhandelen ingebrekestelling 
								</p>
							</v-flex>
							<v-flex xs12 sm12 md12>
								<v-btn color="success" :outline="sign_mode == 2" @click="selectMode(1)" style="margin-left: 0">HANDTEKENING MET DE MUIS OF VINGER</v-btn>
								<label class="v-btn success" :class="{'v-btn--outline':sign_mode === 1}" @click="selectMode(2)" >
						            <input
						            type="file"
						            @change="previewMedia"
						            name="media"
						            id="media"
						            style="display: none;"
						            >
						            UPLOAD EEN AFBEELDING MET UW HANDTEKENING
						        </label>
							</v-flex>
							<v-flex xs12 sm12 md12>
								<div v-if="sign_mode == 1" style="border: solid 1px gray; height: 300px;">
									<VueSignaturePad
								    ref="signaturePad"
								    height="300px"
								    />
									<v-btn color="" @click="resetSign()" style="margin-left: 0; margin-top: 28px;">HANDTEKENING OPNIEUW PLAATSEN</v-btn>
								</div>
								<div v-if="sign_mode == 2" style="border: solid 1px gray; height: 300px;">
								    <template v-if="sign_mode == 2">
			                        	<!-- <v-img v-if="sign_img != ''" :src="sign_img" class="img-responsive" style="max-width:200px;max-height: 280px;"></v-img> -->
			                        	<img :src="sign_img" class="img-responsive" style="max-width:200px;max-height: 280px;"></img>
								    </template>
							    </div>
							</v-flex>
						</v-layout>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-container>
						<v-layout justify-end>
							<!-- <v-btn>Annuleer</v-btn> -->
							<v-btn dark color="primary" outline @click="onPrev">Terug</v-btn>
							<v-btn dark color="primary" @click="onSave">Volgende</v-btn>
						</v-layout>
					</v-container>
				</v-card-actions>
			</v-card>
		</v-container>
	</div>
</template>

<script>
  	export default {
  		data () {
			return {
				sign_mode: 0,
				sign_img: '',
			}
		},

	    created(){
            this.init();
	    },

	    methods: {
	    	init(){
	    	},
	    	onPrev(){
	    		this.$router.push({
	    			name: 'client'
	    		})
	    	},
	    	previewMedia(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                let signForm = new FormData();
                signForm.append('mode', 2);
                signForm.append('media', $('#media')[0].files[0]);
                axios.post('/api/fax/uploadSign', signForm)
                .then(response =>  {
                	this.sign_img = "/assets/signatures/" + response.data.name;
                }).catch(error => {
                });
            },
            removeImg(){
	    		this.sign_img = '';
	    	},
	    	resetSign(){
	    		this.$refs.signaturePad.clearSignature();
	    	},
	    	selectMode(mode){
	    		this.sign_mode = mode;
	    	},
	    	onSave(){
	    		if(this.sign_mode == 1){
		    		const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
		    		if(isEmpty){
		    			alert('empty');
		    			return false;
		    		}
	    			let signForm = new FormData();
	    			signForm.append('mode', this.sign_mode);
	                signForm.append('sign', data);
	                axios.post('/api/fax/publish', signForm)
	                .then(response =>  {
	    				console.log(response.data.result);
                    	if(response.data.result == "success"){
		    				this.$emit("changeStep", 4);
				    		this.$router.push({
				    			name: 'thanks'
				    		})
                    	} else if(response.data.result == "fail"){
                    		this.$emit("changeStep", 1);
                    		this.$router.push({
				    			name: 'general'
				    		})
                    	}
	                }).catch(error => {
	                });
	    		} else if(this.sign_mode == 2){
		    		if(this.sign_img == ''){
		    			alert('image not found');
		    			return false;
		    		}
	    			let signForm = new FormData();
                    signForm.append('mode', 2);
                    signForm.append('media', $('#media')[0].files[0]);
                    axios.post('/api/fax/publish', signForm)
                    .then(response =>  {
                    	console.log(response.data.result);
                    	if(response.data.result == "success"){
		    				this.$emit("changeStep", 4);
				    		this.$router.push({
				    			name: 'thanks'
				    		})
                    	} else if(response.data.result == "fail"){
                    		this.$emit("changeStep", 1);
                    		this.$router.push({
				    			name: 'general'
				    		})
                    	}
                    }).catch(error => {
                    });
	    		}

	    	}
	    }
  	}
</script>