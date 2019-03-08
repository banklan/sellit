<template>
	<div class="seller_reports">
		<h4>Reports on {{ profile.name }}</h4>
		<div class="reports">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a data-toggle="tab" href="#reports">Reports</a></li>
            </ul>
            <div class="tab-content">
                <div id="reports" class="tab-pane fade in active">
                	<div v-if="reports.length > 0">
                		<div v-for="(report, index) in reports" :key="report.id">
                			<report :report="report" :index="index"></report>
                			<span v-if="index + 1 != reports.length"><hr></span>
                		</div>
                	</div>
                	<div v-else>
                		<p>No reports on this seller</p>
                	</div>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
	import Bus from '../bus'

 	export default {
 		props: ['id', 'profile'],
 		data(){
 			return {
 				reports: [],
 			}
 		},
 		methods: {
 			getReports(){
 				axios.get('/getreports/' + this.id).then((res) => {
	 				console.log(res.data)
	 				this.reports = res.data
	 			})
 			}
 		},
 		mounted(){
 			this.getReports();

 			let vm = this
 			Bus.$on('report-deleted', (index) => {
 				vm.reports.splice(index, 1)

 				vm.$toasted.show('Report deleted!',
                    {
                      type: 'success'
                    })
 			})
 		}
 	}
</script>

<style scoped>
	.seller_reports{
		padding: 10px;
		background: #fff;
		margin: 15px auto;
		line-height: 1.8;
		border: 1px solid #f3ebeb;
		border-radius: 6px;
	}
	.seller_reports #reports{
		padding: 5px 10px;
	}
	
</style>