<?php 
/*
	Demo file for tweetCache.php
	
	@author 	Mansimran Singh
	@website 	mansimransingh.com
	@email		me@mansimransingh.com
	@version 	1.0
	Dependencies: tmhOAuth by themattharris
	
	This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
	<http://creativecommons.org/licenses/by-nc-sa/3.0/deed.en_US>
*/
require 'TweetCache.php';

$config = array(
		//'fileName'				=> 'tweetCache.txt',
		'twitterName'				=> 'msingh_5',
		'numberOfTweets'			=> 5,
		//'expire' 					=> 1,
		'consumer_key'              => 'YOUR_CONSUMER_KEY',
		'consumer_secret'           => 'YOUR_CONSUMER_SECRET',
		'user_token'                => 'YOUR_USER_TOKEN',
		'user_secret'               => 'YOUR_USER_SECRET',
	);

$tweetCache = new TweetCache($config);
$tweets = $tweetCache->getTweets();
echo $tweets;
?>