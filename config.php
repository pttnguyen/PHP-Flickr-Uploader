<?php

if (!empty($_POST['submit-login'])) {

    $_SESSION['user-name'] = $_POST["user-name"];
    $_SESSION['user-id'] = $_POST["user-id"];
    $_SESSION['api-key'] = $_POST["api-key"];
    $_SESSION['api-secret'] = $_POST["api-secret"];
    $_SESSION['token'] = $_POST["token"];
    
}

?>