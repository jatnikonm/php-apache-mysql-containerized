<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery.form.js"></script>

<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
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
		 $("[name=roleId]").attr("value", '');
      }
    });
    	
	$("#treeUK").dynatree("option", "autoCollapse", 0);
	$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
	$("#treeUK").dynatree("getTree").activateKey($("[name=roleId]").attr("value"));
  });

	function setLocation(id){
		var roleId = id;
		location.href='index2.php?option=<?php echo $option; ?>&task=list&roleId=' + roleId;
	}
	
	function addBerkas(){
		var cond, id;
		if(arguments[0] != undefined){
			document.forms.form1.cond.value = arguments[0];
			document.forms.form1.id.value = arguments[1];
		}
		cond = document.forms.form1.cond.value;
		id = document.forms.form1.id.value;
		
		getWindow('add_berkas', '&task=' + cond + '&id=' + id);
	}
	
	function setClose(id){
		getWindow('close_berkas', '&id=' + id);
	}
	
	function openBukaBerkas(id){
		if(document.forms.form1.groupId.value != "1"){
			return false;	
		}
		
		getWindow('open_berkas', '&id=' + id);
	}
	
	function respOpenBukaBerkas(){
		TINY.box.hide();
		location.reload(true);
	}
	
	function setSusut(){
		var frm = document.forms[0];
		var a = 0;
		var id = '';
		for (i=0; i<frm.length; i++){
			var obj = frm.elements[i];
			if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
				if (obj.checked == true){
					id = obj.value;
					a++;
				}
			}
		}	
		
		if(a == 0){
			alert('Anda Harus Memilih 1 Berkas Terlebih Dahulu !');
			return false;
		}
		
		if(a > 1){
			alert('Anda Hanya Diperbolehkan Memilih 1 Berkas !');
			for (i=0; i<frm.length; i++){
				var obj = frm.elements[i];
				if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
					obj.checked = false;
				}
			}	
			return false;
		}
		
		getWindow('susut_berkas', '&id=' + id);
					
	}
	
	function confirmValidate(){
		if(document.forms.form1.txt1.value == ''){
			document.getElementById("req").style.display = "inline";
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
	
	function getSearch(){
		var keyword = document.forms.form1.txt_search.value;
		if(keyword == ''){
			document.getElementById("req_search").style.display = "inline";
			return false;
		}		
		
		var roleId = document.forms.form1.roleId.value;
		location.href = 'index2.php?option=AdminBerkas&task=list&roleId=' + roleId + '&keyword=' + keyword;
	}
	
	function setList(){
		document.getElementById("pnlDetails").style.display = "none";
		document.getElementById("pnlGrid").style.display = "inline";
		document.getElementById("btnTambah").style.display = "inline";
		document.getElementById("btnHapus").style.display = "inline";
		document.getElementById("req").style.display = "none";
		document.forms.form1.task.value = 'delete';
	}
	
	function setDelete(){
		if(confDelete() == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
	
</script>