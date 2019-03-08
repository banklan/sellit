<template>
    <div class="ad">
    	<div class="ad_cont">
            <router-link :to="{path: '/service_ad/'+ serv.id + '/' + serv.slug}">
                <span v-if="serv.service_ad_pic.length > 0">
                    <img :src="'/images/service/thumbnails/' + serv.service_ad_pic[0].picture" class="center-block img-responsive" alt="#">
                    <span class="ad_label">
                        <h4 class="text-center">{{ serv.title }}</h4>
                        <h4 class="cost" style="padding-top: 4px; margin-bottom: -15px">Cost: &#8358{{ serv.price | price() }}</h4>
                    </span>
                </span>
                <span v-else class="ad_label">
                    <h3 class="text-center">{{ serv.title }}</h3><hr>
                    <h4 class="cost">Cost: &#8358;{{ serv.price | price() }}</h4>
                    <p>** {{ serv.service_descr[0].description }}</p>
                </span>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
       props: ['serv'],
       filters: {
            price(val){
                let amt = parseInt(val/100);
                let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
                return amount;
            },
        },
    }
</script>

<style>
    .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        margin-bottom: 15px;
        margin-right: -15px;
        max-height: 100%;
        /*height: 200px;*/
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
    .ad_label .cost{
        color: #f36700;
    }
    .ad_cont:hover h3, .ad_cont:hover p, .ad_cont:hover h4, .ad_cont:hover h5{
        color: #b92db9;
        text-decoration: none;
        transition: 0.2s ease-in-out; 
    }

</style>