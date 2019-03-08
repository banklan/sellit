<template>
    <div class="profile">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
    				<div class="user_profile">
    					<h3 class="text-center">{{ user.Fullname }} Profile Page</h3>
    					<div v-if="user.prof_pix" class="center-block text-center">
							<img :src="'/images/profile_pix/' + user.prof_pix" alt="Profile Picture" class="image-responsive prof_pix" />
							<span v-if="!changePicForm">
								<h5 class="text-center"><a href="" @click.prevent="changePic">Change Profile Picture</a></h5>
							</span>
							<span v-if="changePicForm">
								<div class="upload">
									<input class="center-block text-center" type="file" @change="previewPic" ref="file" accept="image/*" />
									<span v-if="prev" class="preview">
										<img v-bind:ref="'image'" />
										<a href="#" @click.prevent="removePic"><i class="fa fa-trash"></i></a>
										<div class="form-group" style="margin: 10px 27px">
											<div class="col-md-2 col-md-offset-3">
												<button type="button" class="btn btn-primary">Update</button>
											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-danger" @click.prevent="cancelUpdatePic">Cancel</button>
											</div>
											<div style="clear:both"></div>
										</div>
									</span>
									
								</div>
							</span>
    					</div>
    					<div v-else>
    						<div class="no_pp center-block">
								<div class="pic_info">
									<h4 class="text-center">You have not uploaded a profile picture</h4>
								</div>
							</div> 
    					</div>
						<div class="biodata center-block">
							<h4 class="text-center">Biodata</h4>
							<form class="form-horizontal" v-if="!edit"> 
								<div class="form-group"> 
									<label class="control-label col-md-3">FullName: </label>
									<div class="col-md-9">
										<p class="form-control-static">{{ user.Fullname }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3">Phone No: </label>
									<div class="col-md-9">
										<p class="form-control-static">{{  user.phone_no }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3">Address: </label>
									<div class="col-md-9">
										<p class="form-control-static">{{  user.location }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3">City: </label>
									<div class="col-md-9">
										<p class="form-control-static">{{  userCity }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3">About Me: </label>
									<div class="col-md-9">
										<p class="form-control-static">{{ user.about_me }}</p>
									</div>
									<div style="clear:both"></div>
								</div>
								<div class="editbtn"> 
									<p class="text-center"><a href="#" @click.prevent="openEdit">Edit Profile</a></p>
								</div>
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
											<option value="" style="font-weight: bold">{{ userCity }}</option><hr>
											<option v-for="city in cities" :value="city.id" :key="city.id">{{ city.name }}</option>
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
										<button class="btn btn-danger" type="button" @click.prevent="cancelUpdate">Cancel</button>
									</div>
								</div>
							</form>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</template>

<script>
	export default{
		data(){
			return {
				user: [],
				profPix: false,
				changePicForm: false,
				prev: false,
				profilePix: '',
				edit: false,
				userCity: '',
				update: {
					f_name: '',
					l_name: '',
					phone: '',
					location: '',
					city: '',
					about: ''
				},
				cities: []
			}
		},
		computed:{

		},
		methods: {
			changePic(){
				this.changePicForm = true
			},
			previewPic(e){
				this.prev = true;
                this.profilePix = e.target.files[0];

                let reader = new FileReader();

                if(this.profilePix !== ''){
                    reader.addEventListener('load', function(){
                    this.$refs['image'].src = reader.result;
                    }.bind(this), false);
                   
                   reader.readAsDataURL(this.profilePix); 
                }
			},
			removePic(){
				this.prev = false;
				this.profilePix = '';
			},
			cancelUpdatePic(){
				this.changePicForm = false;
				this.profilePix = '';
				this.removePic();
			},
			openEdit(){
				this.edit = true;

				//get city
	 			axios.get('/getcities').then((res) => {
	 				this.cities = res.data
	 			})

				this.update.f_name = this.user.f_name
				this.update.l_name = this.user.l_name
				this.update.phone = this.user.phone_no
				this.update.location = this.user.location
				this.update.about = this.user.about_me
				this.update.city = this.user.city.id
			},
			getProfile(){
				axios.get('/getprofile/' + this.user.id).then((res) => {
					console.log(res.data)
					this.user = res.data
					this.userCity = res.data.city.name
				});
			},
			updateProfile(){
				axios.patch('/updateprofile/' + this.user.id, this.update).then((res) => {
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

			}
		},
		mounted(){
			//check if authenticated and get the auth user
	        if(window.Laravel.auth){
	        	let authUser = window.Laravel.user
	        	this.user = authUser
	        	this.userCity = authUser.city.name
	        	console.log(authUser)
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
	.user_profile h3{
		font-size: 22px;
		font-weight: 500;
		padding-bottom: 10px;
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
	.prof_pix{
		height: 300px;
		border-radius: 6px;
		border:1px solid #d4d4d4;
	}
	.user_profile h5 a{
		font-size: 14px;
	}
	.user_profile a:hover{
		text-decoration: none;
		color: #b92db9;
		font-weight: 600;
		transition: 0.4s linear all;
	}
	.upload{
		 margin-top: 8px;
		 margin-left: 50px;
	}
	.upload input{
		margin-bottom: 10px;
	}
	.preview{
		margin-left: -120px;
		margin-top: 30px;
	}
	.preview img{
		height:40px;
		width:40px;
		border-radius:6px;
	}
	.preview .fa{
		font-size: 20px;
	    color: #d03939;
	    padding-left: 80px;
	}
	.biodata{
		margin: 20px 50px 20px 70px;
	}
	.form-horizontal{
		transition: 0.5s ease-in-out;
	}

</style>
