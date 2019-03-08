<template>
    <div class="categories">
		<div class="container">
			<div class="row">
				<h3 class="">Popular Categories</h3>
				<div class="cat_thumbs">
					<div v-for="(categ, index) in categories" :key="index" class="img_wrap" @click="openCat(categ)">
						<img :src="'/images/categories/thumbnails/'+ categ.cat +'.jpg'" alt="#" />
						<p>{{ categ.category}}</p>
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
			},
			openCat(cat){
				console.log(cat)
				this.$router.push({name: 'category', params:{id: cat.id, slug: cat.slug}});
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
	.cat_thumbs{
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		margin: 10px;
	}
	.img_wrap{
		height: 140px;
		border: 1px solid #ddd;
		flex:0 1 12%;
		background: #fff;
		margin-bottom: 7px;
		box-sizing: border-box;
		cursor: pointer;

		display: flex;
		flex-direction: column;
		justify-content: center;
	}
	.img_wrap img{
		margin: auto;
	}
	.img_wrap p{
		font-size: 15px;
		margin:auto;
	}
	.img_wrap a{
		display: block;
	}
</style>
