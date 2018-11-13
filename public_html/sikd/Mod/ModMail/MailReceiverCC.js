<script type="text/javascript">
	function setDelete(id){
		var frm = document.forms.formCC.peopleId.value;
		var arrId;
		var newId = '-';
		
		arrId = frm.split(',');
		for (i=0; i<arrId.length; i++){
			if(id != arrId[i]){
				newId += ',' + arrId[i];
			}
		}
		newId = newId.replace('-,', '');
		newId = newId.replace('-', '');
		
		var from = document.forms.formCC.from.value;
		
		if(from == ''){
			parent.relocateCC(newId);
		}else{
			parent.relocate(from, newId);
		}
	}
</script>