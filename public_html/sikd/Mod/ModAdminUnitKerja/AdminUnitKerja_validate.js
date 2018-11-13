<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skinpengguna.css">

<script type="text/javascript" src="include/jquery.form.js"></script>

<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<script type="text/javascript">
  $(function(){
    $("#treeUK").dynatree({
      fx: { height: "toggle", duration: 200 },
      autoCollapse: true,
      onActivate: function(node) {
	  	if(($("[name=task]").attr("value") == 'new') || $("[name=task]").attr("value") == 'edit'){
			setReset();
		}	
		var valData = (node.data.key).split("|");
		$("[name=txt1]").attr("value", valData[0]);
		$("[name=txt2]").attr("value", valData[1]);
		$("[name=txt3]").attr("value", valData[2]);
		$("[name=txt4]").attr("value", valData[3]);
		$("[name=txt6]").attr("value", valData[5]);
		setChecked(valData[4]);
		$("[name=id]").attr("value", valData[1]);	
      },
      onDeactivate: function(node) {
        $("[name=txt1]").attr("value", "");
		$("[name=txt2]").attr("value", "");
		$("[name=txt3]").attr("value", "");
		$("[name=txt4]").attr("value", "");
		$("[name=txt6]").attr("value", "");
		$("[name=txt5]").attr("checked", "false");
      }
    });
    	
	$("#treeUK").dynatree("option", "autoCollapse", 0);
	$("#treeUK").dynatree("option", "fx", { height: "toggle", duration: 200 });
	
  });
  
	function setChecked(str){
	  	var txt5 = document.forms.formUK.txt5;
		var btn1 = document.forms.formUK.btnTambah;
		var btn2 = document.forms.formUK.btnUbah;
		
	  	if(str == '0'){
			txt5.checked = false;	 
			btn1.disabled = true;
			btn2.disabled = true;
		}else{
			txt5.checked = true;
			btn1.disabled = false;
			btn2.disabled = false;
		}
  	}
  
  function setNew(){
  	var txt1 = document.forms.formUK.txt1;
	var txt2 = document.forms.formUK.txt2;
	var txt3 = document.forms.formUK.txt3;
	var txt4 = document.forms.formUK.txt4;
	var txt5 = document.forms.formUK.txt5;
	var txt6 = document.forms.formUK.txt6;
	var btn1 = document.forms.formUK.btnSimpan;
	var btn2 = document.forms.formUK.btnUbah;
	var btn3 = document.forms.formUK.btnBatal;
	var task = document.forms.formUK.task;
	
	if(txt1.value == ''){
		alert('Pilih data awal untuk Menambah Sub Klasifikasi !');
		return false;
	}
	
	txt3.value='';
	txt4.value='';
	txt6.value='';
	txt5.checked = true;
	txt3.disabled=false;
	txt4.disabled=false;
	txt5.disabled=false;
	txt6.disabled=false;
	btn1.disabled=false;
	btn2.style.display = 'none';
	btn3.disabled=false;
	task.value = 'new';
	txt3.focus();
  }
  
  function setReset(){
  	var txt3 = document.forms.formUK.txt3;
	var txt4 = document.forms.formUK.txt4;
	var txt5 = document.forms.formUK.txt5;
	var txt6 = document.forms.formUK.txt6;
	var btn1 = document.forms.formUK.btnSimpan;
	var btn2 = document.forms.formUK.btnUbah;
	var btn3 = document.forms.formUK.btnBatal;
	var task = document.forms.formUK.task;
	
	txt3.disabled=true;
	txt4.disabled=true;
	txt5.disabled=true;
	txt6.disabled=true;
	btn1.disabled=true;
	btn2.style.display = 'block';
	btn3.disabled=true;
	task.value = 'new';
  }
  
  function setEdit(){
  	var txt1 = document.forms.formUK.txt1;
	var txt2 = document.forms.formUK.txt2;
	var txt3 = document.forms.formUK.txt3;
	var txt4 = document.forms.formUK.txt4;
	var txt5 = document.forms.formUK.txt5;
	var txt6 = document.forms.formUK.txt6;
	var btn1 = document.forms.formUK.btnSimpan;
	var btn2 = document.forms.formUK.btnUbah;
	var btn3 = document.forms.formUK.btnBatal;
	var task = document.forms.formUK.task;
	
	if(txt3.value == ''){
		alert('Pilih data yang akan diubah !');
		return false;
	}
	txt3.disabled=false;
	txt4.disabled=false;
	txt5.disabled=false;
	txt6.disabled=false;
	btn1.disabled=false;
	btn2.disabled=true;
	btn3.disabled=false;
	task.value = 'edit';
	txt3.focus();
  }
  
  function getSave(){
  	var txt3 = document.forms.formUK.txt3;
	var txt4 = document.forms.formUK.txt4;
	var txt5 = document.forms.formUK.txt5;
	var txt6 = document.forms.formUK.txt6;
	if(txt3.value == ""){
		document.getElementById("req").style.display = "inline";
		return false;
	}
	
	if(txt4.value == ""){
		document.getElementById("req2").style.display = "inline";
		return false;
	}
	
	if(txt5.checked == false){
		var conf = window.confirm('Apakah Anda Akan Me-nonAktif kan Unit Kerja Ini ?');
		if(conf == false){
			return false;
		}
	}
	
	if(txt6.value == ""){
		document.getElementById("req3").style.display = "inline";
		return false;
	}

	document.forms.formUK.submit();
  }
  
  function setDelete(){
  
  	var txt1 = document.forms.formUK.txt1;
	var txt2 = document.forms.formUK.txt2;
	
	if(txt1.value == ''){
		alert('Pilih data yang akan dihapus !');
		return false;
	}
	
	if(txt2.value == 'uk'){
		alert('Data Unit Kerja Tidak Boleh Dihapus !');
		return false;
	}
	
  	var conf = confirm('Apakah Anda Yakin Akan Menghapus Data ini ?');
	if (conf == false){
		return false;
	}
	
  	var task = document.forms.formUK.task;
	task.value = 'delete';
	document.forms.formUK.submit();
  }
</script>