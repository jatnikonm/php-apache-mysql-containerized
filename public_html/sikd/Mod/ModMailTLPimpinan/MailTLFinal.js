<script type="text/javascript">
	function getMsg(){
		document.forms.form2.txt4.value = document.forms.form1.txt4.value;
	}
	
	function setSave(){
		document.forms.form1.submit();
	}
	
	function close_win(){
		var vReturnValue = new Object();
		vReturnValue.cond = 'ok';
		window.returnValue = vReturnValue;
		window.close();
	}
		
</script>