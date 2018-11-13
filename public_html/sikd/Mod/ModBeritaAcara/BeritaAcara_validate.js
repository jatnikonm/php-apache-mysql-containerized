<script type="text/javascript" src="include/calendar/calendar.js"></script>
<script type="text/javascript" src="include/calendar/lang/calendar-en.js"></script>

<script type="text/javascript" src="include/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/calendar.js"></script>



<link rel="stylesheet" type="text/css" media="all" href="include/calendar/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="include/calendar/calendar-win2k-1.css" title="win2k-1" />

<script type="text/javascript">
$("#form1").ready(function(){
if($("#task").val()=='delete'){
   document.forms.form1.submit();
}

})


//	function setDetails(cond, id){
//		document.getElementById("pnlDetails").style.display = "inline";
//		document.getElementById("pnlGrid").style.display = "none";
//        document.getElementById("btnTambah").style.display = "none";
//        document.getElementById("files").style.display = "inline";
//		document.forms.form1.task.value = cond;
//        document.forms.form1.txt1.value = "";
//        document.forms.form1.txt2.value = "";
//        document.forms.form1.id.value = "";
//        document.getElementById("dpl").style.display = "none";
//
//         if(cond=="edit" || cond=="new"){
//          document.getElementById('thn1').disabled=false;
//          document.getElementById('thn2').disabled=false;
//          document.forms.form1.txt1.disabled=false;
//          document.forms.form1.txt2.disabled=false;
//         }
//        document.forms.form1.txt1.focus();
//		if(cond == "edit" || cond == "view"){
//        $.ajax({
//        url: "mod/modPindahBerkas/load_pindah.php", // Url to which the request is send
//        type: "POST",             // Type of request to be send, called as method
//        data: "task=list&id="+id,
//        cache: false,             // To unable request pages to be cached
//        success: function(data)   // A function to be called if request succeeds
//        {
//          x = data.split("#");
//          //alert(data);
//          if(cond == "edit")
//          d = x.length-2;
//          else if(cond=="view"){
//          d = x.length-3;
//
//          }
//          document.forms.form1.txt1.value = x[3];
//          tgl_indo = x[4].split("-");
//          tgl = tgl_indo[2]+"/"+tgl_indo[1]+"/"+tgl_indo[0];
//          document.forms.form1.txt2.value = tgl;
//          thn = x[5].split("-");
//          document.forms.form1.thn1.value = thn[0];
//          document.forms.form1.thn2.value = thn[1];
//          $("#id").val(x[1]);
//          if(x[d]!=""){
//           pth = x[d].split("/");
//           filex = pth[2].replace(" ","%20");
//           path_link = pth[0]+"/"+pth[1]+"/"+filex;
//           document.getElementById("fl").style.display = "inline";
//           document.getElementById("btnSimpan").style.display = "inline";
//           link = "Filename : <u><a href="+path_link+">"+pth[2]+"</a></u>";
//           document.forms.form1.temp_file.value = x[d];
//           $("#fl").html(link);
//          }
//          ltblberkas(thn[0],thn[1],x[1]);
//          $("#btnSimpan").val('Ubah');
//          if(x[12]=='OK')
//          document.getElementById("dpl").style.display = "inline";
//          if(cond=="view"){
//          document.getElementById("btnSimpan").style.display = "none";
//          document.getElementById('thn1').disabled="true";
//          document.getElementById('thn2').disabled="true";
//          document.forms.form1.txt1.disabled=true;
//          document.forms.form1.txt2.disabled=true;
//          document.getElementById("files").style.display = "none";
//
//          }
//
//        }
//        });
//      }else
//       ltblberkas("","","");
//	}

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
        document.getElementById("req5").style.display = 'none';

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

    function chpriode(){
      var thn_A = $("#thn1").val();
      var thn_B = $("#thn2").val();
         ltblberkas(thn_A,thn_B,'');
    }

	function setList(){
		window.location.href="index2.php?option=pindahberkas&task=list";
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


    function verifikasi(){
      alert();
    }


    function setverifikasi(cond,id){
    var task = $("#task").val(cond);
    document.getElementById("dpl").style.display = "none";
    $.ajax({
        url: "Mod/ModPindahBerkas/load_pindah.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "task=lists&id="+id,
        cache: false,             // To unable request pages to be cached
        success: function(data)   // A function to be called if request succeeds
        {
          x = data.split("#");

          document.getElementById("pnlDetails").style.display = "inline";
		  document.getElementById("pnlGrid").style.display = "none";
          if(x[12]=='OK')
          d = x.length-3;
          else
          d = x.length-2;
          document.forms.form1.txt1.value = x[3];
          tgl_indo = x[4].split("-");
          tgl = tgl_indo[2]+"/"+tgl_indo[1]+"/"+tgl_indo[0];
          document.forms.form1.txt2.value = tgl;
          thn = x[5].split("-");
          document.forms.form1.thn1.value = thn[0];
          document.forms.form1.thn2.value = thn[1];
          $("#id").val(x[1]);
          if(x[d]!=""){
           pth = x[d].split("/");
           filex = pth[2].replace(" ","%20");
           path_link = pth[0]+"/"+pth[1]+"/"+filex;
           document.getElementById("fl").style.display = "inline";
           document.getElementById("btnSimpan").style.display = "inline";
           link = "Filename : <u><a href="+path_link+">"+pth[2]+"</a></u>";
           document.forms.form1.temp_file.value = x[d];
           $("#fl").html(link);
          }
          ltblberkas(thn[0],thn[1],x[1]);
          $("#btnSimpan").val('Setuju');

          document.getElementById("btnSimpan").style.display = "inline";
          document.getElementById('thn1').disabled="true";
          document.getElementById('thn2').disabled="true";
          document.forms.form1.txt1.disabled=true;
          document.forms.form1.txt2.disabled=true;
          document.getElementById("files").style.display = "none";
          if(x[12]=="OK"){
          document.getElementById("dpl").style.display = "inline";
          document.getElementById("btnSimpan").style.display = "none";
          }
        }
        });
    }

    function setlokasisimpan(id){
      alert(id);
      window.location.href="index2.php?option=lokasi_simpan&task=list";
    }

    function load_BA(ids){
       window.location.href="index2.php?option=berita_acara&mod=up&ids="+ids;
    }
</script>