<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />
<script type="text/javascript" charset="utf-8">
	document.getElementById("title").innerHTML = 'Usul Pindah Arsip Aktif Ke Record Center';

$(document).ready(function() {

  loadtblusul();
  chpriode();
});

function ltblberkas(a,b,id){
       var R_url;
       var task = $("#task").val();
       //var id = $("#id").val();
      R_url = 'Mod/ModPindahBerkas/bantai2.php?thnA='+a+'&thnB='+b+'&id='+id+"&task="+task;
      oTable = $('#loadberkas').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
            "aoColumns": [
                        { "swidth": "1%" },
                        { "swidth": "20%" },
                        { "swidth": "79%" }
                       ],
            "bAutoWidth": false,
			"aaSorting": [[4, "desc"]],
            "bDestroy": true,
			"sAjaxSource": R_url
		});
   };

function loadtblusul(){
   oTable = $('#tblusul').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"aaSorting": [[2, "asc"]],
			"sAjaxSource": "Mod/ModPindahBerkas/bantai1.php"
		});

}
</script>

</script>
<form id="form1" name="form1" method="post" action="handle.php" enctype="multipart/form-data">
<?php if($_SESSION["GroupId"] == 1 or $_SESSION["GroupId"] == 2 ){ }else {?>
<table id="listDocuments" width="100%" cellspacing="0">
    <tr>
        <td class="navrightheader" valign="middle" nowrap="nowrap">
            &nbsp;
            <span class="navIcon">
                <input type="button" id="btnTambah" value="Tambah" onclick="setDetails('new','')" class="art-button" />
            </span>
        </td>
    </tr>
</table>
<?php } ?>
<div class="content-main-popup">
	<div id="pnlDetails" style="display:none">
		<table style="width:100%;" class="tb_grid" cellpadding="2" cellspacing="0">
			<tr>
				<td style="width:20%;"> Nomor Surat Permohonan <font color="red">*</font></td>
				<td style="width:90%;">
					<input type="text" name="txt1" class="inputbox" style="width:20%;">&nbsp;
					<span id="req1" class="req_field" style="display:none;" title="Nomor Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" /></span>
				</td>
			</tr>
           <tr>
                <td>
                    Tanggal Permohonan <font color="red">*</font>                </td>
                <td valign="middle">
                    <input type="text" name="txt2" id="txt2" maxlength="12"
						style="width:75px;" class="inputbox" readonly="true" />
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
					<span id="req2" class="req_field" style="display:none;" title="Tanggal Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
				<td style="width:10%;" valign="top"> Periode Arsip <font color="red">*</font></td>
				<td style="width:90%;">
                    <select class="inputbox" name="thn1" id="thn1" onchange="chpriode();">
                      <?php
                        $thnnow = date(Y);
                        for($thn=1990;$thn<=$thnnow;$thn++){
                          echo "<option value=".$thn.">".$thn."</option>";
                        }
                      ?>
                    </select>
                    s/d
                    <select class="inputbox" name="thn2" id="thn2" onchange="chpriode();">
                      <?php
                        $thnnow = date(Y);
                        for($thn=1990;$thn<=$thnnow;$thn++){
                          echo "<option value=".$thn.">".$thn."</option>";
                        }
                      ?>
                    </select>
                    <span id="req4" class="req_field" style="display:none;">
					<img src="images/Alert.gif" height="12" width="12" /></span>
				</td>
			</tr>
            <tr>
				<td style="width:10%;" valign="top"> Upload File Permohonan <font color="red">*</font></td>
				<td style="width:90%;">
                    <input type="file" name="files" id="files" class="inputbox" style="width:50%;"><br />
                    <div id="fl" style="display:none"></div>
                    <span id="req5" class="req_field" style="display:none;">
					<img src="images/Alert.gif" height="12" width="12" /></span>
                    <input type="hidden" name='temp_file' />
                </td>
			</tr>
            <tr>
				<td colspan="3">
                <input id="cid" name="cid" type="hidden" />
                <br /><br /><b><font color="#FF0000">Keterangan : Pastikan berkas yang akan dipindah telah di close</font></b>
                <br /><p><b>Pilih Berkas :</b></p><hr/>
                 <table cellpadding="0" cellspacing="0" border="0" class="display" id="loadberkas">
                 <thead>
                   <tr>
                      <th style="width:1%">No</th>
                      <th style="width:30%">Kode Berkas</th>
                      <th>Nama Berkas</th>
                   </tr>
                   </thead>
                   <tbody>
                      <tr>
                          <td colspan="5" class="dataTables_empty">Loading data from server</td>
                      </tr>
                  </tbody>
                 </table>
                 <hr/>
                 <span id="dpl" style="display: none"><font size="2" color="#FF0033">*) Telah disetujui oleh tim unit kearsipan</font></span>
                </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" id="task" value="new" />
					<input type="hidden" name="id" id="id" />
					<input type="hidden" name="count" value="4" />
					<input type="button" id="btnSimpan" onclick="confirmValidate()" class="art-button" value="Usulkan">&nbsp;
					<input type="button" id="btnBatal" value=" Batal " onclick="setList()" class="art-button">
				</td>
			</tr>
		</table>
	</div>
	<div id="pnlGrid">
    <hr/>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tblusul" >
    <thead>
		<tr>
			<th style="width:1%">No</th>
			<th style="width:10%">Nomor Permohonan</th>
			<th style="width:10%">Tanggal Permohonan</th>
            <th style="width:15%">Periode Arsip</th>
            <th style="width:25%">Unit Kerja</th>
            <th style="width:25%">Ket</th>
            <th style="width:20%">...</th>
		</tr>
     </thead>
     <tbody>
            <tr>
                <td colspan="7" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
	</table>
	</div>
</div>
<script language="javascript">
       			Calendar.setup(
				{
				  inputField  : "txt2",         // ID of the input field
				  ifFormat    : "%d/%m/%Y",    // the date format
				  button      : "trigger1",       // ID of the button
				  align       : "Tl",           // alignment (defaults to "Bl")
				  singleClick : true
				}

			);
</script>
</form>

