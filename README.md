Floader - Flickr Pool Uploader & Tagger
=====


Members
---
*Chan Kim
*Peter Nguyen
*Haroon Rasheed

Roles
---
*Chan Kim - 
*Peter Nguyen - 
*Haroon Rasheed - 

Bugs
---
*Can't change submit photo button for all devices due to security in Android and iOS devices. 
Tried changing the colors using proxy button and click event, but only works on desktop computers.

Sources
---
http://www.ravikiranj.net/drupal/201103/code/php/how-create-public-photo-uploader-using-flickr




Example--
Tember Members responsibility
·   Brian – Responsible for integration of creator and viewer components via url parameters; introduced 
unified login dialog with progress bar while saving; sort trails by step number before rendering; git 
cheerleader;
·  Peter – Responsible for overall skeleton/template, creator interface for pulling images from flickr and 
making them draggable into the trail-maker, came up with concept of using trailmaker and Flickr images 
to create Delicious Trails, jQuery and Javascript used to create graphical design elements, CSS design and 
templating for Project, created interface for numbering photos added to new trail. 
·    Sonali Sharma - Responsible for the viewer page, where users enter their username and tag to fetch 
tagged photos from delicious. Pages created were viewer.html and viewer.js. Used a jquery cover 
flow to achieve the coverflow gallery affect on the viewer page. (Source code used for reference: 
jquerycss.com)
Project Description
This was an improvement on the Delicious trail maker covered in the lab. In this project we create trails 
of photographs. The user can fetch the photographs from Flickr and use those photographs to create a 
trail of their own on Delicious.
Specific improvements include:
a) Use of pictures instead of text enhances the richness of the trail
b) Allow use of multiple sources (tags) for trail creation
c) Present trails based on step number

This is done in four steps:
·      STEP 1: Fetch photographs from Flickr. Users can fetch any random photographs or based on a tag.
·    STEP 2: Make your own trail. The user can then select a group of these photographs to be included in 
their own trail. They do that by dragging and dropping the photos from Flickr to their trail.
·     STEP 3: Save Trail. The user then saves the trail by giving it a unique name.
·   STEP 4: View Trails. The user can view trails either after directly saving their newly created trail or 
fetching the already saved trails using a username and tag
Delicious username tested with:

Username Tag
Sonalisharma Sun asianslike pikachu
bcavagnolo planets, only-one-image, tag-without-steps

Technologies used on the project
 HTML, Javascript, jQuery, 

URL of the repository on github
https://github.com/pttnguyen/Project-1

Live URL
http://people.ischool.berkeley.edu/~bcavagnolo/deflickus/index.html

Browser support
Tested on Chrome, Firefox, IE7, Safari

Bugs/Quirks
-- coverflow leaves vertical image trails behind as it scrolls images.  Not sure why.
-- When FF focuses on a text box, the placeholder vanishes.
-- Trails with only one image cause unexpected pop-ups on chrome.
-- coverflow completely does not work in IE7.  Not sure why.
-- trail creator fails to save in IE7 without apparent error, and does not redirect to viewer.
-- only links with jpg extension can be displayed, this could be improved by inspecting the url 
HEAD data