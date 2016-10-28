<?php

session_start();
if(!isset($_SESSION['uid']))
{
    echo("<script> alert('请先登录！'); window.location.href = '/mgzd/login.php'; </script>");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
$pdo->query("use projectac;");
$pdo->query("set names 'utf-8';");

$stmt = $pdo->prepare("SELECT uid from file WHERE fid = ?");
$stmt->bindParam(1, $_POST['fid'], PDO::PARAM_INT);
$stmt->execute();

if($_SESSION['uid'] != $row[0])
{
?>

<script type='text/javascript'>
    alert("你只能管理自己的文件哦～")
    window.location.href = '/mgzd/files.php';
</script>

<?php
}
else
{
    $stmt = $pdo->prepare("DELETE FROM file WHERE fid = ?");
    $stmt->bindParam(1, $_POST['fid'], PDO::PARAM_INT);
    $stmt->execute();
    echo("<script type='text/javascript'> alert('删除成功！'); window.location.href = '/mgzd/files.php'; </script>");
}
?>