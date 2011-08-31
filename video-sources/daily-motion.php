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

	class DailyMotion extends VideoSource {
		var $url;
		var $response;
		
		var $ID_PATTERN = '#video/(.{6})(_|<em>)#';
		var $VIDEO_PATTERN = '#media:content url="(.*)" type.*#';
		var $TITLE_PATTERN = '#<title>(.*)</title>#';
		var $PREVIEW_IMAGE_PATTERN = '#media:thumbnail url="(.*)\?.*" height.*#i';
		var $KEY_PATTERN = '#\?key=(.*)#';

		/**
		 *	Default constructor.
		 */
		function DailyMotion($url = '') {
			$this->url = $url;
			$url = "http://www.dailymotion.com/rss/video/".$this->getVideoId();

			//Start the cURL session
			$session = curl_init($url);

			curl_setopt($session, CURLOPT_HEADER, true);
			curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			curl_setopt($session, CURLOPT_FOLLOWLOCATION, false); 
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			
			// Make the call
			$this->response = curl_exec($session);
			$error = curl_error($session);
			curl_close($session);
		}

		/**
		 *	Returns the cache of the video source.
		 */
		function getVideoSourceId() {
		    return "DAILYMOTION";
		}

		/**
		 *	Returns id part of the given url.
		 */
		function getVideoId() {
		    preg_match_all($this->ID_PATTERN, $this->url.'/', $matches);
		    return stripslashes($matches[1][0]);
		}

		/**
		 *	Returns the preview image url of given video link.
		 */
		function getPreviewImageUrl() {
			$cachedCopy = $this->retrievePreviewImageFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}
			
		    preg_match($this->PREVIEW_IMAGE_PATTERN, $this->response, $matches);
		    $previewImage = $matches[1];
		
			return !empty($previewImage) ? $previewImage : '';
		}
		
		/**
		 *	Returns the title of given video link.
		 */
		function getTitle() {
			$cachedCopy = $this->retrieveTitleFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}

			preg_match_all($this->TITLE_PATTERN, $this->response, $matches);
			$title = $matches[1][1];
			
			return !empty($title) ? $title : '';
		}

		/**
		 *	Returns the computed FLV video url of given video link.
		 */
		function getComputedVideoUrl() {
			$cachedCopy = $this->retrieveVideoFromCache();
			if (!empty($cachedCopy)) {
				return $cachedCopy;
			}

			preg_match_all($this->VIDEO_PATTERN, $this->response, $matches);
			$contentUrl = $matches[1][1];
			// preg_match($this->KEY_PATTERN, $contentUrl, $matches);
			// 
			// $flvLocation = get_headers("http://www.dailymotion.com/cdn/FLV-320x240/video/".$this->getVideoId()."?key=".$matches[1], 1);
			// $flvUrl = $flvLocation["Location"];
			
			if (strstr($contentUrl, "http")) {
				// cache the url
				Utils::addCachedVideo(
					$this->getVideoSourceId(), 
					$this->getVideoId(),
					$flvUrl,
					$this->getPreviewImageUrl(),
					$this->getTitle()
				);

				return $contentUrl;
			}

			throw new VideoRetrievalException("Problem with retrieving the video!");
		}
	}

	// Usage:
	
	// $video = new DailyMotion("http://www.dailymotion.com/video/x9oyxt_what-a-week-istanbul-in-timelapse_travel");
	// echo $video->getVideoId()."\n";
	// echo $video->getPreviewImageUrl()."\n";
	// echo $video->getComputedVideoUrl()."\n";
?>