#Welcome
This is the actual application which end use can use for searching the postboxes in India. Read my introductory blog post [Instgram for Crowdsourcing Postbox Locations](http://thejeshgn.com/2012/10/16/instgram-for-crowdsourcing-postbox-locations/) for more details on this project.


## Install and run
`
 git clone https://github.com/datameet/openpostbox openpostbox

 cd openpostbox/html
 
 php -S localhost:8080
`

## Completed Tasks
+ Project setup
+ Scraping the data from instagram (batch)
+ Display of individual postbox page
+ Move to version there of [FatFreeFramework](http://fatfreeframework.com/)
+ Search by pincode
+ Map views for pincode
+ List by user

## Working on
+ Store the pictures(instagrams) on s3
+ Add twitter integration
+ Add ODK integration


## Future 
+ Add geohash for each postbox as part of reverse geo coding
+ Search by Location (given lat long using geohash)
+ Search by Location (Give an actual address using geohash)
+ Reverse Geo code for city, state (batch)
+ Add Notes/comments to each postboxpage
+ JSON - API (end postbox, pincode by /geojson and resturn geojson)
+ Pincode tag cloud

##Note
The same application can be used for any other instagram project. Say mapping dustbins or bus stops etc with very little change. Let me know if you plan to use it.

> if you are serious about running this project locally then get your own [Instagram API keys](http://instagram.com/developer/) and replace it in [instagram.php](https://github.com/datameet/openpostbox/blob/master/inc/instagram.php). As of now it uses my id. Please don't abuse.

##Signed by me
All release are gpg signed by me using 0XBFFC8DD3C06DD6B0.

##Screen shots
![Initial screen](https://raw.githubusercontent.com/datameet/openpostbox/master/docs/postbox_page.png)



