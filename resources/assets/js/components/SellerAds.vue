<template>
	<div class="sellerad">
		<search-pill></search-pill>
		<div class="container">
			<div class="row">
				<div class="top_strip">
					<h4 class="text-center">Ads By {{ seller }} <span class="badge">{{ sellerAds.length }}</span></h4>
				</div>
			</div>    
			<div class="row">  
				<div v-if="sellerAds">  
					<div v-for="ad in sellerAds" :key="ad.id">
						<div class="col-md-3 col-sm-3 col-xs-4">
							<my-ad :prod="ad"></my-ad>
						</div>
					</div>
				</div>
				<div v-else>
					<div class="alert alert-warning">	
						This user hasn't posted any ads!
					</div>																				
				</div>
			</div><hr>
			<div class="row">
				<div v-if="userServices.length > 0">
					<div class="services">
						<h4 class="text-center">Services ads by {{ seller }} <span class="badge">{{ userServices.length }}</span></h4>
						<div v-for="serv in userServices" :key="serv.id"> 
							<div class="col-md-3 col-sm-3 col-xs-4">
								<seller-serv :service="serv"></seller-serv>
							</div>
						</div>
					</div>
				</div>
				<div v-else>
					<div class="alert alert-warning">	
						This user hasn't posted any service ads!
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
                id: this.$route.params.id,
                sellerAds: [],
     			seller: '',
     			userServices: []
     		}
     	},
        watch: {

        },
     	methods: {
     		showServices(){
     			console.log(this.sellerAds)
     		}
     	},
     	mounted(){
    		// get ads by seller
            axios.get('/getuserads/' + this.id).then((res) => {
                console.log(res.data)
                this.sellerAds = res.data

                this.seller = res.data[0].user.Fullname
            })

            //get services by seller
            axios.get('/api/getuserservices/' + this.id).then((res) => {
	            console.log(res.data)
	            this.userServices = res.data
	        })
     	}
     }  
</script>

<style scoped>
	.top_strip{
		margin-top: 30px;
	}
	 h4{
        padding: 10px;
        margin-top: -10px;
     }
     .show_services{
     	color: blue;
     }
     .show_services:hover{
     	cursor: pointer;
     	color: #9b06b5;
     	transform: scale(1.1);
     	transition: 0.2s all linear;
     }
     h4 .badge{
     	background: #9b06b5;
     	padding: 4px 8px;
     	margin-top: -2px;
     }
     .services{
     	padding: 10px;
     	margin-top: 10px;
     }
</style>
