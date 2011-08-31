<?php
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
          * Default constructor.
          */
         function VideoFactory() {
            // do nothing
         }

         /**
          * Returns the suitable video source.
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
