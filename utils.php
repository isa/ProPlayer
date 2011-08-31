<?php
   class Utils {
      var $url;

      /**
       * Finds the key in given multi-dimensional array.
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
       * Returns the cached video from database.
       */
      public static function getCachedVideo($videoSource = '', $videoId) {
         global $wpdb;
         return $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."proplayer WHERE (VIDEO_SOURCE='$videoSource') AND (VIDEO_ID='$videoId')");
      }


      /**
       * Adds a video to the cache table.
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
       * Removes video from the cache table.
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
