<?php
/*
	@author 	Mansimran Singh
	@website 	mansimransingh.com
	@email		me@mansimransingh.com
	@version 	1.0
	Dependencies: tmhOAuth by themattharris
	
	This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
	<http://creativecommons.org/licenses/by-nc-sa/3.0/deed.en_US>
*/
require 'tmhOAuth.php';

class TweetCache {
	//filename, expiry in hours, number of tweets
	public function __construct($config) {
		$this->config = array_merge(
		array(
			//specify filename; useful for multiple instances and multiple twitter accounts/feeds
			'fileName' 					=> 'tweetCache.txt',
			//expiration time in hours
			'expire' 					=> 1,
			//twitter name
			'twitterName' 				=> 'msingh_5',
			//number of tweets to fetch
			'numberOfTweets' 			=> 10,
			'consumer_key'              => 'YOUR_KEY',
			'consumer_secret'           => 'YOUR_SECRET',
			'user_token'                => 'YOUR_USER_TOKEN',
			'user_secret'               => 'YOUR_USER_SECRET',		
		), $config);
		
		if($this->config['consumer_secret'] == "" 
			|| $this->config['consumer_key'] == ""
			|| $this->config['user_token'] == ""
			|| $this->config['user_secret'] == ""){
				exit('Invalid params!');
			}
		
		if(!$this->checkFileExists()){
			$this->writeData();
		}
	}
	
	private function checkFileExists(){
		if(file_exists($this->config['fileName'])){ return true; }
		return false;
	}
	
	private function writeData($data = array('expire'=>0,'response'=>'')){
		file_put_contents($this->config['fileName'],json_encode($data));
	}
	
	private function readData(){
		return file_get_contents($this->config['fileName']);
	}
	
	public function getTweets(){
		$data = $this->readData();
		$data = json_decode($this->readData(),TRUE);
		$expire = $data['expire'];
		$response = $data['response'];
		$difference = time() - $expire;	
		
		if($difference > $this->config['expire']*3600){
			//the tweets have expired, we must create new tweets
			//save these tweets and return the response
			$tmhOAuth = new tmhOAuth(array(
					'consumer_key'               => $this->config['consumer_key'],
					'consumer_secret'            => $this->config['consumer_secret'],
					'user_token'                 => $this->config['user_token'],
					'user_secret'                => $this->config['user_secret'],
			));
			$code = $tmhOAuth->request(
						'GET', 
						$tmhOAuth->url('1.1/statuses/user_timeline'), 
						array(
							'screen_name' => $this->config['twitterName'], 
							'include_rts' => true, 
							'include_entities' => true, 
							'count' => $this->config['numberOfTweets']
							)
						);
			$response = $tmhOAuth->response;
			$response = $response['response'];
			$this->writeData(array('expire'=>time(),'response'=>$response));
		} 
		return $response;
	}
}
?>