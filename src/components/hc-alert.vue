<template>
	<div id="hc_alert" :class="`alert ${data_alert.variant} all_transition_slow position-fixed`" :style="`color: ${data_alert.color_text}`" v-show="data_alert.open">
		<div class="d-flex justify-content-between align-items-center">
			<div class="pr-4">{{data_alert.message}}</div><div>
				<span class="closebtn all_transition" :style="`color: ${data_alert.color_text}`">&times;</span>
			</div>
		</div>
	</div>
</template>

<script>
	//import _Store from '@/store'
	import { mapGetters } from 'vuex'

	export default {
		name: 'hc_alert',
        computed: {
	...mapGetters([
				'getAlert'
		]),

            data_alert() {
            return this.getAlert
            }
        },
		data() {
			return {

			}
		},
		methods: {

		}
	}
</script>

<style lang="scss" scoped>
	#hc_alert {
		padding: 15px 20px;
		min-width: 320px;
		top: 20px;
		//top: 120px;
		right: 10px;
		opacity: 1;
		// transition: opacity 0.6s;
		z-index: 10000;

		.closebtn {
			opacity: .5;
			font-size: 26px;
			line-height: 26px;
			font-weight: bold;
			cursor: pointer;
			float: right;
		}

		.closebtn:hover {
			opacity: 1;
		}
	}

	#hc_alert.danger  { background-color: #dc3545; }
	#hc_alert.success { background-color: #28a745; }
	#hc_alert.primary { background-color: #007bff; }
	#hc_alert.warning { background-color: #fd7e14; }
</style>