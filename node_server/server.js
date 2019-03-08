// var server = require('http').Server();
// var io = require('socket.io')(server);
// var Redis = require('ioredis');
// var redis = new Redis();

// redis.subscribe('chat');

// // io.on('connection', () => {
// // 	console.log('now connected!')
// // });

// io.on('connection', (socket) => {
// 	console.log("user with socket id " + socket.id + " has connected")

// 	redis.on('chat', (channel, message) => {
// 		message = JSON.parse(message)

// 		console.log(message)
// 	})
// })

// redis.on('message', (channel, message) => {
// 	message = JSON.parse(message)
// 	console.log("a message has been sent:" + message)
// 	io.emit(channel + ':' + message.event, message.data)
// });


var server = require('http').Server();
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('chat');

io.on('connection', (socket) => {
	console.log("user " + socket.id + " has connected")

})

redis.on('message', (channel, message) => {
	let parsedMsg = JSON.parse(message)
	console.log(parsedMsg)
	//io.in(message.data.rcv).emit(channel + ':' + message.event, message.data)
	io.emit(channel + ':' + parsedMsg.event, parsedMsg.data, parsedMsg.room)
});

server.listen(8893);