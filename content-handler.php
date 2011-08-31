<?php
   require dirname(__FILE__) . "/playlist-controller.php";
   require dirname(__FILE__) . "/video-factory.php";
   require dirname(__FILE__) . "/playlist-entry.php";

   if (!class_exists("ContentHandler")) {
      class ContentHandler {
         var $VIDEO_URL_PATTERN = "/\](.*)\[/i";
         var $SUPPORTED_SOURCES = array("youtube.com", "vimeo.com", "veoh.com", "dailymotion.com", "google.com", "googlevideo.com", "myspace.com", "youku.com");
         var $PLUGIN_URL;

         // playlist controller
         var $playlistController;

         // default constructor
         function ContentHandler() {
            global $wpdb;

            $this->playlistController = new PlaylistController();
            $this->PLUGIN_URL = WP_PLUGIN_URL."/proplayer";
         }

         // check if the url is one of the supported one
         function isSupportedUrl($url = '') {
            if (!empty($url)) {
               foreach ($this->SUPPORTED_SOURCES as $source) {
                  if (strstr($url, $source)) {
                     return true;
                  }
               }
            }

            return false;
         }

         // future releases will be able to pass their own title, image and type; right now they will be all same
         function addFileAttributes($id = '', $videoURL = '', $type = 'video', $defaultImage = '') {
            $fileAttributes = "";
            $urlList = split(",\s*", $videoURL);
            $image = $defaultImage;

            foreach ($urlList as $url) {
               if (strstr($url, "youtube.com") && strstr($url, "list?p")) {
                  // process YouTube playlist
                  $this->processYouTubePlaylist($id, $url, $type);
               } else {
                  if ($this->isSupportedUrl($url)) {
                     $videoFactory = new VideoFactory();
                     $videoSource = $videoFactory->createVideoSource($url);

                     // get the online video source link
                     try {
                        if (strstr($url, "youtube.com")) {
                           // leave the url as same and just set the type
                           $type = "youtube";
                        }

                        $url = $videoSource->getComputedVideoUrl();
                        if (strstr(get_option('PRO_PLAYER_DEFAULT_PREVIEW_IMAGE'), $defaultImage)) {
                           $image = $videoSource->getPreviewImageUrl();
                        }
                        $title = $videoSource->getTitle();
                     } catch (Exception $e) {
                         $url = '';
                     }
                  }

                  if (!empty($url)) {
                     $entry = new PlaylistEntry($url, $image, $type, $title);
                     $this->playlistController->addToPlaylist($id, $entry);
                  }
               }
            }

            $this->playlistController->savePlaylist($id);
            $fileAttributes = "file: '".$this->PLUGIN_URL."/playlist-controller.php?pp_playlist_id=".$id."&sid=".strtotime("now")."'";

            return $fileAttributes;
         }

         function processYouTubePlaylist($id = '', $url = '', $type = 'video') {
            $url = str_replace('</em>', '_', str_replace('<em>', '_', $url));
            $session = curl_init($url);

            curl_setopt($session, CURLOPT_HEADER, true);
            curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
            curl_setopt($session, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

            // Make the call
            $response = curl_exec($session);
            $error = curl_error($session);

            if (empty($error)) {
               preg_match_all("#href.*watch.{1}v=(.*)&feature#i", $response, $matches);
               $matches = array_unique($matches[1]);

               if (count($matches) > 0) {
                  $videoUrl = "http://www.youtube.com/watch?v=";
               }

               foreach ($matches as $match) {
                  // get the online video source link

                  $videoFactory = new VideoFactory();
                  $videoSource = $videoFactory->createVideoSource($videoUrl.$match);

                  try {
                     $image = $videoSource->getPreviewImageUrl();
                     $title = $videoSource->getTitle();
                     $currentUrl = $videoSource->getComputedVideoUrl();
                  } catch (Exception $e) {
                      $currentUrl = '';
                  }

                  if (!empty($currentUrl)) {
                     $entry = new PlaylistEntry($currentUrl, $image, "youtube", $title);
                     $this->playlistController->addToPlaylist($id, $entry);
                  }
               }
            }
         }
      }
   }
?>
