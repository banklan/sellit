<template>
    <div class="single_ad">
        <!-- <search-bar></search-bar> -->
        <search-pill></search-pill>
        <div class="container">
        	<div class="row ad_details">
                <div class="col-md-8">
                    <div class="ad_img">
                        <span class="previous" v-if="dispImg.pic != firstImg" @click="goPrevious(dispImg.ind)">
                            <img src="/images/bckg/prev.png" alt="previous" class="sideArrows">
                        </span>
                        <span class="next" v-if="dispImg.pic != lastImg" @click="goNext(dispImg.ind)">
                            <img src="/images/bckg/next.png" alt="Next" class="sideArrows">
                        </span>
                        <span>
                            <img :src="'/images/products/flexes/'+ dispImg.pic" class="center-block img-responsive ad_pix" :alt="dispImg.pic">
                            <div class="thumbs">
                                <span v-for="(pic, index) in pics" :key="index">
                                    <img :src="'/images/products/flexes/'+ pic.picture" @click="selImg(pic.picture, index)" />
                                </span>
                            </div>
                        </span>
                    </div>
                    <div class="prod_details">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a data-toggle="tab" href="#details">Details</a></li>
                            <li role="presentation"><a data-toggle="tab" href="#description">Description</a></li>
                            <li role="presentation"><a data-toggle="tab" href="#seller">Seller's Info</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="details" class="tab-pane fade in active">
                                <h4>Details </h4>
                                <ul v-for="desc in descr" :key="desc.id">
                                    <li>{{ desc.description }}</li>
                                </ul>
                            </div>
                            <div id="description" class="tab-pane fade">
                                <h4>Description</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta atque, voluptatem sapiente odit aperiam fuga fugiat dolore harum repellat eum repudiandae autem maiores hic, tenetur quia dignissimos est, facere. Ullam suscipit ut atque quidem architecto, quibusdam totam, tempore ratione minima. Incidunt at praesentium, porro necessitatibus quibusdam ipsa magni fugiat eaque!</p>
                            </div>
                            <div id="seller" class="tab-pane fade">
                                <h4>Seller's Details</h4>
                                <table class="table table-responsive sellers_table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ fullName | caps }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone No:</th>
                                        <td>{{ phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>About</th>
                                        <td>{{ user.about_me }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <product-sidebar :product="ad"></product-sidebar>
                </div>
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
                dispImg: {
                    pic: '',
                    ind: '',
                },
                firstImg: '',
                lastImg: '',
                descr: [],
                user: [],
                phone: '',
                fullName: '',
                pics: [],
            }
        },
        filters: {
            caps(str){
                let capp = str.toLowerCase().split(' ').map(function(word){
                    return (word.charAt(0).toUpperCase() + word.slice(1));
                }).join(' ');
                return capp;
            },
        },
        watch: {
            ad(){
                this.descr = this.ad.ad_descr
                this.user = this.ad.user
                this.phone = this.ad.user.phone_no
                this.fullName = this.ad.user.f_name + ' ' + this.ad.user.l_name
            }
        },
        methods: {
            selImg(img, ind){
                this.dispImg.pic = img;
                this.dispImg.ind = ind;
            },
            goPrevious(img){
                let dispIndex = img;
                let prevImgInd = dispIndex - 1;
                let prevImg = this.ad.ad_pic[prevImgInd].picture
                this.dispImg.pic = prevImg;
                this.dispImg.ind = prevImgInd;
            },
            goNext(img){
                let dispIndex = img;
                let nextImgInd = dispIndex + 1;
                let nextImg = this.ad.ad_pic[nextImgInd].picture
                this.dispImg.pic = nextImg;
                this.dispImg.ind = nextImgInd;
            }
        },
        mounted(){
            axios.get('/getaddetails/' + this.id).then((res) => {
                console.log(res.data)
                this.ad = res.data; 
                let response = res.data.ad_pic
                this.pics = response;
                let firstPix = response[0].picture
                this.dispImg.pic = firstPix;
                this.dispImg.ind = 0;
                // get first and last images
                this.firstImg = res.data.ad_pic[0].picture;
                let len = res.data.ad_pic.length;
                let lastImg = res.data.ad_pic[len -1].picture;
                this.lastImg = lastImg

                console.log(res.data)
            })
        }
    }
</script>

<style scoped>
    .ad_details{
        margin-top: 12px;
    }
    .ad_img{
        background: #fff;
        border: 12px solid #cecece;
        border-radius: 6px;
    }
    .ad_img .ad_pix{
        width: 340px;
        height: 340px;
        padding: 20px 0;
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
    .ad_img .previous{
        float: left;
        padding-top: 150px;
    } 
    .ad_img .previous:hover{
        cursor: pointer;
    }
    .ad_img .next:hover{
        cursor: pointer;
    }
    .ad_img .next{
        float: right;
        padding-top: 150px;
    }
    .ad_img .sideArrows{
        height: 40px;
    }
    .prod_details{
        margin: 20px 10px;
        padding: 20px;
        background: #fff;
    }
    .tab-content{
        padding: 15px;
    }
    #seller p{
        font-size: 14px;
    }
    table.sellers_table{
        table-layout: fixed
    }
    .sellers_table td{
        white-space: normal;
    }

</style>
