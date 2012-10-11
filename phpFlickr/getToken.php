<?php
    /* Last updated with phpFlickr 1.4
     *
     * If you need your app to always login with the same user (to see your private
     * photos or photosets, for example), you can use this file to login and get a
     * token assigned so that you can hard code the token to be used.  To use this
     * use the phpFlickr::setToken() function whenever you create an instance of 
     * the class.
     */

    require_once("phpFlickr.php");
    $apiKey = "8feb459f9cd322658556e3a761867c46";
    $secret = "b23a12330334c320";
    $perms = "write";
    $f = new phpFlickr($apiKey, $secret);
    
    //change this to the permissions you will need
    if(!$_GET['frob']){
        $f->auth($perms);
    }else {
        $tokenArgs = $f->auth_getToken($_GET['frob']);
        echo "<pre>"; var_dump($tokenArgs); echo "</pre>";
    }
    
?>
