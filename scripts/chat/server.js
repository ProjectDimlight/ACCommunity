function htmlspecialchars(str)
{            
    str = str.replace(/&/g, '&amp;');  
    str = str.replace(/</g, '&lt;');  
    str = str.replace(/>/g, '&gt;');  
    str = str.replace(/"/g, '&quot;');  
    str = str.replace(/'/g, '&#039;');  
    return str;  
}  

var UID = new Map();

var http = require('http');
var io = require('socket.io');

var server = http.createServer(
    function(req, res)
    {
        res.writeHead(200, {'Content-type' : 'text/html'});
        res.end();
    }
);
server.listen(8081);

var socket = io.listen(server);
socket.on('connection', 
    function(client)
    {
        client.on('login', 
            function(uid)
            {
                //console.log(uid + 'joined the chat.');
                UID.set(client, uid);
                for(var [key, val] of UID.entries())
                {
                    key.send('<div class="systeminfo">用户' + uid + '加入了。</div>');
                }
            }
        );

        client.on('message', 
            function(uid, message)
            {
                //console.log(uid + ': ' + message);
                for(var [key, val] of UID.entries())
                {
                    if(uid == val)
                        key.send('<div><table width="100%"><tr><td><div class="chattext2">' + htmlspecialchars(message) + '</div></td><td class="uid">' + uid + '</td></tr></table></div>');
                    else
                        key.send('<div><table width="100%"><tr><td class="uid">' + uid + '</td><td><div class="chattext">' + htmlspecialchars(message) + '</div></td></tr></table></div>');
                }
            }
        );

        client.on('disconnect', 
            function()
            {
                //console.log('Client disconnected.');
                var uid = UID.get(client);
                UID.delete(client);
                for(var [key, val] of UID.entries())
                {
                    key.send('<div class="systeminfo">用户' + uid + '离开了。</div>');
                }
            }
        );
    }
);