var server = require('http').Server();
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('chat');

redis.on('message', (channel, message) => {
	console.log("new connection!")

	message = JSON.parse(message);
});

server.listen(8084);


//this received
var server = require('http').Server();
var io = require('socket.io')(server);
var redis = require('ioredis');
//var redis = new Redis();

server.listen(8893);

//redis.subscribe('chat');

io.on('connection', (socket) => {
	console.log("user " + socket.id + " has connected")
})

var redisClient = redis.createClient();
redisClient.subscribe('message');

redisClient.on('message', (channel, message) => {
	console.log("new message seen :", channel, message)
	io.emit('message', channel, message)
});