<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="category page_wrap">
                    <div class="upper_bar">
                        <a href="#" @click.prevent="$router.go(-1)" title="Back"> &larr;</a>
                        <h4>Category: {{ category.category }}</h4>
                    </div>
                    
                    <div v-for="item in category.ad" :key="item.id">
                        <p>{{ item.title }}</p>
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
				category: [],
                id: this.$route.params.id,
    		}
    	},
        methods: {
           
        },
        mounted() {
            // this.category = this.$route.params.categ

            axios.get('/getcategory/' + this.id).then((res) => {
                console.log(res.data)
                this.category = res.data
            })
        }
    }
</script>

<style scoped>
    
    	
</style>
