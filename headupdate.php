<?php include("includes/modules/header.php"); ?>
<?php include("includes/modules/top.php"); ?>

<title><?php echo($title); ?></title>

<div class='title'>
    <h1>上传头像</h1>
</div>

<div class='toollabel'>
    
</div>

<script type='text/javascript'>
    function check()
    {
        if(document.form1.file.value == '')
        {
            window.location.href = '/mgzd/user.php';
        }else
        {
            document.form1.submit.click();
        }
    }

    function change()
    {
        var url = "";
        if (navigator.userAgent.indexOf("MSIE") >= 1) 
            url = document.getElementById("file").value;
        else
            url = window.URL.createObjectURL(document.getElementById("file").files.item(0));  
        //alert(url);
        big.src = url;
        medium.src = url;
        small.src = url;
    }
</script>

<div class='mainnoindent' style='margin: 50 auto; text-align:center; width: 350px;'>
    <form action='/mgzd/scripts/server/headupdate.php'  method="post" name='form1' enctype="multipart/form-data">
        <input type="submit" name="submit" value="1" style="display:none"/>
        <input type='file' id='file' name='file' style='width:295px; border:1px solid;' onchange='change()'/>
        <br/>
        <div>
        <?php echo('<img name="big" height=150 width=150 src="/images/user/' . $_SESSION['uid'] . '/head.jpg"/>'); ?>
        <?php echo('<img name="medium" height=90 width=90 src="/images/user/' . $_SESSION['uid'] . '/head.jpg"/>'); ?>
        <?php echo('<img name="small" height=45 width=45 src="/images/user/' . $_SESSION['uid'] . '/head.jpg"/>'); ?>
        </div>
        <a href='#' onclick='check()'><div class='button' style='width:265px;'>修改</div></a>
    </form>
</div>

<?php include("includes/modules/footer.php"); ?>