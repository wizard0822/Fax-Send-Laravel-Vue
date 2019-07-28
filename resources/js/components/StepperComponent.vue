<style scoped>
	.active{
		background-color: #424242;
	}
</style>

<template>
	<v-container>
		<v-stepper>
			<v-stepper-header>
				<v-stepper-step
				:complete="isComplete(1)"
				:editable="isComplete(1)"
				step="1"
				@click="gotoStep(1)"
				>
				ALGEMENE INFORMATIE
				</v-stepper-step>

				<v-divider></v-divider>

				<v-stepper-step
				:complete="isComplete(2)"
				:editable="isComplete(2)"
				step="2"
				@click="gotoStep(2)"
				>CLIENT INFORMATION
				</v-stepper-step>

				<v-divider></v-divider>

				<v-stepper-step
				:complete="isComplete(3)"
				:editable="isComplete(3)"
				step="3"
				@click="gotoStep(3)"
				>
				SIGNATURE
				</v-stepper-step>
			</v-stepper-header>
		</v-stepper>
	</v-container>
</template>

<script>
	export default {
		props: ['step'],
		data () {
			return {
			}
		},
		methods: {
			isComplete(step){
				if(this.step >= step)
					return true;
				else
					return false;
			},
			gotoStep(step){
				if(this.isComplete(step)){
					if(step == 1){
						this.$router.push({ name: "general" });
					} else if(step == 2) {
						this.$router.push({ name: "client" });
					} else if(step == 3) {
						this.$router.push({ name: "sign" });
					}
				}
			},
		}
	}
</script>