<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost;dbname=projectac;", "access", "");
    $pdo->query("use projectac;");
    $stmt = $pdo->prepare("SELECT uid, password from user where nickname = ?");
    $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();

    $flag = false;
    while($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
    {
        if($row[1] == md5($_POST['password']))
        {
            $flag = true;
            $_SESSION['uid'] = $row[0];
            $_SESSION['username'] = $_POST['username'];
            break;
        }
    }

    if($flag)
    {
        echo("<script type='text/javascript'> window.location.href = '". $_POST['url'] ."' </script>");
    }else
    {
        echo("<script type='text/javascript'> window.location.href = '/mgzd/login.php' </script>");
    }
?>