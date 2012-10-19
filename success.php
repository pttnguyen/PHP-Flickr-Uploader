<?php
session_start();  
//Include phpFlickr
require_once("phpFlickr/phpFlickr.php");
include 'config.php';

$error=0;
$f = null;
if (!empty($_POST['submit-photo'])) {
    /* Check if both name and file are filled in */
    if(!$_POST['name'] || !$_FILES["file"]["name"]["tags"]){
        $error=1;
    }else{
        /* Check if there is no file upload error */
        if ($_FILES["file"]["error"] > 0){
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
        }else if($_FILES["file"]["type"] != "image/jpg" && $_FILES["file"]["type"] != "image/jpeg" && $_FILES["file"]["type"] != "image/png" && $_FILES["file"]["type"] != "image/gif"){
            /* Filter all bad file types */
            $error = 3;
        }else if(intval($_FILES["file"]["size"]) > 5250000){
            /* Filter all files greater than 5 MB */
            $error = 4;
        }else{
            $dir= dirname($_FILES["file"]["tmp_name"]);
            $newpath=$dir."/".$_FILES["file"]["name"];
            rename($_FILES["file"]["tmp_name"],$newpath);
            /* Call uploadPhoto on success to upload photo to flickr */
            $status = uploadPhoto($newpath, $_POST["name"], $_POST["description"], $_POST["tags"]);
            if(!$status) {
                $error = 2;
            }
         }
     }
} 

function uploadPhoto($path, $title, $description, $tags) {

    $userName = $_SESSION["user-name"];
    if($userName == "")
    {
        $userName = "ischoold";
    }
    $userID = $_SESSION["user-id"];
    if($userID == "")
    {
        $userID = "88261501@N05";
    }
    $apiKey = $_SESSION["api-key"];
    if($apiKey == "")
    {
        $apiKey = "8feb459f9cd322658556e3a761867c46";
    }
    $apiSecret = $_SESSION["api-secret"];
    if($apiSecret == "")
    {
        $apiSecret = "b23a12330334c320";
    }
    $token = $_SESSION["token"];
    if($token == "")
    {
        $token = "72157631733392573-0fd762003e9b7f1b";
    }
    $permissions  = "write";
    $f = new phpFlickr($apiKey, $apiSecret, true);
    $f->setToken($token);
    return $f->async_upload($path, $title, $description, $tags);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Floader</title>
    <link rel="stylesheet" href="./js/jquery.mobile-1.2.0.css">
	<link rel="stylesheet" href="./css/colorbox.css">
	<link rel="stylesheet" href="./css/style.css">
	<!-- JavaScript HTML requirements -->

	<script src="./js/jquery.min.js"></script>
    <script src="./js/jquery-ui.min.js"></script>
	<script src="./js/jquery.mobile-1.2.0.min.js"></script>
	<script src="./js/script.js"></script>

	<link href="./css/photoswipe.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="./js/klass.min.js"></script>
	<script type="text/javascript" src="./js/code.photoswipe.jquery-3.0.4.min.js"></script>
	
</head>

<body>

<div data-role="page" id="success" class='type-interior ui-page ui-body-c ui-page-header-fixed ui-page-footer-fixed'>
    <header data-role="header" data-tap-toggle="false" data-position="fixed">
        <h1>Success!</h1>

		<a href="#welcome" data-transition="slideup" class="ui-btn ui-btn-inline ui-btn-hover-d ui-btn-up-d"><span class="ui-btn-inner"><span class="ui-btn-text"><font color='#FF0084'>F</font><font color='#1057AE'>load</font><font color='#FF0084'>r</font></span></span></a>
		
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>  
    <section data-role="content" data-theme="a" class="ui-content ui-body-a">
	
	<div style='min-height: 530px;'>
	<?php 		
	echo "<h3>Your file has been uploaded to <a rel='external' href='index.php#photostream'>$userName's photo stream</a>.</h3> <br><a rel='external' href='index.php#photostream'>View Photos</a> | <a rel='external' href='index.php#photostream'>Upload Another</a>"; 
	?>
	</div>
	
	</section>
    <footer data-role="footer" data-tap-toggle="false" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li><a href="index.php#uploader" rel='external' data-transition="slide" data-icon="camera" data-theme="a" >Uploader</a></li>
			<li><a href="index.php#photostream" rel='external' data-transition="slide" data-direction="reverse" data-icon="photos" data-theme="a" class="ui-btn-active ui-state-persist">Photostream</a></li>
		</ul>
		</div>
	</footer>
</div>

<div data-role="dialog" id="setting">
    <header data-role="header" data-tap-toggle="false" data-position="fixed">
        <h1>About Us</h1>
    </header>      
    <section data-role="content" style="text-align:center;">
        <strong>Flickr ID</strong><br>
        <a href="#">ischoold</a><br><br> 

        <!--Haroon-->
        <form id="form-login" data-ajax="false" method="post" accept-charset="utf-8" enctype='multipart/form-data'>
            <div id="Custom_login" style="text-align:left;" data-role="collapsible" data-collapsed="true" data-mini="true"  data-theme="c" data-content-theme="b" data-iconpos="right">
                <h3>Custom Login</h3>
                <p>User Name <input data-mini="true" data-theme="b" type="text" name="user-name"></p>
                <p>UserID (nsid) <input data-mini="true" data-theme="b" type="text" name="user-id"></p>
                <p>ApiKey<input data-mini="true" data-theme="b" type="text"name="api-key"></p>
                <p>ApiSecret<input data-mini="true" data-theme="b" type="text" name="api-secret"/></p>
                <p>Token<input data-mini="true" data-theme="b" type="text" name="token"/></p>
                <p><input type="submit" name= "submit-login" value="Submit" data-role="button"  data-icon="upload" data-theme="a" data-iconpos="top"></p>
            </div>
        </form>
        <!--Haroon-->

        <strong>Developer Info</strong><br>
        <a href="#">Chan,</a>
		<a href="#"> Haroon,</a>
		<a href="#"> Peter</a><br><br>        
        <div class="ui-bar">
        	<a href="mailto:ptt.nguyen@ischool.berkeley.edu" data-icon="email" data-mini="true" data-theme="a">Contact Us</a>
        </div>
    </section>
	</div>
</body>
</html>


