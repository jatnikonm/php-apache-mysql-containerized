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

<script type="text/javascript" >
	function OpenReport(){
		if (document.forms.form1.txt2.value == "") {
			alert("Anda Belum Memasukkan Tanggal Periode Awal ");
			document.forms.form1.txt2.focus();
			return (false);
		}
		if (document.forms.form1.txt3.value == "") {
			alert("Anda Belum Memasukkan Tanggal Periode Akhir ");
			document.forms.form1.txt3.focus();
			return (false);
		}

		var tgl1 = document.forms.form1.txt2.value;
		var tgl2 = document.forms.form1.txt3.value;
		window.open('Mod/ModAdminReportLogTL/AdminReportLogTL_web.php?tgl1=' + tgl1 + '&tgl2=' + tgl2, 'myReport',
				'Height=380px,Width=1024px;status=no;')
	}
</script>