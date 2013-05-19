Short URL
=========

Short URL, base on PHP &amp; MySQL


Setup
=========

 - Create database
 - Setup your host configurations at /application/config/
 - Setup web server for all requests should be redirected to /index.php
 
   examples at: <br>
   Nginx: /nginx.config <br>
   IIS: /web.config <br>
 
 Usage
=========
 
 build short url
------

 * POST or GET to /api.php with param url 
  
   http://your_short_url_host/api.php?url=your_url
  
 * Then It should response a JSON such as
 
 > { <br>
 >      "status": 1, <br>
 >      "url": "your_url", <br>
 >      "short_url": "http://your_short_url_host/81ce" <br>
 > } 

 * When visit http://your_short_url_host/81ce, it should redirect to your_url
