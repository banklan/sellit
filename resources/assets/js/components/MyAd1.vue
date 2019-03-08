<template>
    <div class="ad">
        <router-link :to="{path: '/ad/'+ prod.id + '/' + urlSlug}" class="test">
            <div class="ad_cont">
                <img :src="'/images/products/thumbnails/'+ prod.ad_pic[0].picture" class="center-block img-responsive" alt="#">
                <span class="ad_label">
                    <h3 class="text-center price">&#8358;{{ prod.price | price() }}</h3>
                    <h4 class="text-center">{{ prod.title | caps | truncate(22) }}</h4>
                </span> 
            </div>
        </router-link>
    </div>
</template>

<script>

    export default {
        props: ['prod'],
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
             let title = this.prod.title;
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

<style>
    .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: 12px 10px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        margin: 15px -15px 15px 10px;
        max-height: 100%;
    }
    .ad:hover a{
        text-decoration: none;
    }
    .ad:hover a h3, .ad:hover a h4{
    	color: #b92db9;
    }
    .ad_label{
        padding: 7px;
    }
    .ad_label h4{
        margin-bottom: -5px;
        font-size: 18px !important;
        color: #fa6e07;
    }
    .ad_cont h3.price{
        color: #fa6e07;
        padding: 8px 0 3px 0;
        display: block;
    }
    @media only screen and (max-width: 780px){
        .ad_cont h3.price{
            font-size: 14px;
        }
        .ad_label h4{
            font-size: 12px;
        }
    }

</style>