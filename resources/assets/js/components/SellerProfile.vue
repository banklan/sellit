<template>
	<div class="seller_prof">
		<search-pill></search-pill>
		<div class="container">
			<div class="row" style="margin-top: 38px">
				<div class="col-md-8">
					<div class="user_profile">
						<h4 class="text-center">User Profile : {{ profile.name | caps }}</h4>
						<span class="prof_pix center-block text-center">
							<span v-if="profile.picture">
								<img :src="'/images/profile_pix/' + profile.picture" alt="avatar" class="image-responsive prof_pic" />
							</span>
							<span v-else>
								<div class="no_pp center-block">
									<div v-if="owner" class="pic_info">
										<h4 class="text-center">You have not uploaded a profile picture</h4>
									</div>
									<div v-if="!owner" class="pic_info">
										<p class="text-center">{{ profile.name | caps }} have not uploaded a profile picture</p>
									</div>
								</div>
							</span>
						</span>
						
						<div class="biodata">
							<form class="form-horizontal"> 
								<div class="form-group"> 
									<label class="control-label col-md-2">Name: </label>
									<div class="col-md-8">
										<p class="form-control-static">{{ profile.name | caps }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-2">Phone No: </label>
									<div class="col-md-8">
										<p class="form-control-static">{{  profile.phone }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-2">City: </label>
									<div class="col-md-8">
										<p class="form-control-static">{{  profile.city }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-2">About Me: </label>
									<div class="col-md-8">
										<p class="form-control-static">{{ profile.about }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
							</form>
						</div>

						<div class="flag center-block" v-if="!owner">
							<a href="#" @click.prevent="reportSeller"><i class="fa fa-flag"></i> Report this Seller</a>
							<div>
								<modal name="flag" height="auto" :draggable="true" :width="450">
									<div class="modal-header">
										<h4 class="text-center">Report {{ profile.name }} </h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal">
											<div class="form-group">
												<p class="text-center">State why you are reporting {{ profile.name }}</p>
												<div class="col-md-12">
													<textarea class="form-control" rows="2" v-model="report"></textarea>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer modal_btns">
										<button class="btn btn-danger" @click.prevent="">Cancel</button>
										<button class="btn btn-primary" @click.prevent="sendReport">Report Seller</button>
									</div>
								</modal>
								<modal name="redirectToLogin">
									<div class="modal-header">
										<h4 class="text-center">Login to continue </h4>
									</div>
									<div class="modal-body">
										<h4>Please <a href="">login</a> to report a seller</h4>
									</div>
									<div class="modal-footer modal_btns">
										<button class="btn btn-danger" @click.prevent="">Ok</button>
									</div>
								</modal>
							</div>
						</div>
					</div>
					<reports :id="id" :profile="profile"></reports>
				</div>
				<div class="col-md-4">
					<div class="profile_sdbar">
						<div class="users_ad">
							<div v-if="userAds">
								<h4 class="text-center">Recent Ads by {{ profile.name | caps }}</h4>
								<hr> 
								<div v-for="(ad, index) in userAds" :key="index">
									<user-ad v-if="index < 4" :ad="ad"></user-ad>
								</div>
								<router-link :to="{path: '/seller/'+ id  + '/' + nameUrlSlug +'/all_ads'}">
									<h5 class="text-center">View All Ads by {{ profile.name | caps }}</h5>
								</router-link>
							</div>
							<div v-else>
								<h4>You have not posted any ads</h4>
							</div>
							<hr>
							<div v-if="userServices">
								<h4 class="text-center">Recent services Ads by {{ profile.name | caps }}</h4>
								<hr>
								<div class="services_list" v-for="(ad, index) in userServices" :key="ad.id">     
									<router-link v-if="index < 3" :to="{path: '/service_ad/' + ad.id + '/' + ad.slug}"> {{ ad.title }} </router-link> 
									<span v-if="index + 1 != userServices.length"><hr></span>
								</div><hr>
							</div>
							<div v-else>
								<h4>You have not posted any services ads</h4>							
							</div>
						</div>
						<!-- <div class="users_rev">
							<h4 class="text-center">Reviews of Ads by {{ profile.name | caps }}</h4>
							<hr>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
 import Bus from '../bus'

 export default {
 	data(){
 		return {
 			id: this.$route.params.id,
 			profile: {
 				name: '',
 				phone: '',
 				city: '',
 				about: '',
 				picture: ''
 			},
 			userAds: [],
 			nameUrlSlug: '',
            userServices: [],
            owner: false,
            cities: [
            	{
            		id: '',
            		name: ''
            	}
            ],
            auth: false,
            report: ''
 		}
 	},
 	filters: {
 		caps(str){
			let capp = str.toLowerCase().split(' ').map(function(word){
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
            return capp;
        },
        price(val){
            let amt = parseInt(val/100);
            let amount = amt.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits: 2});
            return amount;
        },
        truncate(string, value){
            if(string.length > 20){
               return string.substring(0, value) + " ..."; 
           }else{
                return string;
           }
        }
 	},
 	methods: {
 		goBack(){
 			this.$router.go()
 		},
 		getProfile(){
 			axios.get('/getprofile/' + this.id).then((res) => {
				console.log(res.data)
				this.profile.name = res.data.f_name +' '+ res.data.l_name;
				this.profile.phone = res.data.phone_no;
				this.profile.city = res.data.city.name;
				this.profile.about = res.data.about_me;
				this.profile.picture = res.data.prof_pix;

				this.nameUrlSlug = this.profile.name.toString().toLowerCase()
					.replace(/\s+/g, '-') 
					.replace(/&/g, '-and-') 
					.replace(/[^\w\-]+/g, '')
					.replace(/\-\-+/g, '-') 
					.replace(/^-+/, '')
					.replace(/-+$/, '')
			})
 		},
 		reportSeller(){
 			if(this.auth){
 				this.$modal.show("flag")
 			}else{
 				this.$modal.show("redirectToLogin")
 			}
 			
 		},
 		sendReport(){
 			if(this.report !=''){
 				axios.post('/reportseller/' + this.id, {
 					report: this.report.trim()
 				}).then((res) => {
 					console.log(res.data)
 					if(res.data){
 						this.$toasted.show('Your report has been submitted successfully!',
	                    {
	                      type: 'success'
	                    })

	                    this.$modal.hide("flag")
 					}
 				})
 			}
 		}
 	},
 	mounted(){
		//get profile
		this.getProfile();

		// get all ads by users
		axios.get('/getuserads/' + this.id).then((res) => {
			// console.log(res.data)
			this.userAds = res.data
		})

        //get all services by user
        axios.get('/api/getuserservices/' + this.id).then((res) => {
            //console.log(res.data)
            this.userServices = res.data
        })

        //check if authenticated user has profile
        if(window.Laravel.auth){
        	this.auth = true;
        	let authUser = window.Laravel.user.id
        	if(this.id == authUser){
        		this.owner = true
        	}
        }
 	}
 }  
</script>

<style scoped>
	.user_profile{
		  background: url('/images/bckg/prof4.png');
		  background-size: cover;
		  background-position: center center;
		  background-repeat: no-repeat;
		  margin-top: -25px;
		  padding: 20px;
	}
	.prof_pix{
		margin-bottom: 10px;
		padding: 10px;
	}
	.prof_pic{
		width: 240px;
		border-radius: 50%;
	}
	.biodata{
		margin-top: 13px;
		padding: 10px 10px 20px 50px;
		line-height: 1.7;
		/*text-align: center;*/
	}
	table.users_table{
        table-layout: fixed;
        /* align: center; */
        border: none;
        margin: 0 auto;
    }
    .users_table th{
    	 text-align: center;
    }
    .users_table td{
        white-space: nowrap;
        text-align: left;
    }
    .users_ad{
    	background: #fff;
    	padding: 15px;
    	border-radius: 5px;
    }
    .users_rev{
    	background: #fff;
    	padding: 15px;
    	margin: 25px auto;
    	border-radius:5px;
    }
	.seller_ad p{
		font-size: 14px;
	}   
	.seller_ad p:hover{
		text-decoration: none;
	} 
	.profile_sdbar{
		margin-top: -25px;
	}
	.services_list{
		font-size: 16px;
		padding: 3px;
		line-height: 1.1;
	}
	.editbtn a:hover{
		text-decoration: none;
		color: #b92db9;
		font-weight: 600;
		transition: 0.2s all ease-in-out;
	}
	.form-control-static{
		margin-top: -3px;
	}
	.prof_pic_edt{
		padding: 7px;
	}
	.prof_pic_edt h5{
		font-size: 15px !important;
	}
	.prof_pic_edt a:hover{
		text-decoration: none;
		color: #b92db9;
		font-weight: 600;
		transition: 0.2s all ease-in-out;
		cursor: pointer;
	}
	.no_pp{
		height: 250px;
		width: 300px;
		border-radius: 6px;
		border: 1px solid #d6d6d6;
		background: #d6eef1;
	}
	.pic_info{
		margin-top: 100px;
	}
	.pic_info h4{
		margin: 100px auto;
		color: #e27c0f;
		padding-top: 50px;
	}
	.flag{
		margin: -20px 0 0 65px;
		font-size: 15px;
	}
	.flag a:hover{
		text-decoration: none;
		color: #b92db9;
		font-weight: bold;
		transition:  0.4s all;
	}
	.modal-body p{
		padding: 10px 25px 5px 20px;
	}
	.seller_reports{
		padding: 20px;
		background: #fff;
		margin: 15px auto;
		line-height: 1.8;
		border: 1px solid #f3ebeb;
		border-radius: 6px;
	}
	.seller_reports #reports{
		padding: 20px 10px;
	}

</style>
