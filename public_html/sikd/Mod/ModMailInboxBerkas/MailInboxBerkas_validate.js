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
<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript" >
	function setDelete(){
		if(confDelete() == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}
	
	function setDetails(mode, page, id){
		location.href = 'index2.php?option=MailTL&task=' + mode + '&page=' + page + '&id=' + id;
	}
	
	function setSearch(){
		var task = document.forms.form1.task.value;
		var loc = 'index2.php?option=MailInbox&task=' + task;	
		
		if(document.forms.form1.txt1.value != ''){
			loc += '&txt1=' + document.forms.form1.txt1.value;
		}
		
		if(document.forms.form1.txt2.value != ''){
			loc += '&txt2=' + document.forms.form1.txt2.value;
		}
		
		if(document.forms.form1.txt3.value != ''){
			loc += '&txt3=' + document.forms.form1.txt3.value;
		}
		
		if(document.forms.form1.txt4.value != ''){
			loc += '&txt4=' + document.forms.form1.txt4.value;
		}
		
		if(document.forms.form1.txt5.value != ''){
			loc += '&txt5=' + document.forms.form1.txt5.value;
		}
		
		if(document.forms.form1.txt6.value != ''){
			loc += '&txt6=' + document.forms.form1.txt6.value;
		}
		
		if(document.forms.form1.txt7.value != ''){
			loc += '&txt7=' + document.forms.form1.txt7.value;
		}
		
		if(document.forms.form1.txt8.value != ''){
			loc += '&txt8=' + document.forms.form1.txt8.value;
		}
		
		if(document.forms.form1.txt9.value != ''){
			loc += '&txt9=' + document.forms.form1.txt9.value+'&txt10=' + document.forms.form1.txt10.value;
		}
		location.href=loc;
	}
	
	function setSearchAll(){
		var loc = 'index2.php?option=MailInbox&task=listsearch';	
		location.href=loc;
	}
</script>