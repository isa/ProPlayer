<?php
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
       * Returns the cached copy of the preview image url.
       */
      function retrievePreviewImageFromCache() {
         $cachedEntry = $this->retrieveEntryFromCache();

         return $cachedEntry->PREVIEW_IMAGE;
      }

      /**
       * Returns the cached copy of the title.
       */
      function retrieveTitleFromCache() {
         $cachedEntry = $this->retrieveEntryFromCache();

         return $cachedEntry->TITLE;
      }

      /**
       * Returns the cached copy of the video url.
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
