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

	class_exists('YouTube') || require_once( dirname(__FILE__) . "/video-sources/youtube.php");
	class_exists('Vimeo') || require_once( dirname(__FILE__) . "/video-sources/vimeo.php");
	class_exists('Veoh') || require_once( dirname(__FILE__) . "/video-sources/veoh.php");
	class_exists('DailyMotion') || require_once( dirname(__FILE__) . "/video-sources/daily-motion.php");
	class_exists('GoogleVideo') || require_once( dirname(__FILE__) . "/video-sources/google-video.php");
	class_exists('MySpace') || require_once( dirname(__FILE__) . "/video-sources/my-space.php");
	class_exists('Youku') || require_once( dirname(__FILE__) . "/video-sources/youku.php");

	if (!class_exists('VideoFactory')) {
		class VideoFactory {
			/**
			 *	Default constructor.
			 */
			function VideoFactory() {
				// do nothing
			}
		
			/**
			 *	Returns the suitable video source.
			 */
			function createVideoSource($url = '') {
				if (strstr($url, "youtube.com")) {
					return new YouTube($url);
				} else if (strstr($url, "vimeo.com")) {
					return new Vimeo($url);
				} else if (strstr($url, "veoh.com")) {
					return new Veoh($url);
				} else if (strstr($url, "dailymotion.com")) {
					return new DailyMotion($url);
				} else if (strstr($url, "googlevideo.com") || strstr($url, "video.google.com")) {
					return new GoogleVideo($url);
				} else if (strstr($url, "myspace.com")) {
					return new MySpace($url);
				} else if (strstr($url, "youku.com")) {
					return new Youku($url);
				}
			}
		}
	}
?>