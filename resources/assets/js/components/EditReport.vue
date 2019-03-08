<template>
	<div class="update_report">
		<div class="form-group form">
			<textarea class="form-control" v-model="reportEdited"></textarea>
		</div>
		<div class="form-group update_btns">
			<button class="btn btn-primary btn-sm" @click.prevent="updtReport">Update</button>
			<button class="btn btn-danger btn-sm" @click.prevent="cancelUpdt">Cancel</button>
		</div>
	</div>
</template>

<script>
	import Bus from '../bus'

 	export default {
 		props: ['report'],
 		data(){
 			return {
 				reportEdited: ''
 		    }
 		},
 		methods: {
 			cancelUpdt(){
 				Bus.$emit('updt-cancel')
 			},
 			updtReport(){
 				axios.post('/update_report/' + this.report.id, {
 					report: this.reportEdited
 				}).then((res) => {
 					console.log(res.data)
 					Bus.$emit('report-updt', res.data)
 					this.cancelUpdt();

 					this.$toasted.show('Update successful!',
                    {
                      type: 'success'
                    })
 				})
 			}
 		},
 		mounted(){
 			this.reportEdited = this.report.report
 		}
 	}
</script>

<style scoped>
	.form{
		padding: 5px 8px;
	}
	textarea.form-control{
		display: block;
	    width: 100%;
	    height: 36px;
	    padding: 6px 12px;
	    font-size: 14px;
	    line-height: 1.6;
	    color: #555555;
	    background-color: #fff;
	    background-image: none;
	    border: none;
	    overflow: auto;
	    border-color: transparent;
	    outline: none;
	    border-bottom: 1px solid #A70DA4;
	    border-bottom-left-radius: 0;
	    border-bottom-right-radius: 0;
	   -webkit-box-shadow: none;
       -moz-box-shadow: none;
	}
	.update_btns{
		padding-left: 20px;
	}
	.update_btns .btn-primary{
		background: #a70da4;
		border-color: #6f06ad;
	}
	.update_btns .btn-primary:hover{
		background: #560B61;
		border-color: #a70da4;
		color: #fff;
	}
	.update_btns .btn-danger{
		margin-left: 5px;
	}
</style>