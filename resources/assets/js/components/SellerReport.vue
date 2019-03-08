<template>
	<div class="rept">
		<div v-if="!edit">
			<h4>{{ rep.reporter.Fullname }} - <span class="created text-muted">{{ rep.reported }} </span></h4>
			<p>- {{ rep.report }}</p>
			<div v-if="rep.selfOwned" class="editRep">
				<div v-if="!edit">
					<a href="#" @click.prevent="showEdit">Edit</a>
					<a href="#" class="del" @click.prevent="delReport(index, rep.id)"><i class="fa fa-trash"></i></a>
				</div>
			</div>
		</div>
		<div v-else>
			<edit-report :report="rep"></edit-report>
		</div>
		
	</div>
</template>

<script>
	import Bus from '../bus'

 	export default {
 		props: ['report', 'index'],
 		data(){
 			return {
 				edit: false,
 				rep: this.report
 			}
 		},
 		watch: {
 			report(){
 				// this.rep = 
 			}
 		},
 		methods: {
 			showEdit(){
 				this.edit = true;
 				console.log(this.report)
 			},
 			delReport(index, report){
 				if(confirm('Do you want to delete this report?')){
 					console.log(index)
 					axios.delete('/delreport/' + report).then((res) => {
 						Bus.$emit('report-deleted', index);
 					})
 				}
 			}
 		},
 		mounted(){
 			Bus.$on('updt-cancel', ()=>{
 				this.edit = false
 			});

 			Bus.$on('report-updt', (report) => {
 				if(report.id == this.rep.id){
 					this.rep = report
 				}
 				
 			});
 		}
 	}
</script>

<style scoped>
	.rept{
		padding: 0 10px 0 15px;
	}
	.rept h4{
		font-size: 17px;
	}
	.rept .created{
		font-size: 12px;
		color: #a9a9a9;
		padding-left: 2px;
	}
	.rept p{
		font-size: 15px;
		font-style: italic;
		padding-left: 7px;
	}
	.editRep{
		padding-left: 20px;
	}
	.editRep .del{
		padding-left: 30px;
		color: #d23838;
	}
	
</style>