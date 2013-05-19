Short URL
=========

Short URL, base on PHP &amp; MySQL


Setup
=========

 - Create database
 - Setting configurations at /application/config/
 - Setup web server for all requests should be redirected to /index.php
 
   examples at:
   Nginx: /nginx.config
   IIS: /web.config
 
 Usage
=========
 
 build short url
------

 * POST or GET to /api.php with param url 
  
   http://your_short_url_host/api.php?url=your_url
  
 * Then It should response a JSON such as
 
 > {
 >      "status": 1,
 >      "url": "your_url",
 >      "short_url": "http://your_short_url_host/81ce"
 > }

 * Then when visit http://your_short_url_host/81ce, it should redirect to your_url
