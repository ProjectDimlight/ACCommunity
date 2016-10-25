<?php

session_start();
if(!isset($_SESSION['uid']))
    echo("<script> alert('请先登录！'); window.location.href = '/mgzd/login.php'; </script>");
else if($_FILES['file']['type'] != 'image/jpeg' || $_FILES['file']['size'] > 50 * 1024)
    echo("<script type='text/javascript'> alert('仅支持50K以下的JPEG格式图片！'); window.location.href = '/mgzd/headupdate.php'; </script>");
else
{
    move_uploaded_file($_FILES["file"]["tmp_name"],  $_SERVER['DOCUMENT_ROOT'] . "/images/user/" . $_SESSION['uid'] . "/head.jpg");
    echo("<script type='text/javascript'> window.location.href = '/mgzd/user.php'; </script>");
}
?>