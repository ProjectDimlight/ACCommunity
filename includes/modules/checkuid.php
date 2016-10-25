<?php
    if(!isset($_SESSION['uid']))
    {
        echo("<script>window.location.href = '/mgzd/login.php?url=' + window.location.href;</script>");
        exit();
    }

    $uid = $_SESSION['uid'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
?>