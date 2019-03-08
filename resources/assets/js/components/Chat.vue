<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="chat">
                   <h4 class="text-center"><span class="back"><a href="#" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i></a></span>Chat  with {{ receiver }} </h4> 
                   <div class="msgs">
                        <chat-log></chat-log>
                        <div class="msg_form">
                           <textarea class="form-control" v-model="msg" @keyup.enter="PostMessg" placeholder="Type here..."></textarea>
                           <button type="button" class="btn btn-primary" @click="PostMessg">Send</button>
                        </div>
                   </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</template>

<script>
    import Bus from '../bus'
    //var moment = require('Moment');

    export default {
        data(){
            return {
                id: this.$route.params.id,
                receiver: '',
                msg: '',
                me: 'Steve',
            }
        },
        methods: {
            buildtempMess(){
                let tempId = Date.now();

                return {
                    id: tempId,
                    receiver_id: this.id,
                    message: this.msg.trim(),
                    sender_name: "Me",
                    selfOwned: true,
                    postedToday: true,
                    posted: "Today",
                    time: this.$moment().format('h:mm A')
                }
            },
            PostMessg(){
                //post it, if fails remove from log
                if(this.msg.trim() != ''){
                    axios.post('/api/postmsg/' + this.id, {
                        body: this.msg.trim(),
                        receiver: this.id
                    })
                    .then((res) => {
                       console.log(res.data) 
                    })

                    let tempMess = this.buildtempMess()
                    Bus.$emit('chat-posted', tempMess)
                }

                this.msg = '';
            }
        },
        beforeRouteEnter(to, from, next){
			if(!window.Laravel.auth){
				window.location.href="/login"
			}
			next()
		},
        mounted(){
            //check if signed in
            // if(!window.Laravel.user){
            //     this.$router.push({path: '/login'})
            // }

            // get user
            axios.get('/getuser/' + this.id).then((res) => {
                //console.log(res.data)
                let f_name = res.data.f_name.charAt(0).toUpperCase() + res.data.f_name.slice(1)
                let l_name = res.data.l_name.charAt(0).toUpperCase() + res.data.l_name.slice(1)
                this.receiver = f_name + ' ' + l_name
            })

            let user = window.Laravel.user;

            if (this.id == user.id){
                 // vm.$toasted.show('You cannot chat with yourself!',
                 //    {
                 //      type: 'info'
                 //    })
                this.$router.push({path: '/'});
            }
        }
    }
</script>

<style scoped>
    .chat{
        background: #fff;
        padding: 5px;
        border: 2px solid #cecece;
        border-radius: 6px;
        box-shadow: 1px 5px 10px 5px rgba(191, 177, 191, 0.92);
    }
    .msg_form{
        margin: 0 0 20px 15px;
    }
    .msg_form button{
        margin-top: 7px;
    }
    .chat .back{
        float:left;
        padding-left:12px;
    }
    .back a{
        color: #b92db9;
    }
</style>