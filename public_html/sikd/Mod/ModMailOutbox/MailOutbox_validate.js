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
<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />

<script type="text/javascript" src="include/ConfirmDelete.js"></script>
<script type="text/javascript" >


var asInitVals = new Array();

	$(document).ready(function() {
		var oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"aaSorting": [[5, "desc"]],
			"sSearch": "Search all columns:",
			"sAjaxSource": "Mod/ModMailOutbox/bantai1.php",
			"oLanguage": {
				"sSearch": "Pencarian :",
		}
		});
		

		$("tfoot input").keyup( function () {
			/* Filter on the column (the index) of this element */
			oTable.fnFilter( this.value, $("tfoot input").index(this) );
		} );
		
		
		
		/*
		 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
		 * the footer
		 */
		$("tfoot input").each( function (i) {
			asInitVals[i] = this.value;
		} );
		
		$("tfoot input").focus( function () {
			if ( this.className == "search_init" )
			{
				this.className = "";
				this.value = "";
			}
		} );
		
		$("tfoot input").blur( function (i) {
			if ( this.value == "" )
			{
				this.className = "search_init";
				this.value = asInitVals[$("tfoot input").index(this)];
			}
		} );

	} );

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