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

	class Utils {
		var $url;
		
		/**
		 *	Finds the key in given multi-dimensional array.
		 */
		public static function findByKey($array = array(), $searchKey = '') {
			while (list($key, $value) = each($array)) {
				if ($key == $searchKey) {
					return $value;
				}
			}
			
			return '';
		}
		
		/**
		 *	Returns the cached video from database.
		 */
		public static function getCachedVideo($videoSource = '', $videoId) {
			global $wpdb;
			return $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."proplayer WHERE (VIDEO_SOURCE='$videoSource') AND (VIDEO_ID='$videoId')");
		}
		
		
		/**
		 *	Adds a video to the cache table.
		 */
		public static function addCachedVideo($videoSource = '', $videoId = '', $videoUrl = '', $previewImage = '', $title = 'Pro Player') {
			global $wpdb;
			return $wpdb->query("INSERT INTO ".$wpdb->prefix."proplayer 
										VALUES (
											'',
											'$videoSource', 
											'$videoId',
											'$videoUrl',
											'$previewImage',
											'".addslashes($title)."',
											'".date("Y-m-d H:i:s", strtotime("now"))."'
										)
				   ");
		}
		
		/**
		 *	Removes video from the cache table.
		 */
		public static function removeCachedVideo($videoSource = '', $videoId = '') {
			global $wpdb;
			return $wpdb->query("DELETE FROM ".$wpdb->prefix."proplayer 
										WHERE (
											(VIDEO_SOURCE = '$videoSource')
											AND (VIDEO_ID = '$videoId')
										)										
				   ");
		}
	}
?>