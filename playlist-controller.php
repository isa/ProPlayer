<?php
   if file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . "/wp-config.php") {
      require_once dirname(dirname(dirname(dirname(__FILE__)))) . "/wp-config.php";
   } else {
      require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/wp-config.php"
   }

   if (!class_exists("PlaylistController")) {
      class PlaylistController {
         var $entries;
         var $tablePrefix;

         // default constructor
         function PlaylistController() {
            global $table_prefix;
            $this->entries = array(array());

            // unfortunately stupid WP doesn't carry these details :S
            $connection = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD);
            mysql_select_db(DB_NAME, $connection);
            $this->tablePrefix = $table_prefix;
         }

         // add to playlist
         function addToPlaylist($id, $entry) {
            $this->entries[$id][] = $entry;
         }

         // return selected playlist as xml
         function generatePlaylist($id = '') {
            $playlist = $this->entries[$id];

            if (is_array($playlist)) {
               $xml = new DOMDocument("1.0", "utf-8");

               $playlistElement = $xml->createElement("playlist");
               $versionAttribute = $xml->createAttribute("version");
               $versionAttribute->appendChild($xml->createTextNode("1"));
               $nsAttribute = $xml->createAttribute("xmlns");
               $nsAttribute->appendChild($xml->createTextNode("http://xspf.org/ns/0/"));
               $playlistElement->appendChild($versionAttribute);
               $playlistElement->appendChild($nsAttribute);
               $xml->appendChild($playlistElement);

               $trackListElement = $xml->createElement("trackList");
               $playlistElement->appendChild($trackListElement);

               foreach ($playlist as $trackEntry) {
                  $trackElement = $xml->createElement("track");

                  $locationElement = $xml->createElement("location");
                  $locationElement->appendChild($xml->createTextNode(urldecode($trackEntry->getUrl())));
                  $trackElement->appendChild($locationElement);

                  $typeElement = $xml->createElement("meta");
                  $typeAttribute = $xml->createAttribute("rel");
                  $typeAttribute->appendChild($xml->createTextNode("type"));
                  $typeElement->appendChild($typeAttribute);
                  $typeElement->appendChild($xml->createTextNode($trackEntry->getType()));
                  $trackElement->appendChild($typeElement);

                  $previewImage = $trackEntry->getImage();
                  if (!empty($previewImage)) {
                     $imageElement = $xml->createElement("image");
                     $imageElement->appendChild($xml->createTextNode($previewImage));
                     $trackElement->appendChild($imageElement);
                  }

                  $title = $trackEntry->getTitle();
                  if (!empty($title)) {
                     $trackTitleElement = $xml->createElement("title");
                     $trackTitleElement->appendChild($xml->createTextNode($title));
                     $trackElement->appendChild($trackTitleElement);
                  }

                  $trackListElement->appendChild($trackElement);
               }

               return $xml->saveXML();
            }

            return '';
         }

         function savePlaylist($id = '') {
            $playlist = $this->generatePlaylist($id);

            // delete the old entry
            mysql_query("DELETE FROM ".$this->tablePrefix."proplayer_playlist WHERE (POST_ID='$id')");

            // save updated entry
            mysql_query("INSERT INTO ".$this->tablePrefix."proplayer_playlist
                           VALUES (
                              '',
                              '$id',
                              '".addslashes($playlist)."'
                           )
            ");

         }

         function getPlaylist($id = '') {
            $query = mysql_query("SELECT * FROM ".$this->tablePrefix."proplayer_playlist WHERE (POST_ID='$id')");
            $playlistRow = mysql_fetch_row($query);

            return $this->withBackwardCompatibility($playlistRow[2]);
         }

         function withBackwardCompatibility($xml = '') {
            $xml = str_ireplace(">3g2<", ">video<", $xml);
            $xml = str_ireplace(">3gp<", ">video<", $xml);
            $xml = str_ireplace(">aac<", ">video<", $xml);
            $xml = str_ireplace(">f4b<", ">video<", $xml);
            $xml = str_ireplace(">f4p<", ">video<", $xml);
            $xml = str_ireplace(">f4v<", ">video<", $xml);
            $xml = str_ireplace(">flv<", ">video<", $xml);
            $xml = str_ireplace(">m4a<", ">video<", $xml);
            $xml = str_ireplace(">m4v<", ">video<", $xml);
            $xml = str_ireplace(">sdp<", ">video<", $xml);
            $xml = str_ireplace(">vp6<", ">video<", $xml);
            $xml = str_ireplace(">mov<", ">video<", $xml);
            $xml = str_ireplace(">mp4<", ">video<", $xml);
            $xml = str_ireplace(">mp3<", ">sound<", $xml);
            $xml = str_ireplace(">rbs<", ">sound<", $xml);
            $xml = str_ireplace(">png<", ">image<", $xml);
            $xml = str_ireplace(">gif<", ">image<", $xml);
            $xml = str_ireplace(">jpg<", ">image<", $xml);
            $xml = str_ireplace(">jpeg<", ">image<", $xml);
            $xml = str_ireplace(">swf<", ">image<", $xml);

            return $xml;
         }
      }
   }

   $playlistController = new PlaylistController();

   if (!empty($_GET["pp_playlist_id"])) {
      header("Content-type: application/xml");
      $xml = $playlistController->getPlaylist(mysql_real_escape_string($_GET["pp_playlist_id"]));

      if (!empty($xml)) {
         print $xml;
      } else {
         // video is not accessible
         $wwwDirInfo = parse_url(!empty($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : $_SERVER["SCRIPT_NAME"]);
         $errorImage = str_replace("playlist-controller.php", "not-accessible.png", $wwwDirInfo["path"]);
         print trim("
            <?xml version='1.0' encoding='utf-8'?>
            <playlist xmlns='http://xspf.org/ns/0/' version='1'>
               <trackList>
                  <track>
                     <location>$errorImage</location>
                     <meta rel='type'>image</meta>
                     <image>$errorImage</image>
                  </track>
               </trackList>
            </playlist>
         ");
      }

      die;
   }
?>
