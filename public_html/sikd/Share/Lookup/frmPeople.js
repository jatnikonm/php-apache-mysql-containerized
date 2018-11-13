<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<script type="text/javascript">
    
   $(function(){
		$("#treeUK").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  persist:false,
		  autoCollapse: false,
		  onActivate: function(node) {
		  	$("[name=roleId]").attr("value", node.data.key);
		  },
		  onDeactivate: function(node) {
		  }
	});
		
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
	
	function setLocation(id){
		var lookup = document.forms.form1.lookup.value;
		var modeTo = document.forms.form1.modeTo.value;
		var nama = document.forms.form1.txt_nama.value;
		var roleId = id;
		
		//window.target = 'MyWindowDetail';
		window.location = 'window_lookup.php?option=People&lookup=' + lookup + '&modeTo=' + modeTo + '&roleId=' + roleId + '&txtSearch=' + nama;	
	}
	
	function setName(str){
		document.forms.form1.PeopleName.value = str;
	}
	
	function confDone(){
		//check if there are any selected
		var frm = document.forms[0];
		var frmId = document.forms.form1.PeopleId;
		frmId.value = '-';
		
		var a = 0;
		for (i=0; i<frm.length; i++){
			var obj = frm.elements[i];
			if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
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
		
		if (frm.modeTo.value == "kepada"){
			if(a > 1){
				alert('Pilihan hanya diizinkan 1 data !');
				return false;
			}
		}
		done();
	}
					
	function done(){
		//vReturnValue.PeopleId = document.forms.form1.PeopleId.value;
		//vReturnValue.PeopleName = document.forms.form1.PeopleName.value;
		//window.returnValue = vReturnValue;
		var frm = document.forms[0];
		switch(frm.modeTo.value){
			default :
				parent.getSelect(frm.modeTo.value, frm.PeopleId.value, frm.PeopleName.value);    
				break;
			case "kepadaRD":
				parent.respOpenRD('ret_people_RD', frm.modeTo.value, frm.PeopleId.value);
				break;
			case "tembusanRD":
				parent.respOpenRD('ret_people_RD', frm.modeTo.value, frm.PeopleId.value);
				break;
		}
	}
			
	function tutup()
	{
		parent.TINY.box.hide();
	}
	
</script>