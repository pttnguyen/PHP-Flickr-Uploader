Floader - Flickr Pool Uploader & Tagger
=====
A Customizable PHP/HTML5 Flickr Photo Uploader and Tagger. It suggests tags, uploads, and pools photos uploaded from HTML5-Compatible
Devices to an iSchool photo pool, which is customizable if the Flickr user has an API key and token. This is a project
that integrates with Flickr seamlessly to create a photo pooling application anyone can use. This is important for
people without Flickr accounts that want to share their photos with friends at a party, for example. Using Floader, they
can take photos, tag them, and upload them to a photo pool without having to log in.

* Relevant to <strong>People are lazy</strong>: 
* Attempt to prove Doctorow wrong and show that ease-of-use will help this problem. 
* Add UI onto Delicious (or some other service) that helpfully suggests tags to make 
* it easy for you to follow the strict tagging principles you defined in 202. 
* Or, investigate automatic tagging using the TimesTags API, or some other approach.


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
    
    
URL of the repository on github
---
https://github.com/pttnguyen/Project-2

Live URL
---
http://bit.ly/floader

Browser support
---
Tested on Chrome, Firefox, IE7, Safari, Mobile Safari, Android Fennec

Technologies Used
---
PHP, jQuery, jQuery Mobile, Javascript, Flickr API, CSS3, HTML5

Bugs
---
* Can't change submit photo button for all devices due to security in Android and iOS devices. Tried changing the colors using proxy button and click event, but only works on desktop computers.
* Miscellaneous problems with height due to all screen sizes (should fit up to 1280px screens)

Sources
---
* http://www.ravikiranj.net/drupal/201103/code/php/how-create-public-photo-uploader-using-flickr
* http://www.photoswipe.com
* http://www.flickr.com/services/api/flickr.tags.getRelated.html