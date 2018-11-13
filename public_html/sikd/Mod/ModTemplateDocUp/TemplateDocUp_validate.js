<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript">
	function addDoc(){
		getWindow('admin_uploaddoc', '');
	}

	function confirmValidate(){
		if(document.forms.form1.txt1.value == ''){
			document.getElementById("req").style.display = "inline";
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
	
	function setDelete(){
		if(confDelete() == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
</script>