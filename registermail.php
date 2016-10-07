<?php
    session_start();

    if(!isset($_GET['registercode']) || !isset($_SESSION['registercode']) || $_GET['registercode'] != $_SESSION['registercode'])
    {
        $_SESSION['tmp'] = 0;
        session_destroy();
?>

<script type='text/javascript'>
        alert("对不起，验证失败了，请重试一下吧~");
        window.location.href = '/mgzd/register.php';
</script>

<?php
        exit();
    }else
    {
        $tmp = md5($_SESSION['password']);
        $pdo = new PDO("mysql:host=localhost;dbname=projectac;", "access", "");
        $pdo->query("use projectac;");
        $stmt = $pdo->prepare("INSERT INTO user (nickname, password, time, vip, exp, ban, email, op, sex, motto) values (?, ?, now(), 0, 0, 0, ?, 0, 0, '');");
        $stmt->bindParam(1, $_SESSION['nickname'], PDO::PARAM_STR);
        $stmt->bindParam(2, $tmp, PDO::PARAM_STR);
        $stmt->bindParam(3, $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();
        
        $stmt = $pdo->prepare("SELECT uid from user where email = ?");
        $stmt->bindParam(1, $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
        mkdir($_SERVER['DOCUMENT_ROOT'] . "images/user/" . $row[0]);
        copy($_SERVER['DOCUMENT_ROOT'] . "images/system/defaulthead.jpg", $_SERVER['DOCUMENT_ROOT'] . "images/user/" . $row[0] . "/head.jpg");

        session_destroy();
?>
<script type='text/javascript'>
        alert("注册成功！请登录吧~");
        window.location.href = '/mgzd/login.php';
</script>
<?php
        exit();
    }
?>