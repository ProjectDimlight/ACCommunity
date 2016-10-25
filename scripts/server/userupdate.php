<?php
    session_start();
    echo("<meta charset='utf-8'>");

    include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php");

    if(strlen($_POST['username']) > 60 || strlen($_POST['motto']) > 1000)
    {
        echo("<script type='text/javascript'> alert('用户名或格言太长！'); window.location.href = '/mgzd/userupdate.php';</script>");
        exit();
    }

    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
    $pdo->query("use projectac;");
    $pdo->query("set names 'utf-8';");

    $stmt = $pdo->prepare("SELECT password from user where uid = ?");
    $stmt->bindParam(1, $_SESSION['uid'], PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
    if(!isset($_POST['password']) || $row[0] != md5($_POST['password']))
    {
        echo("<script type='text/javascript'>alert('原密码错误！'); window.location.href = '/mgzd'; </script>");
        exit();
    }

    if($_POST['newpswd'] != '')
    {
        $tmp = md5($_POST['newpswd']);
        $tmp2 = htmlspecialchars($_POST['username']);
        $tmp3 = htmlspecialchars($_POST['motto']);
        $stmt = $pdo->prepare("UPDATE user SET nickname = ?, password = ?, sex = ?, motto = ? WHERE uid = ?");
        $stmt->bindParam(1, $tmp2, PDO::PARAM_STR);
        $stmt->bindParam(2, $tmp, PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['sex'], PDO::PARAM_INT);
        $stmt->bindParam(4, $tmp3, PDO::PARAM_STR);
        $stmt->bindParam(5, $_SESSION['uid'], PDO::PARAM_INT);
        $stmt->execute();
    }else
    {
        $tmp2 = htmlspecialchars($_POST['username']);
        $tmp3 = htmlspecialchars($_POST['motto']);
        $stmt = $pdo->prepare("UPDATE user SET nickname = ?, sex = ?, motto = ? WHERE uid = ?");
        $stmt->bindParam(1, $tmp2, PDO::PARAM_STR);
        $stmt->bindParam(2, $_POST['sex'], PDO::PARAM_INT);
        $stmt->bindParam(3, $tmp3, PDO::PARAM_STR);
        $stmt->bindParam(4, $_SESSION['uid'], PDO::PARAM_INT);
        $stmt->execute();
    }
    
    echo("<script type='text/javascript'> window.location.href = 'logout.php'; </script>");
?>
