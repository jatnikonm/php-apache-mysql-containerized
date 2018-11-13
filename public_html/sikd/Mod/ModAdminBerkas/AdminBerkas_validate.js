<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skin.css">
<script type="text/javascript" src="include/jquery.form.js"></script>
<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<link rel="stylesheet" type="text/css" href="include/assets/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/chosen.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace-fonts.css" />
<link rel="stylesheet" type="text/css" href="include/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />

<script type="text/javascript" src="include/assets/js/ace-extra.js"></script>
<script type="text/javascript" src="include/assets/js/chosen.jquery.js"></script>


<script type="text/javascript">


$(document).ready(function(){
  tbl_berkas();
})

function tbl_berkas(uks){

if(uks != undefined){
url = "Mod/ModAdminBerkas/bantai1.php?roleid="+uks;
}else { url = "Mod/ModAdminBerkas/bantai1.php";}

	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting": [[6, "asc"]],
		"bDestroy": true,
		"aoColumns": [
					{ "swidth": "1%" },
					{ "swidth": "3%" },
					{ "swidth": "10%" },
					{ "swidth": "10%" },
					{ "swidth": "15%" },
					{ "swidth": "15%" },
					{ "swidth": "15%" },
					{ "swidth": "10%" },
				   ],
		"bAutoWidth": false,
		"sAjaxSource": url
	});
}

function tbl_item(BerkasId, judul){

document.getElementById("page1").style.display = 'none';
document.getElementById("page2").style.display = 'inline';
$("#lblberkas").html("Daftar Isi Berkas : " + judul);
if(BerkasId != undefined){
url = "Mod/ModAdminBerkas/bantai2.php?BerkasId="+BerkasId;
  }else {
url = "Mod/ModAdminBerkas/bantai2.php";
}

	oTable = $('#example1').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting": [[2, "desc"]],
		"aoColumns": [
					{ "swidth": "1%" },
					{ "swidth": "5%" },
					{ "swidth": "10%" },
					{ "swidth": "20%" },
					{ "swidth": "60%" },
					{ "swidth": "10%" }
				   ],
		"bDestroy": true,
		"bAutoWidth": false,
		"sAjaxSource": url
	});
}

  $("#uk_bawahan").ready(function(){
    $.ajax({
        url: "Mod/ModAdminBerkas/load_uk.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=luk",
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {
          $("#uk_bawahan").html(data);}
    })
  });

  function load_uk(){
      var rid = $("#uk_bawahan").val();
      tbl_berkas(rid);
  }

  function detail_item(Nid){
     location.href = "index2.php?option=MailTLberkas&task=viewBerkas&id="+Nid;
  }

  function load_treeUK(){
    $("#treeUK").dynatree({
      fx: { height: "toggle", duration: 200 },
      autoCollapse: true,
      onActivate: function(node) {
		 $("[name=roleId]").attr("value", node.data.key);
      },
      onDeactivate: function(node) {
		 $("[name=roleId]").attr("value", '');
      }
    });

	$("#treeUK").dynatree("option", "autoCollapse", 0);
	$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
	$("#treeUK").dynatree("getTree").activateKey($("[name=roleId]").attr("value"));
  };
//
    function getBack(){
      location.href='index2.php?option=AdminBerkas&task=list';
    }

	function setLocation(id){
		var roleId = id;
		location.href='index2.php?option=<?php echo $option; ?>&task=list&roleId=' + roleId;
	}
//
	function addBerkas(cond, id){
	var cond, id;

		if(arguments[0] != undefined){
			document.forms.form1.cond.value = arguments[0];
			document.forms.form1.id.value = arguments[1];
		}
		cond = document.forms.form1.cond.value;
		id = document.forms.form1.id.value;

		getWindow('add_berkas', '&task=' + cond + '&id=' + id);
	}
//
	function setClose(id){
		getWindow('close_berkas', '&id=' + id);
	}

	function openBukaBerkas(id){
		if(document.forms.form1.groupId.value != "1"){
			return false;
		}

		getWindow('open_berkas', '&id=' + id);
	}

	function respOpenBukaBerkas(){
		TINY.box.hide();
		location.reload(true);
	}

	function setSusut(){
		var frm = document.forms[0];
		var a = 0;
		var id = '';
		for (i=0; i<frm.length; i++){
			var obj = frm.elements[i];
			if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
				if (obj.checked == true){
					id = obj.value;
					a++;
				}
			}
		}

		if(a == 0){
			alert('Anda Harus Memilih 1 Berkas Terlebih Dahulu !');
			return false;
		}

		if(a > 1){
			alert('Anda Hanya Diperbolehkan Memilih 1 Berkas !');
			for (i=0; i<frm.length; i++){
				var obj = frm.elements[i];
				if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
					obj.checked = false;
				}
			}
			return false;
		}

		getWindow('susut_berkas', '&id=' + id);

	}

	function confirmValidate(){
		if(document.forms.form1.txt1.value == ''){
			document.getElementById("req").style.display = "inline";
			return false;
		}else{
			document.forms.form1.submit();
		}
	}

	function getSearch(){
		var keyword = document.forms.form1.txt_search.value;
		if(keyword == ''){
			document.getElementById("req_search").style.display = "inline";
			return false;
		}

		var roleId = document.forms.form1.roleId.value;
		location.href = 'index2.php?option=AdminBerkas&task=list&roleId=' + roleId + '&keyword=' + keyword;
	}

	function setList(){
		document.getElementById("pnlDetails").style.display = "none";
		document.getElementById("pnlGrid").style.display = "inline";
		document.getElementById("btnTambah").style.display = "inline";
		document.getElementById("btnHapus").style.display = "inline";
		document.getElementById("req").style.display = "none";
		document.forms.form1.task.value = 'delete';
	}

	function setDelete(bid){
	document.forms.form1.id.value = bid;
    tanya = confirm("Apakah berkas ini mau dihapus... ?")
		if(tanya == false){
			return false;
		}else{
			document.forms.form1.submit();
		}
	}

</script>
 
<script type="text/javascript">
	jQuery(function($) {
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
</script>
