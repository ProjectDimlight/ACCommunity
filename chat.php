<?php session_start(); $_SESSION["uid"] = rand(); ?>
<?php $uid = $_SESSION['uid']; ?>

<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<script src="http://192.168.1.101:8080/mgzd/scripts/chat/node_modules/socket.io-client/socket.io.js"></script>
<script type="text/javascript">

    var socket;

    function startClient()
    {
        //var socket = new io.Socket('localhost', {port: 8081});
        //socket.connect();
        socket = io("http://192.168.1.101:8081");

        socket.on('connect', 
            function()
            {
                console.log('Connected to server!');
                socket.emit('login', <?php echo($uid); ?> );
            }
        );

        socket.on('message',
            function(message)
            {
                console.log(message);
                var div = document.getElementById('showchat');
                div.innerHTML += message;
                div.scrollTop = div.scrollHeight;
            }
        );

        socket.on('disconnect',
            function()
            {
                console.log('Disconnected!');
            }
        );
    }

    window.onload = startClient;

    function sendMessage()
    {
        var div = document.getElementById('chatinput');
        socket.emit('message', <?php echo($uid); ?>, div.value);
        div.value = ''; 
    }
</script>

<title>冥光之都 - 版聊</title>

<div style='width:100%;'>
    <div class='mainchat'>
        <div id='showchat' class='chatbox'></div>
        <textarea class='chatinput' id='chatinput'></textarea>
        <div style='float:right'>
            <a href='#' class='button' onclick='sendMessage()'>发送</a>
        </div>
    </div>
</div>

<?php include("includes/modules/footer.php"); ?>