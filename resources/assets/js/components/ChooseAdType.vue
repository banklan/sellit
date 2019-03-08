<template>
	<div class="new_ad row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="text-center">What type of Ad are you posting?</h3>
			<div class="row choice">
				<div class="col-md-6">
					<router-link :to="{path: '/create_ad'}">
						<div class="ad_type_box">
							<h3 class="text-center">I'm posting an ad for a visible product i want to sell</h3>
						</div>
					</router-link>
				</div>
				<div class="col-md-6">
					<router-link :to="{path: '/create_service_ad'}">
						<div class="ad_type_box">
							<h3 class="text-center">I'm posting an ad for a service or an event, or other invisible events</h3>
						</div>
					</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	 export default {
        data(){
            return{
            	
            }
        },
        // beforeRouteEnter(to, from, next){
		// 	if(!window.Laravel.auth){
		// 		window.location.href="/login"
		// 		// this.$router.push({path: '/'})
		// 		// next('/login')
		// 	}
		// 	next()
		// },
        methods: {
        	
            
        },
        mounted(){
        	
        }
    }

</script>

<style scoped>
	.choice{
		padding: 20px;
		margin-top: 20px;
	}
	.ad_type_box{
		border: 1px solid #cecece;
		border-radius: 6px;
		box-shadow: 1px 9px 10px 5px rgba(191, 177, 191, 0.92);
		padding: 6px 10px;
		height: 200px;
		margin: 20px;
	}
	.ad_type_box:hover{
		transform: rotate(-4deg);
		transition: 0.2s all linear;
	}
	.ad_type_box h3{
		color: #6b6b6b;
		font-size: 23px;
		font-weight: 300;
		line-height: 1.5;
	}
	.ad_type_box:hover h3{
		color: #b92db9;
		text-decoration: none;
		transition: 0.2s ease-in-out; 
	}
	a:hover{
		text-decoration: none;
	}
</style>