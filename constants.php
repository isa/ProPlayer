<?php
	if (!class_exists('Constants')) {
		class Constants {
			
			/* ----= FLASH VARS =---- */

			// id
			public static $ID_KEY = 'id';
			public static $JAVASCRIPT_ID_KEY = 'javascriptid';

			// enablejs
			public static $ENABLE_JS_KEY = 'enablejs';
			public static $ENABLE_JS_VALUE = 'true';
			
			// file type
			public static $FILE_TYPE_KEY = 'type';
			public static $FILE_TYPE_VALUE = 'video';
			
			// background color
			public static $BACKGROUND_COLOR_KEY = 'backcolor';
			public static $BACKGROUND_COLOR_VALUE = '111111';
			
			// foreground color
			public static $FOREGROUND_COLOR_KEY = 'frontcolor';
			public static $FOREGROUND_COLOR_VALUE = 'cccccc';
			
			// light color
			public static $LIGHT_COLOR_KEY = 'lightcolor';
			public static $LIGHT_COLOR_VALUE = '66cc00';
			
			// stretching
			public static $STRETCHING_KEY = 'stretching';
			public static $STRETCHING_VALUE = 'fill';
			
			// autostart
			public static $AUTO_START_KEY = 'autostart';
			public static $AUTO_START_VALUE = 'false';
			
			// repeat
			public static $REPEAT_KEY = 'repeat';
			public static $REPEAT_VALUE = 'false';
			
			// mute
			public static $MUTE_KEY = 'mute';
			public static $MUTE_VALUE = 'false';
			
			// watermark
			public static $WATERMARK_KEY = 'logo';
			public static $WATERMARK_VALUE = 'watermark.png';
			
			// preview image
			public static $PREVIEW_KEY = 'image';
			public static $PREVIEW_VALUE = 'preview.png';
			
			// plugins
			public static $PLUGINS_KEY = 'plugins';
			public static $PLUGINS_VALUE = '';
			
			// skin
			public static $SKIN_KEY = 'skin';
			public static $SKIN_VALUE = 'default.swf';
			
			// ad channel
			public static $AD_CHANNEL_KEY = 'channel';
			public static $AD_CHANNEL_VALUE = '';
			
			// ad channel script
			public static $AD_SCRIPT_KEY = 'adscript';
			public static $AD_SCRIPT_VALUE = '';
			
			/* ----= FLASH ATTRIBUTES =---- */
			
			// width
			public static $WIDTH_KEY = 'width';
			public static $WIDTH_VALUE = '530';
			
			// height
			public static $HEIGHT_KEY = 'height';
			public static $HEIGHT_VALUE = '253';
			
			/* ----= FLASH PARAMS =---- */
			
			// wmode
			public static $WMODE_KEY = 'wmode';
			public static $WMODE_VALUE = 'transparent';
			
			// allowfullscreen
			public static $ALLOW_FULLSCREEN_KEY = 'allowfullscreen';
			public static $ALLOW_FULLSCREEN_VALUE = 'true';
			
			// allowscriptaccess
			public static $ALLOW_SCRIPT_ACCESS_KEY = 'allowscriptaccess';
			public static $ALLOW_SCRIPT_ACCESS_VALUE = 'always';
			
			// allownetworking
			public static $ALLOW_NETWORKING_KEY = 'allownetworking';
			public static $ALLOW_NETWORKING_VALUE = 'all';
			
			/* ---= PLUGINS =--- */
			
			public static $PLUGIN_REVOLT = 'revolt-1';
			public static $PLUGIN_REVOLT_OPTIONS = '';
			
			public static $PLUGIN_VIRAL = 'viral-2';
			public static $PLUGIN_VIRAL_OPTIONS = '&viral.callout=none&viral.onpause=false';
			
			public static $PLUGIN_SUBPLY = 'subply-1';
			public static $PLUGIN_SUBPLY_OPTIONS = '';
			
			public static $PLUGIN_RATE_IT = 'rateit-1';
			public static $PLUGIN_RATE_IT_OPTIONS = '';
			
			public static $PLUGIN_QUICK_KEYS = 'quickkeys-1';
			public static $PLUGIN_QUICK_KEYS_OPTIONS = '';
			
			public static $PLUGIN_FLOW = 'flow-1';
			public static $PLUGIN_FLOW_OPTIONS = '&flow.position=bottom&flow.showtext=false';
		}
	}
?>