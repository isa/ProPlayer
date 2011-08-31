<?php
/*
	Plugin Name: PRO Player
	Plugin URI: http://isagoksu.com/proplayer-wordpress-plugin/
	Description: Display videos from various online sources in a Custom FLV Player. For details please visit <a href="http://isagoksu.com/proplayer-wordpress-plugin/" target="_new">project page</a> for more information. 
	Author: Isa Goksu
	Version: 4.7.7
	Author URI: http://isagoksu.com
	
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

	Special thanks to:
	- SWFObject [ http://code.google.com/p/swfobject ] authors, they made flash part really easier.
*/
	
	require dirname(__FILE__) . "/content-handler.php";
	require dirname(__FILE__) . "/attribute-resolver.php";
	require dirname(__FILE__) . "/constants.php";
	require dirname(__FILE__) . "/configuration-builder.php";

	if (!class_exists("ProPlayer")) {
		class ProPlayer {
			var $NEW_LINE = "\r";
			var $PLUGIN_URL;
			var $contentHandler;
			
			function ProPlayer() {				
				$this->PLUGIN_URL = WP_PLUGIN_URL."/proplayer";
				$this->contentHandler = new ContentHandler();
			}
			
			function constructSnippet($attrs, $content = '') {
				$configurationBuilder = new ConfigurationBuilder($attrs);
				$configuration = $configurationBuilder->build();
				
				$flashvars = $configuration->getFlashVars();
				$params = $configuration->getParams();
				$others = $configuration->getOthers();
				
				$id = $others[Constants::$ID_KEY].uniqid('pp-single-');
				
				$result  = '<!-- ProPlayer by Isa Goksu -->';
				$result .= '<div name="mediaspace" id="mediaspace"><div class="pro-player-container" width="'.$flashvars[Constants::$WIDTH_KEY].'px" height="'.$flashvars[Constants::$HEIGHT_KEY].'px"><div id="pro-player-'.$id.'"></div></div></div>'.$this->NEW_LINE;
				$result .= '<script type="text/javascript" charset="utf-8">'.$this->NEW_LINE;
				
				$result .= $this->getFlashVars($flashvars, $id, $content);
				$result .= $this->getParams($params);
				
				$result .= 'var attributes = {'.$this->NEW_LINE;
				$result .= 'id: "obj-pro-player-'.$id.'",'.$this->NEW_LINE;
				$result .= 'name: "obj-pro-player-'.$id.'"'.$this->NEW_LINE;
				$result .= '};'.$this->NEW_LINE;
				
				$result .= 'swfobject.embedSWF("'.$this->getPlayer().'", "pro-player-'.$id.'", "'.$flashvars[Constants::$WIDTH_KEY].'", "'.$flashvars[Constants::$HEIGHT_KEY].'", "9.0.0", false, flashvars, params, attributes);';
				
				$result .= '</script>'.$this->NEW_LINE;
				$result .= $others[Constants::$AD_SCRIPT_KEY];
				
				return $result;
			}
			
			/* ---= getters =--- */
			
			function getFlashVars($flashvars, $id, $content) {
				$result = 'var flashvars = {'.$this->NEW_LINE;

				for ($i = 0; $i < count($flashvars); $i++) {
					$keys = array_keys($flashvars);
					$values = array_values($flashvars);

					if ($keys[$i] != Constants::$FILE_TYPE_KEY) {
						$result .= $keys[$i].': "'.$values[$i].'",'.$this->NEW_LINE;
					}
				}
				
				$result .= Constants::$JAVASCRIPT_ID_KEY.': "'.$id.'",'.$this->NEW_LINE;
				$result .= Constants::$PREVIEW_KEY.': "'.$flashvars[Constants::$PREVIEW_KEY].'",'.$this->NEW_LINE;
				$playlist = $this->contentHandler->addFileAttributes($id, $content, $flashvars[Constants::$FILE_TYPE_KEY], $flashvars[Constants::$PREVIEW_KEY]);
				$result .= $playlist.$this->NEW_LINE;
				
				$result .= '};'.$this->NEW_LINE;
				
				return $result;
			}
			
			function getParams($params) {
				$result = 'var params = {'.$this->NEW_LINE;

				for ($i = 0; $i < count($params); $i++) {
					$keys = array_keys($params);
					$values = array_values($params);

					$result .= $keys[$i].': "'.$values[$i].'",'.$this->NEW_LINE;
				}
				
				$result = substr($result, 0, strlen($result)-2).$this->NEW_LINE.'};'.$this->NEW_LINE;
				
				return $result;
			}
			
			function getPlayer() {
				return $this->PLUGIN_URL."/players/player.swf";
			}
			
			function getSkinPath() {
				return $this->PLUGIN_URL."/players/skins";
			}
			
			/* ---= wordpress settings =--- */
					
			function addHeaderCode() {
				print "<script type='text/javascript' src='".$this->PLUGIN_URL."/js/swfobject.js'></script>";
			}
					
			function addOptions() {
				add_option("PRO_PLAYER_WIDTH", Constants::$WIDTH_VALUE);
				add_option("PRO_PLAYER_HEIGHT", Constants::$HEIGHT_VALUE);
				add_option("PRO_PLAYER_TYPE", Constants::$FILE_TYPE_VALUE);
				add_option("PRO_PLAYER_BACKCOLOR", Constants::$BACKGROUND_COLOR_VALUE);
				add_option("PRO_PLAYER_FRONTCOLOR", Constants::$FOREGROUND_COLOR_VALUE);
				add_option("PRO_PLAYER_LIGHTCOLOR", Constants::$LIGHT_COLOR_VALUE);
				add_option("PRO_PLAYER_STRETCHING", Constants::$STRETCHING_VALUE);
				add_option("PRO_PLAYER_AUTO_START", Constants::$AUTO_START_VALUE);
				add_option("PRO_PLAYER_REPEAT", Constants::$REPEAT_VALUE);

				add_option("PRO_PLAYER_SHOW_WATERMARK", "true");

				add_option("PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE", "true");
				add_option("PRO_PLAYER_DEFAULT_PREVIEW_IMAGE", $this->PLUGIN_URL.'/players/'.Constants::$PREVIEW_VALUE);
				add_option("PRO_PLAYER_SKIN_FILE", $this->getSkinPath().'/'.Constants::$SKIN_VALUE);
				
				add_option("PRO_PLAYER_VISUALIZER_SUPPORT", "false");
				add_option("PRO_PLAYER_RATING_SUPPORT", "false");
				add_option("PRO_PLAYER_EMBEDDING_SUPPORT", "false");
				add_option('PRO_PLAYER_SUBTITLE_SUPPORT', 'false');
				add_option('PRO_PLAYER_SHORTCUT_SUPPORT', 'false');
				add_option('PRO_PLAYER_FLOW_VIEW_SUPPORT', 'false');
				
				add_option("PRO_PLAYER_AD_SUPPORT", "false");
				add_option("PRO_PLAYER_AD_CHANNEL", "");
				add_option("PRO_PLAYER_AD_SCRIPT", "");
				add_option("PRO_PLAYER_CACHE_TIMEOUT", "90");
			}
			
			function removeOptions() {
				delete_option("PRO_PLAYER_WIDTH");
				delete_option("PRO_PLAYER_HEIGHT");
				delete_option("PRO_PLAYER_TYPE");
				delete_option("PRO_PLAYER_BACKCOLOR");
				delete_option("PRO_PLAYER_FRONTCOLOR");
				delete_option("PRO_PLAYER_LIGHTCOLOR");
				delete_option("PRO_PLAYER_STRETCHING");
				delete_option("PRO_PLAYER_SKIN_FILE");
				delete_option("PRO_PLAYER_VISUALIZER_SUPPORT");
				delete_option("PRO_PLAYER_RATING_SUPPORT");
				delete_option("PRO_PLAYER_EMBEDDING_SUPPORT");
				delete_option("PRO_PLAYER_SHOW_WATERMARK");
				delete_option("PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE");
				delete_option("PRO_PLAYER_DEFAULT_PREVIEW_IMAGE");
				delete_option("PRO_PLAYER_REPEAT");
				delete_option("PRO_PLAYER_CACHE_TIMEOUT");
				delete_option("PRO_PLAYER_AUTO_START");
				delete_option('PRO_PLAYER_SUBTITLE_SUPPORT');
				delete_option('PRO_PLAYER_SHORTCUT_SUPPORT');
				delete_option('PRO_PLAYER_FLOW_VIEW_SUPPORT');
				delete_option("PRO_PLAYER_AD_SUPPORT");
				delete_option("PRO_PLAYER_AD_CHANNEL");
				delete_option("PRO_PLAYER_AD_SCRIPT");
			}
					
			function addOptionsPage() {
				add_options_page(
					"ProPlayer Configuration",
					"ProPlayer",
					9,
					"proplayer/options-page.php"
				);	
			}
					
			function updateOptions($post) {
				if (is_array($post)) {
					update_option("PRO_PLAYER_WIDTH", $post["proPlayerWidth"]);
					update_option("PRO_PLAYER_CACHE_TIMEOUT", $post["proPlayerCacheTimeout"]);
					update_option("PRO_PLAYER_HEIGHT", $post["proPlayerHeight"]);
					update_option("PRO_PLAYER_TYPE", $post["proPlayerType"]);
					update_option("PRO_PLAYER_BACKCOLOR", $post["proPlayerBackColor"]);
					update_option("PRO_PLAYER_FRONTCOLOR", $post["proPlayerFrontColor"]);
					update_option("PRO_PLAYER_LIGHTCOLOR", $post["proPlayerLightColor"]);
					update_option("PRO_PLAYER_STRETCHING", $post["proPlayerStretching"]);
					update_option("PRO_PLAYER_SKIN_FILE", $post["proPlayerSkinFile"]);
					update_option("PRO_PLAYER_VISUALIZER_SUPPORT", isset($post["proPlayerVisualizerSupport"]) ? $post["proPlayerVisualizerSupport"] : "false");
					update_option("PRO_PLAYER_RATING_SUPPORT", isset($post["proPlayerRatingSupport"]) ? $post["proPlayerRatingSupport"] : "false");
					update_option("PRO_PLAYER_EMBEDDING_SUPPORT", isset($post["proPlayerEmbeddingSupport"]) ? $post["proPlayerEmbeddingSupport"] : "false");
					update_option("PRO_PLAYER_SHOW_WATERMARK", isset($post["proPlayerShowWatermark"]) ? $post["proPlayerShowWatermark"] : "false");
					update_option("PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE", isset($post["proPlayerShowDefaultPreviewImage"]) ? $post["proPlayerShowDefaultPreviewImage"] : "false");
					update_option("PRO_PLAYER_DEFAULT_PREVIEW_IMAGE", $post["proPlayerDefaultPreviewImage"]);
					update_option("PRO_PLAYER_REPEAT", isset($post["proPlayerRepeat"]) ? $post["proPlayerRepeat"] : "false");
					update_option("PRO_PLAYER_AUTO_START", isset($post["proPlayerAutoStart"]) ? $post["proPlayerAutoStart"] : "false");
					update_option("PRO_PLAYER_AD_SUPPORT", isset($post["proPlayerAdSupport"]) ? $post["proPlayerAdSupport"] : "false");
					update_option("PRO_PLAYER_AD_CHANNEL", $post["proPlayerAdChannel"]);
					update_option("PRO_PLAYER_AD_SCRIPT", $post["proPlayerAdScript"]);
					update_option("PRO_PLAYER_SUBTITLE_SUPPORT", isset($post["proPlayerSubtitleSupport"]) ? $post["proPlayerSubtitleSupport"] : "false");
					update_option("PRO_PLAYER_SHORTCUT_SUPPORT", isset($post["proPlayerShortcutSupport"]) ? $post["proPlayerShortcutSupport"] : "false");
					update_option("PRO_PLAYER_FLOW_VIEW_SUPPORT", isset($post["proPlayerFlowViewSupport"]) ? $post["proPlayerFlowViewSupport"] : "false");
				}
			}
					
			function addTinyMCEButton() {
				if ( get_user_option("rich_editing") == "true") {
					add_filter("mce_external_plugins", array(&$this, "addTinyMCEPlugin"));
					add_filter("mce_buttons", array(&$this, "registerTinyMCEButton"));
				} 
			}
					
			function quickTagButtonAction() {
				?>
					<script type="text/javascript">
						function proPlayerQuickTagAction(querystr) {
						  var content = document.getElementById('content');
						  var prefix = content.value.substring(0, content.selectionStart);
						  var selection = content.value.substring(content.selectionStart, content.selectionEnd);
						  var suffix = content.value.substring(content.selectionEnd);
					
					
						  if (selection != "") {
							content.value = prefix + "[pro-player]" + selection + "[/pro-player]" + suffix;												
						  } else {
							alert("Please, select the URL string and then click!")
						  }
					
						  return false;
						}
			
						var ed_toolbar = document.getElementById("ed_toolbar");
			
						if (ed_toolbar) {
						  var theButton = document.createElement('input');
						  theButton.type = 'button';
						  theButton.value = 'ProPlayer';
						  theButton.onclick = proPlayerQuickTagAction;
						  theButton.className = 'ed_button';
						  theButton.title = 'ProPlayer!';
						  theButton.id = 'ed_ProPlayer';
						  ed_toolbar.appendChild(theButton);
						}
					</script>
				<?php
			}
			
			function registerTinyMCEButton($buttons) {
			   array_push($buttons, "separator", "proPlayer");
			
			   return $buttons;
			}
			
			function addTinyMCEPlugin($plugin_array) {
			   $plugin_array["proPlayer"] = $this->PLUGIN_URL."/tinymce/editor_plugin.js";
			
			   return $plugin_array;
			}
			
			function installDatabase() {
				global $wpdb;
				$cacheTable = $wpdb->prefix."proplayer";
				$playlistTable = $wpdb->prefix."proplayer_playlist";
			
				$wpdb->query("DROP TABLE IF EXISTS ".$cacheTable);
				$wpdb->query("DROP TABLE IF EXISTS ".$playlistTable);
			
				$sql = "CREATE TABLE ".$cacheTable." (
						  ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						  VIDEO_SOURCE VARCHAR(255) NOT NULL,
						  VIDEO_ID VARCHAR(100) NOT NULL,
						  VIDEO_URL TEXT NOT NULL,
						  PREVIEW_IMAGE TEXT,
						  TITLE VARCHAR(255) NOT NULL,
						  CREATION_DATE DATETIME NOT NULL
						);						
						CREATE TABLE ".$playlistTable." (
						  ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						  POST_ID VARCHAR(50) NOT NULL,
						  PLAYLIST TEXT NOT NULL
						);
				";
			
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
				
				add_option("PRO_PLAYER_DB_VERSION", "1.1");
			}

		}
	}
	
	function insert_proplayer($attrs = array(), $content = '') {
		$proPlayer = new ProPlayer();
		
		return $proPlayer->constructSnippet($attrs, $content);
	}

	$proPlayer = new ProPlayer();

	// add plugin actions
	add_action("wp_head", array(&$proPlayer, "addHeaderCode"), 1);
	add_shortcode('pro-player', array(&$proPlayer, "constructSnippet"));
	
	// register option hooks
	register_activation_hook(__FILE__, array(&$proPlayer, "addOptions"));
	register_activation_hook(__FILE__,array(&$proPlayer, "installDatabase"));
	register_deactivation_hook(__FILE__, array(&$proPlayer, "removeOptions"));

	// add options page
	add_action("admin_menu", array(&$proPlayer, "addOptionsPage"));

	// add tinymce buttons
	add_action("init", array(&$proPlayer, "addTinyMCEButton"));
	add_filter("admin_footer", array(&$proPlayer, "quickTagButtonAction"));
?>