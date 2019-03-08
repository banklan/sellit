<template>
    <div class="categories">
        <h3>Popular categories</h3>
        <div class="row">
        	<div class="cat_listing">
        		<div v-for="(categ, index) in categories">
        			<div class="categ" v-if="index < 10">
		        		<div class="col-md-2 col-sm-3 col-xs-3 cat_badge">
		        			<img :src="'/images/categories/thumbnails/' + categ.cat +'.jpg'" class="pic center-block" alt="#"/>
		        			<h5 class="text-center">{{ categ.category }}</h5>
		        		</div>
		        	</div>
		        </div>
	        </div>
        </div>
        <div style="padding-top: 15px">
        	<a href="">View All <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
    	data(){
    		return {
    			categories: []
    		}
    	},
        mounted() {
            axios.get('/getcategories').then((res) => {
            	this.categories = res.data
            	console.log(res.data)
            })
        }
    }
</script>

<style scoped>
	.cat_listing{
		padding: 10px 15px;
	}
	.cat_badge{
		background: #fff;
		padding: 7px 12px;
		border: 1px solid #ccc;
		margin-right: 5px;
		margin-bottom: 5px;
	}
	.cat_badge img{
		max-width: 100%;
		height: auto;
		display: block;
	}
</style>


<div class="container">
    		<div class="row pop_cats">
		        <h3>Popular categories</h3>
					<div class="cats_wrapper">
						<div v-for="(categ, index) in categories" :key="categ">
							<div class="img_wrap">
								<a href="#">
									<img :src="'/images/categories/thumbnails/'+ categ.cat +'.jpg'" class="center-block cat" alt="#" >
									<h5 class="text-center">{{ categ.category }}</h5>
								</a>
							</div>
						</div>
					</div>
    			</div>
		        <div style="padding-top: 15px" v-if="!allCats">
		        	<a href="" @click.prevent="showAllCats">Show All Categories <i class="fa fa-angle-double-right"></i></a>
		        </div>
		        <div style="padding-top: 10px" v-if="allCats">
		            <a href="" @click.prevent="showPopCats">Show Popular Categories <i class="fa fa-angle-double-right"></i></a>
		        </div>
		    </div>
		</div>
