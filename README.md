Floader - Flickr Pool Uploader & Tagger
=====
<u>Description:</u> A Customizable PHP/HTML5 Flickr Photo Uploader and Tagger. It suggests tags, uploads, and pools photos uploaded from HTML5-Compatible
Devices to an iSchool photo pool, which is customizable if the Flickr user has an API key and token. This is a project
that integrates with Flickr seamlessly to create a photo pooling application anyone can use. This is important for
people without Flickr accounts that want to share their photos with friends at a party, for example. Using Floader, they
can take photos, tag them, and upload them to a photo pool without having to log in. It is a universal uploader that fluidly adapts to fit most devices.

* Relevant to <strong>People are lazy</strong>: 
* Attempt to prove Doctorow wrong and show that ease-of-use will help this problem. 
* We added UI onto a Flickr uploader that helpfully suggests tags to make it easier for people to tag their photos before uploading to the service.
* Using Floader, users are given the same tags others would be given if they were to type the same words. 
* This should help keep tags standardized, which should help deter big and complicated "folksonomies."

Members & Roles
---
* Chan Kim (chan@ischool.berkeley.edu)
    Hacker, Developer, Designer
    - Created layout, jQuery animation elements, page structure, tagging/suggestion interface, oversaw project development. 
* Peter Nguyen (ptt.nguyen@ischool.berkeley.edu)
    Hacker, Developer, Designer
    - Integrated photostream component, added photoswipe library and touch support for application, added new PHP
    variables to persist throughout user-session.
* Haroon Rasheed (haroon@ischool.berkeley.edu)
    Hacker, Developer
    - Integrated Flickr Tags API, created login interface from scratch for customizable photostreams/uploading, was able
    to deliver on anything we asked of. Created PHP session system for persistent logins.
    
How We Did It
---
* We needed a Flickr Uploader, so we used phpFlickr, which is a framework designed to make uploading to Flickr easier. It uses our username, API Key, Secret Key, and Token to allow uploads to our account, "ischoold." 
* Next, we themed it using jQuery Mobile, and added our own Flickr Tag Suggester, which uses the Flickr Tags API to suggest tags before someone uploads a photo. 
* After uploading, they are presented with a "Congratulations" screen, and are allowed to return to the photostream, which is also embedded onto our web app using phpFlickr.
* Next, we made it even more useful-- people can now enter their own credentials and use the app to upload to their own accounts. This can be done through the "info" section. By default, photos will be sent to our account.

Technologies Used
---
PHP, jQuery, jQuery Mobile, Javascript, Flickr API, CSS3, HTML5

URL of the repository on github
---
https://github.com/pttnguyen/Project-2

Live URL
---
* http://bit.ly/floader
* Callback URL: http://people.ischool.berkeley.edu/~ptt.nguyen/Floader/phpFlickr/getToken.php

Browser support
---
Tested on Chrome, Firefox, IE7, Safari, Mobile Safari, Android Fennec

Bugs
---
* Can't change submit photo button for all devices due to security in Android and iOS devices. Tried changing the colors using proxy button and click event, but only works on desktop computers.
* Miscellaneous problems with height due to all screen sizes (should fit up to 1280px screens)
* File uploads are limited to 5MB.
* Works on all devices (>iOS 6 for uploading)

Sources
---
* http://www.ravikiranj.net/drupal/201103/code/php/how-create-public-photo-uploader-using-flickr
* http://www.photoswipe.com
* http://www.flickr.com/services/api/flickr.tags.getRelated.html