<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?> - 登陆</title>

<?php
if(isset($_SESSION['uid']))
{
    $uid = $_SESSION['uid'];
    $username = $_SESSION['username'];
?>
    <script type='text/javascript'> window.location.href = '/mgzd/index.php'; </script>
<?php
}else
{
?>

<div class='title'>
    <h1>登陆</h1>
</div>

<div class='toollabel'>
    
</div>

<script type='text/javascript'>
    function check()
    {
        if(document.getElementById('email').value == '' || document.getElementById('password').value == '')
            alert("请完整填写登录信息哦~");
        else
            document.form1.submit.click();
    }
</script>

<div class='mainnoindent' style='width: 350px; margin: 50 auto;'>
    <form action='/mgzd/scripts/server/login.php'  method="post" name='form1'>
        <div style='width: 100%; text-align:center;'>
            邮箱
            <input type='text' id='email' name='email' class='login'/><br/>
            密码
            <input type='password' id='password' name='password' class='login'/><br/>
            验证
            <input type='text' id='id' name='id' class='login' value='请暂时留空'/><br/>
            <input type="submit" name="submit" value="1" style="display:none"/>
            <?php 
                if(isset($_GET['url']))
                    echo('<input type="text" name="url" value="'. $_GET['url'] .'" style="display:none"/>');
                else
                    echo('<input type="text" name="url" value="/mgzd" style="display:none"/>');
            ?>
            <a href='#' onclick='check();'><div class='button' style='width: 200px; margin-bottom: 10px;'>登陆</div></a>
            <a href='register.php'><div class='button-green' style='width: 200px;'>注册</div></a>
        </div>
    </form>
</div>

<?php
}
?>

<?php include("includes/modules/footer.php"); ?>
