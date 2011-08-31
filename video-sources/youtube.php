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
		var $SWFARGS_PATTERN = '#swfArgs\s*=\s*{(.*)};#';		
		var $TOKEN_PATTERN = '#"t":\s*"(.*)"#';
		var $HD_PATTERN = '#isHDAvailable\s*=\s*(.{4,5})#';

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

			//Start the cURL session
			$url = "http://www.youtube.com/get_video_info?video_id=".$this->getVideoId();
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
				parse_str($response);

                return $title;
			}

			return '';
		}
		
		/**
		 *	Returns the computed FLV video url of given video link.
		 */
		function getComputedVideoUrlInternal() {
			$cachedCopy = $this->retrieveVideoFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}
			
			// token's sessions don't match with api :S
			// $url = "http://www.youtube.com/api2_rest?method=youtube.videos.get_video_token&video_id=".$this->getVideoId();
			$url = "http://www.youtube.com/watch?v=".$this->getVideoId();

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
				preg_match($this->HD_PATTERN, $response, $matches);
				
				$isHDAvailable = str_replace(";", "", $matches[1]);
				$format = ($isHDAvailable == "true") ? 22 : 18;
				
				preg_match($this->SWFARGS_PATTERN, $response, $matches);
				$token = $this->getToken($matches[1]);

				$flvUrl = "http://www.youtube.com/get_video?video_id=".$this->getVideoId()."&t=".$token."&fmt=$format";

				// cache the url
				Utils::addCachedVideo(
					$this->getVideoSourceId(), 
					$this->getVideoId(),
					$flvUrl,
					$this->getPreviewImageUrl(),
					$this->getTitle()
				);

                return $flvUrl;
			}

			throw new VideoRetrievalException("Problem with retrieving the video!");
		}
		
		/**
		 *	Returns the computed FLV video url of given video link.
		 */
		function getComputedVideoUrl() {
			$cachedCopy = $this->retrieveVideoFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}
			
			$flvUrl = "http://www.youtube.com/watch?v=".$this->getVideoId();
			
			// cache the url
			Utils::addCachedVideo(
				$this->getVideoSourceId(), 
				$this->getVideoId(),
				$flvUrl,
				$this->getPreviewImageUrl(),
				$this->getTitle()
			);

            return $flvUrl;
		}
		
		function getToken($match = '') {
			$swfArgs = explode(",", $match);

			foreach ($swfArgs as $argument) {
				if (strstr($argument, '"t"')) {
					preg_match($this->TOKEN_PATTERN, $argument, $matches);
					return $matches[1];					
				}
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