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

	class_exists('Utils') || require_once(dirname(dirname(__FILE__)) . "/utils.php");

	abstract class VideoSource {
		abstract function getVideoSourceId();
		abstract function getVideoId();
		abstract function getPreviewImageUrl();
		abstract function getComputedVideoUrl();
		abstract function getTitle();
		
		function retrieveEntryFromCache() {
			$cachedEntry = Utils::getCachedVideo($this->getVideoSourceId(), $this->getVideoId());
			if ($this->isCacheTimedOut($cachedEntry)) {
				return '';
			}
			
			return $cachedEntry;
		}
		
		/**
		 *	Returns the cached copy of the preview image url.
		 */
		function retrievePreviewImageFromCache() {
			$cachedEntry = $this->retrieveEntryFromCache();
			
			return $cachedEntry->PREVIEW_IMAGE;
		}
		
		/**
		 *	Returns the cached copy of the title.
		 */
		function retrieveTitleFromCache() {
			$cachedEntry = $this->retrieveEntryFromCache();

			return $cachedEntry->TITLE;
		}
		
		/**
		 *	Returns the cached copy of the video url.
		 */
		function retrieveVideoFromCache() {
			$cachedEntry = $this->retrieveEntryFromCache();

			return $cachedEntry->VIDEO_URL;
		}
		
		/**
		 * Checks if cache is timed out, if it is then removes the cached video.
		 */
		function isCacheTimedOut($cachedEntry) {
			$proPlayerCacheTimeOut = stripslashes(get_option('PRO_PLAYER_CACHE_TIMEOUT'));
			$timePassed = round((strtotime("now") - strtotime($cachedEntry->CREATION_DATE)) / 60);
			
			if (!empty($cachedEntry) && $timePassed > $proPlayerCacheTimeOut) {
				Utils::removeCachedVideo($this->getVideoSourceId(), $this->getVideoId());
				return true;
			}
			
			return false;
		}
	}
?>