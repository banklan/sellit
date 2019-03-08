<template>
    <div class="container">
        <div class="row">
        	<div class="col-md-8">
        		<div class="user_profile">
        			<a href="#" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
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
					<span v-if="owner">
						<span v-if="!picEdit" class="prof_pic_edt center-block text-center"> 
							<h5><a hef="#" @click.prevent="replacePic">Update Profile Picture</a></h5>
						</span>
						<span v-if="picEdit"> 
							<prof-pic></prof-pic>
						</span>
					</span>
					
					<div class="biodata">
						<form class="form-horizontal" v-if="!edit"> 
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
							<span v-if="owner">
								<div v-if="!edit" class="editbtn"> 
									<p class="text-center"><a href="#" @click.prevent="openEdit">Edit Profile</a></p>
								</div>
							</span>	
						</form>
						
						<form class="form-horizontal" v-if="edit"> 
							<div class="form-group"> 
								<label class="control-label col-md-2">First Name: </label>
								<div class="col-md-8">
									<input type="text" class="form-control" v-model="update.f_name">
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group"> 
								<label class="control-label col-md-2">Last Name: </label>
								<div class="col-md-8">
									<input type="text" class="form-control" v-model="update.l_name">
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group"> 
								<label class="control-label col-md-2">Phone No: </label>
								<div class="col-md-8">
									<input type="text" class="form-control" v-model="update.phone">
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group"> 
								<label class="control-label col-md-2">Address: </label>
								<div class="col-md-8">
									<input type="text" class="form-control" v-model="update.location">
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group"> 
								<label class="control-label col-md-2">City: </label>
								<div class="col-md-8">
									<select class="form-control" v-model="update.city"> 
										<option value="" style="font-weight: bold">{{ profile.city }}</option>
										<option v-for="city in cities" :value="city.id">{{ city.name }}</option>
									</select>
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group"> 
								<label class="control-label col-md-2">About Me: </label>
								<div class="col-md-8">
									<textarea class="form-control" rows="3" v-model="update.about" />
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form-group" style="margin-top:20px"> 
								<div class="col-md-2 col-md-offset-4"> 
									<button class="btn btn-primary" type="button" @click.prevent="updateProfile">Update</button>
								</div>
								<div class="col-md-2"> 
									<button class="btn btn-danger" type="button" @click="cancelUpdate">Cancel</button>
								</div>
							</div>
						</form>
					</div>
        		</div>
        	</div>
        	<div class="col-md-4">
        		<div class="profile_sdbar">
        			<div class="users_ad">
                        <div v-if="userAds">
            				<h4 class="text-center">Recent Ads by {{ profile.name | caps }}</h4>
            				<hr>
            				<div v-for="(ad, index) in userAds">
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
                            <div class="services_list" v-for="(ad, index) in userServices">     
                                <router-link v-if="index < 3" :to="{path: '/service_ad/' + ad.id + '/' + ad.slug}"> {{ ad.title }} </router-link> 
                                <span v-if="index + 1 != userServices.length"><hr></span>
                            </div><hr>
                        </div>
                        <div v-else>
                        	<h4>You have not posted any services ads</h4>							
                        </div>
        			</div>
        			<div class="users_rev">
        				<h4 class="text-center">Reviews of Ads by {{ profile.name | caps }}</h4>
        				<hr>
        				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
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
            edit: false,
            update: {
            	f_name: '',
            	l_name: '',
            	phone: '',
            	location: '',
            	city: '',
            	about: ''
            },
            cities: [
            	{
            		id: '',
            		name: ''
            	}
            ],
            picEdit: false
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
 		openEdit(){
 			this.edit = true;
 			//get profile
 			axios.get('/getprofile/' + this.id).then((res) => {
 				this.update.f_name = res.data.f_name
 				this.update.l_name = res.data.l_name
 				this.update.phone = res.data.phone_no
 				this.update.location = res.data.location
 				this.update.city = res.data.city_id
 				this.update.about = res.data.about_me
 			})
 			//get city
 			axios.get('/getcities').then((res) => {
 				this.cities = res.data
 				//this.city.name = res.data.name
 			})
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
 		updateProfile(){
 			axios.patch('/updateprofile/' + this.id, this.update).then((res) => {
 				if(res.data){
 					this.edit = false;
 					this.getProfile();
 					this.$toasted.show('Your profile has been updated successfully!',
                    {
                      type: 'success'
                    })
 				}
 			})
 		},
 		cancelUpdate(){
 			this.edit = false
 		},
 		replacePic(){
 			this.picEdit = true
 		},
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
        	let authUser = window.Laravel.user.id
        	if(this.id == authUser){
        		this.owner = true
        	}
        }

        Bus.$on('cancel-update', ()=>{
        	this.picEdit = false;
        	this.profPix = ''
        })

        Bus.$on('pic-updated', (pic)=> {
        	this.profile.picture = pic
        	this.$toasted.show('Your profile picture has been updated successfully!',
                {
                  type: 'success'
                })
        })
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
		margin-top: -23px;
		padding: 10px 10px 20px 50px;
		line-height: 1.7;
		/*text-align: center;*/
	}
	table.users_table{
        table-layout: fixed;
        align: center;
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
	.pic_info h4{
		margin: 100px auto;
		color: #e27c0f;
	}
</style>
