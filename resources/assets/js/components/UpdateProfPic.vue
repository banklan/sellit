<template>
    <div class="edit-profile" style="margin: 25px" v-if="pixEdit">
    	<div class="form-group"> 
    		<div class="col-md-6 col-md-offset-3"> 
				<input type="file" class="form-control" @change="previewPic" ref="file" accept="image/*" />
    		</div>
    		<div style="clear:both"></div>
    	</div>
    	<div class="form-group">
    		<div class="col-md-6 col-md-offset-3"> 
		    	<span v-if="prev" class="preview"> 
		    		<img v-bind:ref="'image'" style="" />
		            <a href="#" @click.prevent="removePic"><i class="fa fa-trash"></i></a>
		    	</span>
		    </div>
	    </div>
	    <div class="form-group picEditBtn"> 
			<div class="col-md-2 col-md-offset-3"> 
				<button class="btn btn-primary" type="button" @click.prevent="updatePix">Update</button>
			</div>
			<div class="col-md-2"> 
				<button class="btn btn-danger" type="button" @click="cancelPixUpdt">Cancel</button>
			</div>
			<div style="clear:both"></div>
		</div>
    </div>
</template>

<script>
	import Bus from '../bus'

    export default {
    	props: ['profile'],
    	data(){
    		return {
    			profPix: '',
    			prev: false,
    			pixEdit: true
    		}
    	},
    	methods: {
    		uploadPix(e){
    			this.profPix = e.target.files[0]
    			this.previewPic()
    		},
    		previewPic(e){
                this.prev = true;
                this.profPix = e.target.files[0];

                let reader = new FileReader();

                if(this.profPix !== ''){
                    reader.addEventListener('load', function(){
                    this.$refs['image'].src = reader.result;
                    }.bind(this), false);
                   
                   reader.readAsDataURL(this.profPix); 
                }
                //console.log(this.profPix)
            },
            removePic(){
            	this.prev = false;
            	this.profPix = ''
            },
            updatePix(){
                if(this.profPix !== ''){
                    const config = {headers: {
                      'Content-Type' : 'multipart/form-data',
                      }
                    };

                    var pix = this.profPix;
                    let form = new FormData();
                    form.append('picture', pix);
                    let vm = this
                    axios.post('/updateprofilepix', form, config).then((res) => {
                        vm.cancelPixUpdt()
                        vm.prev = false;
                        vm.profPix = ''
                        
                        //emit an event to the parent component that the profile pic has been changed
                        Bus.$emit('pic-updated', res.data)
                        // vm.profile.prof_pix = res.data.prof_pix
                        // vm.$toasted.show('Your profile picture has been updated successfully!',
                        // {
                        //   type: 'success'
                        // })
                        
                    })
                }
            },
            cancelPixUpdt(){
            	Bus.$emit('cancel-update')
            }
    	},
    	mounted(){
    		
    	}
        
    }
</script>

<style scoped>
	.preview img{
		height:40px;
		width:40px;
		border-radius:6px;
		margin-bottom: 7px;
		margin-top:-5px;
	}
	.preview .fa{
		font-size: 20px;
	    color: #d03939;
	    padding-left: 64px;
	}
	.preview .fa:hover{
		color: #b92db9;
	}
	.picEditBtn{
		padding: 7px;
	}

</style>
