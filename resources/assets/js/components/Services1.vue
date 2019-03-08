<template>
    <div class="services">
        <search-pill></search-pill>
        <div class="container">
            <div class="myads row">
                <h3>Latest Services Ad</h3>
                <div class="row ads_wrap">
                    <div v-for="ad in ads" :key="ad.id">
                        <div class="col-md-3 col-sm-3 col-xs-4">
                        <service-ad :serv="ad"></service-ad>
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

