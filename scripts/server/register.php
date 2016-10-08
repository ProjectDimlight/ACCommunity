<?php include("../../includes/modules/header.php"); ?>
<?php include("../../includes/modules/top.php"); ?>

<title>冥光之都 - 等待注册</title>

<?php
    require_once "emailssl.class.php";

    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8", "access", "");
    $pdo->query("use projectac;");

    $stmt = $pdo->prepare("SELECT uid from user where email = ?");
    $stmt->bindParam(1, $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();

    $flag = false;
    if($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
    {
?>

<script type='text/javascript'>
    alert("这个邮箱已经被使用过了哦，请换一个或者用这个邮箱直接登陆吧~");
    window.location.href = '/mgzd/register.php';
</script>

<?php
    }else
    {
    
        $_SESSION['registercode'] = rand() * 32768 + rand();
        $_SESSION['nickname'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['email'] = $_POST['email'];

        $msg = '请点击<a href="http://' . $hostip . ':' . $hostport . '/mgzd/registermail.php?registercode=' . $_SESSION['registercode'] . '">链接</a>或复制以下内容到地址栏完成注册：<br/>http://' . $hostip . ':' . $hostport . '/mgzd/registermail.php?registercode=' . $_SESSION['registercode'];
        
        $mail = new MySendMail();
        $mail->setServer("smtp.qq.com", "1846326091", "cszvptingdredcfj", 465, true); //设置smtp服务器，到服务器的SSL连接
        $mail->setFrom("1846326091@qq.com"); //设置发件人
        $mail->setReceiver($_POST['email']); //设置收件人，多个收件人，调用多次
        $mail->setMail('注册验证 - ProjectAC::寂月城', $msg);
        $mail->sendMail(); 
    }
?>

<div class='title'>
    <h1>注册 - 等待验证</h1>
</div>

<div class='toollabel'>
    
</div>

<div class='main'>
    请通过邮件中的链接完成验证。
</div>

<?php include("../../includes/modules/footer.php"); ?>
