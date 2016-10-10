<?php
    session_start();
    echo("<meta charset='utf-8'>");

    if(!isset($_SESSION['uid']))
    {
        echo("<script type='text/javascript'>window.location.href = '/mgzd/login.php?url=' + window.location.href;</script>");
        exit();
    }

    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
    $pdo->query("use projectac;");
    $pdo->query("set names 'utf-8';");

    $stmt = $pdo->prepare("SELECT password from user where uid = ?");
    $stmt->bindParam(1, $_SESSION['uid'], PDO::PARAM_STR);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
    if($row[0] != md5($_POST['password']))
    {
        echo("<script type='text/javascript'>alert('原密码错误！'); window.location.href = '/mgzd'; </script>");
        exit();
    }

    if($_POST['newpswd'] != '')
    {
        $tmp = md5($_POST['newpswd']);
        $stmt = $pdo->prepare("UPDATE user SET nickname = ?, password = ?, sex = ?, motto = ? WHERE uid = ?");
        $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $tmp, PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['sex'], PDO::PARAM_INT);
        $stmt->bindParam(4, $_POST['motto'], PDO::PARAM_STR);
        $stmt->bindParam(5, $_SESSION['uid'], PDO::PARAM_INT);
        $stmt->execute();
    }else
    {
        $stmt = $pdo->prepare("UPDATE user SET nickname = ?, sex = ?, motto = ? WHERE uid = ?");
        $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $_POST['sex'], PDO::PARAM_INT);
        $stmt->bindParam(3, $_POST['motto'], PDO::PARAM_STR);
        $stmt->bindParam(4, $_SESSION['uid'], PDO::PARAM_INT);
        $stmt->execute();
    }
    
    echo("<script type='text/javascript'> window.location.href = 'logout.php'; </script>");
?>
