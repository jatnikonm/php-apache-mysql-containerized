<script type="text/javascript">
	function setSave(){
		document.getElementById("req1").style.display = 'none';
		document.getElementById("req2").style.display = 'none';
		document.getElementById("req3").style.display = 'none';
		
		if(document.forms.form1.txt1.value == ""){
			document.getElementById("req1").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt2.value == ""){
			document.getElementById("req2").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt3.value == ""){
			document.getElementById("req3").style.display = 'inline';
			return false;
		}
		
		document.forms.form1.submit();
	}
</script>
