<script type="text/javascript">
	function subRestart(){
		document.getElementById("req1").style.display = 'none';
		document.getElementById("req2").style.display = 'none';
		document.getElementById("req3").style.display = 'none';
		document.getElementById("req4").style.display = 'none';
		document.getElementById("req5").style.display = 'none';
		var frm = document.forms[0];
		
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
		
		if(frm.rad2.checked == true){
			if(document.forms.form1.txt5.value == ""){
				document.getElementById("req5").style.display = 'inline';
				return false;
			}
		}
			
		document.forms.form1.submit();
	}
	
	function setInstall(str){		
		if (str == "new"){
			document.getElementById("tbl_upgrade").style.display = "none";		
		}else{		
			document.getElementById("tbl_upgrade").style.display = "inline";
		}		
	}
</script>