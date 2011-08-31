<?php
/*
	Software License Agreement (BSD License)

	Copyright (c) 2009, Isa Goksu [ info@isagoksu.com ]
	All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	    * Redistributions of source code must retain the above copyright
	      notice, this list of conditions and the following disclaimer.
	    * Redistributions in binary form must reproduce the above copyright
	      notice, this list of conditions and the following disclaimer in the
	      documentation and/or other materials provided with the distribution.
	    * Neither the name of the <organization> nor the
	      names of its contributors may be used to endorse or promote products
	      derived from this software without specific prior written permission.

	THIS SOFTWARE IS PROVIDED BY Isa Goksu ''AS IS'' AND ANY
	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL Isa Goksu BE LIABLE FOR ANY
	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

	// video sources
	class_exists('VideoSource') || require_once(dirname(__FILE__) . "/video-source.php");
	
	// exceptions
	class_exists('VideoRetrievalException') || require_once(dirname(dirname(__FILE__)) . "/exceptions/video-retrieval-exception.php");

	class YouTube extends VideoSource {
		var $url;
		var $proxyUrl;
		
		var $ID_PATTERN = '#v=(.+)&*#';
		var $TOKEN_PATTERN = '#<t>(.*)</t>#i';
		var $KTUNNEL_PATTERN = '#myArray\[\d{1}\]\s*=\s*\'(.*)\'#';
		var $ACTION_PATTERN = '#action="(.*)"#';
		var $VIDEO_INFO_PATTERN = '#myArray\[5\]\s*=\s*\'(.*)\'#';
		var $VIDEO_URL_PATTERN = '#file=(.*)%26#';
		var $MOVED_TEMPORARILY_PATTERN = '#302 Moved Temporarily#i';
		var $LOCATION_PATTERN = '#Location: (.*)\n#i';
		
		var $PROXIES = array(
						"http://ktunnel.com",
						"http://ltunnel.com",
						"http://safeforwork.net",
						"http://ctunnel.com",
						"http://apbiology.info",
						"http://unblock8e6.com",
						"http://polysolve.com",
						"http://ktunnel.net",
						"http://dtunnel.com",
						"http://ztunnel.com"
					   );
		
		/**
		 *	Default constructor.
		 */
		function YouTube($url = '') {
			$this->url = $url;
			srand((double) microtime() * 1234567);
			srand((double) microtime() * rand(1000000, 9999999));
			$this->proxyUrl = $this->PROXIES[rand (0, 9)];
		}

		/**
		 *	Returns the cache of the video source.
		 */
		function getVideoSourceId() {
		    return "YOUTUBE";
		}

		/**
		 *	Returns id part of the given url.
		 */
		function getVideoId() {
		    preg_match($this->ID_PATTERN, $this->url, $matches);
		    return $matches[1];
		}
		
		/**
		 *	Returns the preview image url of given video link.
		 */
		function getPreviewImageUrl() {
			$cachedCopy = $this->retrievePreviewImageFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}

			return "http://i.ytimg.com/vi/".$this->getVideoId()."/0.jpg";
		}
		
		/**
		 *	Returns the title of given video link.
		 */
		function getTitle() {
			$cachedCopy = $this->retrieveTitleFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}

			return 'Pro Player';
		}
		
		/**
		 *	Returns the computed FLV video url of given video link.
		 */
		function getComputedVideoUrl() {
			$cachedCopy = $this->retrieveVideoFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}

		    $url = $this->proxyUrl;

			//Start the cURL session
			$session = curl_init($url);

			curl_setopt($session, CURLOPT_HEADER, true);
			curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			curl_setopt($session, CURLOPT_FOLLOWLOCATION, false); 
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

			// Make the call
			$response = curl_exec($session);
			$error = curl_error($session);
			curl_close($session);

			// if there is no error
			if (empty($error)) {
				preg_match_all($this->KTUNNEL_PATTERN, $response, $matches);

				$proxy = $this->constructProxy($matches);
				$videoInfo = $this->retrieveVideoInfoThroughProxy($proxy);
				
				return $videoInfo;
			}

			throw new VideoRetrievalException("Problem with retrieving the video!");
		}

		/**
		 * Constructs the proxy for YouTube access.
		 */
		function constructProxy($matches = array()) {
			$result = "";

			foreach ($matches[1] as $match) {
				if (strlen($match) > 22) {
					$result .= $this->decrypt($match);
				}
			}
			
			return urldecode($result);
		}
		
		/**
		 * Decrypts the encrypted request.
		 */
		function decrypt($encrypted = '') {
			$dst = ""; 
			$len = strlen($encrypted); 
			
			if ($len > 0) { 
				for ($ctr = 0; $ctr < $len ; $ctr++) { 
					$b = ord(substr($encrypted, $ctr, 1));
					
					if ((($b > 64) && ($b < 78)) || (($b > 96) && ($b < 110))) {
						$b = $b + 13;
					} else {
						if ((($b > 77) && ($b < 91)) || (($b > 109) && ($b < 123))) {
							$b = $b - 13;
						}
					}
					
					$t = chr($b);
					$dst .= $t;
				} 
			}
			
			return $dst;
		}
		
		/**
		 * Retrieves the video through randomly selected proxy.
		 */
		function retrieveVideoInfoThroughProxy($proxy = '') {
			preg_match($this->ACTION_PATTERN, $proxy, $matches);
			$proxySession = curl_init($matches[1]);

			curl_setopt($proxySession, CURLOPT_HEADER, true);
			curl_setopt($proxySession, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			curl_setopt($proxySession, CURLOPT_POST, 1);
			curl_setopt($proxySession, CURLOPT_POSTFIELDS, "r4=checked&rs=true&br=true&if=true&username=".$this->url);
			curl_setopt($proxySession, CURLOPT_REFERER, $this->proxyUrl);
			curl_setopt($proxySession, CURLOPT_FOLLOWLOCATION, false); 
			curl_setopt($proxySession, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($proxySession);
			$error = curl_error($proxySession);
			curl_close($proxySession);		
			
			// server might move the content to some other location, 
			preg_match($this->MOVED_TEMPORARILY_PATTERN, $response, $movedTemporarilyMatches);
			
			while (!empty($movedTemporarilyMatches[0])) {
				preg_match($this->LOCATION_PATTERN, $response, $locationMatches);
				$proxySession = curl_init($locationMatches[1]);

				curl_setopt($proxySession, CURLOPT_HEADER, true);
				curl_setopt($proxySession, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
				curl_setopt($proxySession, CURLOPT_POST, 1);
				curl_setopt($proxySession, CURLOPT_POSTFIELDS, "r4=checked&rs=true&br=true&if=true&username=".$this->url);
				curl_setopt($proxySession, CURLOPT_REFERER, $this->proxyUrl);
				curl_setopt($proxySession, CURLOPT_FOLLOWLOCATION, false); 
				curl_setopt($proxySession, CURLOPT_RETURNTRANSFER, true);
				
				$response = curl_exec($proxySession);
				$error = curl_error($proxySession);
				curl_close($proxySession);		

				preg_match($this->MOVED_TEMPORARILY_PATTERN, $response, $movedTemporarilyMatches);
			}
			
			// if there is no error
			if (empty($error)) {
				preg_match($this->VIDEO_INFO_PATTERN, $response, $videoInfoMatches);				
				$result = $this->decrypt($videoInfoMatches[1]);
				
				preg_match($this->VIDEO_URL_PATTERN, $result, $videoUrlMatches);

				// cache the url
				Utils::addCachedVideo(
					$this->getVideoSourceId(), 
					$this->getVideoId(),
					$videoUrlMatches[1],
					$this->getPreviewImageUrl()
				);

				return $videoUrlMatches[1];
			}
			
			return '';
		}
	}

/*
	// Usage:
	
	// $video = new YouTube("http://www.youtube.com/watch?v=2YAvfxA6a94");
	$video = new YouTube("http://www.youtube.com/watch?v=yoDOjVpFOe0");
	echo $video->getVideoId()."\n";
	echo $video->getPreviewImageUrl()."\n";
	echo $video->getComputedVideoUrl()."\n";
*/
?>