<?php
	require_once('simpletest/autorun.php');
	require_once('../configuration-builder.php');
	
	class configurationBuilderTest extends UnitTestCase {
		
		function test_get_key_value_returns_the_value_in_attributes() {
			// given
			$attrs = array();
			$key = "A_KEY";
			$expectedValue = "A_VALUE";
			$defaultValue = "A_DEFAULT_VALUE";
			
			$attrs[$key] = $expectedValue;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->getKeyValue($key, $defaultValue);
			$this->assertEqual($expectedValue, $result);
		}
		
		function test_build_returns_the_overridden_image_value() {
			// given
			$expectedValue = "A_VALUE";
			$attrs = array(
				Constants::$PREVIEW_KEY => $expectedValue
			);
			$key = Constants::$PREVIEW_KEY;
			
			$attrs[$key] = $expectedValue;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$configuration = $configurationBuilder->build();
			$flashvars = $configuration->getFlashVars();
			$this->assertEqual($expectedValue, $flashvars[Constants::$PREVIEW_KEY]);
		}
		
		function test_get_key_value_returns_default_when_attributes_does_not_contain_the_key() {
			// given
			$attrs = array();
			$key = "A_KEY";
			$defaultValue = "A_DEFAULT_VALUE";
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->getKeyValue($key, $defaultValue);
			$this->assertEqual($defaultValue, $result);
		}
		
		function test_build_returns_the_overridden_value_when_attributes_contain_the_given_key() {
			// given
			$key = 'A_KEY';
			$expectedValue = 'A_VALUE';
			$attrs = array($key => $expectedValue);
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expectedValue, $result[$key]);
		}
		
		function test_build_returns_the_default_value_for_a_key_defined_in_constants_when_attributes_contain_no_flashvar_override() {
			// given
			$key = Constants::$WIDTH_KEY;
			$expectedValue = Constants::$WIDTH_VALUE;
			$attrs = array();
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expectedValue, $result[$key]);
		}
		
		function test_build_returns_the_default_value_for_a_key_defined_in_constants_when_attributes_contain_no_param_override() {
			// given
			$key = Constants::$WMODE_KEY;
			$expectedValue = Constants::$WMODE_VALUE;
			$attrs = array();
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getParams();
			
			$this->assertEqual($expectedValue, $result[$key]);
		}
		
		/* ---= default value tests =--- */
				
		function test_build_returns_default_enable_javascript_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$ENABLE_JS_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$ENABLE_JS_KEY]);
		}
		
		function test_build_returns_default_width_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$WIDTH_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$WIDTH_KEY]);
		}
		
		function test_build_returns_default_height_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$HEIGHT_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$HEIGHT_KEY]);
		}
		
		function test_build_returns_default_file_type_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$FILE_TYPE_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$FILE_TYPE_KEY]);
		}
		
		function test_build_returns_default_auto_start_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$AUTO_START_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$AUTO_START_KEY]);
		}
		
		function test_build_returns_default_repeat_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$REPEAT_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$REPEAT_KEY]);
		}
		
		function test_build_returns_default_background_color_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$BACKGROUND_COLOR_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$BACKGROUND_COLOR_KEY]);
		}
		
		function test_build_returns_default_foreground_color_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$FOREGROUND_COLOR_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$FOREGROUND_COLOR_KEY]);
		}
		
		function test_build_returns_default_light_color_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$LIGHT_COLOR_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$LIGHT_COLOR_KEY]);
		}
		
		function test_build_returns_default_mute_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = Constants::$MUTE_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$MUTE_KEY]);
		}
		
		function test_build_returns_default_watermark_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = WP_PLUGIN_URL.'/proplayer/players/'.Constants::$WATERMARK_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$WATERMARK_KEY]);
		}
		
		function test_build_returns_default_skin_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = WP_PLUGIN_URL.'/proplayer/players/skins/'.Constants::$SKIN_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$SKIN_KEY]);
		}
		
		function test_build_returns_default_plugins_for_video_files_when_attributes_contain_no_flashvar_override() {
			// given
			$COMMA = ',';
			$attrs = array();
			$expected = Constants::$PLUGIN_RATE_IT.Constants::$PLUGIN_RATE_IT_OPTIONS.$COMMA.
						Constants::$PLUGIN_VIRAL.Constants::$PLUGIN_VIRAL_OPTIONS.$COMMA.
						Constants::$PLUGIN_SUBPLY.Constants::$PLUGIN_SUBPLY_OPTIONS.$COMMA.
						Constants::$PLUGIN_QUICK_KEYS.Constants::$PLUGIN_QUICK_KEYS_OPTIONS.$COMMA.
						Constants::$PLUGIN_FLOW.Constants::$PLUGIN_FLOW_OPTIONS;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$PLUGINS_KEY]);
		}
		
		function test_build_returns_default_plugins_for_sound_files_when_attributes_contain_no_flashvar_override() {
			// given
			$COMMA = ',';
			$attrs = array("type" => "mp3");
			$expected = Constants::$PLUGIN_REVOLT.Constants::$PLUGIN_REVOLT_OPTIONS.$COMMA.
						Constants::$PLUGIN_RATE_IT.Constants::$PLUGIN_RATE_IT_OPTIONS.$COMMA.
						Constants::$PLUGIN_VIRAL.Constants::$PLUGIN_VIRAL_OPTIONS.$COMMA.
						Constants::$PLUGIN_SUBPLY.Constants::$PLUGIN_SUBPLY_OPTIONS.$COMMA.
						Constants::$PLUGIN_QUICK_KEYS.Constants::$PLUGIN_QUICK_KEYS_OPTIONS.$COMMA.
						Constants::$PLUGIN_FLOW.Constants::$PLUGIN_FLOW_OPTIONS;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getFlashVars();
			
			$this->assertEqual($expected, $result[Constants::$PLUGINS_KEY]);
		}
		
		function test_build_returns_default_ad_channel_value_when_attributes_contain_no_flashvar_override() {
			// given
			$attrs = array();
			$expected = 'DEMO_CHANNEL';
			$expectedScript = 'DEMO_SCRIPT';
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$flashvars = $configurationBuilder->build()->getFlashVars();
			$others = $configurationBuilder->build()->getOthers();
			
			$this->assertEqual($expected, $flashvars[Constants::$AD_CHANNEL_KEY]);
			$this->assertEqual($expectedScript, $others[Constants::$AD_SCRIPT_KEY]);
		}
		
		function test_build_returns_default_wmode_param_when_attributes_contain_no_param_override() {
			// given
			$attrs = array();
			$expected = Constants::$WMODE_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getParams();
			
			$this->assertEqual($expected, $result[Constants::$WMODE_KEY]);
		}
		
		function test_build_returns_default_fullscreen_param_when_attributes_contain_no_param_override() {
			// given
			$attrs = array();
			$expected = Constants::$ALLOW_FULLSCREEN_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getParams();
			
			$this->assertEqual($expected, $result[Constants::$ALLOW_FULLSCREEN_KEY]);
		}
		
		function test_build_returns_default_script_access_param_when_attributes_contain_no_param_override() {
			// given
			$attrs = array();
			$expected = Constants::$ALLOW_SCRIPT_ACCESS_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getParams();
			
			$this->assertEqual($expected, $result[Constants::$ALLOW_SCRIPT_ACCESS_KEY]);
		}
		
		function test_build_returns_default_networking_param_when_attributes_contain_no_param_override() {
			// given
			$attrs = array();
			$expected = Constants::$ALLOW_NETWORKING_VALUE;
			
			// test
			$configurationBuilder = new ConfigurationBuilder($attrs);
			$result = $configurationBuilder->build()->getParams();
			
			$this->assertEqual($expected, $result[Constants::$ALLOW_NETWORKING_KEY]);
		}
	}
	
	// mocking wordpress' get_option function
	define('WP_PLUGIN_URL', '');
	function get_option($key) {
		$arr = array(
			'PRO_PLAYER_WIDTH' => Constants::$WIDTH_VALUE,
			'PRO_PLAYER_HEIGHT' => Constants::$HEIGHT_VALUE,
			'PRO_PLAYER_TYPE' => Constants::$FILE_TYPE_VALUE,
			'PRO_PLAYER_REPEAT' => Constants::$REPEAT_VALUE,
			'PRO_PLAYER_AUTO_START' => Constants::$AUTO_START_VALUE,
			'PRO_PLAYER_BACKCOLOR' => Constants::$BACKGROUND_COLOR_VALUE,
			'PRO_PLAYER_FRONTCOLOR' => Constants::$FOREGROUND_COLOR_VALUE,
			'PRO_PLAYER_LIGHTCOLOR' => Constants::$LIGHT_COLOR_VALUE,
			'PRO_PLAYER_STRETCHING' => Constants::$STRETCHING_VALUE,
			'PRO_PLAYER_SKIN_FILE' => '/proplayer/players/skins/default.swf',
			'PRO_PLAYER_VISUALIZER_SUPPORT' => true,
			'PRO_PLAYER_RATING_SUPPORT' => true,
			'PRO_PLAYER_EMBEDDING_SUPPORT' => true,
			'PRO_PLAYER_SHOW_WATERMARK' => true,
			'PRO_PLAYER_SUBTITLE_SUPPORT' => true,
			'PRO_PLAYER_SHORTCUT_SUPPORT' => true,
			'PRO_PLAYER_FLOW_VIEW_SUPPORT' => true,
			'PRO_PLAYER_AD_SUPPORT' => true,			
			'PRO_PLAYER_AD_CHANNEL' => 'DEMO_CHANNEL',
			'PRO_PLAYER_AD_SCRIPT' => 'DEMO_SCRIPT'
		);
		
		return $arr[$key];
	}
?>