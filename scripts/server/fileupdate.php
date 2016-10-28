<?php

session_start();
if(!isset($_SESSION['uid']))
{
    echo("<script> alert('请先登录！'); window.location.href = '/mgzd/login.php'; </script>");
    exit();
}


$pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
$pdo->query("use projectac;");

$stmt = $pdo->prepare("SELECT count(*) FROM file WHERE uid = ? AND type = 0");
$stmt->bindParam(1, $_SESSION['uid'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);

if($_POST['password'] != $_POST['check'])
{
    echo("<script> alert('密码不一致！'); window.location.href = '/mgzd/files.php'; </script>");
    exit();
}else if(strlen($_POST['name']) > 50 || strlen($_POST['tag']) > 50 || strlen($_POST['url']) > 200)
{
    echo("<script> alert('输入信息太长啦～请精简一下吧～'); window.location.href = '/mgzd/files.php'; </script>");
    exit();
}
else if(!isset($_POST['fid']) || $_POST['fid'] == -1)
{
    if($row[0] >= 3)
    {
        echo("<script> alert('已经达到了上限（10个文件）了哦～请删除一些文件！');window.location.href = '/mgzd/files.php'</script> ");
        exit();
    }
    $tmp = $_POST['password'] == '' ? '' : md5($_POST['password']);
    $tmp2 = htmlspecialchars($_POST['name']);
    $tmp3 = htmlspecialchars($_POST['introduction']);
    $tmp4 = htmlspecialchars($_POST['url']);
    $tmp5 = htmlspecialchars($_POST['tag']);
    $tmp6 = $_POST['permission'] ? $_POST['permission'] : 0;

    $stmt = $pdo->prepare("INSERT INTO file (uid, name, type, score, time, introduction, permission, password, level, url, tag) VALUES (?, ?, 0, 50, now(), ?, ?, ?, 0, ? ,?)");
    $stmt->bindParam(1, $_SESSION['uid'], PDO::PARAM_INT);
    $stmt->bindParam(2, $tmp2, PDO::PARAM_STR);
    $stmt->bindParam(3, $tmp3, PDO::PARAM_STR);
    $stmt->bindParam(4, $tmp6, PDO::PARAM_INT);
    $stmt->bindParam(5, $tmp, PDO::PARAM_STR);
    $stmt->bindParam(6, $tmp4, PDO::PARAM_STR);
    $stmt->bindParam(7, $tmp5, PDO::PARAM_STR);
    $stmt->execute();
}else
{       
    $stmt = $pdo->prepare("SELECT uid FROM file WHERE fid = ?");
    $stmt->bindParam(1, $_POST['fid'], PDO::PARAM_INT);
    $stmt->execute();

    if(!($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)))
    {
        echo("<script> alert('未找到该文件！'); window.location.href = '/mgzd/fileupdate.php'; </script>");
        exit(); 
    }else if($row[0] != $_SESSION['uid'])
    {
        echo("<script> alert('只能管理自己的文件哦～'); window.location.href = '/mgzd/fileupdate.php'; </script>");
        exit(); 
    }
    
    $tmp = $_POST['password'] == '' ? '' : md5($_POST['password']);
    $tmp2 = htmlspecialchars($_POST['name']);
    $tmp3 = htmlspecialchars($_POST['introduction']);
    $tmp4 = htmlspecialchars($_POST['url']);
    $tmp5 = htmlspecialchars($_POST['tag']);
    $tmp6 = $_POST['permission'] ? $_POST['permission'] : 0;

    $stmt = $pdo->prepare("UPDATE file SET name = ?, introduction = ?, permission = ?, password = ?, url = ?, tag = ? WHERE fid = ?");
    $stmt->bindParam(1, $tmp2, PDO::PARAM_STR);
    $stmt->bindParam(2, $tmp3, PDO::PARAM_STR);
    $stmt->bindParam(3, $tmp6, PDO::PARAM_INT);
    $stmt->bindParam(4, $tmp, PDO::PARAM_STR);
    $stmt->bindParam(5, $tmp4, PDO::PARAM_STR);
    $stmt->bindParam(6, $tmp5, PDO::PARAM_STR);
    $stmt->bindParam(7, $_POST['fid'], PDO::PARAM_INT);
    $stmt->execute();
}
?>

<script>
    alert("更新成功！");
    window.location.href = '/mgzd/files.php';
</script>