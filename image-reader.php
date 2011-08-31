<?php
   header("Content-type: image/png");

   if (!class_exists("ImageReader")) {
      class ImageReader {
         var $url;

         function ImageReader($url = '') {
            $this->setUrl($url);
         }

         function setUrl($url = '') {
            $this->url = $url;
         }

         function getImage() {
            return urldecode($this->url);
         }
      }
   }

   $imageReader = new ImageReader($_GET["image"]);

   header("Location: ".$imageReader->getImage());
?>
