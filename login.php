<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title>冥光之都 - 登陆</title>

<?php
if(isset($_SESSION['uid']))
{
    $uid = $_SESSION['uid'];
    $username = $_SESSION['username'];
?>
    
<?php
}else
{
?>

<div class='title'>
    <h1>登陆</h1>
</div>

<div class='toollabel'>
    
</div>

<script>
    function check()
    {
        if(document.getElementById('username').value == '' || document.getElementById('password').value == '')
            alert("请完整填写登录信息哦~");
        else
            document.form1.submit.click();
    }
</script>

<div class='mainnoindent' style='width: 350px; margin: 50 auto;'>
    <form action='/mgzd/scripts/server/login.php'  method="post" name='form1'>
        <div style='width: 100%; text-align:center;'>
            <input type='text' id='username' name='username' class='login'/><br/>
            <input type='password' id='password' name='password' class='login'/><br/>
            <input type='text' id='id' name='id' class='login'/><br/>
            <input type="submit" name="submit" value="1" style="display:none"/>
            <?php 
                if(isset($_GET['url']))
                    echo('<input type="text" name="url" value="'. $_GET['url'] .'" style="display:none"/>');
                else
                    echo('<input type="text" name="url" value="/mgzd" style="display:none"/>');
            ?>
            <a href='#' onclick='check();'><div class='button' style='width: 170px; margin-bottom: 10px;'>登陆</div></a>
            <a href='register.php'><div class='button-green' style='width: 170px;'>注册</div></a>
        </div>
    </form>
</div>

<?php
}
?>

<?php include("includes/modules/footer.php"); ?>