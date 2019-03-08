<template>
    <div class="ad">
    	<div class="ad_cont">
            <router-link :to="{path: '/service_ad/'+ serv.id + '/' + serv.slug}">
                <span v-if="serv.service_ad_pic.length > 0">
                    <img :src="'/images/service/thumbnails/' + serv.service_ad_pic[0].picture" class="center-block img-responsive" alt="#">
                    <span class="ad_label">
                        <h4 class="text-center">{{ serv.title }}</h4>
                        <h3 class="text-center price">Cost: &#8358;{{ serv.price | price() }}</h3>
                    </span>
                </span>
                <span v-else class="ad_label">
                    <h4 class="text-center">{{ serv.title }}</h4><hr>
                    <h3 class="text-center price">Cost: &#8358;{{ serv.price | price() }}</h3>
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

<style scoped>
   .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        /* padding: 12px 10px; */
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        /* margin: 15px -15px 15px 10px; */
        box-sizing: border-box;
        height: 280px;
        flex: 0 1 23%;

        /* display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; */

        /* height: 140px; */
		/* border: 1px solid #ddd; */
		/* flex:0 1 12%; */
		/* background: #fff; */
		/* margin-bottom: 7px; */
		/* box-sizing: border-box; */
		/* cursor: pointer; */

		
    }

</style>