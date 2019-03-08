<template>
    <div class="container">
    	<div class="myads row">
	        <h3>Latest Ads</h3>
	        <div class="row ads_wrap">
	            <div v-for="(ad, index) in ads" :key="index">
	                <div class="col-md-3 col-sm-3 col-xs-4">
                        <my-ad :prod="ad"></my-ad>
	                    <!-- <div class="ad_cont">
	                        <router-link :to="{path: '/ad/'+ ad.title|slugify +'/' + ad.id}">
	                            <img :src="'/images/products/thumbnails/'+ ad.ad_pic[0].picture" class="center-block img-responsive" alt="#">
	                            <span class="ad_label">
	                                <h4 class="text-center">&#8358{{ ad.price | price() }}</h4>
	                                <h6 class="text-center">{{ ad.title | caps | truncate(22) }}</h6>
	                            </span>
	                        </router-link>
	                    </div> -->
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
                ads: [],
                pics: []
            }
        },
        filters: {
            price(val){
                let amt = parseInt(val/100);
                let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
                return amount;
            },
            truncate(string, value){
                if(string.length > 22){
                   return string.substring(0, value) + " ..."; 
               }else{
                    return string;
               }
            },
            caps(str){
                return str.toLowerCase().split(' ').map(function(word){
                    return (word.charAt(0).toUpperCase() + word.slice(1));
                }).join(' ');
            },
            slugify(str){
                str = str.toLowerCase()
                str = str.replace(/\W/gi, "-");
                str = str.replace(/(\-)\1+/gi, "-");
                return str;
            }
        },
        methods: {
            openAd(ad){
                this.$router.push('/ad/'+ad.id)
            }
        },
        mounted() {
            axios.get('/getads').then((res) => {
                this.ads = res.data
                console.log(res.data)
            })
        }
    }
</script>

<style scoped>
    .myads{
    	padding: 15px;
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

