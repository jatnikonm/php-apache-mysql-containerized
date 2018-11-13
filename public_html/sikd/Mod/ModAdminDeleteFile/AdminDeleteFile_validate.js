<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript">
	function setDelete(){
		if(confDelete() == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
</script>