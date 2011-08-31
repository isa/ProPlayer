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

	load_plugin_textdomain('pro-player', 'wp-content/plugins/proplayer'); // NLS
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=proplayer/options-page.php'; // Form Action URI

	/* Check form submission and update options */
	if ('process' == $_POST['stage']) {
		include_once('pro-player.php');
		
		$proPlayer = new ProPlayer();
		$proPlayer->updateOptions($_POST);
	}

	/* Get options for form fields */
	$proPlayerWidth = stripslashes(get_option('PRO_PLAYER_WIDTH'));
	$proPlayerHeight = stripslashes(get_option('PRO_PLAYER_HEIGHT'));
	$proPlayerType = stripslashes(get_option('PRO_PLAYER_TYPE'));
	$proPlayerBackColor = stripslashes(get_option('PRO_PLAYER_BACKCOLOR'));
	$proPlayerFrontColor = stripslashes(get_option('PRO_PLAYER_FRONTCOLOR'));
	$proPlayerLightColor = stripslashes(get_option('PRO_PLAYER_LIGHTCOLOR'));
	$proPlayerStretching = stripslashes(get_option('PRO_PLAYER_STRETCHING'));
	$proPlayerSkinFile = stripslashes(get_option('PRO_PLAYER_SKIN_FILE'));
	$proPlayerVisualizerSupport = stripslashes(get_option('PRO_PLAYER_VISUALIZER_SUPPORT'));
	$proPlayerRatingSupport = stripslashes(get_option('PRO_PLAYER_RATING_SUPPORT'));
	$proPlayerEmbeddingSupport = stripslashes(get_option('PRO_PLAYER_EMBEDDING_SUPPORT'));
	$proPlayerShortcutSupport = stripslashes(get_option('PRO_PLAYER_SHORTCUT_SUPPORT'));
	$proPlayerSubtitleSupport = stripslashes(get_option('PRO_PLAYER_SUBTITLE_SUPPORT'));
	$proPlayerFlowViewSupport = stripslashes(get_option('PRO_PLAYER_FLOW_VIEW_SUPPORT'));
	$proPlayerShowWatermark = stripslashes(get_option('PRO_PLAYER_SHOW_WATERMARK'));
	$proPlayerShowDefaultPreviewImage = stripslashes(get_option('PRO_PLAYER_SHOW_DEFAULT_PREVIEW_IMAGE'));
	$proPlayerDefaultPreviewImage = stripslashes(get_option('PRO_PLAYER_DEFAULT_PREVIEW_IMAGE'));
	$proPlayerRepeat = stripslashes(get_option('PRO_PLAYER_REPEAT'));
	$proPlayerCacheTimeout = stripslashes(get_option('PRO_PLAYER_CACHE_TIMEOUT'));
	$proPlayerAutoStart = stripslashes(get_option('PRO_PLAYER_AUTO_START'));
	$proPlayerAdSupport = stripslashes(get_option('PRO_PLAYER_AD_SUPPORT'));
	$proPlayerAdChannel = stripslashes(get_option('PRO_PLAYER_AD_CHANNEL'));
	$proPlayerAdScript = stripslashes(get_option('PRO_PLAYER_AD_SCRIPT'));
?>

<div class="wrap"> 
  <h2><?php _e('ProPlayer Options', 'proplayer') ?></h2> 
  <form name="pro-player-form" method="post" action="<?php echo $location ?>&amp;updated=true">
  	<input type="hidden" name="stage" value="process" />

    <table width="100%" cellpadding="5" class="form-table"> 
      <tr valign="top">
        <th scope="row"><label for="proPlayerWidth"><?php _e('Default Width', 'proplayer') ?> (px):</label></th>
        <td>
          <input name="proPlayerWidth" type="text" class="small-text" id="proPlayerWidth" value="<?php echo $proPlayerWidth ?>"/>
          <span class="setting-description"><?php _e('Defines what size ProPlayer will be if the width attribute is not provided.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerHeight"><?php _e('Default Height', 'proplayer') ?> (px):</label></th>
        <td>
          <input name="proPlayerHeight" type="text" class="small-text" id="proPlayerHeight" value="<?php echo $proPlayerHeight ?>"/>
          <span class="setting-description"><?php _e('Defines what size ProPlayer will be if the height attribute is not provided.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerType"><?php _e('Default Video Type', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerType" type="text" class="small-text" style="width: 40px" id="proPlayerType" value="<?php echo $proPlayerType ?>"/>
          <span class="setting-description"><?php _e('Defines what type of media ProPlayer will look for. Please don\'t change this setting if you don\'t know what exactly it is.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerBackColor"><?php _e('Back Color', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerBackColor" type="text" class="small-text" style="width: 100px" id="proPlayerBackColor" value="<?php echo $proPlayerBackColor ?>"/>
          <span class="setting-description"><?php _e('Back color of the player.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerFrontColor"><?php _e('Front Color', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerFrontColor" type="text" class="small-text" style="width: 100px" id="proPlayerFrontColor" value="<?php echo $proPlayerFrontColor ?>"/>
          <span class="setting-description"><?php _e('Front color of the player.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerLightColor"><?php _e('Light Color', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerLightColor" type="text" class="small-text" style="width: 100px" id="proPlayerLightColor" value="<?php echo $proPlayerLightColor ?>"/>
          <span class="setting-description"><?php _e('Light color of the player.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerSkinFile"><?php _e('Skin File (JW FLV Player)', 'proplayer') ?>:</label></th>
        <td>
	       <select name="proPlayerSkinFileSelector" id="proPlayerSkinFileSelector" class="large-text" onchange="if (this.value != '') { document.getElementById('proPlayerSkinFile').value='<?php echo $proPlayer->getSkinPath()?>' + '/' + this.value + '.swf'; return true; } ">
       		<option value="">Custom</option>
	         <option value="default">Stijl (Default)</option>
	         <option value="bekle">Bekle</option>
	         <option value="bluemetal">Blue Metal</option>
	         <option value="grungetape">Grunge Tape</option>
	         <option value="3dpixelstyle">3D Pixel Style</option>
	         <option value="atomicred">Atomic Red</option>
	         <option value="bekle">Overlay</option>
	         <option value="comet">Comet</option>
	         <option value="controlpanel">Control Panel</option>
	         <option value="dangdang">DangDang</option>
	         <option value="fashion">Fashion</option>
	         <option value="festival">Festival</option>
	         <option value="icecreamsneaka">Ice Cream Sneaka</option>
	         <option value="kleur">Kleur</option>
	         <option value="magma">Magma</option>
	         <option value="metarby10">Metarby 10</option>
	         <option value="modieus">Stylish v1.0</option>
	         <option value="nacht">Nacht</option>
	         <option value="neon">Neon</option>
	         <option value="pearlized">Pearlized</option>
	         <option value="pixelize">Pixelize</option>
	         <option value="playcasso">Playcasso</option>
	         <option value="schoon">Schoon</option>
	         <option value="silverywhite">Silvery White</option>
	         <option value="simple">Simple</option>
	         <option value="snel">Snel</option>
	         <option value="stylish">Stylish v1.1</option>
	         <option value="traganja">Traganja</option>
			 </select>
          <input name="proPlayerSkinFile" type="text" class="small-text" style="width: 440px" id="proPlayerSkinFile" value="<?php echo $proPlayerSkinFile ?>"/>
          <span class="setting-description"><?php _e('Should be a URL!', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerStretching"><?php _e('Stretching', 'proplayer') ?>:</label></th>
        <td>
          <select name="proPlayerStretching" id="proPlayerStretching">
            <option value="none"<?php if ($proPlayerStretching == 'none') echo ' selected="selected"' ?>>None</option>
            <option value="uniform"<?php if ($proPlayerStretching == 'uniform') echo ' selected="selected"' ?>>Uniform</option>
            <option value="fill"<?php if ($proPlayerStretching == 'fill') echo ' selected="selected"' ?>>Fill</option>
            <option value="exactfit"<?php if ($proPlayerStretching == 'exactfit') echo ' selected="selected"' ?>>Exact Fit</option>
          </select>
          <span class="setting-description"><?php _e('Default stretching option.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerRepeat"><?php _e('Always Repeat', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerRepeat" type="checkbox" class="small-text" id="proPlayerRepeat" value="always" <?php if ($proPlayerRepeat == "always") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off repeating media files by default.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerAutoStart"><?php _e('Auto Start', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerAutoStart" type="checkbox" class="small-text" id="proPlayerAutoStart" value="true" <?php if ($proPlayerAutoStart == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off starting media files automatically by default.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerShowWatermark"><?php _e('Show Watermark (logo)', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerShowWatermark" type="checkbox" class="small-text" id="proPlayerShowWatermark" value="true" <?php if ($proPlayerShowWatermark == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off displaying a watermark/logo image on top of media files.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerShowDefaultPreviewImage"><?php _e('Show Default Preview Image', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerShowDefaultPreviewImage" type="checkbox" class="small-text" id="proPlayerShowDefaultPreviewImage" value="true" <?php if ($proPlayerShowDefaultPreviewImage == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off displaying a default preview image before video starts.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerDefaultPreviewImage"><?php _e('Default Preview Image', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerDefaultPreviewImage" type="text" class="small-text" style="width: 440px" id="proPlayerDefaultPreviewImage" value="<?php echo $proPlayerDefaultPreviewImage ?>"/>
          <span class="setting-description"><?php _e('Default preview image. Please type full URL.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerVisualizerSupport"><?php _e('Show Visualizer for Audio Files', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerVisualizerSupport" type="checkbox" class="small-text" id="proPlayerVisualizerSupport" value="true" <?php if ($proPlayerVisualizerSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Visualizer for audio files.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerRatingSupport"><?php _e('Show Rating Options', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerRatingSupport" type="checkbox" class="small-text" id="proPlayerRatingSupport" value="true" <?php if ($proPlayerRatingSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Rating support for all media files.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerEmbeddingSupport"><?php _e('Show Embedding/Sharing Options', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerEmbeddingSupport" type="checkbox" class="small-text" id="proPlayerEmbeddingSupport" value="true" <?php if ($proPlayerEmbeddingSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Embedding/Sharing (Viral) support for all media files.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerShortcutSupport"><?php _e('Enable Quick Keys', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerShortcutSupport" type="checkbox" class="small-text" id="proPlayerShortcutSupport" value="true" <?php if ($proPlayerShortcutSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Quick Keys for playlist browsing. Use arrow keys to brows, change volume.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerSubtitleSupport"><?php _e('Enable Subtitles via SubPly', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerSubtitleSupport" type="checkbox" class="small-text" id="proPlayerSubtitleSupport" value="true" <?php if ($proPlayerSubtitleSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off subtitle support for video files. You need to use SubPly services!', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerFlowViewSupport"><?php _e('Show Playlist Files in FlowView', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerFlowViewSupport" type="checkbox" class="small-text" id="proPlayerFlowViewSupport" value="true" <?php if ($proPlayerFlowViewSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Flow View for media files in the playlist.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerCacheTimeout"><?php _e('Cache Timeout', 'proplayer') ?> (minutes) :</label></th>
        <td>
          <input name="proPlayerCacheTimeout" type="text" class="small-text" id="proPlayerCacheTimeout" size="5" value="<?php echo $proPlayerCacheTimeout ?>"/>
          <span class="setting-description"><?php _e('Defines the lifetime of video caches, if you don\'t know what cache means, please leave as default!', 'proplayer') ?></span>
  	    </td>
      </tr>

	  <tr>
	  	<td colspan="2" style="border-bottom:1px solid #e3e3e3; padding-bottom: 13px;">
			<h2>Longtail AdSolutions Options</h2>
		</td>
	  </tr>

	  <tr>
	  	<td colspan="2" style="border-bottom:1px solid #e3e3e3; padding-bottom: 13px;">
			<h3>What is This?</h3>
			<p>
				Longtail AdSolution is completely <strong>self-serve</strong> ad solution. It allows you to embed any ad tag from any ad network (Google, ScanScout, YuMe, and more) into your website's media player. You can create pre-roll, overlay mid-roll and post-roll ads in minutes!
			</p>
			<p>	
				By using Longtail AdSolution, you can create great looking ads (pre/mid/post rolls) and even you can <strong>make money</strong> very quickly. Using this system is free. If you wanna learn more about the service please go visit <a href="http://www.longtailvideo.com/referral.aspx?page=pubreferral&ref=mhrjtrstbyxqwn" target="_new">Longtail AdSolutions</a> page, or if you're already familiar with the Ad system, you might consider <a href="http://www.longtailvideo.com/referral.aspx?page=signup&ref=mhrjtrstbyxqwni" target="_new">signing up</a> for free.
			</p>
			<p>
				A side note: Using Ad systems like Google Adsense or ScanScout, you don't earn instant money. These services are really professional services and you need to configure them properly. However Longtail AdSolutions has already done this part for you. From my personal experience, using their dashboard, the only thing you need to do is creating your custom/preselected channels and follow the implementations steps (or enable these options below).
			</p>
		</td>
	  </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerAdSupport"><?php _e('Longtail AdSolutions', 'proplayer') ?>:</label></th>
        <td style="padding-top: 7px">
          <input name="proPlayerAdSupport" type="checkbox" class="small-text" id="proPlayerAdSupport" value="true" <?php if ($proPlayerAdSupport == "true") { echo "checked='true'"; } ?> />
          <span class="setting-description"><?php _e('Turns on/off Longtail AdSolutions Network support.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerAdChannel"><?php _e('AdSolutions Channel', 'proplayer') ?>:</label></th>
        <td>
          <input name="proPlayerAdChannel" type="text" class="small-text" id="proPlayerAdChannel" value="<?php echo $proPlayerAdChannel ?>"/>
          <span class="setting-description"><?php _e('Longtail AdSolutions channel that you\'ve defined in your LongtailVideo Dashboard.', 'proplayer') ?></span>
  	    </td>
      </tr>

      <tr valign="top">
        <th scope="row"><label for="proPlayerAdScript"><?php _e('AdSolutions Script Code', 'proplayer') ?>:</label></th>
        <td>
          <textarea name="proPlayerAdScript" rows="3" class="long-text" style="width: 440px" id="proPlayerAdScript"><?php echo $proPlayerAdScript ?></textarea><br />
          <span class="setting-description"><?php _e('Longtail AdSolutions scripts. You can get this script code from LongtailVideo Dashboard\'s impelementation section.', 'proplayer') ?></span>
  	    </td>
      </tr>
    </table>
    
    <p class="submit">
      <input type="submit" class="button-primary" name="Submit" value="<?php _e('Save Options', 'proplayer') ?> &raquo;" />
    </p>
  </form> 
</div>