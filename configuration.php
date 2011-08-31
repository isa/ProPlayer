<?php
   if (!class_exists('Configuration')) {
      class Configuration {
         var $flashvars;
         var $params;
         var $others;

         function Configuration($flashvars = array(), $params = array(), $others = array()) {
            $this->flashvars = $flashvars;
            $this->params = $params;
            $this->others = $others;
         }

         function addFlashVar($key, $value) {
            $this->flashvars[$key] = $value;
         }

         function addParam($key, $value) {
            $this->params[$key] = $value;
         }

         function addOther($key, $value) {
            $this->others[$key] = $value;
         }

         function getFlashVars() {
            return $this->flashvars;
         }

         function getParams() {
            return $this->params;
         }

         function getOthers() {
            return $this->others;
         }
      }
   }
?>
