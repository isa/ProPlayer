<?php
   if (!class_exists("AttributeResolver")) {
      class AttributeResolver {
         var $content;
         var $PLUGIN_URL;

         var $WIDTH_PATTERN = "/width\s*=\s*([\"\'])\s*\d+\s*([\"\'])/i";
         var $HEIGHT_PATTERN = "/height\s*=\s*([\"\'])\s*\d+\s*([\"\'])/i";
         var $TYPE_PATTERN = "/type\s*=\s*([\"\'])\s*[a-zA-Z0-9\-]+\s*([\"\'])/i";
         var $REPEAT_PATTERN = "/repeat\s*=\s*([\"\'])\s*\w+\s*([\"\'])/i";
         var $AUTO_START_PATTERN = "/autostart\s*=\s*([\"\'])\s*\w+\s*([\"\'])/i";
         var $IMAGE_PATTERN = "/image\s*=\s*([\"\'])\s*.+\s*([\"\'])/i";
         var $RTMP_PATTERN = "/rtmp\s*=\s*([\"\'])\s*.+\s*([\"\'])/i";

         function AttributeResolver($content = '') {
            $this->content = $content;
            $this->PLUGIN_URL = WP_PLUGIN_URL."/proplayer";
         }

         // return explicit video width argument's value
         function getVideoWidth() {
            preg_match($this->WIDTH_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(width=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return get_option("PRO_PLAYER_WIDTH");
         }

         // return explicit video height argument's value
         function getVideoHeight() {
            preg_match($this->HEIGHT_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(height=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return get_option("PRO_PLAYER_HEIGHT");
         }

         // return explicit video type argument's value
         function getVideoType() {
            preg_match($this->TYPE_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(type=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return get_option("PRO_PLAYER_TYPE");
         }

         // return explicit repeat argument's value
         function getVideoRepeat() {
            preg_match($this->REPEAT_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(repeat=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return get_option("PRO_PLAYER_REPEAT");
         }

         // return explicit autostart argument's value
         function getVideoAutoStart() {
            preg_match($this->AUTO_START_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(autostart=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return get_option("PRO_PLAYER_AUTO_START");
         }

         // return explicit rtmp argument's value
         function getRtmpServer() {
            preg_match($this->RTMP_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(rtmp=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return '';
         }

         // tries to get image attribute given with [pro-player] tags
         // if not returns the default preview image from the options.
         function resolvePreviewImage() {
             $previewImage = $this->getImage();

            if (empty($previewImage) && get_option("PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE") == "true") {
               $previewImage = $this->PLUGIN_URL."/image-reader.php?image=".get_option("PRO_PLAYER_DEFAULT_PREVIEW_IMAGE");
            }

            return $previewImage;
         }

         // return explicit video image argument's value
         function getImage() {
            preg_match($this->IMAGE_PATTERN, $this->content, $match);

            if (!empty($match[0])) {
               return preg_replace("(image=)", "", preg_replace("/[\ \'\"]*/", "", $match[0]));
            }

            return '';
         }

      }
   }
?>
