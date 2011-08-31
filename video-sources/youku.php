<?php
   // video sources
   class_exists('VideoSource') || require_once(dirname(__FILE__) . "/video-source.php");

   // exceptions
   class_exists('VideoRetrievalException') || require_once(dirname(dirname(__FILE__)) . "/exceptions/video-retrieval-exception.php");

   class Youku extends VideoSource {
      var $url;
      var $response;
      var $hexId;

      var $ID_PATTERN = '#id([_|/]|</em>)(.+?)=#';
      var $HEX_ID_PATTERN = '#sendVideoLink\(.*,\'(.*)\'\);#';
      var $VIDEO_ID_PATTERN = '#videoId2= \'(.+?)=#';
      var $SIZE_PATTERN = '#no":?.+?,"size#';
      var $TITLE_PATTERN = '#"title":"(.*)","key1"#';
      var $PREVIEW_IMAGE_PATTERN = '#"logo":"(.*)","seed"#i';
      var $KEYS_PATTERN = '#key1":"(.+?)","key2":"(.+?)"#';

      /**
       * Default constructor.
       */
      function Youku($url = '') {
         $this->url = $url;
         $hexResponse = $this->getUrlContents($url);

         preg_match($this->HEX_ID_PATTERN, $hexResponse, $matches);
         $this->hexId = $matches[1];

         $this->response = $this->getUrlContents("http://v.youku.com/player/getPlayList/VideoIDS/".$this->getVideoId()."/version/5/source/index");
      }

      /**
       * Returns the cache of the video source.
       */
      function getVideoSourceId() {
          return "YOUKU";
      }

      /**
       * Returns id part of the given url.
       */
      function getVideoId() {
          preg_match($this->ID_PATTERN, $this->url, $matches);
          return stripslashes($matches[count($matches)-1]);
      }

      /**
       * Returns the preview image url of given video link.
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
       * Returns the title of given video link.
       */
      function getTitle() {
         $cachedCopy = $this->retrieveTitleFromCache();
         if (!empty($cachedCopy)) {
            return $cachedCopy;
         }

         preg_match($this->TITLE_PATTERN, $this->response, $matches);
         $title = $matches[1];

         return !empty($title) ? $title : '';
      }

      /**
       * Returns the computed FLV video url of given video link.
       */
      function getComputedVideoUrl() {
         $cachedCopy = $this->retrieveVideoFromCache();
         if (!empty($cachedCopy)) {
            return $cachedCopy;
         }

         preg_match($this->KEYS_PATTERN, $this->response, $matches);
         $key = $this->decrypt($matches[1], $matches[2]);
         $parts = preg_match_all($this->SIZE_PATTERN, $this->response, $test);

         // support playlist files in the future..
          for ($i=0; $i < $parts; $i++) {
              $no = strtoupper(dechex($i));

              if (strlen($no) > 1) {
                  $newId = substr_replace($this->hexId, $no, 8, 2);
              } else {
                  $newId = substr_replace($this->hexId, $no, 9, 1);
              }

              $flvUrl = "http://f.youku.com/player/getFlvPath/sid/00_00/st/flv/fileid/$newId?K=$key";
          }

         if (strstr($flvUrl, "http")) {
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
       *  Returns the decrypted key for Youku video file
       */
      function decrypt($key1 = '', $key2 = '') {
          $key = hexdec($key1) ^ hexdec(A55AA5A5);
          return "$key2".dechex($key);
      }

      function getUrlContents($url = '') {
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

         return $response;
      }
   }


   // Usage:
/*
   $video = new Youku("http://v.youku.com/v_show/id_XMTc1MDUzODQ=.html");
   echo $video->getVideoId()."\n";
   echo $video->getPreviewImageUrl()."\n";
   echo $video->getTitle()."\n";
   echo $video->getComputedVideoUrl()."\n";
*/
?>
