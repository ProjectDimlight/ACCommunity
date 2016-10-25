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

<div class='mainnoindent' style='width: 650px; height:500px; margin: 50 auto;'>
    <div style='float:right; text-indent:0;'>
        
    </div>

    <div style='float:left; padding-bottom:20px; width:100%;'>
        <?php echo('<div style="float:left; padding-left: 50px;"><img class="headbig" src="/images/user/' . $row[0] . '/head.jpg"/></div>'); ?>

        <div style="float:left; padding-left: 70px; padding-top:15px;">
        <font style="font-weight:bold; font-size: 30px;">
        <?php 
            $res = '';
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
            echo($res . ' ' . $row[1]);
        ?>
        </font>
        <?php
            echo("<div style='line-height:20px'><br/>");
            echo('等级 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/greenbar.png"  width="'.($row[6] * 299 / 99999 + 1).'px" height="11px" /></div><br/>');
            echo('特权 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/orangebar.png" width="'.($row[5] * 299 / 13 + 1).'px" height="11px" /></div><br/>');
            echo('信用 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/purplebar.png" width="300px" height="11px" /></div><br/>');
            echo("</div>");
        ?>
        </div>
    </div>
    <div style='float:left width:100%;'>
        <div class='block' style='float:left'>用户ID<br/>#<?php echo($row[0]); ?></div>
        <div class='block' style='float:left'>电子邮箱<br/><?php echo($row[8]); ?></div>
        <div class='block' style='float:left'>注册时间<br/><?php echo($row[3]); ?></div>
    </div>

    <div style='float: left; width: 577px; height: 175px; line-height: 23px; overflow-y: scroll; border: 1px solid rgb(150, 150, 150); margin: 5px; padding: 30px; text-indent: 0em; white-space:pre-wrap;'><?php echo($row[4]); ?></div>

    <div style='float:left; width:100%; margin-top:20px;'>
        <?php
            if(!isset($_GET['uid']) || $_GET['uid'] == $_SESSION['uid'])
                echo("<a href='userupdate.php'><div class='button' style='margin: 0px auto; width:180px;'>修改</div></a>");
        ?>
    </div>
</div>

<?php include("includes/modules/footer.php"); ?>
