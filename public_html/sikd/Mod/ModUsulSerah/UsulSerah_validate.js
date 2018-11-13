<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>



<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />

<script type="text/javascript">
//    function setadd(cond, id){
//      document.getElementById("pnlDetails").style.display = "inline";
//	  document.getElementById("pnlGrid").style.display = "none";
//      document.getElementById("btnTambah").style.display = "none";
//      document.getElementById("files").style.display = "inline";
//    }
	function setDetails(cond, id){
		document.getElementById("pnlDetails").style.display = "inline";
		document.getElementById("pnlGrid").style.display = "none";
      document.getElementById("btnTambah").style.display = "none";
      document.getElementById("files").style.display = "inline";
		document.forms.form1.task.value = cond;
        document.forms.form1.txt1.value = "";
        document.forms.form1.txt2.value = "";
        document.forms.form1.id.value = "";
        document.getElementById("dpl").style.display = "none";
         if(cond=="edit" || cond=="new"){
          document.forms.form1.txt1.disabled=false;
          document.forms.form1.txt2.disabled=false;
         }
        document.forms.form1.txt1.focus();
		if(cond == "edit" || cond == "view"){
        $.ajax({
        url: "Mod/ModUsulSerah/load_serah.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=list&id="+id,
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {

          x = data.split("#");
//          if(cond == "edit")
//          d = x.length-5;
          document.forms.form1.txt1.value = x[1];
          tgl_indo = x[2].split("-");
          tgl = tgl_indo[2]+"/"+tgl_indo[1]+"/"+tgl_indo[0];
          document.forms.form1.txt2.value = tgl;
          $("#id").val(x[0]);
          if(x[3]!=""){
           pth = x[3].split("/");
           filex = pth[2].replace(" ","%20");
           path_link = pth[0]+"/"+pth[1]+"/"+filex;
           document.getElementById("fl").style.display = "inline";
           document.getElementById("btnSimpan").style.display = "inline";
           link = "Filename : <u><a href="+path_link+">"+pth[2]+"</a></u>";
           document.forms.form1.temp_file.value = x[3];
           $("#fl").html(link);
          }
          ltblberkas(x[0],'');
          $("#btnSimpan").val('Ubah');

        }
        });
      }else
       ltblberkas("","","");
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

        //if($("#btnSimpan").val()=="Setuju"){
        //  $("#task").val('ok');
        //}

        document.getElementById("req1").style.display = 'none';
        document.getElementById("req2").style.display = 'none';
        document.getElementById("req5").style.display = 'none';



        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
          x = x + "#" + val[i];
        });
        $("#cid").val(x);

        if($("#cid").val()==''){
          alert('Berkas yang di usul serah belum ada ...');
          validasi = false;
        }

        if(document.forms.form1.txt1.value==""){
          document.getElementById("req1").style.display = 'inline';
          validasi = false;
        }
        if(document.forms.form1.txt2.value==""){
          document.getElementById("req2").style.display = 'inline';
          validasi = false;
        }

        if(document.forms.form1.files.value=="" && document.forms.form1.task.value=="new"){
          document.getElementById("req5").style.display = 'inline';
          validasi = false;
        }

      if(validasi)
			document.forms.form1.submit();
//		}
	}

//    function chpriode(){
//      var thn_A = $("#thn1").val();
//      var thn_B = $("#thn2").val();
//      var role = $("#uk").val();
//         ltblberkas('','','','');
//    }

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