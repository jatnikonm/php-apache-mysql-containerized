<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>



<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />

<script type="text/javascript">

	function setDetails(cond, id){
	  if(cond=="new"){
       chsurat();
       $("#btnSimpan").val('Simpan');
       ltblberkas("",task);
	  }

		document.getElementById("pnlDetails").style.display = "inline";
		document.getElementById("pnlGrid").style.display = "none";
        document.getElementById("btnTambah").style.display = "none";
        document.getElementById("files").style.display = "inline";
		document.forms.form1.task.value = cond;
        document.forms.form1.txt1.value = "";
        document.forms.form1.txt2.value = "";
        document.forms.form1.id.value = "";
        document.forms.form1.NoS.style.display = "inline"
        document.forms.form1.NoS2.style.display = "none"

        document.getElementById("dpl").style.display = "none";
        task = $("#task").val(cond);

        document.forms.form1.txt1.focus();

        if(cond == "edit" || cond == "view"){
        $.ajax({
        url: "Mod/ModMusnah/load_surat.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=get&id="+id,
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {
          x = data.split("#");
          document.forms.form1.txt1.value = x[4];
          tgl_indo = x[5].split("-");
          tgl_usul = tgl_indo[2]+"/"+tgl_indo[1]+"/"+tgl_indo[0];
          tgl_indo = x[2].split("-");
          tgl = tgl_indo[2]+"-"+tgl_indo[1]+"-"+tgl_indo[0];
          document.forms.form1.txt2.value = tgl_usul;
          $("#NoS2").val(x[1]+"/"+tgl);
          $("#NoS1").val(x[7]);
          document.forms.form1.NoS2.disabled = "none";
          document.forms.form1.NoS.style.display = "none";
          document.forms.form1.NoS2.style.display = "inline";
          $("#id").val(x[3]);
          if(x[6]!=""){
           pth = x[6].split("/");
           filex = pth[2].replace(" ","%20");
           path_link = pth[0]+"/"+pth[1]+"/"+filex;
           document.getElementById("fl").style.display = "inline";
           document.getElementById("btnSimpan").style.display = "inline";
           link = "Filename : <u><a href="+path_link+">"+pth[2]+"</a></u>";
           document.forms.form1.temp_file.value = x[6];
           $("#fl").html(link);
          }
          document.getElementById('tblberkas').style.display = "none";
          ltblberkas(x[d+2],task);
        }
        });
        $("#btnSimpan").val('Ubah');
      }
    }


 function load_surat(){
    $.ajax({
        url: "Mod/ModMusnah/load_pindah.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=permohonan",
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {$("#NoS").html(data);}
    })
 }

 $(function(){
      $('#save_value').click(function(){
        var val = [];
        var x = "";
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
          x = x + "#" + val[i];
        });
        $("#cid").val(x);
      });
    });


	function confirmValidate(){
        var val = [];
        var x = "";
        var validasi = true;

        document.getElementById("req1").style.display = 'none';
        document.getElementById("req2").style.display = 'none';
//        document.getElementById("req3").style.display = 'none';
        document.getElementById("req4").style.display = 'none';
        document.getElementById("req5").style.display = 'none';



//        $(':checkbox:checked').each(function(i){
//          val[i] = $(this).val();
//          x = x + "#" + val[i];
//        });
//        $("#cid").val(x);

        if(document.forms.form1.txt1.value==""){
          document.getElementById("req1").style.display = 'inline';
          validasi = false;
        }
        if(document.forms.form1.txt2.value==""){
          document.getElementById("req2").style.display = 'inline';
          validasi = false;
        }
//        if(document.forms.form1.txt3.value==""){
//          document.getElementById("req3").style.display = 'inline';
//          validasi = false;
//        }
        if(document.forms.form1.NoS1.value==""){
          document.getElementById("req4").style.display = 'inline';
          validasi = false;
        }
        if(document.forms.form1.files.value=="" && document.forms.form1.task.value=="new"){
          document.getElementById("req5").style.display = 'inline';
          validasi = false;
        }

      if(validasi){
          if($("#task").val()=='new'){
           tanya = confirm("Apakah berita acara dan usulan pemusnahan arsip sudah yakin... !!");
          }else tanya = true;
           if(tanya)
			document.forms.form1.submit();
           else
            return false;
		}
	}

    function chsurat(){
      var task = $("#task").val();
      var idsurat = $("#NoS").val();

      $.ajax({
        url: "Mod/ModMusnah/load_surat.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=lists",
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {
          $("#NoS").html(data);}
      })
      ltblberkas(idsurat,task);
    }

    function set_surat(){
      var task = 'new';
      var nos = $("#NoS").val();
      $("#NoS1").val(nos);
      ltblberkas($("#NoS").val(),task);
      $.ajax({
        url: "Mod/ModMusnah/load_berkas.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=lists&nos="+nos,
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {
          $("#berkasId").val(data);}
      })
    }

	function setList(){
		document.getElementById("pnlDetails").style.display = "none";
		document.getElementById("pnlGrid").style.display = "inline";
		document.getElementById("btnTambah").style.display = "inline";
		document.getElementById("btnHapus").style.display = "inline";
		document.getElementById("req").style.display = "none";
		document.forms.form1.task.value = 'delete';
	}
	
	function setDelete(id){
		if(confDelete() == false){
			return false;
		}else{
            document.forms.form1.task.value = 'delete';
            document.forms.form1.id.value = id;
			document.forms.form1.submit();
		}
	}


    function confDelete(){
      tanya = confirm("Apakah Surat Permohonan ini akan dihapus ?");
      if (tanya)
        return true;
      else
        return false;
    }



</script>