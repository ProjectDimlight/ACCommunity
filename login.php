<?php session_start(); ?>

<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title>冥光之都 - 登陆</title>

<?php
if(isset($_SESSION['uid']))
{
    $uid = $_SESSION['uid'];
?>

<?php
}else
{
?>

<div class='title'>
    <h1>冥光之都</h1>
</div>

<div class='toollabel'>
    
</div>

<div class='main'>
    <form action='/mgzd/scripts/server/login.php'  method="post" name='form1'>
        <div style='width: 100%; text-align:center;'>
            <table style='width: 100%;'>
                <tr>
                    <td style='text-align:right; width: 43%;'>
                        用户名
                    </td>
                    <td style='text-align:left'>
                        <input type='text' id='username'/>
                    </td>
                </tr>
                <tr>
                    <td style='text-align:right; width: 43%;'>
                        密码
                    </td>
                    <td style='text-align:left'>
                        <input type='password' id='password'/>
                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="1" style="display:none"/>
            <input type="reset" name="reset" value="2" style="display:none"/>
            <a href='#' class='button' type='submit' onclick='document.form1.submit.click();'>登陆</a>
            <a href='#' class='button-green' type='reset' onclick='document.form1.reset.click();'>重填</a>
        </div>
    </form>
</div>

<?php
}
?>

<?php include("includes/modules/footer.php"); ?>