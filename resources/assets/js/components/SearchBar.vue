<template>
    <div class="search_bar row">
    	<div class="top_strip">
    		<form class="form-horizontal">
    			<div class="form-group">
    				<div class="col-md-4" style="padding: 5px 0 0 80px;">
						<a href="#" @click.prevent="$router.go(-1)" title="Back"> &larr;</a>
					</div>
	                <div class="col-md-4 col-md-offset-2">
	                    <div class="input-group">
	                        <input type="text" class="form-control" name="query" placeholder="What are you looking for?">
                            <!-- <span class="input-group-btn" style="width:0px"></span> -->
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                            </span>
	                    </div>
	                </div>
	            </div>
	        </form>
	     </div>
    </div>
</template>

<script>
	export default {
        data(){
            return {

            }
        },
        methods: {
        	goBack(){
        		this.$router.push('/')
        	}
        }
    }
</script>

<style scoped>
	.top_strip{
		padding: 7px 10px;
	}
	.search_bar{
        background-color: #fff;
        height: 50px;
        margin-top: -22px;
    }
</style>
