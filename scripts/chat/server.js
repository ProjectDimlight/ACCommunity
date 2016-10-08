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
var CLIENT = new Map();

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
                var mysql = require("mysql");
                var sql = mysql.createConnection({
                    user: 'access',
                    password: ''
                });
                sql.connect();
                sql.query("use projectac");

                var query = "select password from user where uid = ?";
                var data = [uid];
                var flag = true;

                sql.query(query, data,
                    function(err, results, fields)   
                    {
                        if(results && password == results[0].password)
                        {
                            if(CLIENT.has(uid))
                            {
                                var c = CLIENT.get(uid);
                                CLIENT.delete(uid);
                                UID.delete(c);
                                UNAME.delete(c);
                                PASSWORD.delete(c);
                            }

                            CLIENT.set(uid, client);
                            UID.set(client, uid);
                            UNAME.set(client, username);
                            PASSWORD.set(client, password);

                            var res = "";

                            UID.forEach(function(val, key, map)
                            {
                                key.send('<div class="systeminfo">' + username + '加入了。</div>');
                                key.emit('login', uid, '<div id="user'+ uid +'"><a href="#" onclick="showUser(' + uid + ')"><div class="chatuser"><img align="middle" height="25" width="25" src="/images/user/' + uid + '/head.jpg"/>' + username + '</div></a></div>');
                                res += '<div id="user'+ val +'"><a href="#" onclick="showUser(' + val + ');"><div class="chatuser"><img align="middle" height="25" width="25" src="/images/user/' + val + '/head.jpg"/>' + UNAME.get(key) + '</div></a></div>';
                            });
                            client.emit('listalluser', res);
                            flag = false;
                        }
                    }
                );
                
                sql.end();
            });

        client.on('message', 
            function(password, message)
            {
                if(message == '')
                    return;

                if(!PASSWORD.has(client) || password != PASSWORD.get(client))
                    return;

                var uid = UID.get(client);
                //console.log(uid + ': ' + message);
                UID.forEach(function(val, key, map)
                {
                    if(uid == val)
                        key.send('<div><table width="100%"><tr><td><div class="chattext2">' + htmlspecialchars(message) + '</div></td><td class="uid" valign="top"><a href="#" onclick="showUser('+ uid +');"><img height=30 width=30 src="/images/user/' + uid + '/head.jpg"/></a></td></tr></table></div>');
                    else
                        key.send('<div><table width="100%"><tr><td class="uid" valign="top"><a href="#" onclick="showUser('+ uid +');"><img height=30 width=30 src="/images/user/' + uid + '/head.jpg"/></a></td><td><div class="chattext">' + htmlspecialchars(message) + '</div></td></tr></table></div>');
                });
            }
        );

        client.on('disconnect', 
            function()
            {
                //console.log('Client disconnected.');
                if(!PASSWORD.has(client))
                    return;

                var username = UNAME.get(client);
                var uid = UID.get(client);
                UID.delete(client);
                UNAME.delete(client);
                PASSWORD.delete(client);
                CLIENT.delete(uid);

                UID.forEach(function(val, key, map)
                {
                    key.send('<div class="systeminfo">' + username + '离开了。</div>');
                    key.emit('logout', uid);
                });
            }
        );
    }
);
