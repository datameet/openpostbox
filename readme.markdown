#Welcome
This is the actual application which end use can use for searching the postboxes in India. Read my introductory blog post [Instgram for Crowdsourcing Postbox Locations](http://thejeshgn.com/2012/10/16/instgram-for-crowdsourcing-postbox-locations/) for more details on this project.


## Install and run

> hg clone http://code.thejeshgn.com/postbox

> cd postbox

> php -S localhost:8080


## Completed Tasks
+ Project setup
+ Scraping the data from instagram (batch)
+ Display of individual postbox page

## Working on
+ Search by pincode
+ Pincode tag cloud

## Future 
+ Search by Location (given lat long)
+ Search by Location (Give an actual address)
+ Map views
+ Reverse Geo code for city, state (batch)
+ Search by user
+ Store the instagrams locally
+ Add Notes/comments to each postboxpage
+ JSON - API

##Note
The same application can be used for any other instagram project. Say mapping dustbins or bus stops etc with very little change. Let me know if you plan to use it.

> if you are serious about running this project locally then get your own [Instagram API keys](http://instagram.com/developer/) and replace it in [instagram.php](http://code.thejeshgn.com/postbox/src/tip/inc/instagram.php?at=default). As of now it uses my id. Please don't abuse.

##Signed by me
All release are gpg signed by me using 0XBFFC8DD3C06DD6B0.
[![endorse](http://api.coderwall.com/thejeshgn/endorsecount.png)](http://coderwall.com/thejeshgn)

##Screen shots
![Initial screen](http://code.thejeshgn.com/postbox/raw/tip/docs/postbox_page.png)



