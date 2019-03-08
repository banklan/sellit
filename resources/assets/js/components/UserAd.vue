<template>
    <div class="user_ad">
    	<router-link :to="{path: '/ad/'+ ad.id  + '/' + urlSlug}">
            <div class="ad_slot">
                <p><span class="ad_info"> {{ ad.title |truncate(15) | caps }} - <span class="price">&#8358;{{ ad.price | price }}</span></span>
                    <img :src="'/images/products/thumbnails/'+ ad.ad_pic[0].picture" class="center-block img-responsive pix" alt="#">
                </p>
            </div>
        </router-link>
        <hr>
    </div>
</template>

<script>

    export default {
        props: ['ad'],
        data(){
            return {
                urlSlug: ''
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
             let title = this.ad.title;
             this.urlSlug = title.toString().toLowerCase()
                                .replace(/\s+/g, '-')
                                .replace(/&/g, '-and-')
                                .replace(/[^\w\-]+/g, '')
                                .replace(/\-\-+/g, '-')
                                .replace(/^-+/, '')
                                .replace(/-+$/, '')
        }
    }
</script>

<style scoped>
    .ad_slot{
        padding: 7px;
        border-radius: 3px;
    }
    .ad_slot img{
        float: left;
        width: 50px;
        height: 50px;
        margin-right: 5px;
    }
    p .ad_info{
        padding: 18px 0 0 10px;
        margin-top: 10px;
        font-size: 14px;
    }
    .ad_info:hover{
        text-decoration: none;
    }
    .ad_info .price{
        color: red;
    }
</style>