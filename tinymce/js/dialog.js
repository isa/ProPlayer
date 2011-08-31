tinyMCEPopup.requireLangPack();

var ProPlayerDialog = {
	init : function() {
		var f = document.forms[0];

		f.videoURL.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		var regex = new RegExp("(http.*)\\[.*");
		var match = regex.exec(f.videoURL.value);
		
		if (match != null) {
			f.videoURL.value = match[1];
		}
		
		f.videoPreviewURL.value = tinyMCEPopup.getWindowArg('videoPreviewURL');
		f.pDefaultWidth.value = tinyMCEPopup.getWindowArg('proPlayerDefaultWidth');
		f.pDefaultHeight.value = tinyMCEPopup.getWindowArg('proPlayerDefaultHeight');
	},

	insert : function() {
		var f = document.forms[0];
		var options = "";
		
		if (f.pDefaultWidth.value != "") {
			options += " width='" + f.pDefaultWidth.value + "'";
		}
		
		if (f.pDefaultHeight.value != "") {
			options += " height='" + f.pDefaultHeight.value + "'";
		}

		if (f.pDefaultRepeat.value == "true") {
			options += " repeat='true'";
		}
		
		if (f.pDefaultAutoStart.value == "true") {
			options += " autostart='true'";
		}
		
		options += " type='" + f.pDefaultType.value + "'"		

		if (f.videoPreviewURL.value != "") {
			options += " image='" + f.videoPreviewURL.value + "'";
		}
		
		if (f.videoRtmpServer.value != "") {
			options += " streamer='" + f.videoRtmpServer.value + "'";
		}
		
		var result = "[pro-player" + options + "]" + f.videoURL.value + "[/pro-player]";

		tinyMCEPopup.editor.execCommand('mceInsertContent', false, result);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(ProPlayerDialog.init, ProPlayerDialog);
