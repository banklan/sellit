<template>
    <div class="services">
        <serv-search-pill></serv-search-pill>
        <div class="container">
            <div class="myads row">
                <h3 class="text-center">Latest Services Ad</h3>
                <div class="ads_wrap">
                    <div v-for="ad in ads" :key="ad.id">
                        <!-- <service-ad :serv="ad"></service-ad> -->
                        <div class="ad_cont">
                            <router-link :to="{path: '/service_ad/'+ ad.id + '/' + ad.slug}">
                                <span v-if="ad.service_ad_pic.length > 0">
                                    <img :src="'/images/service/thumbnails/' + ad.service_ad_pic[0].picture" class="center-block img-responsive" alt="#">
                                    <span class="ad_label">
                                        <h4 class="text-center">{{ ad.title }}</h4>
                                        <h3 class="text-center price"> &#8358;{{ ad.price | price() }}</h3>
                                    </span>
                                </span>
                                <span v-else class="ad_label">
                                    <h4 class="text-center">{{ ad.title }}</h4><hr>
                                    <h3 class="text-center price">Cost: &#8358;{{ ad.price | price() }}</h3>
                                    <p>** {{ ad.service_descr[0].description }}</p>
                                </span>
                            </router-link>
                        </div>
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
                ads: []
            }
        },
         filters: {
            price(val){
                let amt = parseInt(val/100);
                let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
                return amount;
            },
         },
        mounted(){
            axios.get('/api/getservices').then((res) => {
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
    .myads h3{
        padding: 10x;
        margin-bottom: 25px;
    }
    .ads_wrap{
        /* margin: 20px 0 20px -10px; */
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        /* width: 100%; */
        /* align-items: center; */
        /* margin: 10px; */
    }
    .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        height: 280px;
        width: 260px;
        margin-bottom: 20px;
        /* flex: 1; */
        flex-basis: 24%;
        box-sizing: border-box;
        text-align: center;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        /* align-content: flex-start; */
        
    }
    .ad_cont img{
        /* margin: auto; */
        flex: 2;
        padding: 10px;
    }
    .ad_cont .ad_label{
        align-content: baseline;
        margin-bottom: 20px;
        /* margin:auto; */
        /* flex: 1; */
    }
    .ad_cont img{
        flex: 0 1 60%;
    }
    .ad_label h3{
        font-weight: 100;
        font-size: 22px;
        color: #fa6e07;
        position: relative;
    }
    .ad_label h4{
        font-weight: 100;
        font-size: 18px;
    }
    .ad:hover a{
        text-decoration: none;
    }
    .ad_cont:hover a{
        text-decoration: none;
    }
    .ad_cont:hover h3{
        color: #a70da4;
        animation: h3-anim .8s ease-in-out;
    }
    .ad_cont:hover h4{
        animation: h4-anim 2s cubic-bezier(.84,-0.61,0,1.59);
    }
    @keyframes h3-anim{
        0%{
            transform: translateY(-30px);
            opacity: 0;
            visibility: hidden;
        }
        100%{
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes h4-anim{
        0%{
            transform: translateX(-40px);
            opacity: 0;
            visibility: hidden;
        }
        100%{
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

