<?php
   if (!class_exists("PlaylistEntry")) {
      class PlaylistEntry {
         var $url;
         var $image;
         var $type;
         var $title;

         function PlaylistEntry($url = '', $image = '', $type = 'video', $title = '') {
            $this->url = $url;
            $this->image = $image;
            $this->type = $type;
            $this->title = $title;
         }

         // Getters..
         function getUrl() {
            return $this->url;
         }

         function getImage() {
            return $this->image;
         }

         function getType() {
            return $this->type;
         }

         function getTitle() {
            return $this->title;
         }
      }
   }
?>
