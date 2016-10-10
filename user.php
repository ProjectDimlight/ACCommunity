<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>

<?php 
    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
    $pdo->query("use projectac;");
    $stmt = $pdo->prepare("SELECT * from user where uid = ?");
    if(isset($_GET['uid']))
        $stmt->bindParam(1, $_GET['uid'], PDO::PARAM_INT);
    else
        $stmt->bindParam(1, $uid, PDO::PARAM_INT);
    $stmt->execute();

    $flag = false;
    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
    if(!$row)
    {
        echo('<script type="text/javascript">alert("未找到相应数据！");window.location.href="/mgzd/user.php";</script>)');
        exit();
    }
?>

<title><?php echo($row[1]." - ".$title); ?></title>

<div class='title'>
    <h1><?php echo($row[1]); ?></h1>
</div>

<div class='toollabel'>
    
</div>

<div class='main'>
    <div style='float:right; text-indent:0;'>
        <div style='text-align:right; margin-bottom:15px'>
            <?php echo('<img height=150 width=150 src="/images/user/' . $row[0] . '/head.jpg"/>'); ?>
        </div>
        <div>
        <?php
            if(!isset($_GET['uid']) || $_GET['uid'] == $_SESSION['uid'])
                echo("<a href='userupdate.php'><div class='button' style='width:120px;'>修改</div></a>");
        ?>
        </div>
    </div>

    <table>
        <tr>
            <td>
                用户编号
            </td>
            <td>
                <?php echo($row[0]); ?>
            </td>
        </tr>
        <tr>
            <td>
                性别
            </td>
            <td>
                <?php 
                $res = '保密的';
                if($row[10] == 1)
                    $res = '帅哥';
                else if($row[10] == 2)
                    $res = '萌妹';
                else if($row[10] == 3)
                    $res = '可爱的男孩子';
                else if($row[10] == 4)
                    $res = '女汉子';
                else if($row[10] == 5)
                    $res = '秀吉';
                echo($res); 
                ?>
            </td>
        </tr>
        <tr>
            <td>
                经验值
            </td>
            <td>
                <?php echo($row[6]); ?>
            </td>
        </tr>
        <tr>
            <td>
                VIP等级
            </td>
            <td>
                <?php echo($row[5]); ?>
            </td>
        </tr>
        <tr>
            <td>
                OP
            </td>
            <td>
                <?php echo($row[9] ? "是" : "否"); ?>
            </td>
        </tr>
        <tr>
            <td>
                注册时间
            </td>
            <td>
                <?php echo($row[3]); ?>
            </td>
        </tr>
        <tr>
            <td>
                邮箱
            </td>
            <td>
                <?php echo($row[8]); ?>
            </td>
        </tr>
        <tr valign='top'>
            <td>
                格言
            </td>
            <td style="text-indent:0em; padding-left:2em;">
                <div style='white-space:pre-wrap;'><?php echo($row[4]); ?></div>
            </td>
        </tr>
    </table>
</div>

<?php include("includes/modules/footer.php"); ?>
