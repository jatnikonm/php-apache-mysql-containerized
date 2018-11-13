<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
	<link rel="stylesheet" type="text/css" href="style/tree.skin.css">

<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<!-- import the calendar script -->
<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-2.css" title="win2k-2" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-cold-2.css" title="win2k-cold-2" />

<script type="text/javascript">
	$(function(){
		$("#treeUK").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
			  if($("[name=task]").attr("value") == 'newFix'){
				  $("#treeUK").dynatree("getTree").activateKey($("[name=txt1_2]").attr("value"));
			  }else{
				  $("[name=txt1]").attr("value", node.data.key);
			  }
		  },
		  onDeactivate: function(node) {
		  }
	});
		
	$("#treeUK").dynatree("option", "autoCollapse", 0);
	$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
	$("#treeUK").dynatree("getTree").activateKey($("[name=txt1]").attr("value"));
	
	
	$("#treeCl").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
		  	if($("[name=task]").attr("value") == 'edit'){
				$("#treeCl").dynatree("getTree").activateKey($("[name=txt2_2]").attr("value"));
			}else{
				setBerkas(node.data.key);
			}
		  },
		  onDeactivate: function(node) {
			$("[name=txt2]").attr("value", "");
		  }
		});
    	$("#treeCl").dynatree("option", "autoCollapse", 1);
		$("#treeCl").dynatree("option", "fx", { height: "toggle", duration: 200 });
		$("#treeCl").dynatree("getTree").activateKey($("[name=txt2_2]").attr("value"));


  });

    $("#txt3").focus(function(){
      alert();
    })
	function setBerkas(str){
		var value = str.split("|");
		document.forms.form1.txt2.value = value[0];
		document.forms.form1.txt3.value = value[1];
		document.forms.form1.thn.value = value[2];
		document.forms.form1.thn2.value = value[3];
        document.forms.form1.txt7.value = value[4];

        var klas = value[1];
        $.ajax({
        url: "Mod/ModAdminBerkas/getnumberberkas.php?klas="+klas,
        cache: false,
        success: function(number){
        if(value[0]!=1 && value[5]!=1)
        $("#txt4").val(number); else $("#txt4").val("");}
        });
	}

	function trim(s)
	{
		var l=0; var r=s.length -1;
		while(l < s.length && s[l] == ' '){	
			l++; 
		}
		while(r > l && s[r] == ' '){	
			r-=1;	
		}
		return s.substring(l, r+1);
	}
	
	function showExisting(){
		var id = document.forms.form1.txt2.value;
		if(id == ''){
			alert('Pilih Klasifikasi terlebih dahulu !');
			return false;
		}
		parent.getWindow('vw_berkas_nmr', '&ClId=' + id);
	}
		
	function ChooseRadRetensi(group, radioVal){
		if(group == "active"){
			if(radioVal == "rdRetSplit"){
				document.forms.form1.thn.disabled = false;
				document.forms.form1.bln.disabled = false;
				document.forms.form1.hr.disabled = false;
				
				document.forms.form1.tgl.value = "";
				document.forms.form1.tgl.disabled = true;
				document.forms.form1.trigger1.style.display = "none";
			}else{
				document.forms.form1.thn.value = "";
				document.forms.form1.bln.value = "";
				document.forms.form1.hr.value = "";
				document.forms.form1.thn.disabled = true;
				document.forms.form1.bln.disabled = true;
				document.forms.form1.hr.disabled = true;
				
				document.forms.form1.tgl.disabled = false;
				document.forms.form1.trigger1.style.display = "inline";
			}
		}else if(group == "inactive"){
			if(radioVal == "rdRetSplit2"){
				document.forms.form1.thn2.disabled = false;
				document.forms.form1.bln2.disabled = false;
				document.forms.form1.hr2.disabled = false;
				
				document.forms.form1.tgl2.value = "";
				document.forms.form1.tgl2.disabled = true;
				document.forms.form1.trigger2.style.display = "none";
			}else{
				document.forms.form1.thn2.value = "";
				document.forms.form1.bln2.value = "";
				document.forms.form1.hr2.value = "";
				document.forms.form1.thn2.disabled = true;
				document.forms.form1.bln2.disabled = true;
				document.forms.form1.hr2.disabled = true;
				document.forms.form1.tgl2.disabled = false;
				document.forms.form1.trigger2.style.display = "inline";
			}
		}
	}
	
	
	function ChooseRetensi(group){
		if(group == "created"){                
			
			document.forms.form1.rdRetSplit.disabled = false;
			document.forms.form1.rdTgl.disabled = false;
			
			document.forms.form1.rdRetSplit2.disabled = false;
			document.forms.form1.rdTgl2.disabled = false;
			
			document.forms.form1.thn.disabled = false;
			document.forms.form1.bln.disabled = false;
			document.forms.form1.hr.disabled = false;
			document.forms.form1.tgl.disabled = true;
			document.forms.form1.trigger1.style.display = "none";
			
			document.forms.form1.thn2.disabled = false;
			document.forms.form1.bln2.disabled = false;
			document.forms.form1.hr2.disabled = false;
			
			document.forms.form1.tgl2.disabled = true;
			document.forms.form1.trigger2.style.display = "none";
			
		}else if(group == "closed"){
			
			document.forms.form1.rdRetSplit.checked = true;
			document.forms.form1.rdRetSplit.disabled = false;
			document.forms.form1.rdTgl.disabled = true;
			
			document.forms.form1.rdRetSplit2.checked = true;
			document.forms.form1.rdRetSplit2.disabled = false;
			document.forms.form1.rdTgl2.disabled = true;
			
			document.forms.form1.thn.disabled = false;
			document.forms.form1.bln.disabled = false;
			document.forms.form1.hr.disabled = false;
			document.forms.form1.tgl.value = "";
			document.forms.form1.tgl.disabled = true;
			document.forms.form1.trigger1.style.display = "none";
			
			document.forms.form1.thn2.disabled = false;
			document.forms.form1.bln2.disabled = false;
			document.forms.form1.hr2.disabled = false;
			document.forms.form1.tgl2.value = "";
			
			document.forms.form1.tgl2.disabled = true;
			document.forms.form1.trigger2.style.display = "none";
		
		}else{
			document.forms.form1.rdRetSplit.checked = false;
			document.forms.form1.rdRetSplit.disabled = true;
			
			document.forms.form1.rdTgl.checked = false;
			document.forms.form1.rdTgl.disabled = true;
			
			document.forms.form1.rdRetSplit2.checked = false;
			document.forms.form1.rdRetSplit2.disabled = true;
			
			document.forms.form1.rdTgl2.checked = false;
			document.forms.form1.rdTgl2.disabled = true;
			
			document.forms.form1.thn.disabled = true;
			document.forms.form1.bln.disabled = true;
			document.forms.form1.hr.disabled = true;
			document.forms.form1.tgl.value = "";
			document.forms.form1.tgl.disabled = true;
			document.forms.form1.trigger1.style.display = "none";
			
			document.forms.form1.thn2.disabled = true;
			document.forms.form1.bln2.disabled = true;
			document.forms.form1.hr2.disabled = true;
			document.forms.form1.tgl2.value = "";
			
			document.forms.form1.tgl2.disabled = true;
			document.forms.form1.trigger2.style.display = "none";                
		}
	}
	
	function setSave(){
		document.getElementById("req").style.display = 'none';
		document.getElementById("req2").style.display = 'none';
		document.getElementById("req3").style.display = 'none';
		document.getElementById("req4").style.display = 'none';
		document.getElementById("req5").style.display = 'none';
		document.getElementById("req6").style.display = 'none';
		document.getElementById("req_number").style.display = 'none';
		
		if(document.forms.form1.txt1.value == ""){
			document.getElementById("req").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt3.value == ""){
			document.getElementById("req2").style.display = 'inline';
			return false;
		}

	
		if(document.forms.form1.txt4.value == ""){
			document.getElementById("req3").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt5.value == ""){
			document.getElementById("req4").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt6.value == ""){
			document.getElementById("req5").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt7.value == ""){
			document.getElementById("req6").style.display = 'inline';
			return false;
		}
				
		//--------------------- retensi ----------------------
		if((document.forms.form1.rentesiAktif.checked == false) && (document.forms.form1.rentesiAktif.checked == false)){
			document.getElementById("req_number").style.display = 'inline';
			document.getElementById("req_number").title = 'Pilih Salah satu Pada Retensi Arsip! Berdasarkan Tahun-Bulan-Hari atau Tanggal';
			document.forms.form1.thn.focus();
			return false;
		}
		
		if(document.forms.form1.rdRetSplit.checked == true){
			if((document.forms.form1.thn.value == '') &&
				(document.forms.form1.bln.value == '') && 
				(document.forms.form1.hr.value == '')){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Berdasarkan Tahun-Bulan-Hari pada Retensi Aktif Harus Diisi !';
				document.forms.form1.thn.focus();
				return false;				
			}
		}
		
		if(document.forms.form1.rdRetSplit2.checked == true){
			if((document.forms.form1.thn2.value == '') &&
				(document.forms.form1.bln2.value == '') && 
				(document.forms.form1.hr2.value == '')){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Berdasarkan Tahun-Bulan-Hari pada Retensi InAktif Harus Diisi !';
				document.forms.form1.thn2.focus();
				return false;				
			}
		}
		
		if(document.forms.form1.thn.value != ''){
			if(IsNumeric(document.forms.form1.thn.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Tahun Pada Retensi Arsip - Aktif Harus Angka !';
				document.forms.form1.thn.focus();
				return false;
			}
		}
		
		if(document.forms.form1.bln.value != ''){
			if(IsNumeric(document.forms.form1.bln.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Bulan Pada Retensi Arsip - Aktif Harus Angka !';
				document.forms.form1.bln.focus();
				return false;
			}
		}
		
		if(document.forms.form1.hr.value != ''){
			if(IsNumeric(document.forms.form1.hr.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Hari Pada Retensi Arsip - Aktif Harus Angka !';
				document.forms.form1.hr.focus();
				return false;
			}
		}
		
		if(document.forms.form1.thn2.value != ''){
			if(IsNumeric(document.forms.form1.thn2.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Tahun Pada Retensi Arsip - InAktif Harus Angka !';
				document.forms.form1.thn2.focus();
				return false;
			}
		}
		
		if(document.forms.form1.bln2.value != ''){
			if(IsNumeric(document.forms.form1.bln2.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Bulan Pada Retensi Arsip - InAktif Harus Angka !';
				document.forms.form1.bln2.focus();
				return false;
			}
		}
		
		if(document.forms.form1.hr2.value != ''){
			if(IsNumeric(document.forms.form1.hr2.value) == false){
				document.getElementById("req_number").style.display = 'inline';
				document.getElementById("req_number").title = 'Isian Hari Pada Retensi Arsip - InAktif Harus Angka !';
				document.forms.form1.hr2.focus();
				return false;
			}
		}
		//---------------------------------------------
		
		document.forms.form1.submit();
	}
	
	function IsNumeric(input)
	{
	   return (input - 0) == input && input.length > 0;
	}
	
</script>