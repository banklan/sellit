<template>
	<div class="search_result">
		<search-pill></search-pill>
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 page_wrap">
					<div class="upper_bar_search">
						<h4 class="return text-center">Search result for <strong><span class="query_str">{{ query }}</span></strong> returned {{ count | plural }}</h4>
					</div>
					<div class="result_grid">
						<div v-for="ad in results" :key="ad.id" class="prod">
							<my-ad :prod="ad"></my-ad>
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
			}
		},
		watch: {
			results(){
				axios.post('/product_search', {
					prod: this.$route.query.prod
				}).then((res) => {
					let vm = this
					vm.results = res.data
					vm.count = res.data.length;
					vm.query = vm.$route.query.prod
				});
			},
		},
		mounted(){
			// this.count = this.$route.params.result.length;
			this.results = this.$route.params.result;
			this.query = this.$route.query.prod

			console.log(this.$route.query.prod)
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
	}
	.result_grid .prod{
		width: 23%;
		margin: 10px;
	}
	.upper_bar .return{
		font-size: 20px;
		font-weight: 300;
	}
</style>