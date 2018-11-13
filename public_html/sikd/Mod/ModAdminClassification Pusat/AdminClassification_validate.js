<link rel="stylesheet" type="text/css" href="style/ui.dynatree.css">
<link rel="stylesheet" type="text/css" href="style/tree.skinklas.css">

<script type="text/javascript" src="include/jquery.form.js"></script>

<script type="text/javascript" src="include/jquery-ui.custom.js"></script>
<script type="text/javascript" src="include/jquery.cookie.js"></script>
<script type="text/javascript" src="include/jquery.dynatree.js"></script>

<script type="text/javascript">
  $(function(){
    $("#treeClassfication").dynatree({
      fx: { height: "toggle", duration: 200 },
      autoCollapse: true,
      onActivate: function(node) {
	  	if(($("[name=task]").attr("value") == 'edit') || ($("[name=task]").attr("value") == 'new')){
			setReset();
		}	
		var valData = (node.data.key).split("|");
		$("#txtParent").text(valData[1]);
		$("[name=txt1]").attr("value", valData[3]);
		$("[name=txt2]").attr("value", valData[4]);
		$("[name=txt3]").attr("value", valData[5]);
		$("[name=txt4]").attr("value", valData[0]);
		$("[name=txt5]").attr("value", valData[2]);
		$("[name=txt6]").attr("value", valData[6]);
		$("[name=txt7]").attr("value", valData[7]);
        $("[name=txt10]").attr("value", valData[9]);
		setChecked(valData[8]);
//		$("[name=txt8]").attr("value", valData[8]);
		$("[name=txt9]").attr("value", valData[10]);	
		$("[name=id]").attr("value", valData[2]);
		setButton(valData[11]);
      },
      onDeactivate: function(node) {
        $("[name=txt1]").attr("value", "");
		$("[name=txt2]").attr("value", "");
		$("[name=txt3]").attr("value", "");
		$("[name=txt4]").attr("value", "");
		$("[name=txt8]").attr("checked", "false");
		setButton(1);
      }
    });
    	
	$("#treeClassfication").dynatree("option", "autoCollapse", 0);
	$("#treeClassfication").dynatree("option", "fx", { height: "toggle", duration: 200 });
	
  });
 
	function setChecked(str){
		
	  	var txt8 = document.forms.formClassification.txt8;
		var btn1 = document.forms.formClassification.btnTambahx;
		var btn2 = document.forms.formClassification.btnUbah;
		//alert(btn1);
	  	if(str == 0){
			txt8.checked = false;	 
			btn1.disabled = true;
			btn2.disabled = true;
			//alert(txt8);
		}else{
			txt8.checked = true;
			btn1.disabled = false;
			btn2.disabled = false;
		}
  	}

	function setButton(int){
		var btn = document.forms.formClassification.btnUbah;
		if(int == 0){
			btn.disabled = true;
		}else{
			btn.disabled = false;
		}
	}
 
  function setNew(){
  	var parent = document.getElementById("txtParent");
	var dparent = document.getElementById("dotParent");
	
	var txt1 = document.forms.formClassification.txt1;
	var txt2 = document.forms.formClassification.txt2;
	var txt3 = document.forms.formClassification.txt3;
	var txt6 = document.forms.formClassification.txt6;
	var txt7 = document.forms.formClassification.txt7;
	var txt8 = document.forms.formClassification.txt8;
    var txt10 = document.forms.formClassification.txt10;
	
	var btn1 = document.forms.formClassification.btnSimpan;
	var btn2 = document.forms.formClassification.btnUbah;
	var btn3 = document.forms.formClassification.btnBatal;
	var task = document.forms.formClassification.task;
	
	parent.innerHTML  = txt1.value;
	
	if(txt1.value == ''){
		alert('Pilih data awal untuk Menambah Sub Klasifikasi !');
		return false;
	}
	
	if(parent.innerHTML != ""){	
		if(parent.innerHTML != "SK"){
			parent.style.display = "inline";
			dparent.style.display = "inline";
		}else{
			parent.style.display = "none";
		}
	}	
	
	txt1.value='';
	txt2.value='';
	txt3.value='';
	txt6.value='0';
	txt7.value='0';
	txt8.checked = true;
	
	txt1.disabled=false;
	txt2.disabled=false;
	txt3.disabled=false;
	txt6.disabled=false;
	txt7.disabled=false;
	txt8.disabled=false;
	txt10.disabled=false;
	btn1.disabled=false;
	btn2.disabled=true;
	btn3.disabled=false;
	task.value = 'new';
	txt1.focus();
  }
  
  function setReset(){
  	var parent = document.getElementById("txtParent");
	var dparent = document.getElementById("dotParent");
  	var txt1 = document.forms.formClassification.txt1;
	var txt2 = document.forms.formClassification.txt2;
	var txt3 = document.forms.formClassification.txt3;
	var txt6 = document.forms.formClassification.txt6;
	var txt7 = document.forms.formClassification.txt7;
	var txt8 = document.forms.formClassification.txt8;
    var txt10 = document.forms.formClassification.txt10;
	
	var btn1 = document.forms.formClassification.btnSimpan;
	var btn2 = document.forms.formClassification.btnUbah;
	var btn3 = document.forms.formClassification.btnBatal;
	var task = document.forms.formClassification.task;
	
	parent.style.display = "none";
	dparent.style.display = "none";	
	if(parent.innerHTML != 'SK'){
		txt1.value = parent.innerHTML + dparent.innerHTML + txt1.value;
	}
  	txt1.disabled=true;
	txt2.disabled=true;
	txt3.disabled=true;
	txt6.disabled=true;
	txt7.disabled=true;
	txt8.disabled=true;
    txt10.disabled=true;
	
	btn1.disabled=true;
	btn2.disabled=false;
	btn3.disabled=true;
	task.value = 'new';
  }
  
  function setEdit(){
  	var parent = document.getElementById("txtParent");
	var dparent = document.getElementById("dotParent");
	var txt1 = document.forms.formClassification.txt1;
	var txt2 = document.forms.formClassification.txt2;
	var txt3 = document.forms.formClassification.txt3;
	var txt6 = document.forms.formClassification.txt6;
	var txt7 = document.forms.formClassification.txt7;
	var txt8 = document.forms.formClassification.txt8;
	var txt9 = document.forms.formClassification.txt9;
    var txt10 = document.forms.formClassification.txt10;
	var btn1 = document.forms.formClassification.btnSimpan;
	var btn2 = document.forms.formClassification.btnUbah;
	var btn3 = document.forms.formClassification.btnBatal;
	var task = document.forms.formClassification.task;
	
	if(txt1.value == ''){
		alert('Pilih data yang akan diubah !');
		return false;
	}
	
	if(txt1.value == "SK"){
		alert('Sistem tidak mengijinkan untuk Perubahan Klasifikasi ini !');
		return false;
	}
	
	if(parent.innerHTML != ""){	
		if(parent.innerHTML != "SK"){
			txt1.value = txt1.value.replace(parent.innerHTML + '.','');
			parent.style.display = "inline";
			dparent.style.display = "inline";
		}else{
			parent.style.display = "none";
		}	
	}
	txt1.disabled=parseBool(txt9.value);
	txt2.disabled=false;
	txt3.disabled=false;
	txt6.disabled=false;
	txt7.disabled=false;
	txt8.disabled=false;
    txt10.disabled=false;

	btn1.disabled=false;
	btn2.disabled=true;
	btn3.disabled=false;
	
	task.value = 'edit';
	txt1.focus();
  }
  
  function parseBool(val){
	  if(val == 'true') return true;
	  if(val == 'false') return false;
  }
  
  function setDelete(){
  
  	var txt1 = document.forms.formClassification.txt1;
	if(txt1.value == ''){
		alert('Pilih data yang akan dihapus !');
		return false;
	}
	
  	var conf = confirm('Apakah Anda Yakin Akan Menghapus Data ini ?');
	if (conf == false){
		return false;
	}
	
  	var task = document.forms.formClassification.task;
	task.value = 'delete';
	document.forms.formClassification.submit();
  }
  
  function setSave(){
  	var txt1 = document.forms.formClassification.txt1;
	var txt2 = document.forms.formClassification.txt2;
	if(txt1.value == ""){
		document.getElementById("req").style.display = "inline";
		return false;
	}
	
	if(txt2.value == ""){
		document.getElementById("req2").style.display = "inline";
		return false;
	}
	document.forms.formClassification.submit();
	
  }
</script>
