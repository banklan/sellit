<template>
    <div class="single_ad">
        <search-bar></search-bar>
        <div class="container">
        	<div class="row ad_details">
                <div class="col-md-8">
                    <div class="ad_img">
                        <span v-for="(pic, index) in ad.ad_pic" v-if="pic.picture != dispImg">Prev</span>
                        <img :src="'/images/products/flexes/'+ dispImg" class="center-block img-responsive ad_pix" :alt="dispImg">
                        <div class="thumbs">
                            <span v-for="(pic, index) in ad.ad_pic">
                                <img :src="'/images/products/flexes/'+ pic.picture" v-on:mouseover="highlight(pic)" @click="selImg(pic.picture)" />
                            </span>
                        </div>       
                    </div>
                </div>
                <div class="col-md-4"></div>
            	<h1>{{ id }}</h1>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                id: this.$route.params.id,
                ad: [],
                isHovered: false,
                dispImg: '',
                hovered: {
                    border: '2px solid red',
                    scale: '1.2',
                    cursor: 'pointer',
                }
            }
        },
        methods: {
            selImg(img){
                this.dispImg = img
            },
            highlight(pic){
                this.isHovered = true
            }
        },
        computed: {

        },
        mounted(){
            axios.get('/getaddetails/' + this.id).then((res) => {
                this.ad = res.data 
                this.dispImg = res.data.ad_pic[0].picture
                console.log(res.data)
            })
        }
    }
</script>

<style scoped>
    .ad_details{
        margin-top: 8px;
    }
    .ad_img{
        background: #fff;
        border: 2px solid #cecece;
        border-radius: 6px;
    }
    .ad_img .ad_pix{
        width: 340px;
        height: 340px;
    }
    .thumbs{
        margin-top: 20px;
        margin-left: 3px;
    }
    .thumbs img{
        width: 80px;
        height: 80px;
        border: 1px solid #cecece;
        margin-right: 5px;
        margin-bottom: 10px;
    }
    .thumbs:hover img{
        opacity: 0.6;
        transform: scale(0.9);
    }
    .thumbs img:hover{
        cursor: pointer;
        transform: scale(1.1);
        transform: rotate(4deg);
        box-shadow: 0 0 7px rgba(79, 33, 49, 0.5);
        /*filter: grayscale(100%);*/
        transition: 0.4s;
        opacity: 1;
    }

</style>
