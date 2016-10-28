<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?></title>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>
<?php
    if(!$_SESSION['isop'])
    {
?>
<script type='text/javascript'>
    alert("只有权限汪才能从这里上传文件哦～")
    window.location.href = '/mgzd/files.php';
</script>
<?php
    }
?>

<div class='title'>
    <h1>上传文件 - OP</h1>
</div>

<div class='toollabel'>
    
</div>

<script type='text/javascript'>
    function check()
    {
        if(document.form1.file.value == '')
        {
            alert("请选择一个文件哦～");
            window.location.href = '/mgzd/fileupdateop.php';
        }else
        {
            document.form1.submit.click();
        }
    }
</script>

<div class='mainnoindent' style='margin: 50 auto; text-align:center; width: 350px;'>
    <form action='/mgzd/scripts/server/fileupdateop.php'  method="post" name='form1' enctype="multipart/form-data">
        <input type="submit" name="submit" value="1" style="display:none"/>
        <input type='file' id='file' name='file' style='width:295px; margin-left:6px; border:1px solid;' onchange='change()'/>
        <br/>
        <a href='#' onclick='check()'><div class='button' style='width:265px;'>上传</div></a>
    </form>
</div>

<?php include("includes/modules/footer.php"); ?>