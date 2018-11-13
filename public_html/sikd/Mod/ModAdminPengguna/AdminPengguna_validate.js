<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery.form.js"></script>

<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<link rel="stylesheet" type="text/css" href="include/assets/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/chosen.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace-fonts.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

<script type="text/javascript" src="include/assets/js/ace-extra.js"></script>
<script type="text/javascript" src="include/assets/js/chosen.jquery.js"></script>

<script type="text/javascript">
	jQuery(function($) {
		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	
			$(window)
			.off('resize.chosen')
			.on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': 500});
				})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': 500});
				})
			});
		}
	});
</script>

<script type="text/javascript">
	$(function(){
		$("#treeUK").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
			 $("[name=roleId]").attr("value", node.data.key);	
		  },
		  onDeactivate: function(node) {
			 $("[name=roleId]").attr("value", '');
		  }
		});
			
		$("#treeUK").dynatree("option", "autoCollapse", 0);
		$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
		$("#treeUK").dynatree("getTree").activateKey($("[name=roleId]").attr("value"));
	  });
	
	function setLocation(id){
		location.href='index2.php?option=<?php echo $option; ?>&task=list&roleId=' + id;
	}

	function openDetails(cond, id){
		getWindow('admin_pengguna', '&task=' + cond + '&id=' + id);
	}
	
	function respDetails(){
		TINY.box.hide();
		if(arguments[0] == 'reload'){
			location.reload(true);
		}
	}
	
	function setDelete(){
		if(confDelete() == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}


    function piluk(){
      var pil_uk = $("#pil_uk").val();
      window.location.href = "index2.php?option=AdminPengguna&task=list&roleId="+pil_uk;
    }

	function getAll(){
		location.href = '?option=AdminPengguna';
	}
	
	function setSearch(){
		var loc = 'index2.php?option=AdminPengguna&task=list';	
		
		if(document.forms.form1.txt1.value != ''){
			loc += '&txt1=' + document.forms.form1.txt1.value;
		}
		
		if(document.forms.form1.txt2.value != ''){
			loc += '&txt2=' + document.forms.form1.txt2.value;
		}
		
		location.href=loc;
	}
	
</script>