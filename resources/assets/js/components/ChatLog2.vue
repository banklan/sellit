<template>
    <div class="chat_log">
    	<div v-for="chat in chats" class="chat">
    		<div :class="chat.selfOwned ? 'self' : 'not_self'"> 
				<h5><strong>{{ chat.name }}: </strong><small class="text-muted">{{ chat.time | moment("h:mm A") }}</small></h5>
    	   		<p>{{ chat.message }}</p>
    		</div>
    		<hr/>
	    </div>
    </div>
</template>

<script>
    import Bus from '../bus';
    //var moment = require('Moment');
    import moment from 'vue-moment'

    import io from "socket.io-client";

    export default {
        data(){
            return {
                id: this.$route.params.id,
                //moment: moment,
                messages: [],
                date: new Date,
                day: '',
                time: '',
                chats: [
                	{
                		name: '',
                		message: '',
                		time: '',
                		selfOwned: false
                	}
                ],
                room: ''
            }
        },
        filters: {
            formatTime(x){
                let hour = x.getHours();
                let mins = x.getMinutes();
                var mer;
                if(hour > 11){
                    mer = "PM"
                }else{
                    mer = "AM"
                }
                let time = hour +':'+mins+mer
                return time;
            },
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
                		this.chats.push({
	                    	name: res.data[i].selfOwned ? 'Me' : res.data[i].receiver.Fullname,
	                    	message: res.data[i].message,
	            			time: res.data[i].time,
	            			selfOwned: res.data[i].selfOwned
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
            			//name: msg.data.sender.f_name +' '+ msg.data.sender.l_name,
            			name: msg.data.sender.Fullname,
            			message: msg.data.message,
            			time: msg.data.created_at,
            			selfOwned: false
            		})
            	}
           	});

            Bus.$on('chat-posted', (chat) => {
                this.chats.push({
                	name: 'Me',
                	message: chat.message,
                	time: chat.created_at,
                	selfOwned: true
                })
            })

            //console.log(this.id)
            let today = new Date();
                today = today.getDay();
        }
    }
</script>

<style scoped>
	.chat_log{
		height: 250px;
		max-height: 250px;
		overflow-y: scroll;
		padding: 10px;
	}
    .self{
    	color: #7b0090;
    	
    }
    .chat{
    	padding: 0 7px 0 10px;
    }

</style>