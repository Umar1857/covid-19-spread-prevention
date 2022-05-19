const express = require('express');
var cors = require('cors')
const socket  = require('socket.io');
const http    = require('http') ;
const app     = express();

const io=socket(server, {
    allowEIO3: true, // false by default
    cors:{
        origins: '*:*'
    }
  });
app.use(cors());

var server = http.createServer(app).listen(4001)
io.attach(server);


io.on('connection',socket=>{
    console.log(socket);
        socket.on('notification',function(data){
            io.emit('notification',data)
        })
})


