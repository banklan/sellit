<template>
	<div class="container">
		<div class="myads row">
	        <h3>My Ads <span v-if="ads.length > 0" class="badge">{{ ads.length }}</span></h3>
	        <div class="row ads_wrap">
	            <div v-for="ad in ads">
	            	<div v-if="ads.length > 0">
		                <div class="col-md-3 col-sm-3 col-xs-4">
							<my-ad :prod="ad"></my-ad>
		                </div>
		            </div>
		            <div v-else>
		            	<h4 class="text-center">You have not posted any ads</h4>
		            </div>
	            </div>
	        </div>
	        <hr>
	        <div class="row ads_wrap">
	        	<h3>My Services Ads <span class="badge">{{ services.length }}</span></h3>
	        	<div v-if="serves">
	        		<div v-for="serv in services">
		                <div class="col-md-3 col-sm-3 col-xs-4">
							<service-ad :serv="serv"></service-ad>
		                </div>
		            </div>
		        </div>
        		<div v-else class="alert alert-info">
	            	<h4>You have not posted any services ads</h4>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
    export default {
        data(){
            return {
                ads: [],
                pics: [],
                services: [],
                serves: false
            }
        },
        filters: {
            
        },
        methods: {
            
        },
        mounted() {
        	// get my own ads
            axios.get('/getmyads').then((res) => {
                this.ads = res.data
            })

            // get my own events
            axios.get('/api/getmyownservices').then((res) =>{
            	
            	if(res.data.length != 0){
            		this.serves = true
            		this.services = res.data
            	}else{
            		this.serves = false
            	}
            	// console.log(res.data.length)
            })
        }
    }
</script>

<style scoped>
    .myads{
    	padding: 15px;
    }
    .myads h3{
    	font-size: 18px;
    }
    .ads_wrap{
        margin: 20px 0 20px -10px;
    }
    .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        margin-bottom: 15px;
        margin-right: -15px;
        max-height: 100%;
    }
    .ad_cont h4{
        color: #fa6e07;
    }
    .ad_cont a:hover{
        text-decoration: none;
    }
    .ad_cont h6{
        font-size: 13px;
        color: #4c4c4c;
    }
    .ad_label{
        padding: 7px;
    }
    .ad_label h4{
        margin-bottom: -5px;
    }
</style>