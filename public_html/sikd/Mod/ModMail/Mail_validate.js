<link rel="stylesheet" type="text/css" href="style/jquery.autocomplete.css">

<!-- import the calendar script -->
<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />

<script type="text/javascript" src="include/jquery.autocomplete.js"></script>

<script type='text/javascript'>

$(document).ready(function(){
	$("#txt_berkas").autocomplete("Mod/ModMail/loadberkas.php", {
		matchContains: true,
		selectFirst: true
});

	$("#txt_berkas").result(function(){
		var id = $("#txt_berkas").val();
		var kode = id.split(" - ");
		var ambil = kode[0];
		$("#txt13").val(ambil);
	});
});

//-------------------------- AutoComplete -----------------------------------
	$().ready(function() {

		if(document.forms.form1.txt23.value == 'inbox'){		
			$("#txt_kepada").tokenInput("Share/Lookup/listPeopleMail.php", {
				theme: "facebook",
				preventDuplicates: true,
				hintText: "Surat dikirim kepada ?",
				noResultsText: "O Hasil",
				searchingText: "Mencari...",
				animateDropdown: false
			});
		}

		if(document.forms.form1.txt23.value == 'outbox'){		
			$("#txt_kepada").tokenInput("Share/Lookup/listPeopleMail.php", {
				theme: "facebook",
				preventDuplicates: true,
				hintText: "Surat dikirim kepada ?",
				noResultsText: "O Hasil",
				searchingText: "Mencari...",
				animateDropdown: false
			});
		}

		if(document.forms.form1.txt23.value == 'outboxmemo'){		
			$("#txt_kepada").tokenInput("Share/Lookup/listPeopleMail.php", {
				theme: "facebook",
				preventDuplicates: true,
				hintText: "Surat dikirim kepada ?",
				noResultsText: "O Hasil",
				searchingText: "Mencari...",
				animateDropdown: false
			});
		}

		if(document.forms.form1.txt23.value == 'outboxins'){		
			$("#txt_kepada").tokenInput("Share/Lookup/listPeopleMail.php", {
				theme: "facebook",
				preventDuplicates: true,
				hintText: "Surat dikirim kepada ?",
				noResultsText: "O Hasil",
				searchingText: "Mencari...",
				animateDropdown: false
			});
		}

		$("#txt_CC").tokenInput("Share/Lookup/listPeople.php", {
			theme: "facebook",
			preventDuplicates: true,
			hintText: "Tembusan dikirim kepada ?",
			noResultsText: "O Hasil",
			searchingText: "Mencari...",
			animateDropdown: false
		});
	});

//--------------------------------------------------------------------------------

	function ShowPeople(mode) {
		var modeRD = 'kepada';
		var lookup;
		if(mode == 'kepada'){
			lookup = document.forms.form1.lookup.value;
		}else{
			lookup = 'upper';
		}
		getWindow('vw_people', '&modeRD=' + modeRD + '&modeTo=' + mode + '&lookup=' + lookup);
	}

	function getSelect(mode, val1, val2){
		if (mode == "kepada"){
			var peopleId = document.forms.form1.txt14;
			var penerima = document.forms.form1.txt_kepada;
			peopleId.value = (val1).replace('-,', '');
			penerima.value = val2;
		}else if(mode == 'tembusan'){
			peopleId = document.forms.form1.txt15;
			if (peopleId.value != ""){
				peopleId.value += ',' + (val1).replace('-,', '');
			}else{
				peopleId.value = (val1).replace('-,', '');
			}
			document.getElementById("frmCC").src = 'frame.php?option=Mail&filetopen=MailReceiverCC&peopleId=' + peopleId.value;
		}else if(mode == 'berkas'){
			document.forms.form1.txt13.value = val1;
		}
		TINY.box.hide();
	}
	
	function openRef(){
		//window.open('window_lookup.php?option=Surat', 'myRef', 'center=yes,resizable=yes,scrollbar=yes,height=530,width=1050,status=no');
		getWindow('vw_surat', '');
	}
	
	function getSelectSurat(hal, nid, bid, tref){
		document.forms.form1.txt24.value = hal;
		document.forms.form1.txt25.value = nid;
		document.forms.form1.txt26.value = bid;
		document.forms.form1.txt27.value = tref;
		TINY.box.hide();
	}
	
	function openBerkas(){
		getWindow('search_berkas');
	}
	
	function resOpenBerkas(){
		TINY.box.hide();
		document.forms.form1.txt13.value = arguments[0];
        var id = $("#txt13").val();
		$.ajax({
		  type : "POST",
		  url  : "Mod/ModMail/loadberkas.php",
          data : "req=load&task="+id,
		  success : function(msg){
			  $("#txt_berkas").val(msg);
		  }

		});
	}
	
	function addBerkas(){
		getWindow('add_berkas','&task=newFix');
	}
	
	function respAddBerkas(){
		TINY.box.hide();
		if (arguments[0] != undefined) {
			document.forms.form1.txt13.options[(document.forms.form1.txt13.options.length)] = new Option(arguments[0], arguments[1], false, true);
		}
	}
	
	function openAgenda(){
		var NTipe = document.forms.form1.txt23.value;
		getWindow('vw_agenda', 'Ntipe=' + NTipe);
	}
	
	function relocateCC(idCC){
		var peopleId = document.forms.form1.txt15;
		peopleId.value = idCC;
		document.getElementById("frmCC").src = 'frame.php?option=Mail&filetopen=MailReceiverCC&peopleId=' + peopleId.value;
	}
	
	function getSave(){
//		document.getElementById("req1").style.display = 'none';
//		document.getElementById("req2").style.display = 'none';
		document.getElementById("req3").style.display = 'none';
		document.getElementById("req4").style.display = 'none';
		document.getElementById("req5").style.display = 'none';
//		document.getElementById("req7").style.display = 'none';
//		document.getElementById("req8").style.display = 'none';
//		document.getElementById("req9").style.display = 'none';
		document.getElementById("req10").style.display = 'none';
//		document.getElementById("req11").style.display = 'none';
		document.getElementById("req13").style.display = 'none';
		document.getElementById("req14").style.display = 'none';
//		document.getElementById("req18").style.display = 'none';
//		document.getElementById("req19").style.display = 'none';
//		document.getElementById("req20").style.display = 'none';
//		
//		if(document.forms.form1.txt1.value == ''){
//			document.getElementById("req1").style.display = 'inline';
//			document.forms.form1.txt1.focus;
//			return false;
//		}
//		
//		
//		if(document.forms.form1.txt2.value == ''){
//			document.getElementById("req2").style.display = 'inline';
//			document.forms.form1.txt2.focus;
//			return false;
//		}
		
		if(document.forms.form1.txt3.value == ''){
			document.getElementById("req3").style.display = 'inline';
			document.forms.form1.txt3.focus;
			return false;
		}
		
		if(document.forms.form1.txt4.value == ''){
			document.getElementById("req4").style.display = 'inline';
			document.forms.form1.txt4.focus;
			return false;
		}
		
		if(document.forms.form1.txt5.value == ''){
			document.getElementById("req5").style.display = 'inline';
			document.forms.form1.txt5.focus;
			return false;
		}
		
//		if(document.forms.form1.txt7.value == ''){
//			document.getElementById("req7").style.display = 'inline';
//			document.forms.form1.txt7.focus;
//			return false;
//		}
//		
//		if(document.forms.form1.txt8.value == ''){
//			document.getElementById("req8").style.display = 'inline';
//			document.forms.form1.txt8.focus;
//			return false;
//		}
//		
//		if(document.forms.form1.txt9.value == ''){
//			document.getElementById("req9").style.display = 'inline';
//			document.forms.form1.txt9.focus;
//			return false;
//		}
//		
		if(document.forms.form1.task.value == "new"){
			if(document.forms.form1.txt10.value == ''){
				document.getElementById("req10").style.display = 'inline';
				document.forms.form1.txt10.focus;
				return false;
			}
			
//			if(document.forms.form1.txt11.value == ''){
//				document.getElementById("req11").style.display = 'inline';
//				document.forms.form1.txt11.focus;
//				return false;
//			}
//			
//			if(document.forms.form1.txt23.value == 'outbox'){		
//				if(document.forms.form1.txt13.value == ''){
//					document.getElementById("req13").style.display = 'inline';
//					document.forms.form1.txt13.focus;
//					return false;
//				}
//			}
//
//			if(document.forms.form1.txt23.value == 'outboxmemo'){		
//				if(document.forms.form1.txt13.value == ''){
//					document.getElementById("req13").style.display = 'inline';
//					document.forms.form1.txt13.focus;
//					return false;
//				}
//			}
//
//			if(document.forms.form1.txt23.value == 'outboxins'){		
//				if(document.forms.form1.txt13.value == ''){
//					document.getElementById("req13").style.display = 'inline';
//					document.forms.form1.txt13.focus;
//					return false;
//				}
//			}
			
			if(document.forms.form1.txt_kepada.value == ''){
				if(document.forms.form1.txt23.value == 'inbox'){
					document.getElementById("req14").style.display = 'inline';
					document.forms.form1.txt_kepada.focus;
					return false;
				}				
			}

		}
				
//		if(document.forms.form1.txt18.value == ''){
//			document.getElementById("req18").style.display = 'inline';
//			document.forms.form1.txt18.focus;
//			return false;
//		}
//		
//		if(document.forms.form1.txt19.value == ''){
//			document.getElementById("req19").style.display = 'inline';
//			document.forms.form1.txt19.focus;
//			return false;
//		}
//		
//		if(IsNumeric(document.forms.form1.txt20.value) == false){
//			document.getElementById("req20").style.display = 'inline';
//			document.forms.form1.txt20.focus;
//			return false;
//		}
		
		document.forms.form1.submit();
	}	
	
	function IsNumeric(input)
	{
	   return (input - 0) == input && input.length > 0;
	}

</script>