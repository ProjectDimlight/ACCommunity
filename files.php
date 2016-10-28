<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?> - 资料站</title>

<div class='title'>
    <h1>资料站</h1>
</div>

<div style='width:100%;'>
    <img width='16%' style=' height: 160px;' src='/images/system/jiangyi.jpg'/><img width='17%' style=' height: 160px;' src='/images/system/500AC.png'/><img width='16%' style=' height: 160px;' src='/images/system/hxmj.jpg'/><img width='17%' style=' height: 160px;' src='/images/system/music.jpg'/><img width='17%' style=' height: 160px;' src='/images/system/FAQ.jpg'/><img width='17%' style=' height: 160px;' src='/images/system/huaji.jpg'/>
</div>

<div class='toollabel'>
    <a href='fileupdate.php'><div class='toolbox'>上传</div></a>
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 0; ?>
    <?php echo("<a href='files.php?page=".($page-1)."'><div class='toolbox'>上一页</div></a>"); ?>
    <?php echo("<a href='files.php?page=".($page+1)."'><div class='toolbox'>下一页</div></a>"); ?>
</div>

<div style='height: 600px;'>
<?php
    $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
    $pdo->query("use projectac;");
    $pdo->query("set names 'utf-8';");
    $id = $page * 20;
    $stmt = $pdo->prepare("SELECT fid, file.uid, name, user.nickname, file.time, tag from user, file WHERE file.uid = user.uid ORDER BY file.time DESC LIMIT ?, 20");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $cnt = 0;
    while($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
    {
        echo("<a href='/mgzd/file.php?fid=".$row[0]."'><div class='fileblock". $cnt ."'>");
        echo("<div style='float:right;'>");
        if($row[5] != '')
        {
            $tmp = explode(';', $row[5]);
            foreach($tmp as $val)
            echo("<font class='button-green'>".$val."</font> ");
        }
        echo("</div><font style='color:yellow; font-weight: bold;'>". $row[2] ."</font> <font style='font-size:12px;'>来自". $row[3]. " 于". $row[4]." </font></div></a>");
        $cnt=1-$cnt;
    }
?>
</div>

<?php include("includes/modules/footer.php"); ?>