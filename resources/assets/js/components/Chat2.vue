<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="chat">
                   <h4 class="text-center">Chat  with {{ name }} </h4> 
                   <div class="msgs">
                       <div class="msg_form">
                           <textarea class="form-control" v-model="msg" @keyup.enter="PostMessg" placeholder="Type here..."></textarea>
                           <button type="button" class="btn btn-primary" @click="PostMessg">Send</button>
                       </div>
                       <chat-log></chat-log>
                   </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</template>

<script>
    import Bus from '../bus'
    var moment = require('Moment');

    export default {
        data(){
            return {
                id: this.$route.params.id,
                name: '',
                msg: '',
                me: 'Steve',
                moment: moment
            }
        },
        methods: {
            PostMessg(){
                //post it, if fails remove from log
                if(this.msg.trim() != ''){
                    axios.post('/postmsg/' + this.id, {
                        body: this.msg.trim(),
                        receiver: this.id
                    })
                    .then((res) => {
                       // console.log(res.data) 
                    })

                    Bus.$emit('chat-posted', {
                        body: this.msg.trim(),
                        time: new Date(),
                        // time: this.moment().format("MMM Do YYYY - HH:mm A"),
                        me: this.me,
                        rx: this.id
                    })
                }

                this.msg = '';
            }
        },
        sockets:{
            message(data){
                let mess = JSON.parse(data)
                console.log("message from socket.io "+ mess)
            }
        },
        mounted(){
            let socket = io('http://localhost:8893');
            //check if signed in
            if(!window.Laravel.user){
                this.$router.push({path: '/login'})
            }
            // get user
            axios.get('/getuser/' + this.id).then((res) => {
                console.log(res.data)
                let f_name = res.data.f_name.charAt(0).toUpperCase() + res.data.f_name.slice(1)
                let l_name = res.data.l_name.charAt(0).toUpperCase() + res.data.l_name.slice(1)
                this.name = f_name + ' ' + l_name
            })

            let user = window.Laravel.user;
            // this.me = user;
            console.log(user)
        }
    }
</script>

<style scoped>
    .chat{
        background: #fff;
        padding: 15px;
    }
    .msg_form{
        margin-bottom: 20px;
    }
    .msg_form button{
        margin-top: 7px;
    }
    .msgs{
        height: 500px;
        overflow: scroll;
        padding: 15px 20px;
    }
</style>