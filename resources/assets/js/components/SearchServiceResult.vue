<template>
	<div class="search_result">
		<serv-search-pill></serv-search-pill>
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 page_wrap">
					<div class="upper_bar_search">
						<h4 class="return text-center">Search result for services <strong><span class="query_str">{{ query }}</span></strong> returned {{ count | plural }}</h4>
					</div>
					<!-- <div v-for="ad in results" :key="ad.id">
						{{ ad }}
						<hr>
					</div> -->
					<div class="result_grid">
						<div v-for="ad in results" :key="ad.id" class="ad_cont">
							<div v-if="ad.service_ad_pic.length > 0" >
								<router-link :to="{path: '/service_ad/'+ ad.id + '/' + ad.slug}" class="ad_wrap">
									<img :src="'/images/service/thumbnails/' + ad.service_ad_pic[0].picture" class="center-block img-responsive" alt="#">
									<!-- <span class="ad_label"> -->
										<h4 class="text-center">{{ ad.title }}</h4>
										<h3 class="text-center"> &#8358;{{ ad.price | price() }}</h3>
									<!-- </span> -->
								</router-link>
							</div>
							<div v-else>
								<router-link :to="{path: '/service_ad/'+ ad.id + '/' + ad.slug}" class="ad_wrap">
									<h4 class="text-center">{{ ad.title }}</h4>
									<p>** {{ ad.service_descr[0].description }}</p>
									<h3 class="text-center price">&#8358;{{ ad.price | price() }}</h3>
								</router-link>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data(){
			return{
				results: [],
				query: '',
				count: ''
			}
		},
		filters:{
			plural(int){
				if(int === 0){
					return "no result."
				}else if(int === 1){
					return "1 result."
				}else{
					return int +' '+ "results."
				}
			},
			price(val){
                let amt = parseInt(val/100);
                let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
                return amount;
            },
            caps(str){
                return str.toLowerCase().split(' ').map(function(word){
                    return (word.charAt(0).toUpperCase() + word.slice(1));
                }).join(' ');
            },
            truncate(string, value){
                if(string.length > 22){
                   return string.substring(0, value) + " ..."; 
               }else{
                    return string;
               }
            }
		},
		watch: {
			results(){
				axios.post('/service_search', {
					service: this.$route.query.service
				}).then((res) => {
					let vm = this
					vm.results = res.data
					vm.count = res.data.length;
					vm.query = vm.$route.query.service
				});
			},
		},
		mounted(){
			this.query = this.$route.query.service
			this.results = this.$route.params.result
		}
	}
</script>

<style scoped>
	.page_wrap{
		margin-top: 5px;
	}
	.query_str{
		text-decoration: underline;
	}
	.result_grid{
		display: flex;
		justify-content: space-between;
		align-items: stretch;
		flex-wrap: wrap;
	}
	.result_grid .ad_cont{
		background: #fff;
		padding: 15px;
		border: 1px solid #cecece;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
		/* flex-basis: 31%; */
		height: 280px;
		margin-bottom: 10px;
		flex: 0 1 31%;
		box-sizing: border-box;
		/* text-align: center; */
		position: relative;

	}
	.result_grid a{
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		overflow: hidden;
	}
	.ad_wrap{
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: flex-end;
	}
	.ad_wrap h3{
		/* justify-self: flex-end; */
		/* margin-top: auto; */
		padding-bottom: 20px;
		font-size: 22px;
  		color: #fa6e07;
	}
	.ad_wrap h4{
		font-weight: 100;
  		font-size: 18px;
	}
	.ad_cont a:hover{
		text-decoration: none;
	}
	.ad_cont:hover h3{
		color: #a70da4;
		animation: h3-anim .8s ease-in-out;
	}
	.ad_cont:hover h4{
		animation: h4-anim 2s cubic-bezier(.84,-0.61,0,1.59);
	}
	@keyframes h3-anim{
		0%{
			transform: translateY(-30px);
			opacity: 0;
			visibility: hidden;
		}
		100%{
			transform: translateY(0);
			opacity: 1;
		}
	}

	@keyframes h4-anim{
		0%{
			transform: translateX(-40px);
			opacity: 0;
			visibility: hidden;
		}
		100%{
			transform: translateX(0);
			opacity: 1;
		}
	}
</style>


