<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/jquery.form.js"></script>

<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>
<script type="text/javascript">
	$(function(){
		$("#treeCl").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
		  	$("[name=ClId]").attr("value", node.data.key);
		  },
		  onDeactivate: function(node) {
			$("[name=ClId]").attr("value", "");
		  }
		});
    	$("#treeCl").dynatree("option", "autoCollapse", 1);
		$("#treeCl").dynatree("option", "fx", { height: "toggle", duration: 200 });
		$("#treeCl").dynatree("getTree").activateKey(<? echo $_REQUEST["ClId"]; ?>);
  });
  	
	function setLocationCl(id){
		var loc;
		var NId;
		NId = document.forms.form1.id.value;
		
		loc = 'window_lookup.php?option=Surat&ClId=' + id;
		if(NId != ''){
			loc += '&NId=' + NId;
		}
		location.href = loc;		
	}
	
	function setLocationBr(id){
		var loc;
		var NId;
		NId = document.forms.form1.id.value;
		
		loc = 'window_lookup.php?option=Surat&ClId=' + <? echo $_REQUEST["ClId"]; ?> + '&BerkasId=' + id;
		if(NId != ''){
			loc += '&NId=' + NId;
		}
		location.href = loc;
		
	}
	
	function setName(id, name, bid, tref){
		document.forms.form1.NId.value = id;
		document.forms.form1.NHal.value = name;
		document.forms.form1.BId.value = bid;
		document.forms.form1.TipeRef.value = tref;
	}
	
	function done(){
		var NId, NHal, BId, TipeRef;
		NId = document.forms.form1.NId.value;
		NHal = document.forms.form1.NHal.value;
		BId = document.forms.form1.BId.value;
		TipeRef = document.forms.form1.TipeRef.value;
		if(NId == ''){
			alert('Pilih Surat Yang Akan Menjadi Referensi');
			return false;
		}
		
		parent.getSelectSurat(NHal, NId, BId, TipeRef);
	}
</script>
<script type="text/javascript" src="include/ConfirmDelete.js"></script>
