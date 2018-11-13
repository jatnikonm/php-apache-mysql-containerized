<!-- import the calendar script -->
<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript">
	function getId(str){
		document.forms.form1.id.value = str;	
	}
	
	function setDetails(cond, id){
		document.getElementById("pnlDetails").style.display = "inline";
		document.getElementById("pnlGrid").style.display = "none";
		document.getElementById("btnTambah").style.display = "none";
		document.getElementById("btnHapus").style.display = "none";
		document.forms.form1.task.value = cond;
		
		var txt1, txt2, txt3, txt4, txt5, txt6, txt7, txt8;
		txt1 = document.forms.form1.txt1;
		txt2 = document.forms.form1.txt2;
		txt3 = document.forms.form1.txt3;
		txt4 = document.forms.form1.txt4;
		txt5 = document.forms.form1.txt5;
		txt6 = document.forms.form1.txt6;
		txt7 = document.forms.form1.txt7;
		txt8 = document.forms.form1.txt8;
		
		if(cond == "view"){
			var val = id.split('|');
			txt1.value = val[0];
			txt2.value = val[1];
			txt3.value = val[2];
			txt4.value = val[3];
			txt5.value = val[4];
			txt6.value = val[5];
			txt7.value = val[6];
			txt8.checked = val[7];
			
			txt1.disabled = true;
			txt2.disabled = true;
			txt3.disabled = true;
			txt4.disabled = true;
			txt5.disabled = true;
			txt6.disabled = true;
			txt7.disabled = true;
			txt8.disabled = true;
			
			document.getElementById("btnSimpan").style.display = "none";
		}else{
			document.forms.form1.id.value = '';
			txt3.value = "";
			txt4.value = "";
			txt5.value = "";
			txt6.value = "";
			txt7.value = "";
			txt8.checked = false;
			
			
			txt1.disabled = false;
			txt2.disabled = false;
			txt3.disabled = false;
			txt4.disabled = false;
			txt5.disabled = false;
			txt6.disabled = false;
			txt7.disabled = false;
			txt8.disabled = false;
			document.getElementById("btnSimpan").style.display = "inline";
		}
		document.forms.form1.txt1.focus();
	}
	
	function confirmValidate(){
		if(document.forms.form1.txt1.value == ''){
			document.getElementById("req").style.display = "inline";
			return false;
		}else if(document.forms.form1.txt2.value == ''){
			document.getElementById("req2").style.display = "inline";
			return false;
		}else if(document.forms.form1.txt5.value == ''){
			document.getElementById("req3").style.display = "inline";
			return false;
		}else if(document.forms.form1.txt6.value == ''){
			document.getElementById("req4").style.display = "inline";
			return false;
		}else if(document.forms.form1.txt7.value == ''){
			document.getElementById("req5").style.display = "inline";
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
		if(document.forms.form1.id.value == ""){
			alert('Pilih Data Yang Akan Dihapus !');
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
</script>