<script type='text/javascript'>
    function mOver(id)
    {
        document.getElementById(id).style.background = 'rgba(255,255,255,0.3)';
    }

    function mOut(id)
    {
        document.getElementById(id).style.background = 'rgba(255,255,255,0)';
    }
</script>

<div class='top'>
    <a href='#'><div class='topbox' id='hb0' onMouseOver='mOver("hb0")' onMouseOut='mOut("hb0")' style='float:right'>
        用户
    </div></a>
    <a href='/mgzd/index.php'><div class='topbox' id='hb1' onMouseOver='mOver("hb1")' onMouseOut='mOut("hb1")' style='width:150px; color: rgb(0, 200, 255);'>
        冥光之都
    </div></a>
    <a href='#'><div class='topbox' id='hb2' onMouseOver='mOver("hb2")' onMouseOut='mOut("hb2")'>
        论坛
    </div></a>
    <a href='/mgzd/files.php'><div class='topbox' id='hb3' onMouseOver='mOver("hb3")' onMouseOut='mOut("hb3")'>
        资料
    </div></a>
    <a href='/mgzd/chat.php'><div class='topbox' id='hb4' onMouseOver='mOver("hb4")' onMouseOut='mOut("hb4")'>
        版聊
    </div></a>
</div>

<div style='height:50px;'>
</div>