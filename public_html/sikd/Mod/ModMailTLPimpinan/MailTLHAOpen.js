<script type="text/javascript">
	function ShowPeople() {
		window.open('window_lookup.php?option=People&modeTo=tembusan&lookup=upper','myArgs',
												'center=yes,resizable=no,scroll=no,height=530,width=900,status=no');
	}
	
	function getSelect(mode, val1, val2){
		var peopleId = document.forms.form1.txt1;
		if (peopleId.value != ""){
			peopleId.value += ',' + (val1).replace('-,', '');
		}else{
			peopleId.value = (val1).replace('-,', '');
		}
		relocateCC(peopleId.value);
	}
	
	function relocateCC(idCC){
		var peopleId = document.forms.form1.txt1;
		peopleId.value = idCC;
		document.getElementById("frmCC").src = 'frame.php?option=Mail&filetopen=MailReceiverCC&peopleId=' + peopleId.value;
	}
	
	function setSave(){
		if(document.forms.form1.txt1.value == ''){
			alert('Tambahkan Pengguna Untuk Menyimpan Data !');
			ShowPeople();
			return false;
		}
		
		document.forms.form1.submit();
	}
</script>