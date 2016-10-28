<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>

<?php 
    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
    $pdo->query("use projectac;");
    $stmt = $pdo->prepare("SELECT * from file where fid = ?");
    if(isset($_GET['fid']))
        $stmt->bindParam(1, $_GET['fid'], PDO::PARAM_INT);
    else
    {
        echo('<script type="text/javascript">alert("你走错地方啦～");window.location.href="/mgzd/files.php";</script>)');
        exit();
    }

    $fid = $_GET['fid'];
    $stmt->execute();

    $flag = false;
    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
    if(!$row)
    {
        echo('<script type="text/javascript">alert("未找到相应数据！");window.location.href="/mgzd/files.php";</script>)');
        exit();
    }
?>

<title><?php echo($row[2]." - ".$title); ?></title>

<div class='mainnoindent' style='width: 650px; height:540px; margin: 50 auto;'>
    <div style='float:right; padding-top:20px; text-align:center; font-size:30px; width: 100%; font-family: "Times New Roman Italic", "Courier New", "Ubuntu", "楷体", "微软雅黑", "黑体";'>
        <?php echo('#'. $fid . ' ' . $row[2]); ?>
    </div>
    <div style='float:right; margin-right: 7px; padding-top:15px; font-family: "Times New Roman Italic", "Courier New", "Ubuntu", "楷体", "微软雅黑", "黑体"; '>
        <?php
            echo("<div style='line-height:20px'><br/>");
            echo('评分 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/greenbar.png"  width="'.($row[4] * 299 / 100 + 1).'px" height="11px" /></div><br/>');
            echo('等级 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/orangebar.png" width="'.($row[7] * 299 / 13 + 1).'px" height="11px" /></div><br/>');
            echo('水平 <div style="display: inline-block; border:white 1px solid; width: 300px; height: 11px;"><img src="/images/system/purplebar.png" width="'.($row[9] * 299 / 13 + 1).'px" height="11px" /></div><br/>');
            echo("</div>");
        ?>
    </div>
    <div class='block' style='float:left; text-align:left; width: 240px; line-height: 16px; font-size:13px; height: 40px; margin-top:30px;'>
        <div>发布用户：<?php echo($row[1]); ?></div>
        <div>上传时间：<?php echo($row[5]); ?></div>
        <div>密码保护：<?php echo($row[8]==''?'否':'是'); ?></div>
    </div>
    
    <div style='float: left; width: 577px; height: 175px; line-height: 23px; overflow-y: scroll; border: 1px solid rgb(150, 150, 150); margin: 5px; padding: 30px; text-indent: 0em; white-space:pre-wrap;'><?php echo($row[6]); ?></div>

    <div style='float:left; width: 100%;'>
    <div class='instruction' style='width: 637px; margin: 0px auto; text-align: center;'> 我们不能保证用户提供的链接安全！请在点击按钮前仔细检查源码！</div>
    </div>

    <?php echo('<a href="'.htmlspecialchars($row[10]).'">') ?><div style='float:left; margin: 25px auto; width: 100%;'><div class='button' style='width:300px;'>立即下载</div></div></a>
    <?php if($uid == $row[1]){ echo('<a href="/mgzd/fileupdate.php?fid='.$fid.'">') ?><div style='float:left; margin: -25px auto; width: 100%;'><div class='button-green' style='width:300px;'>修改信息</div></div></a><?php } ?>
</div>

<?php include("includes/modules/footer.php"); ?>
