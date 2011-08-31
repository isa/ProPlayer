<?php
   // video sources
   class_exists('VideoSource') || require_once(dirname(__FILE__) . "/video-source.php");

   // exceptions
   class_exists('VideoRetrievalException') || require_once(dirname(dirname(__FILE__)) . "/exceptions/video-retrieval-exception.php");

   class GoogleVideo extends VideoSource {
      var $url;
      var $response;

      var $ID_PATTERN = '#docid=(.+)&.*#';
      var $VIDEO_PATTERN = '#<a href=[\'"]*(.*)[\'"]*>this link</a>#i';
      var $TITLE_PATTERN = '#<title>(.*)</title>#i';
      var $PREVIEW_IMAGE_PATTERN = '#(http://[\w\d\.]+gvt[^\s\"]+)%3D#i';

      /*
         Default constructor.
      */
      function GoogleVideo($url = '') {
         $this->url = $url;
         $session = curl_init($url);

         curl_setopt($session, CURLOPT_HEADER, true);
         curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
         curl_setopt($session, CURLOPT_FOLLOWLOCATION, false);
         curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

         $this->response = curl_exec($session);
         $error = curl_error($session);

         curl_close($session);
      }

      /**
       * Returns the cache of the video source.
       */
      function getVideoSourceId() {
          return "GOOGLEVIDEO";
      }

      /*
         Returns id part of the given url.
      */
      function getVideoId() {
          preg_match($this->ID_PATTERN, $this->url, $matches);
          return $matches[1];
      }

      /*
         Returns the preview image url of given video link.
      */
      function getPreviewImageUrl() {
         $cachedCopy = $this->retrievePreviewImageFromCache();
         if (!empty($cachedCopy)) {
            return $cachedCopy;
         }

         preg_match_all($this->PREVIEW_IMAGE_PATTERN, $this->response, $matches);

         $flvUrl = trim($matches[0][0]);

         if (strstr($flvUrl, "http://")) {
            return urldecode($flvUrl).$this->getVideoId();
         }

         return '';
      }

      /**
       * Returns the title of given video link.
       */
      function getTitle() {
         $cachedCopy = $this->retrieveTitleFromCache();
         if (!empty($cachedCopy)) {
            return $cachedCopy;
         }

         preg_match_all($this->TITLE_PATTERN, $this->response, $matches);
         $title = $matches[1][0];

         return !empty($title) ? $title : '';
      }

      /*
         Returns the computed FLV video url of given video link.
      */
      function getComputedVideoUrl() {
         $cachedCopy = $this->retrieveVideoFromCache();
         if (!empty($cachedCopy)) {
            return $cachedCopy;
         }

         preg_match_all($this->VIDEO_PATTERN, $this->response, $matches);
         $flvUrl = trim($matches[1][0]);

         if (strstr($flvUrl, "http://")) {
            $flvUrl = urldecode($flvUrl);

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
   }

/*
   // Usage:
   $video = new GoogleVideo("http://video.google.com/videoplay?docid=-4593856023146493852&hl=en");
// $video = new GoogleVideo("http://video.google.com/videoplay?docid=-3054974855576235846&hl=en");
   echo $video->getVideoId()."\n";
   echo $video->getPreviewImageUrl()."\n";
   echo $video->getComputedVideoUrl()."\n";
*/
?>
