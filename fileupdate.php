<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>

<?php

$pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
$pdo->query("use projectac;");

if(isset($_GET['fid']))
{
    $stmt = $pdo->prepare("SELECT uid, name, url, introduction, permission, tag FROM file WHERE fid = ?");
    $stmt->bindParam(1, $_GET['fid'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
}
?>

<title>文件更新</title>

<div class='title'>
    <h1>发布文件</h1>
</div>

<div class='toollabel'>
    
</div>

<script type='text/javascript'>
    function check()
    {
        var a = document.getElementById('password').value;
        var b = document.getElementById('check').value;

        if(document.getElementById('name').value == '' || document.getElementById('url').value == '')
            alert("请完整填写上传信息哦~必须的信息：名称、地址～");
        else if(a != b)
            alert("两次密码输入不一致哦，请核对一下吧~");
        else
            document.form1.submit.click();
    }

    function remove()
    {
        if(confirm("确实要删除吗？"))
        {
            document.form2.submit.click();
        }
    }
</script>

<?php if(!isset($_GET['fid']) || $_SESSION['uid'] != $row[0]) { ?>
<script type='text/javascript'>
    alert("你只能管理自己的文件哦～");
    window.location.href = '/mgzd/files.php';
</script>
<?php } ?>
<div class='mainnoindent' style='width: 800px; margin: 50px auto;'>
    <form action='/mgzd/scripts/server/fileupdate.php' method="post" name='form1'>
        <div style='width: 100%; text-align:center;'>
            <?php if(isset($_GET['fid'])){ ?>
            <?php echo("<input type='text' id='fid' name='fid' class='login' style='display:none;' value='".$_GET['fid']."'/>"); ?>
            名称
            <?php echo("<input type='text' id='name' name='name' class='login' value='".$row[1]."'/>"); ?>
            地址
            <?php echo("<input type='text' id='url' name='url' class='login' value='".$row[2]."'/>"); ?>
            密码
            <input type='password' id='password' name='password' class='login'/><br/>
            标签
            <?php echo("<input type='text' id='tag' name='tag' class='login' value='".$row[5]."'/>"); ?>
            权限
            <?php echo("<input type='text' id='permisison' name='permission' class='login' value='".$row[4]."'/>"); ?>
            确认
            <input type='password' id='check' name='check' class='login'/><br/>
            <?php }else{ ?>
            名称
            <?php echo("<input type='text' id='name' name='name' class='login' />"); ?>
            地址
            <?php echo("<input type='text' id='url' name='url' class='login' />"); ?>
            密码
            <input type='password' id='password' name='password' class='login'/><br/>
            标签
            <?php echo("<input type='text' id='tag' name='tag' class='login' />"); ?>
            权限
            <?php echo("<input type='text' id='permisison' name='permission' class='login' />"); ?>
            确认
            <input type='password' id='check' name='check' class='login'/><br/>
            <?php } ?>
            
            <input type="submit" name="submit" value="1" style="display:none"/>
            <div style='text-align:left; margin-left: 40px;'>简介</div>
            <textarea name='introduction' style='width: 730px; height:150px; font-size: 15px;'><?php if(isset($_GET['fid']))echo($row[3]); ?></textarea>
            <div class='instruction'>
                说明：权限为0～99999即下载要求经验值；标签以英文分号‘;’隔开；密码如果不需要请留空。
            </div>
            <a href='#' onclick='check();'><div class='button' style='width: 300px; margin: 20px auto; margin-bottom: 0px;'>发布</div></a>
        </div>
    </form>
    <form action='/mgzd/scripts/server/fileremove.php' method="post" name='form2'>
        <input type="submit" name="submit" value="1" style="display:none"/>
        <a href='#' onclick='remove();'><div class='button-green' style='width: 300px; margin: -10px auto; margin-bottom: 0px;'>删除</div></a>
    </form>
</div>

<?php include("includes/modules/footer.php"); ?>
