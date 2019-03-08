<template>
    <div class="categories">
    	<div class="container">
    		<div class="row pop_cats">
		        <h3>Popular categories</h3>
		        <div class="row">
		            <div class="cat_listing">
		            	<div v-for="(categ, index) in categories" :key="categ">
		                    <div v-if="!allCats">
		                        <div v-if="index < 6">
		                            <div class="col-md-2 col-sm-4 col-xs-4">
		                                <div class="img_wrap">
		                                    <a href="#">
		                                        <img :src="'/images/categories/thumbnails/'+ categ.cat +'.jpg'" class="center-block cat" alt="#" >
		                                        <h5 class="text-center">{{ categ.category }}</h5>
		                                    </a>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div v-if="allCats">
		                        <div class="col-md-2 col-sm-4 col-xs-4">
		                            <div class="img_wrap">
		                                <a href="#">
		                                    <img :src="'/images/categories/thumbnails/'+ categ.cat +'.jpg'" class="center-block cat" alt="#" >
		                                    <h5 class="text-center">{{ categ.category }}</h5>
		                                </a>
		                            </div>
		                        </div>
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
	</div>
</template>

<script>
    export default {
    	data(){
    		return {
    			categories: [],
                allCats: false 
    		}
    	},
        methods: {
            showAllCats(){
                this.allCats = true;
            },
            showPopCats(){
                this.allCats = false;
            }
        },
        mounted() {
            axios.get('/getcategories').then((res) => {
            	this.categories = res.data
            	// console.log(res.data)
            })
        }
    }
</script>

<style scoped>
	.pop_cats{
		padding: 10px 20px;
	}
	.cat_listing{
        margin-right: -10px;
    }
    .img_wrap{
        background: #fff;
        padding: 15px;
        margin-bottom: 10px;
        float: left;
        margin-right: 10px;
        box-sizing: border-box;
        height: 120px;
    }
    .img_wrap h5{
        font-size: 13px;
    }
    img{
       display: block;
        margin-top: -7px;
    }
</style>
