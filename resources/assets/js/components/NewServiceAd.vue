<template>
	<div class="new_ad row">
		<div class="col-md-10 col-md-offset-1">
			<h4 class="text-center">Create New Service Ad</h4>
			<div class="new_ad_form">
				<form class="form-horizontal" onsubmit="event.preventDefault()">
					<div class="form-group">
						<label class="control-label col-md-2">Service Title</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="title" v-model="newService.title" placeholder="The title of the service or event you are advertising. e.g Drycleaning service" autofocus v-validate.disable="'required|min:5|max:200'">
							<div v-show="errors.has('title')">
                                <span class="help-block alert alert-danger">
                                    {{ errors.first('title') }}
                                </span>
                            </div>
						</div>
						<div style="clear: both"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Service Category</label>
						<div class="col-md-6">
							<select class="form-control" v-model="newService.cat" name="service" v-validate.disable="'required'">
								<option disabled value=""> - Choose a Category -</option>
								<option v-for="service in serviceCats" :value="service.id" :key="service.id">{{ service.category }} </option>
							</select> 
							<div v-show="errors.has('service')">
                                <span class="help-block alert alert-danger">
                                    {{ errors.first('service') }}
                                </span>
                            </div>
						</div>
						<div style="clear: both"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Service Description</label>
						<div class="col-md-8">
							<textarea class="form-control" v-model="newService.descr" rows="2" placeholder="Enter description of service/events one at a time and click the button below after each entry" @keyup.enter="addDet"></textarea>
							<span class="addbtn">
								<button type="button" class="btn btn-primary btn-sm" @click="addDet">+</button>
							</span>
							<div v-if="descrAdded">
								<div class="descr">
									<ul class="">
										<li v-for="(det, index) in description" :key="det.id">{{ det }}<span class="pull-right"><a href="#" @click="delDescr(index)"><i class="fa fa-trash"></i></a></span></li>
									</ul>
								</div>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Price(&#8358;)</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="price" v-model="newService.price" placeholder="The cost of the service/event" @focus="showKobo" v-validate.disable="'required|numeric'">
							<div v-show="errors.has('price')">
                                <span class="help-block alert alert-danger">
                                    {{ errors.first('price') }}
                                </span>
                            </div>
							<transition name="fade">
								<div v-if="showKoboInfo">
									<div class="descr">
										<h5 class="text-info">
											**Price must be entered without spaces and commas.
											Figures entered are treated as Naira. To enter kobo values, immediately after the naira value, type a period(.) and then the kobo value, without spaces. For example, N2200.50
										</h5>
									</div>
								</div>
							</transition>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Upload Pictures</label>
						<div class="col-md-6">
							<input type="file" class="form-control" ref="files" multiple @change="chooseFiles">
							<div v-if="!previewFile" class="file_info">
								<h5 class="text-info">**You can upload a max of 5 pictures per Ad**</h5>
							</div>
							<div v-if="previewFile" class="">
                               <span v-for="(pic, index) in pictures" :key="pic.name">
                                   <h6>{{ pic.name }}
                                   		<span style="float:right"><button type="button" class="btn btn-danger btn-xs" @click.prevent="removePic(index)"> X </button></span>
                                   </h6> 
                               </span>
                            </div>
						</div>
					</div>
					<div class="form-group">
                        <div class="col-md-2 col-md-offset-2">
                            <button type="button" class="btn btn-primary btn-block" @click.prevent="submitAd">Submit</button>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	 export default {
        data(){
            return{
            	newService: {
            		title: '',
            		cat: '',
            		descr: '',
            		price: ''
            	},
            	serviceCats: [],
            	description: [],
            	descrAdded: false,
            	showKoboInfo: false,
            	previewFile: false,
            	pictures: []
            }
        },
        methods: {
        	addDet(){
        		this.descrAdded = true;
        		this.description.push(this.newService.descr);
        		this.newService.descr = '';
        	},
        	showKobo(){
        		this.showKoboInfo = true;
        	},
        	prevPics(){
                for (let i=0; i<this.pictures.length; i++){
                    let reader = new FileReader();

                    reader.readAsDataURL(this.pictures[i]);
                }
            },
        	chooseFiles(e){
        		this.previewFile = true
                let pics = e.target.files
                let vm = this
                for (let i=0; i < pics.length; i++){
                    vm.pictures.push(pics[i]);
                }
                this.prevPics()
        	},
       		ServiceprevPics(){
                for (let i=0; i<this.pictures.length; i++){
                    let reader = new FileReader();

                    reader.readAsDataURL(this.pictures[i]);
                }
            },
            removePic(index){
                this.pictures.splice(index, 1)
            },
            delDescr(index){
            	this.description.splice(index, 1)
            	if(this.description.length == 0){
            		this.descrAdded = false;
            	}
            },
            submitAd(){
            	this.$validator.validateAll().then(() =>{
                    if(!this.errors.any() && this.description !== ''){
                    	 const config = {headers: {
                          'Content-Type' : 'multipart/form-data',
                          }
                        };
                  
                        let vm = this; 

                        let form = new FormData();
                        let title = vm.newService.title.trim();
                        let cat = vm.newService.cat;
                        let price = vm.newService.price.trim();

                        form.append('title', title)
                        form.append('cat', cat)
                        form.append('price', price)

                        for(let i=0; i<vm.description.length; i++){
                            form.append('descr[]', vm.description[i]);
                        }

                        for(let i=0; i<vm.pictures.length; i++){
                            form.append('pics[]', vm.pictures[i]);
                        }

                        axios.post('/post_services', form, config).then((res) => {
                        	if(res.data){
                        		this.$router.push({path: '/services'})
                        		console.log(res.data)
                                vm.$toasted.show('Your service Ad has been posted successfully!',
                                {
                                  type: 'success'
                                })
                        	}
                        })
                    }
                })
            }
        },
        mounted(){
        	//if not logged in, redirect to login
        	// if(!window.Laravel.auth){
        	// 	window.location.href="/login"
        	// }

        	axios.get('/getservicecategories').then((res) => {
            	this.serviceCats = res.data
            	console.log(res.data)
            })
        }
    }

</script>

<style scoped>
	.new_ad_form{
		padding: 15px;
	}
	.new_ad_form textarea{
		margin-bottom: 10px;
	}
	.descr{
		padding: 12px;
		margin-top: 15px;
		background: #f4ddfb;
		border-radius: 6px;
		border: 1px solid #f4ddfb;
	}
	.descr .fa{
		padding-right: 10px;
		color: #F73E61;
	}
	.descr .fa:hover{
		color: #a70da4;
	}
	.descr h5{
		line-height:1.6;
		transition: 0.1s all ease-in;
	}
	.fade-enter-active, .fade-leave-active{
		opacity: 1;
		transition: opacity .5s ease-in-out;
	}
	.fade-enter, .fade-leave-active{
		opacity: 0;
	}
	.file_info{
		background: #f4ddfb;
		padding: 9px;
		margin-top: 15px;
		border: 1px solid #e4e4e4;
		border-radius: 7px;
	}

</style>