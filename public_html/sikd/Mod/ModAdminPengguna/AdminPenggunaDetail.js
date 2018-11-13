<base target="_self">
<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skinklaspengguna.css">

<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<script type="text/javascript" src="include/jquery.form.js"></script>
<script type="text/javascript" src="include/jquery.idTabs.min.js"></script>

<!-- import the calendar script -->
<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />

<link rel="stylesheet" type="text/css" href="include/assets/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/chosen.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace-fonts.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

<script type="text/javascript" src="include/assets/js/ace-extra.js"></script>
<script type="text/javascript" src="include/assets/js/chosen.jquery.js"></script>

<script type="text/javascript">
	$(function(){

		$("#treeUK").dynatree({
		  fx: { height: "toggle", duration: 200 },
		  autoCollapse: true,
		  onActivate: function(node) {
		  	var setId = (node.data.key).split('|');
			$("[name=txt2]").attr("value", setId[0]);
			if($("[name=task]").attr("value") == "new"){
				$("[name=txt5]").attr("value", setId[1]);
			}
		  },
		  onDeactivate: function(node) {
			$("[name=txt2]").attr("value", "");
		  }
		});
    	
		$("#treeUK").dynatree("option", "autoCollapse", 1);
		$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
		$("#treeUK").dynatree("getTree").activateKey(($("[name=txt2]").attr("value") + '|' + $("[name=txt13]").attr("value")));

		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	
			$(window)
			.off('resize.chosen')
			.on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': 500});
				})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': 500});
				})
			});
		}

  });
  
	function setSave(){
		document.getElementById("req1").style.display = 'none';
		document.getElementById("req2").style.display = 'none';
		document.getElementById("req3").style.display = 'none';
		document.getElementById("req4").style.display = 'none';
		document.getElementById("req5").style.display = 'none';
		document.getElementById("req6").style.display = 'none';
		document.getElementById("req7").style.display = 'none';
		
		var uk1 = document.forms.form1.txt1;
		var uk2 = document.forms.form1.txt2;
		var task = document.forms.form1.task;
		
		if(uk2.value == ''){
			document.getElementById("req1").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt3.value == ''){
			document.getElementById("req2").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt4.value == ''){
			document.getElementById("req3").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt5.value == ''){
			document.getElementById("req7").style.display = 'inline';
			return false;
		}
		
		if(document.forms.form1.txt9.value == ''){
			document.getElementById("req4").style.display = 'inline';
			return false;
		}
		
		if(task.value == "new"){
			if(document.forms.form1.txt11.value == ''){
				document.getElementById("req5").style.display = 'inline';
				return false;
			}
		}
		
		if(task.value == "edit"){
			if(uk1.value != uk2.value){
				var ask = window.confirm("Apakah Juga Anda Akan Memindahkan Unit Kerja dari Pengguna ini ? \nPilih 'Cancel' maka sistem akan melakukan Update tanpa merubah Unit Kerja.");
				if(ask == false){
					uk2.value = uk1.value;
				}
			}
		}
	
		var username1 = document.forms.form1.txt9;
		var username2 = document.forms.form1.txt10;
		var pass1 = document.forms.form1.txt11;
		var pass2 = document.forms.form1.txt12;
		
		if(task.value == "edit"){
			if(username1.value != username2.value){
				if(pass1.value == ""){
					alert('Penggatian Username mengharuskan Perubahan Password !');
					return false;

				}
			}
		}
		
		if((pass1.value != "") || (pass2.value != "")){
			if(pass1.value != pass2.value){
				document.getElementById("req5").style.display = 'inline';
				document.getElementById("req5").title = 'Password tidak sama !';
				return false;
			}
		}
		
		document.forms.form1.submit();
	}
	
	function openTab(str){
		if(str == 'detail'){
			document.getElementById("tab1").style.display = 'inline';
			document.getElementById("tab2").style.display = 'none';
		}
		
		if(str == 'history'){
			document.getElementById("tab1").style.display = 'none';
			document.getElementById("tab2").style.display = 'inline';
		}
	}
	
</script>