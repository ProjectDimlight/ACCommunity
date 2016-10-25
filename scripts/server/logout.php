<?php 
    session_start();
    $_SESSION['tmp'] = " ";
    session_destroy();
?>

<script>
    window.location.href = '/mgzd/';
</script>
