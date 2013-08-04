<!DOCTYPE html>
<!-- new server -->
<html>
    <head>
        <meta charset="utf-8">
        <title>Tweet Cache</title>
        <link href='http://fonts.googleapis.com/css?family=Lato:400|Lobster' rel='stylesheet' type='text/css'>
        <style>
		* {text-shadow: 0 1px 1px rgba(255,255,255,.3);padding:0;margin:0;}
		body {width:100%;color:#666;font-family: 'Lato', sans-serif; -webkit-font-smoothing: antialiased;
			 font-smoothing: antialiased;font-weight:400;text-align:center;margin-top:15%;}
		h1{font-size:4em;font-family: 'Lobster', cursive;padding:0;margin:0}
		a:link,a:visited{color:#666;text-decoration:none;}
		a:hover{text-decoration:underline;}
		p{margin:0; }
		p.social{margin:0.67em 0;}
		#twitter_update_list {list-style-type:circle;max-width:500px;margin:0 auto;text-align:left;margin-top:1em;}
		#twitter_update_list li {position:relative;padding-bottom:2em;}
		#twitter_update_list li span + a {position:absolute;right:0;bottom:1em;}
		</style>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			//get tweets
			$.getJSON("getTweets.php", function(data) {
				//pass data to blogger.js functions to display
				twitterCallback2(data);
			});
		});
		/*
		Blogger.js functions
		SRC: https://twitter.com/javascripts/blogger.js
		*/
		function twitterCallback2(twitters) {
		  var statusHTML = [];
		  for (var i=0; i<twitters.length; i++){
			var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			  return '<a href="'+url+'">'+url+'</a>';
			}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
			});
			statusHTML.push('<li><span>'+status+'</span> <a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');
		  }
		  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
		  console.log(statusHtml.join(''));
		}

		function relative_time(time_value) {
		  var values = time_value.split(" ");
		  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		  var parsed_date = Date.parse(time_value);
		  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		  delta = delta + (relative_to.getTimezoneOffset() * 60);

		  if (delta < 60) {
			return 'less than a minute ago';
		  } else if(delta < 120) {
			return 'about a minute ago';
		  } else if(delta < (60*60)) {
			return (parseInt(delta / 60)).toString() + ' minutes ago';
		  } else if(delta < (120*60)) {
			return 'about an hour ago';
		  } else if(delta < (24*60*60)) {
			return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
		  } else if(delta < (48*60*60)) {
			return '1 day ago';
		  } else {
			return (parseInt(delta / 86400)).toString() + ' days ago';
		  }
		}
		</script>
    </head>
	<body>
	<h1>Tweet Cache</h1>
	<p>by <a href="http://mansimransingh.com">mansimran singh</a></p>
	<ul id="twitter_update_list">
		<li><p>loading weets</p></li>
		<li><p>if your tweets do not load, please ensure you have downloaded <a href="https://github.com/themattharris/tmhOAuth" target="_blank">tmhOAuth</a> by <a href="https://github.com/themattharris/">themattharris</a><br /> and filled out your keys/secrets in getTweets.php</p></li>
	</ul>
	<p>view on <a href="https://github.com/mansimransingh/TweetCache">github</a></p>
	</body>
</html>
		
		
