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

<style scoped>
    .ad_cont{
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: 12px 10px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);
        margin: 15px -15px 15px 10px;
        height: 280px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
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