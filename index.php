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
        }else if(intval($_FILES["file"]["size"]) > 525000){
            /* Filter all files greater than 512 KB */
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
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.css">
	<link rel="stylesheet" href="./css/style.css">
	<!-- JavaScript HTML requirements -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script src="./js/script.js"></script>
</head>

<body>
<!-- Uploader -->
<div data-role="page" id="uploader">
    <header data-role="header" data-position="fixed">
        <h1>Floader</h1>
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>    
    <section data-role="content">
		<form id="form-flickr" data-ajax="false"  method="post" accept-charset="utf-8" enctype='multipart/form-data'>
						<h3>Upload Photo</h3>
				<?php
				if (isset($_POST['name']) && $error==0) {
                    $userID = $_SESSION["user-id"];
                    $userName = $_SESSION["user-name"];
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
					//echo "  <h2>Your file has been uploaded to <a href='http://www.flickr.com/photos/88261501@N05/' target='_blank'>ischoold's photo stream</a></h2>";
                    echo "  <h2>Your file has been uploaded to <a href='http://www.flickr.com/photos/$userID/' target='_blank'>$userName's photo stream</a></h2>";
                    session_unset();
				}else {
					if($error == 1){
						echo "  <font color='red'>Please provide both name and a file</font>";
					}else if($error == 2) {
						echo "  <font color='red'>Unable to upload your photo, please try again</font>";
					}else if($error == 3){
						echo "  <font color='red'>Please upload JPG, JPEG, PNG or GIF image ONLY</font>";
					}else if($error == 4){
						echo "  <font color='red'>Image size greater than 512KB, Please upload an image under 512KB</font>";
					}
				?>
				<div id="upload_file_name">
					<div id="load" >
							<p>Name <input data-mini="true" data-theme="b" type="text" name="name" value="" ></p>
							<p>Description<input data-mini="true" data-theme="b" type="text"name="description" value="" ></p>
							<p>Tags<input data-mini="true" data-theme="b" type="text" id="form-flickr-keyword"  name="tags-search" placeholder="keyword" /></p>
							<!-- hidden input for tags-->
							<input type="text" id="store-tags"  name="tags"/>
							<ul id="tag-for-input"></ul>
							<div id="suggest_tags" data-role="collapsible" data-collapsed="false" data-mini="true"  data-theme="c" data-content-theme="b" data-iconpos="right">
									<h3>Suggested Tags</h3>
									<!-- Tags-list -->
									<ul id="tag-list"></ul>
							</div>
							<p>Picture: <input data-role="button" data-icon="upload2" data-mini="true" data-theme="b" type="file" name="file"></p>
							<!-- Upload button -->
						   <p><input type="submit" name="submit-photo" value="Upload Photo" data-role="button"  data-icon="upload" data-theme="a" data-iconpos="top"></p>
					</div>
				</div>
	</form>
<?php
				}
?>
	</section>       
    <footer data-role="footer" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li><a href="#uploader" data-icon="camera" data-theme="a" class="ui-btn-active ui-state-persist" >Uploader</a></li>
			<li><a href="#photostream"  data-icon="photos" data-theme="a" >Photostream</a></li>
		</ul>
		</div>
	</footer>
</div>
			<!-- Tags-list -->
<div data-role="page" id="photostream">
    <header data-role="header" data-position="fixed">
        <h1>Floader</h1>
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>      
    <section data-role="content">
		<h3>Photostream</h3>	
        <ul data-role="listview" data-split-icon="gear" data-inset="true">
            <li>
                <a href="#toobin">
                    <h4>Jeffrey Toobin<br>Black Robed Secrets</h4>
                    <h4>October 19, 2011</h4>                   
                </a>
                <a href="#buytix" data-rel="dialog" data-transition="pop">Buy Tickets</a>
            </li>
        </ul>
    </section>       
    <footer data-role="footer" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li><a href="#uploader" data-icon="camera" data-theme="a"  >Uploader</a></li>
			<li><a href="#photostream"  data-icon="photos" data-theme="a" class="ui-btn-active ui-state-persist">Photostream</a></li>
		</ul>
		</div>
	</footer>
</div>

<div data-role="dialog" id="setting">
    <header data-role="header" data-position="fixed">
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
        	<a href="mailto:info@google.com" data-icon="email" data-mini="true" data-theme="a">Contact Us</a>
        </div>
    </section>
	</div>
</body>
</html>


