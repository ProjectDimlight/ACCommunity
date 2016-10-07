<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?> - 注册</title>

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
    <h1>注册</h1>
</div>

<div class='toollabel'>
    
</div>

<script>
    function check()
    {
        var a = document.getElementById('password').value;
        var b = document.getElementById('repeatpassword').value;
        var c = document.getElementById('email').value;

        if(document.getElementById('username').value == '' || a == '' || b == '' || c == '')
            alert("请完整填写注册信息哦~");
        else if(a != b)
            alert("两次密码输入不一致哦，请核对一下吧~");
        else
            document.form1.submit.click();
    }
</script>

<div class='mainnoindent' style='width: 350px; margin: 50 auto;'>
    <form action='/mgzd/scripts/server/register.php'  method="post" name='form1'>
        <div style='width: 100%; text-align:center;'>
            昵称
            <input type='text' id='username' name='username' class='login'/><br/>
            密码
            <input type='password' id='password' name='password' class='login'/><br/>
            确认
            <input type='password' id='repeatpassword' name='repeatpassword' class='login'/><br/>
            邮箱
            <input type='text' id='email' name='email' class='login'/><br/>
            <input type="submit" name="submit" value="1" style="display:none"/>
            <a href='#' onclick='check();'><div class='button' style='width: 170px; margin-bottom: 10px;'>注册</div></a>
            <a href='login.php'><div class='button-green' style='width: 170px;'>登陆</div></a>
        </div>
    </form>
</div>

<?php
}
?>

<?php include("includes/modules/footer.php"); ?>