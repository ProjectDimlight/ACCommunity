<?php

session_start();
if(!isset($_SESSION['uid']))
    echo("<script> alert('请先登录！'); window.location.href = '/mgzd/login.php'; </script>");
else if(!$_SESSION['isop'])
    {
?>

<script type='text/javascript'>
    alert("只有权限汪才能从这里上传文件哦～")
    window.location.href = '/mgzd/files.php';
</script>

<?php
    }
else
{
    move_uploaded_file($_FILES["file"]["tmp_name"],  $_SERVER['DOCUMENT_ROOT'] . "/files/tmp/" . $_FILES["file"]["name"]);
    echo("<script type='text/javascript'> window.location.href = '/mgzd/files.php'; </script>");
}
?>