<template>
	<div class="container">
		<div class="myflags row">
	        <div class="col-md-10 col-md-offset-1">
	        	<div class="flags">
		        	<h3>Sellers i flagged <span v-if="reports.length > 0" class="badge">{{ reports.length }}</span></h3>
			        <div v-if="reports.length > 0" class="flag_table">
			        	<table class="table table-responsive table-hover table-condensed">
			        		<thead>
			        			<th style="padding-left: 15px">S/N</th>
			        			<th style="padding-left: 15px">Date</th>
			        			<th style="padding-left: 50px">Seller reported</th>
			        			<th style="padding-left: 50px">Report</th>
			        		</thead>
			        		<tbody>
			        			<tr v-for="(rep, index) in reports">
			        				<td style="padding-left: 20px">{{ index + 1 }}</td>
			        				<td style="">{{ rep.reported }}</td>
			        				<td style="padding-left: 50px">
			        					<router-link :to="{path: '/seller/' + rep.reportee_id + '/' + rep.reportee.slug}">{{ rep.reportee.Fullname }}</router-link>
			        				</td>
			        				<td style="padding-left: 50px">{{ rep.report }}</td>
			        			</tr>
			        		</tbody>
			        	</table>
				    </div>
				    <div v-else class="alert alert-info">
				    	<h4> You have not reported any seller(s)</h4>
				    </div>
				</div>
			</div>
	    </div>
	</div>
</template>

<script>
    export default {
        data(){
            return {
                reports: []
            }
        },
        mounted() {
        	// get my flags
            axios.get('/api/getmyflags').then((res) => {
                this.reports = res.data
                console.log(res.data)
            })

            
        }
    }
</script>

<style scoped>
   .myflags h3{
   		font-size: 18px;
   		padding-left: 20px;
   }
   .flags{
   		background: #fff;
   		border: 1px solid #333;
   		padding: 20px;
   		border: 1px solid #f3ebeb;
		border-radius: 6px;
		line-height: 1.8;
		-webkit-box-shadow: 14px 9px 8px 0px rgb(175, 45, 164), inset 5px -2px 14px 0px rgba(140, 43, 117, 0.47);
		-moz-box-shadow: 14px 9px 8px 0px rgb(175, 45, 164), inset 5px -2px 14px 0px rgba(140, 43, 117, 0.47);
    	-webkit-font-smoothing: antialiased;
   }
   .flag_table{
   		margin: 20px;
   }
   .flag_table thead{
		padding-left: 15px;
   }
   .flag_table tr{
   		
   }
   .alert h4{
   		padding-left: 10px;
   }

</style>