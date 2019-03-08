<template>
    <div class="home_banner">
        <div class="home_caption">
	        <h1 class="text-center">Buy and sell anything, whenever, wherever you are</h1>
	        <div class="search-form">
	            <form class="form-horizontal" method="POST" action="">
	                <div class="form-group">
	                    <div class="col-md-10 col-md-offset-1" >
	                        <div class="input-group input-group-lg">
	                            <input type="text" class="form-control" name="query" v-model="query.product" placeholder="What are you looking for?">
	                            <span class="input-group-btn" style="width:0px"></span>
	                            <select class="form-control" style="margin-left: -1px" v-model="query.location">
	                                <option value="" class="faw"> &#xf041; </option>
	                                <option v-for="city in cities" :value="city.id" :key="city.id">{{ city.name }}</option>
	                            </select>
								<!-- <input type="text" class="hidden" v-model="query.loc"> -->
	                            <span class="input-group-btn">
	                                <button class="btn btn-default" type="button" @click.prevent="search"><i class="fa fa-search"></i></button>
	                            </span>
	                        </div>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
    </div>
</template>

<script>
	export default {
        data(){
        	return{
        		query: {
        			product: '',
					location: '',
					loc: ''
        		},
        		cities: []
        	}
		},
		watch:{
			// this.query.loc(){

			// }
		},
        methods:{
        	search(){
        		if(this.query.product != ''){
        			axios.post('/product_search/', {
        				prod: this.query.product,
        				loc: this.query.location
        			}).then((res) => {
        				let vm = this
        				// console.log(res.data)
        				this.$router.push({name: 'searchresult', query:{prod: vm.query.product, loc:vm.query.location}, params: {result: res.data}})
        			})
        		}
        	}
        },
        mounted(){
        	// get cities
        	axios.get('/getcities').then((res) => {
 				this.cities = res.data
 			})
        }
    }
</script>
