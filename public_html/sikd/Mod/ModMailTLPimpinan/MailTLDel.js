<script type="text/javascript">
	function setSave(){
		if(document.forms.form1.txt1.value == ""){
			document.getElementById("req1").style.display = 'inline';
			return false;
		}
		document.forms.form1.submit();
	}
</script>