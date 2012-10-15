<?php

if (!empty($_POST['submit-login'])) {

    $_SESSION['user-name'] = $_POST["user-name"];
    $_SESSION['user-id'] = $_POST["user-id"];
    $_SESSION['api-key'] = $_POST["api-key"];
    $_SESSION['api-secret'] = $_POST["api-secret"];
    $_SESSION['token'] = $_POST["token"];
    
}

$apiKey = "8feb459f9cd322658556e3a761867c46";
$secret = "b23a12330334c320";
$perms = "write";

$key = "8feb459f9cd322658556e3a761867c46";
$username="ischoold";

?>