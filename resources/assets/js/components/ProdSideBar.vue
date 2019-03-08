<template>
    <div class="sidebar">
    	<div class="top">
    		<h4 class="price">Price: &#8358;{{ product.price | price() }}</h4>
    		<h4 class="prod_name">{{ prod | caps }}</h4>
    		<hr>
    		<p class="deemph" >Published: {{ moment(product.created_at).fromNow() | caps }} </p>
    	</div>
		<div class="mid">
			<p style="font-size: 15px; font-weight: bold;">Seller</p>
			<span class="seller_details">
				<p>
					<div class="avat">
						<img src="/images/profile_pix/avatar.png" alt="avatar" class="image-responsive sellers_avatar" />
					</div>
					<div class="name">
						<router-link :to="{path: '/seller/' + product.user_id + '/' + urlSlug}"> {{ user }} </router-link>
						<h5>
							<i class="fa fa-map-marker"></i><span> {{ loc }} </span>
						</h5>
					</div>
			    </p>
			</span>
			<span class="commun">
				<p class="tel">
					<i class="fa fa-mobile-phone"></i> - {{ phone }}
				</p>
				<div class="form-group chat_btn">
					<div class="col-md-10 col-md-offset-1">
						<router-link v-if="!product.selfOwned" :to="{path: '/chat/'+ product.user_id}" class="btn btn-default btn-block">Chat</router-link>
					</div>
				</div>
			</span>
    	</div>
    </div>
</template>

<script>
	 var moment = require('Moment');

	 export default {
		props: ['product'],
		data(){
			return {
				moment: moment,
				user: '',
				prod: '',
				loc: '',
				phone: '',
				urlSlug: '',
				me: ''
			}
		},
		watch: {
			 product(){
                this.user = this.product.user.f_name+' '+this.product.user.l_name
                this.prod = this.product.title
                this.loc = this.product.user.city.name
                this.phone = this.product.user.phone_no
                this.urlSlug = this.user.toString().toLowerCase()
                						.replace(/\s+/g, '-')
                						.replace(/&/g, '-and-')
                						.replace(/[^\w\-]+/g, '')
                						.replace(/\-\-+/g, '-')
                						.replace(/^-+/, '')
                						.replace(/-+$/, '')
            },
		},
		methods: {
			slugify(){
				let user = this.user
				let slug = user.toString().toLowerCase()
					.replace(/\s+/g, '-') //Replace spaces with -
					.replace(/&/g, '-and-') //Replace & with 'and'
					.replace(/[^\w\-]+/g, '') //Remove all non-word characters
					.replace(/\-\-+/g, '-') //Replace multiple - with single '-'
					.replace(/^-+/, '') //Trim from start of text
					.replace(/-+$/, '') //Trim fron end of text
					// Not used as a method, used in watch above
			}
		},
		filters: {
			price(val){
                let amt = parseInt(val/100);
                let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
                return amount;
            },
			caps(str){
				let capp = str.toLowerCase().split(' ').map(function(word){
                    return (word.charAt(0).toUpperCase() + word.slice(1));
                }).join(' ');
                return capp;
            },
		},
		mounted(){
			if(window.Laravel.user){
				let me = window.Laravel.user.id
				this.me = me
			}

			console.log(this.product)
		}
	}
    
</script>

<style scoped>
	.sidebar{
		padding: 5px;
	}
	.top, .mid{
		padding: 17px;
        border: 1px solid #f1f1f1;
        border-radius: 6px; 
		background: #fff;
		margin-bottom: 15px;
	}
	.top h4.price{
		color: #d41313;
		padding: 10px 0;
	}
	.seller_details{
		margin: 50px 0;
	}
	.deemp{
		font-size: 14px;
	}
	.seller_details .avat{
		float: left;
	}
	.seller_details img{
		border-radius: 50%;
		border: 1px solid #f1f1f1;
		height: 80px;
	}
	.seller_details .name{
		margin-left: 100px;
		margin-top: 25px;
		margin-bottom: 30px;
	}
	.seller_details a{
		font-size: 14px;
	}
	.seller_details a:hover{
		text-decoration: none;
		color: #a70da4;
		font-weight: 500;
	}
	.commun{
		margin: 20px 0 50px 0;
		padding: 10px;
	}
	.commun .tel{
		font-size: 14px;
	}
	.commun .chat_btn{
		margin: 20px 0 40px 0;
	}
	.commun a{
		border-radius: 800px;
		border: 2px solid #a70da4;
		color: #a70da4;
	}
	.commun a:hover{
		border: 2px solid #a70da4;
		background: #a70da4;
		color: #fff;
		transition: 0.3s ease-in-out;
	}
	.fa{
		font-family: fontAwesome;
		font-size: 18px;
		color: #a70da4;
	}
	.prod_name{
		line-height: 1.6;
	}
	
</style>
