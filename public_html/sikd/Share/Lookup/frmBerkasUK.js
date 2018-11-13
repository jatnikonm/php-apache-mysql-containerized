<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<script type="text/javascript">
	$(function(){
		$("#treeUK").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
		  	$("[name=roleId]").attr("value", node.data.key);
		  },
		  onDeactivate: function(node) {
		  }
	});
		
	$("#treeUK").dynatree("option", "autoCollapse", 0);
	$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
	$("#treeUK").dynatree("getTree").activateKey($("[name=roleId]").attr("value"));
  });
  
	var vReturnValue = new Object();
	vReturnValue.BerkasId = '';
	
	function changeCheckState(checked){
		var frm  = document.forms[0];
		for (i=0; i<frm.length; i++){
			var obj = frm.elements[i];
			if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
				obj.checked = checked;
			}
		}
	}
	
	function getSearch(key){
		var roleId = document.forms[0].roleId.value;
		location.href = 'window_lookup.php?option=BerkasUK&task=list&NId=<?php echo $NId; ?>&search=' + key + '&roleId=' + roleId;
	}
	
	
	function setId(id){
		document.forms.form1.BerkasIdpil.value = id;
	}
	
	function setLocation(id){
		location.href='window_lookup.php?option=BerkasUK&task=list&NId=<?php echo $NId; ?>&roleId=' + id;
	}
	
	function confDone(){
		//check if there are any selected
		var frm = document.forms[0];
        //var frmId = document.forms.form1.BerkasId.value;
		var frmId = $("#BerkasIdpil").val();
		//frmId.value = '-';
		var a = 0;
		for (i=0; i<frm.length; i++){
			var obj = frm.elements[i];
			if ((obj.name == 'ids[]') && (obj.type == 'radio')) {
				if (obj.checked == true){
					frmId.value += ',' + obj.value;
					a++;      
				}
			}
		}

		if(a == 0){
			alert('Anda Harus Pilih minimal 1 data !');
			return false;
		}
				
		if(a > 1){
			alert('Pilihan hanya diizinkan 1 data !');
			return false;
		}
		done();
	}

	function done(){
		var bId;
		//bId = document.forms.form1.BerkasId.value;
        bId = $("#BerkasIdpil").val();
		bId = bId.replace('-,', '');
		bId = bId.replace('-', '');

		parent.resOpenBerkas(bId);
	}
			
	function tutup()
	{
		parent.closeWindow();
	}
</script>