<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript">
	function setDetails(cond, id){
		document.getElementById("pnlDetails").style.display = "inline";
		document.getElementById("pnlGrid").style.display = "none";
		document.forms.form1.task.value = cond;
		if(cond == "edit"){
			var val = id.split('|');
			document.forms.form1.id.value = val[0];
			document.forms.form1.txt0.value = val[1];
			document.forms.form1.txt1.value = val[2];
		}else{
			document.forms.form1.id.value = '';
			document.forms.form1.txt0.value = '';
			document.forms.form1.txt1.value = '';
		}
		document.forms.form1.txt1.focus();
	}
	
	function confirmValidate(){
		document.forms.form1.submit();
	}
	
	function setList(){
		document.getElementById("pnlDetails").style.display = "none";
		document.getElementById("pnlGrid").style.display = "inline";
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