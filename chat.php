<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?>  - 版聊</title>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>

<?php echo('<script src="http://' . $hostip. ':' . $hostport . '/mgzd/scripts/chat/node_modules/socket.io-client/socket.io.js"></script>'); ?>
<script type="text/javascript">

    var socket;

    function showUser(uid)
    {
        window.location.href = "user.php?uid=" + uid;
    }

    function startClient()
    {
        //var socket = new io.Socket('localhost', {port: 8081});
        //socket.connect();
        socket = io("http://" + <?php echo('"'.$hostip.':8081"'); ?>);

        socket.on('connect', 
            function()
            {
                socket.emit('login', <?php echo($uid); ?>, <?php echo("'".$password."'"); ?>, <?php echo("'".$username."'"); ?>);
            }
        );

        socket.on('listalluser', 
            function(message)
            {
                var div = document.getElementById('showuser');
                div.innerHTML = message;
            }
        );

        socket.on('login', 
            function(uid, message)
            {
                if(!document.getElementById('user' + uid))
                {
                    var div = document.getElementById('showuser');
                    div.innerHTML += message;
                }
            }
        );

        socket.on('logout', 
            function(uid)
            {
                var div;
                while(div = document.getElementById('user' + uid))
                    div.parentNode.removeChild(div);
            }
        );

        socket.on('message',
            function(message)
            {
                var div = document.getElementById('showchat');
                div.innerHTML += message;
                div.scrollTop = div.scrollHeight;
            }
        );

        socket.on('disconnect',
            function()
            {
            }
        );
    }

    window.onload = startClient;
    
    function sendMessage()
    {
        var div = document.getElementById('chatinput');
        if(div.value != "")
        {
            socket.emit('message', <?php echo("'".$password."'"); ?>, div.value);
            div.value = '';
        }else
        {
            alert("请不要发送空信息哦~");
        } 
    }

    function clearMessage()
    {
        var div = document.getElementById('chatinput');
        div.value = ''; 
    }

    function hotKeys(event)
    {
        if(event.ctrlKey && event.keyCode == 8)
        {
            clearMessage();
        }
        if(event.ctrlKey && event.keyCode == 13)
        {
            sendMessage();
        }
    }

    document.onkeydown = hotKeys;

</script>

<div style='width: 95%; margin: 40px auto;'>
    <div class='mainchat'>
        <table style='width:100%'><tr>
            <td style='width:auto;'>
                <div id='showchat' class='chatbox'><br/></div>
                <textarea class='chatinput' id='chatinput'></textarea>
            </td>
            <td style='width:180px; border:0px; background-color: rgb(100, 120, 135); overflow: scroll;' valign="top">
                <div id='showuser' style='margin: 0px; padding: 0px;'>
                    
                </div>
            </td>
        </tr></table>
        
        <div style='float:right'>
            <a href='#' onclick='clearMessage()'><font class='button-green' >清空</font></a>
            <a href='#' onclick='sendMessage()'><font class='button' >发送</font></a>
        </div>
    </div>
</div>

<?php include("includes/modules/footer.php"); ?>
