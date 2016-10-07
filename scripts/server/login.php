<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost;dbname=projectac;", "access", "");
    $pdo->query("use projectac;");
    $stmt = $pdo->prepare("SELECT uid, nickname, password from user where email = ?");
    $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();

    $flag = false;
    while($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
    {
        if($row[2] == md5($_POST['password']))
        {
            $flag = true;
            $_SESSION['uid'] = $row[0];
            $_SESSION['username'] = $row[1];
            $_SESSION['password'] = md5($_POST['password']);
            break;
        }
    }

    if($flag)
    {
        echo("<script type='text/javascript'> window.location.href = '". $_POST['url'] ."'; </script>");
    }else
    {
        echo("<script type='text/javascript'> window.location.href = '/mgzd/login.php'; </script>");
    }
?>