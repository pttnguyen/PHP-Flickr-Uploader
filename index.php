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

// For paging the thumbnails, get the page we are on
// if there isn't one - we are on page 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Fire up the phpFlickr class
$f = new phpFlickr($key);

// phpFlickr needs a cache folder
// in this case we have a writable folder on the root of our site, with permissions set to 777
$f->enableCache("fs", "cache");

//returns an array
$result = $f->people_findByUsername($userName);

// grab our unique user id from the $result array
$nsid = $result["id"];

// Get the user's public photos and show 21 per page
//$page at the end specifies which page to start on, that's the page number ($page) that we got at the start
$photos = $f->people_getPublicPhotos($nsid, NULL, NULL, 96, $page);

// Some bits for paging
$pages = $photos[photos][pages]; // returns total number of pages
$total = $photos[photos][total]; // returns how many photos there are in total

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
	
	<script type='text/javascript'>
	//jQuery version
$(document).ready(function(){

	var myPhotoSwipe = $("#thumbs a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });
	
	$('#loader').hide();
	
	$('.loader').click(function() {
		$.mobile.showPageLoadingMsg("a","Floading ...");
	});

});
</script>
	
</head>

<body>

<!-- Splash -->
<div data-role="page" id="welcome" data-theme="a" class='type-interior ui-page ui-body-a ui-page-header-fixed ui-page-footer-fixed'>
    <section data-role="content">
	
				<!-- Content -->
			<div id="content" data-role="content" data-scrollz="pull">
	
	<div style='width: 100%; height: 100%; font-size: 100%; text-align: center; margin: auto;'>
	<div style='font-size: 180%;'>Welcome to</div>
	<a href="#uploader" data-prefetch="true" data-transition="slidedown" class="ui-btn ui-btn-hover-d ui-btn-up-d" style='font-size: 150%; padding: 10px;'><font color='#FF0084'>F</font><font color='#1057AE'>load</font><font color='#FF0084'>r</font></a>
	<div style='font-size: 100%;'>A Tagging, Uploading, and Photo Pooling Application for HTML5-Compatible Devices</div>
	</div>
			</div>
	
	</section>
</div>

<!-- Uploader -->
<div data-role="page" id="uploader" class='type-interior ui-page ui-body-c ui-page-header-fixed ui-page-footer-fixed'>
    <header data-role="header" data-tap-toggle="false" data-position="fixed">
        <h1>Uploader</h1>

		<a href="#welcome" data-transition="slideup" class="ui-btn ui-btn-inline ui-btn-hover-d ui-btn-up-d"><span class="ui-btn-inner"><span class="ui-btn-text"><font color='#FF0084'>F</font><font color='#1057AE'>load</font><font color='#FF0084'>r</font></span></span></a>
		
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>    
    <section data-role="content" data-theme="a" class="ui-content ui-body-a">
		
		<div style='min-height: 680px; height: 100%;'>
		<form id="form-flickr" data-ajax="false"  method="post" accept-charset="utf-8" enctype='multipart/form-data'>
						<!-- <h3>Upload Photo</h3> //-->
				<?php
				if (isset($_POST['name']) && $error==0) {

                    // echo "<h3>Your file has been uploaded to <a href='#photostream'>$userName's photo stream</a>.</h3> <br><a href='#photostream'>View Photos</a> | <a href='#' onClick='window.location.reload(); return false;'>Upload Another</a>";
                    // session_unset();
                    // window.location.reload();
                    	header("Location: success.php");
                    	
				}else {
					if($error == 1){
						echo "  <font color='red' style='margin-bottom: 10px;'>Please provide both name and a file</font>";
					}else if($error == 2) {
						echo "  <font color='red' style='margin-bottom: 10px;'>Unable to upload your photo, please try again</font>";
					}else if($error == 3){
						echo "  <font color='red' style='margin-bottom: 10px;'>Please upload JPG, JPEG, PNG or GIF image ONLY</font>";
					}else if($error == 4){
						echo "  <font color='red' style='margin-bottom: 10px;'>Image size greater than 5MB, Please upload an image under 5MB</font>";
					}
				?>
				
				<div id="upload_file_name">
					<div id="load" >

							<p>Picture: <input data-role="button" data-icon="upload2" data-mini="true" data-theme="b" type="file" name="file"></p>

							<p>Name <input data-mini="true" data-theme="b" type="text" name="name" value="" ></p>
							<p>Description<input data-mini="true" data-theme="b" type="text"name="description" value="" ></p>
							<p>Tags<input data-mini="true" data-theme="b" type="text" id="form-flickr-keyword"  name="tags-search" placeholder="keyword" /></p>
							
							<div id="suggest_tags" data-role="collapsible" data-collapsed="false" data-mini="true"  data-theme="c" data-content-theme="b" data-iconpos="right">
									<h3>Suggested Tags</h3>
									<!-- Tags-list -->
									<ul id="tag-list"></ul>
							</div>
							
							<!-- hidden input for tags-->
							<input type="text" id="store-tags" name="tags"/>
							<ul id="tag-for-input"></ul>
														
							<!-- Upload button -->
						   <p><input type="submit" name="submit-photo" class="loader" value="Upload Photo" data-role="button" onclick="$.mobile.showPageLoadingMsg();" data-icon="upload" data-theme="a" data-iconpos="top"></p>
					</div>
				</div>
	</form>
	</div>
<?php
				}
?>
	</section>       
    <footer data-role="footer" data-tap-toggle="false" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li class='upload'><a href="#uploader" data-prefetch="true" data-transition="none" data-icon="camera" data-theme="a" class="ui-btn-active ui-state-persist">Uploader</a></li>
			<li class='photos'><a href="#photostream" data-prefetch="true" data-transition="none" data-direction="reverse" data-icon="photos" data-theme="a" >Photostream</a></li>
		</ul>
		</div>
	</footer>
</div>
			<!-- Tags-list -->
<div data-role="page" id="photostream" class='type-interior ui-page ui-body-c ui-page-header-fixed ui-page-footer-fixed gallery-page'>
    <header data-role="header" data-tap-toggle="false" data-position="fixed">
        <h1>Photostream (<?php echo $total ?>)</h1>
		
		<a href="#welcome" data-transition="slideup" class="ui-btn ui-btn-inline ui-btn-hover-d ui-btn-up-d"><span class="ui-btn-inner"><span class="ui-btn-text"><font color='#FF0084'>F</font><font color='#1057AE'>load</font><font color='#FF0084'>r</font></span></span></a>
		
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>  
    <section data-role="content" data-theme="a" class="ui-content ui-body-a">
		<!-- <h3>Photostream</h3> //-->
		
		<div style='min-height: 680px;'>

		<!-- <div class="gallery">
		
		</div> //-->
		
		
<div id="thumbs">
<?php

	foreach ($photos['photos']['photo'] as $photo) {
   
         echo "<a href=\"" . $f->buildPhotoURL($photo, "full") . "\" target='_blank' rel='external' title=\"View $photo[title]\">";
	 // this next line uses buildPhotoURL to construct the location of our image 
	   echo "<img alt=\"$photo[title]\" ".
            "src=\"" . $f->buildPhotoURL($photo, "Square") . "\" width=\"75\" height=\"75\" />";
        echo "</a>\n";

} // end loop

?>
</div><!-- end thumbs -->

<div style='clear: both;'></div>


<!-- Paging -->
<p id="nav">
<?php
// Some simple paging code to add Prev/Next to scroll through the thumbnails
$back = $page - 1; 
$next = $page + 1; 

if($page > 1) { 
echo "<a rel='external' href='#photostream?page=$back'>&laquo; <strong>Prev</strong></a>"; 
} 
// if not last page
if($page != $pages) { 
echo "<a rel='external' href='#photostream?page=$next'><strong>Next</strong> &raquo;</a>";} 
?>
</p>

<?php
// a quick bit of info about where we are in the gallery
// echo"<p>Page $page of $pages</p>";
echo"<p class=\"note\">$total photos in the gallery</p>";

?>
		
		<div style='clear: both;'></div>
	<?php 					
	echo "<h4><a style='color: white;' href='http://www.flickr.com/photos/$userID/' target='_blank'>View All</a> - $userName's Photo Stream</h3>"; 
	?>
		
		</div>
		
		
		

    </section>       
    <footer data-role="footer" data-tap-toggle="false" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li><a href="#uploader" data-transition="none" data-icon="camera" data-theme="a" >Uploader</a></li>
			<li><a href="#photostream" data-transition="none" data-direction="reverse" data-icon="photos" data-theme="a" class="ui-btn-active ui-state-persist">Photostream</a></li>
		</ul>
		</div>
	</footer>
</div>

<div data-role="page" id="success" class='type-interior ui-page ui-body-c ui-page-header-fixed ui-page-footer-fixed'>
    <header data-role="header" data-tap-toggle="false" data-position="fixed">
        <h1>Success!</h1>

		<a href="#welcome" data-transition="slideup" class="ui-btn ui-btn-inline ui-btn-hover-d ui-btn-up-d"><span class="ui-btn-inner"><span class="ui-btn-text"><font color='#FF0084'>F</font><font color='#1057AE'>load</font><font color='#FF0084'>r</font></span></span></a>
		
		<p><a href="#setting" data-role="button" data-icon="info" data-mini="true" data-theme="a"  data-iconpos="notext" class="ui-btn-right">Info</a></p>
    </header>  
    <section data-role="content" data-theme="a" class="ui-content ui-body-a">
	
	<?php 		
	echo "<h3>Your file has been uploaded to <a href='http://www.flickr.com/photos/$userID/' target='_blank'>$userName's photo stream</a>.</h3> <br><a href='http://www.flickr.com/photos/$userID/' target='_blank'>View Photos</a> | <a href='#' onClick='window.location.reload(); return false;'>Upload Another</a>"; 
	?>
	
	</section>
    <footer data-role="footer" data-tap-toggle="false" data-position="fixed">
        <div data-role="navbar">
		<ul>
			<li><a href="#uploader" data-transition="none" data-icon="camera" data-theme="a" >Uploader</a></li>
			<li><a href="#photostream" data-transition="none" data-direction="reverse" data-icon="photos" data-theme="a" class="ui-btn-active ui-state-persist">Photostream</a></li>
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
        <a href="<?php echo "http://www.flickr.com/photos/$userID/" ?>" ref='external' target='_blank'><?php echo $userName ?></a></a><br><br> 

        <!--Haroon-->
        <form id="form-login" data-ajax="false" method="post" accept-charset="utf-8" enctype='multipart/form-data'>
            <div id="Custom_login" style="text-align:left;" data-role="collapsible" data-collapsed="true" data-mini="true"  data-theme="c" data-content-theme="b" data-iconpos="right">
                <h3>Custom Login</h3>
                <p>User Name <input data-mini="true" data-theme="b" type="text" name="user-name"></p>
                <p>UserID (nsid) <input data-mini="true" data-theme="b" type="text" name="user-id"></p>
                <p>ApiKey<input data-mini="true" data-theme="b" type="text"name="api-key"></p>
                <p>ApiSecret<input data-mini="true" data-theme="b" type="text" name="api-secret"/></p>
                <p>Token<input data-mini="true" data-theme="b" type="text" name="token"/></p>
                <p><a href='http://people.ischool.berkeley.edu/~ptt.nguyen/Floader/phpFlickr/getToken.php' rel='external'>Callback URL</a></p>
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


