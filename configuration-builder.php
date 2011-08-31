<?php
/*
	Software License Agreement (BSD License)

	Copyright (c) 2009, Isa Goksu [ info@isagoksu.com ]
	All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	    * Redistributions of source code must retain the above copyright
	      notice, this list of conditions and the following disclaimer.
	    * Redistributions in binary form must reproduce the above copyright
	      notice, this list of conditions and the following disclaimer in the
	      documentation and/or other materials provided with the distribution.
	    * Neither the name of the <organization> nor the
	      names of its contributors may be used to endorse or promote products
	      derived from this software without specific prior written permission.

	THIS SOFTWARE IS PROVIDED BY Isa Goksu ''AS IS'' AND ANY
	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL Isa Goksu BE LIABLE FOR ANY
	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
	
	require dirname(__FILE__) . '/constants.php';
	require dirname(__FILE__) . '/configuration.php';

	if (!class_exists('ConfigurationBuilder')) {
		class ConfigurationBuilder {
			var $attrs;
			var $PARAM_KEYS;
			var $OTHER_KEYS;
			var $PLUGIN_URL;
			
			function ConfigurationBuilder($attrs = array()) {
				$this->PLUGIN_URL = WP_PLUGIN_URL."/proplayer";
				$this->attrs = $attrs;
				
				$this->PARAM_KEYS = array(
					Constants::$WMODE_KEY, 
					Constants::$ALLOW_FULLSCREEN_KEY, 
					Constants::$ALLOW_SCRIPT_ACCESS_KEY, 
					Constants::$ALLOW_NETWORKING_KEY
				);
				
				$this->OTHER_KEYS = array(Constants::$AD_SCRIPT_KEY);
			}
			
			function build() {
				$configuration = new Configuration(
					$this->getDefaultFlashVars(), 
					$this->getDefaultParams(), 
					$this->getOtherValues()
				);
				
				error_reporting(0);
				foreach($this->attrs as $key => $value) {
					if (in_array($key, $this->PARAM_KEYS)) {
						$oldValues = $configuration->getParams();
						$configuration->addParam($key, $this->getKeyValue($key, $oldValues[$key]));
					} else if (in_array($key, $this->OTHER_KEYS)) {
						$oldValues = $configuration->getOthers();
						$configuration->addOther($key, $this->getKeyValue($key, $oldValues[$key]));
					} else {
						$oldValues = $configuration->getFlashVars();
						$configuration->addFlashVar($key, $this->getKeyValue($key, $oldValues[$key]));
					}
				}
				
				return $configuration;
			}
			
			function getKeyValue($key, $default = '') {
				if (@array_key_exists($key, $this->attrs)) {
					return $this->attrs[$key];
				}
				
				return $default;
			}
			
			function getDefaultFlashVars() {
				$flashvars = array();
				
				$flashvars[Constants::$WIDTH_KEY] = get_option('PRO_PLAYER_WIDTH');
				$flashvars[Constants::$HEIGHT_KEY] = get_option('PRO_PLAYER_HEIGHT');
				$flashvars[Constants::$FILE_TYPE_KEY] = get_option('PRO_PLAYER_TYPE');
				$flashvars[Constants::$AUTO_START_KEY] = get_option('PRO_PLAYER_AUTO_START');
				$flashvars[Constants::$REPEAT_KEY] = get_option('PRO_PLAYER_REPEAT');
				$flashvars[Constants::$BACKGROUND_COLOR_KEY] = get_option('PRO_PLAYER_BACKCOLOR');
				$flashvars[Constants::$FOREGROUND_COLOR_KEY] = get_option('PRO_PLAYER_FRONTCOLOR');
				$flashvars[Constants::$LIGHT_COLOR_KEY] = get_option('PRO_PLAYER_LIGHTCOLOR');
				$flashvars[Constants::$STRETCHING_KEY] = get_option('PRO_PLAYER_STRETCHING');
				
				$flashvars[Constants::$ENABLE_JS_KEY] = Constants::$ENABLE_JS_VALUE;
				$flashvars[Constants::$MUTE_KEY] = Constants::$MUTE_VALUE;
				$flashvars[Constants::$SKIN_KEY] = get_option('PRO_PLAYER_SKIN_FILE');
				
				if (get_option('PRO_PLAYER_SHOW_WATERMARK') == 'true') {
					$flashvars[Constants::$WATERMARK_KEY] = $this->PLUGIN_URL.'/players/'.Constants::$WATERMARK_VALUE;
				}
				
				if (get_option('PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE') == 'true') {
					$flashvars[Constants::$PREVIEW_KEY] = get_option('PRO_PLAYER_DEFAULT_PREVIEW_IMAGE');
				}
				
				if (get_option('PRO_PLAYER_AD_SUPPORT') == 'true') {
					$flashvars[Constants::$AD_CHANNEL_KEY] = get_option('PRO_PLAYER_AD_CHANNEL');
				}
				
				$flashvars[Constants::$PLUGINS_KEY] = $this->getPluginDefinitions();
				
				return $flashvars;
			}
			
			function getPluginDefinitions() {
				$plugins = '';
				$COMMA = ',';
				$type = $this->getKeyValue(Constants::$FILE_TYPE_KEY, Constants::$FILE_TYPE_VALUE);
				
				if (get_option('PRO_PLAYER_VISUALIZER_SUPPORT') == 'true' && ($type == 'sound' || $type == 'mp3' || $type == 'rbs')) {
					$plugins .= Constants::$PLUGIN_REVOLT.Constants::$PLUGIN_REVOLT_OPTIONS.$COMMA;
				}

				if (get_option('PRO_PLAYER_RATING_SUPPORT') == 'true') {
					$plugins .= Constants::$PLUGIN_RATE_IT.Constants::$PLUGIN_RATE_IT_OPTIONS.$COMMA;
				}

				if (get_option('PRO_PLAYER_EMBEDDING_SUPPORT') == 'true') {
					$plugins .= Constants::$PLUGIN_VIRAL.Constants::$PLUGIN_VIRAL_OPTIONS.$COMMA;
				}

				if (get_option('PRO_PLAYER_SUBTITLE_SUPPORT') == 'true') {
					$plugins .= Constants::$PLUGIN_SUBPLY.Constants::$PLUGIN_SUBPLY_OPTIONS.$COMMA;
				}
				
				if (get_option('PRO_PLAYER_SHORTCUT_SUPPORT') == 'true') {
					$plugins .= Constants::$PLUGIN_QUICK_KEYS.Constants::$PLUGIN_QUICK_KEYS_OPTIONS.$COMMA;
				}
				
				if (get_option('PRO_PLAYER_FLOW_VIEW_SUPPORT') == 'true') {
					$plugins .= Constants::$PLUGIN_FLOW.Constants::$PLUGIN_FLOW_OPTIONS.$COMMA;
				}
				
				return substr($plugins, 0, strlen($plugins) - 1);
			}
			
			function getOtherValues() {
				global $wp_query;
				$others = array();
				
				$others[Constants::$ID_KEY] = $wp_query->post->ID;
				
				if (get_option('PRO_PLAYER_AD_SUPPORT') == 'true') {
					$others[Constants::$AD_SCRIPT_KEY] = get_option('PRO_PLAYER_AD_SCRIPT');
				}
				
				return $others;
			}
			
			function getDefaultParams() {
				$params = array();
				
				$params[Constants::$WMODE_KEY] = Constants::$WMODE_VALUE;
				$params[Constants::$ALLOW_FULLSCREEN_KEY] = Constants::$ALLOW_FULLSCREEN_VALUE;
				$params[Constants::$ALLOW_SCRIPT_ACCESS_KEY] = Constants::$ALLOW_SCRIPT_ACCESS_VALUE;
				$params[Constants::$ALLOW_NETWORKING_KEY] = Constants::$ALLOW_NETWORKING_VALUE;
				
				return $params;
			}
		}
	}
?>
