<script type="text/javascript">
	function openRef(){
		parent.openRef(<?php echo clean($_REQUEST["NId"]); ?>);   
	}
	
	function getSelectSurat(hal, nid, bid, tref){
		document.forms.form1.txt1.value = hal;
		document.forms.form1.txt2.value = nid;
		document.forms.form1.txt3.value = bid;
		document.forms.form1.txt5.value = tref;
	}
	
	function setSave(){
		if(document.forms.form1.txt2.value == ''){
			alert('Pilih Surat Yang Akan Dijadikan Referensi !');
			openRef();
			return false;
		}
		
		if(document.forms.form1.BerkasId.value != document.forms.form1.txt3.value){
			if(document.forms.form1.txt4.value=='reply'){
				var conf = window.confirm("Dengan memasukkan surat ini sebagai Balasan, sistem akan memberkaskan ulang. \nklik 'Ok' untuk melanjutkan 'Cancel' untuk membatalkan.");
				if(conf == false){
					return false;
				}
				document.forms.form1.txt4.value = conf;
			}
		}
		
		document.forms.form1.submit();
	}
</script>