/**
 * @author Isa Goksu
 * @copyright Copyright © 2009, Isa Goksu, All rights reserved, License: BSD.
 */

(function() {
	tinymce.PluginManager.requireLangPack('proPlayer');

	tinymce.create('tinymce.plugins.ProPlayer', {
		init : function(ed, url) {
			ed.addCommand('mceProPlayer', function() {
				ed.windowManager.open({
					file : url + '/dialog.htm',
					width : 430,
					height : 440,
					inline : 1
				}, {
					plugin_url : url,
					proPlayerDefaultWidth : '530',
					proPlayerDefaultHeight : '253',
					videoPreviewURL : '',
					videoRtmpServer : ''
				});
			});

			ed.addButton('proPlayer', {
				title : 'proPlayer.desc',
				cmd : 'mceProPlayer',
				image : url + '/img/pro-player.png'
			});

			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('proPlayer', n.nodeName == 'IMG');
			});
		},

		createControl : function(n, cm) {
			return null;
		},

		getInfo : function() {
			return {
				longname : 'ProPlayer TinyMCE Toolbar Button',
				author : 'Isa Goksu',
				authorurl : 'http://isagoksu.com',
				infourl : 'http://isagoksu.com/proplayer-wordpress-plugin/',
				version : "4.7.5"
			};
		}
	});

	tinymce.PluginManager.add('proPlayer', tinymce.plugins.ProPlayer);
})();