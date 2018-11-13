<script type="text/javascript">   
	function getSave(){
		if(document.forms.form1.txt2.value == ''){
			alert('Keterangan Text Halaman Depan Wajib Diisi !');
			return false;	
		}
		document.forms.form1.submit();		
	}
		
	function UploadGambar(){
		var myArgs;
		myArgs = window.showModalDialog('window.php?option=SetSitus&filetopen=SetSitus_Upload&width=410', 'myModal', 
				'center:yes;resizable:no;scroll=no;dialogHeight:180px;dialogWidth:400px;status=no;');
		if (myArgs != null) {
			if (myArgs.length != 0) {
				if (myArgs.ImgFile.toString() != ""){
					document.forms.form1.txt1.value = myArgs.ImgFile.toString();
					document.getElementById('imgFront').src = 'images/Frontpage/' + myArgs.ImgFile.toString();
				}
			}
		}
	}
</script>
<script type="text/javascript" src="include/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
	
			// Skin options
			skin : "o2k7",
			skin_variant : "silver"
	
			// Example content CSS (should be your site CSS)
			//content_css : "style.css"
	
	});
</script>
