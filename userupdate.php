<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/mgzd/includes/modules/checkuid.php"); ?>

<?php 
        $pdo = new PDO("mysql:host=localhost;dbname=projectac;charset=utf8;", "access", "");
        $pdo->query("use projectac;");
        $stmt = $pdo->prepare("SELECT * from user where uid = ?");
        $stmt->bindParam(1, $uid, PDO::PARAM_INT);
        $stmt->execute();

        $flag = false;
        $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
?>

<title><?php echo($row[1]." - ".$title); ?></title>

<div class='title'>
    <h1>修改用户信息 - <?php echo($row[1]); ?></h1>
</div>

<div class='toollabel'>
    
</div>

<script type='text/javascript'>
    function submit()
    {
        if(document.form1.newpswd.value != document.form1.cfmpswd.value)
            alert("请检查你的新密码输入哦~");
        else
            document.form1.submit.click();
    }
</script>

<div class='main' style='width: 800px; margin:50px auto;'>
    <div style='float:right; text-indent:0;'>
        <div style='text-align:right; margin-bottom:15px'>
            <a href='headupdate.php'><?php echo('<img height=150 width=150 src="/images/user/' . $row[0] . '/head.jpg"/>'); ?></a>
        </div>
        <div>
            <a href='userupdate.php'><div class='button' style='width:120px;'>撤销</div></a>
            <a href='#' onclick='submit()'><div class='button-green' style='width:120px;'>保存</div></a>
        </div>
    </div>

    <form action='/mgzd/scripts/server/userupdate.php' method="post" name='form1'>
    
    <input type="submit" name="submit" value="1" style="display:none"/>

    <table style='width: auto;'>
        <tr style='width: 100%;'>
            <td style='width: 60px;'>
                编号
            </td>
            <td>
                <?php echo($row[0]); ?>
            </td>
        </tr>
        <tr style='width: 100%;'>
            <td>
                昵称
            </td>
            <td>
                <?php echo('<input type="text" class="login" style="width:510px" name="username" value="' . $row[1] . '" />'); ?>
            </td>
        </tr>
        <tr style='width: 100%;'>
            <td>
                密码
            </td>
            <td style='letter-spacing: 0px;'>
                <?php echo('<input type="password" class="login" style="width:163px; margin: 0px;" name="password" />'); ?>
                <?php echo('<input type="password" class="login" style="width:164px; margin: 0px;" name="newpswd" />'); ?>
                <?php echo('<input type="password" class="login" style="width:164px; margin: 0px;" name="cfmpswd" />'); ?>
            </td>
        </tr>
        <tr style='width: 100%;'>
            <td>
                性别
            </td>
            <td>
                <?php 
                    $selected = ["", "", "", "", "", ""];
                    $selected[$row[10]] = "selected";

                    echo('<select class="login" style="width:510px" name="sex">');
                    echo('<option value ="0" '.$selected[0].'>保密的</option>');
                    echo('<option value ="1" '.$selected[1].'>帅哥</option>');
                    echo('<option value ="2" '.$selected[2].'>萌妹</option>');
                    echo('<option value ="3" '.$selected[3].'>可爱的男孩子</option>');
                    echo('<option value ="4" '.$selected[4].'>女汉子</option>');
                    echo('<option value ="5" '.$selected[5].'>秀吉</option>');
                    echo('</select>');
                ?>
            </td>
        </tr>
        <tr style='width: 100%; height:40px'>
            <td valign="top">
                格言
            </td>
            <td style='width: 540px;'>
                <textarea name='motto' style='width: 510px; height:120px; font-size: 15px;'><?php echo($row[4]); ?></textarea>
            </td>
        </tr>
    </table>
    </form>
</div>

<?php include("includes/modules/footer.php"); ?>
