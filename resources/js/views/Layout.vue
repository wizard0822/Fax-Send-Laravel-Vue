<style scoped>
	.router-anim-enter-active {
        animation: coming 1s;
        animation-delay: 1s;
        opacity: 0;
    }

    .router-anim-leave-active {
        animation: going 1s;
    }

    @keyframes going {
        from{
            transform: translateX(0px);
        }
        to {
            transform: translateX(-50px);
            opacity: 0;
        }
    }

    @keyframes coming {
        from{
            transform: translateX(-50px);
            opacity: 0;
        }
        to {
            transform: translateX(0px);
            opacity: 1;
        }
    }
</style>

<template>
	<v-app>
            <stepper-component :step="curr_step"></stepper-component>
            <transition name="router-anim">
                <router-view @changeStep="onStepChange" />
            </transition>
	</v-app>
</template>

<script>
    export default {
        data () {
            return {
                curr_step: 1,
            }
        },
        methods :{
            onStepChange(step){
                console.log(step);
                this.curr_step = step;
            }
        },
        components: {
        },
        mounted() {
        }
    }
</script>