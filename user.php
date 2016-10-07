<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<?php 
    if(isset($_SESSION['uid']))
    {
        $uid = $_SESSION['uid'];
        $username = $_SESSION['username'];
    }

        $pdo = new PDO("mysql:host=localhost;dbname=projectac;", "access", "");
        $pdo->query("use projectac;");
        $stmt = $pdo->prepare("SELECT * from user where uid = ?");
        if(isset($_GET['uid']))
            $stmt->bindParam(1, $_GET['uid'], PDO::PARAM_INT);
        else
            $stmt->bindParam(1, $uid, PDO::PARAM_INT);
        $stmt->execute();

        $flag = false;
        $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
?>

<title><?php echo($row[1]." - ".$title); ?></title>

<div class='title'>
    <h1><?php echo($row[1]); ?></h1>
</div>

<div class='toollabel'>
    
</div>

<div class='main'>
    <div style='float:right'>
        <?php echo('<img height=100 width=100 src="/images/user/' . $row[0] . '/head.jpg"/>'); ?>
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
                上次登录时间
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
        <tr>
            <td>
                格言
            </td>
            <td>
                <?php echo($row[4]); ?>
            </td>
        </tr>
    </table>
</div>

<?php include("includes/modules/footer.php"); ?>