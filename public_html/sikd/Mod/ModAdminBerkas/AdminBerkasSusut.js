<script type="text/javascript">
	function setProses(){
		var conf = window.confirm('Anda Yakin Akan Melakukan Proses Ini ?');
		if(conf == false){
			return false;
		}
		document.forms.form1.submit();
	}
</script>
<!-- import the calendar script -->
<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />