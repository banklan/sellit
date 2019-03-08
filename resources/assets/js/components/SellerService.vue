<template>
    <div class="ad">
        <router-link :to="{path: '/service_ad/'+ service.id + '/' + service.slug}">
        	<div class="ad_cont">
            	<div v-if="service.service_ad_pic.length > 0">
                	<img :src="'/images/service/thumbnails/'+ service.service_ad_pic[0].picture" class="center-block img-responsive" alt="#">
                	<span class="ad_label">
	                	<h3 class="text-center price">&#8358{{ service.price | price() }}</h3>
	                	<h4 class="text-center">{{ service.title | caps | truncate(22) }}</h4>
	                </span>
                </div>
                <div v-else>
                	<h3 class="text-center" style="padding-top: 10px">{{ service.title }} </h3> 
                	<span class="ad_label">
	                	<h3 class="text-center price">&#8358{{ service.price | price() }}</h3>
	                	<h4>**{{ service.service_descr[0].description }} </h4>
	                </span>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>

    export default {
        props: ['service'],
        data(){
            return {
               
            }
        },
        filters: {
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
        mounted(){
             
        }
    }
</script>

<style>
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
    .ad_cont h3.price{
        color: #fa6e07;
        margin-top: -4px;
    }
    .ad_cont a:hover{
        text-decoration: none;
    }
    .ad_cont h4{
        font-size: 15px;
        color: #4c4c4c;
        padding: 10px 5px;
    }
    .ad_label{
        padding: 7px;
    }
    .ad_label h3{
        margin-bottom: -5px;
    }

</style>