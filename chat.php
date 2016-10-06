<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title>冥光之都 - 版聊</title>

<?php
if(isset($_SESSION['uid']))
{
    $uid = $_SESSION['uid'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
?>

<?php echo('<script src="http://' . $hostip. ':' . $hostport . '/mgzd/scripts/chat/node_modules/socket.io-client/socket.io.js"></script>'); ?>
<script type="text/javascript">

    var socket;

    function startClient()
    {
        //var socket = new io.Socket('localhost', {port: 8081});
        //socket.connect();
        socket = io("http://" + <?php echo('"'.$hostip.':8081"'); ?>);

        socket.on('connect', 
            function()
            {
                //console.log('Connected to server!');
                socket.emit('login', <?php echo($uid); ?>, <?php echo("'".$password."'"); ?>, <?php echo("'".$username."'"); ?>);
            }
        );

        socket.on('message',
            function(message)
            {
                //console.log(message);
                var div = document.getElementById('showchat');
                div.innerHTML += message;
                div.scrollTop = div.scrollHeight;
            }
        );

        socket.on('disconnect',
            function()
            {
                //console.log('Disconnected!');
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

<div style='width:100%;'>
    <div class='mainchat'>
        <div id='showchat' class='chatbox'><br/></div>
        <textarea class='chatinput' id='chatinput'></textarea>
        <div style='float:right'>
            <a href='#' class='button-green' onclick='clearMessage()'>清空</a>
            <a href='#' class='button' onclick='sendMessage()'>发送</a>
        </div>
    </div>
</div>

<?php
}else
{
?>

<script>
    window.location.href = '/mgzd/login.php?url=' + window.location.href;
</script> 

<?php
}
?>

<?php include("includes/modules/footer.php"); ?>