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
var UNAME = new Map();
var PASSWORD = new Map();

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
            function(uid, password, username)
            {
                //console.log(uid + 'joined the chat.');
                var mysql = require("mysql");
                var sql = mysql.createConnection({
                    user: 'access',
                    password: ''
                });
                sql.connect();
                sql.query("use projectac");

                var query = "select password from user where uid = ?";
                var data = [uid];

                sql.query(query, data,
                    function(err, results, fields)   
                    {
                        if(results && password == results[0].password)
                        {
                            UID.set(client, uid);
                            UNAME.set(client, username);
                            PASSWORD.set(client, password);
                            for(var [key, val] of UID.entries())
                            {
                                key.send('<div class="systeminfo">' + username + '加入了。</div>');
                            }
                            return;
                        }
                    }
                );

                sql.end();
            }
        );

        client.on('message', 
            function(password, message)
            {
                if(message == '')
                    return;

                if(!PASSWORD.has(client) || password != PASSWORD.get(client))
                    return;

                var uid = UID.get(client);
                //console.log(uid + ': ' + message);
                for(var [key, val] of UID.entries())
                {
                    if(uid == val)
                        key.send('<div><table width="100%"><tr><td><div class="chattext2">' + htmlspecialchars(message) + '</div></td><td class="uid" valign="top"><img height=30 width=30 src="/images/user/' + uid + '/head.jpg"/></td></tr></table></div>');
                    else
                        key.send('<div><table width="100%"><tr><td class="uid" valign="top"><img height=30 width=30 src="/images/user/' + uid + '/head.jpg"/></td><td><div class="chattext">' + htmlspecialchars(message) + '</div></td></tr></table></div>');
                }
            }
        );

        client.on('disconnect', 
            function()
            {
                //console.log('Client disconnected.');
                if(!PASSWORD.has(client))
                    return;

                var username = UNAME.get(client);
                UID.delete(client);
                UNAME.delete(client);
                PASSWORD.delete(client);
                for(var [key, val] of UID.entries())
                {
                    key.send('<div class="systeminfo">' + username + '离开了。</div>');
                }
            }
        );
    }
);