<script type="text/javascript">
	function setDetails(cond, id){
		document.getElementById("pnlDetails").style.display = "inline";
		document.getElementById("pnlGrid").style.display = "none";
		document.getElementById("btnTambah").style.display = "none";
		document.getElementById("btnHapus").style.display = "none";
		document.forms.form1.task.value = cond;
		if(cond == "edit"){
			var val = id.split('|');
			document.forms.form1.id.value = val[0];
			document.forms.form1.txt1.value = val[1];
		}else{
			document.forms.form1.id.value = '';
			document.forms.form1.txt1.value = '';
		}
		document.forms.form1.txt1.focus();
	}
	
	function confirmValidate(){
		if(document.forms.form1.txt1.value == ''){
			document.getElementById("req").style.display = "inline";
			return false;
		}else{
			document.forms.form1.submit();
		}
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