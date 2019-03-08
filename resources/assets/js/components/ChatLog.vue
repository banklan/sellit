<template>
    <div class="chat_log" v-chat-scroll="{always: false, smooth: true}">
    	<div v-for="(chat, index) in chats" class="chat">
    		<div :class="chat.selfOwned ? 'self' : 'not_self'"> 
				<h5><strong>{{ chat.name }} </strong><small class="text-muted">{{ chat.postedToday ? chat.time : chat.posted | moment("ddd, Do MMM h:mm A") }}</small></h5>
    	   		<p>{{ chat.message }}</p>
    		</div>
    		<span v-if="index != chats.length - 1">
    			<hr/>
    		</span>
    	</div>
    </div>
</template>

<script>
    import Bus from '../bus';
    //var momen = require('moment');

    import io from "socket.io-client";

    export default {
        data(){
            return {
                id: this.$route.params.id,
                messages: [],
                date: new Date,
                day: '',
                time: '',
                chats: [
                	{
                		name: '',
                		message: '',
                		time: '',
                		selfOwned: false,
                		day: '',
                		postedToday: '',
                		posted: ''
                	}
                ],
                room: ''
            }
        },
        filters: {
            formatDate(x){
                return x.toLocaleDateString();
            },
            caps(str){
				let capp = str.toLowerCase().split(' ').map(function(word){
	                return (word.charAt(0).toUpperCase() + word.slice(1));
	            }).join(' ');
	            return capp;
	        }
        },
        methods: {
            fetchChats(){
                axios.get('/fetchchats/' + this.id).then((res) => {
                	console.log(res.data)
                	for(var i=0; i<res.data.length; i++){
                // 		let today = this.$moment().format('YYYY-MM-DD');
                // 		let yesterday = this.$moment().subtract(1, 'day').format('YYYY-MM-DD');
                // 		let posted = this.$moment(res.data[i].created_at).format('YYYY-MM-DD')

                		this.chats.push({
	                    	name: res.data[i].selfOwned ? 'Me' : res.data[i].receiver.Fullname,
	                    	message: res.data[i].message,
	            			time: res.data[i].time,
	            			selfOwned: res.data[i].selfOwned,
	            			postedToday: res.data[i].postedToday,
	            			posted: res.data[i].created_at
	                    })
                	}
                })
            },
            getRoom(){
            	let myId = window.Laravel.user.id
	        	let recId = parseInt(this.id)
	        	let ids = [myId, recId]
	        	let max = Math.max.apply(null, ids)
	        	let min = Math.min.apply(null, ids)
	        	this.room = min + '-' + max;
            },
        },
        mounted(){
        	this.getRoom();

        	this.fetchChats();

        	let socket = io('http://localhost:8893');

            socket.on('chat:App\\Events\\NewChatPosted', msg =>{
            	if(this.room == msg.room && msg.data.sender_id !== window.Laravel.user.id){
            		this.chats.push({
            			name: msg.data.sender.Fullname,
            			message: msg.data.message,
            			time: msg.data.time,
            			selfOwned: false,
            			postedToday: msg.data.postedToday,
	            		posted: msg.data.created_at
            		})
            	}
           	});

            Bus.$on('chat-posted', (chat) => {
            	//console.log("from events: " + chat)
                this.chats.push({
                	name: 'Me',
                	message: chat.message,
                	time: chat.time,
                	selfOwned: true,
                	postedToday: true,
                	posted: chat.posted
                })
            })
        }
    }
</script>

<style scoped>
	.chat_log{
		height: 250px;
		max-height: 250px;
		overflow-y: scroll;
		padding: 10px;
		/*background: #fff;
        border: 12px solid #cecece;
        border-radius: 6px;*/
	}
    .self{
    	color: #7b0090;
    }
    .chat{
    	padding: 0 7px 0 13px;
    }
    .chat .text-muted{
    	padding-left: 4px;
    	font-style:italic;
    }

</style>