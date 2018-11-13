<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />
<script type="text/javascript" charset="utf-8">
	document.getElementById("title").innerHTML = 'Pengajuan Surat Permohonan Usul Musnah Arsip';

$(document).ready(function() {
  loadtblusul();
});

function ltblberkas(a,b,id,role){
       var R_url;
       var task = $("#task").val();
       //var id = $("#id").val();
      R_url = 'Mod/ModUsulMusnah/bantai2.php?thnA='+a+'&thnB='+b+'&id='+id+"&task="+task+"&role="+role;
      oTable = $('#loadberkas').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
            "aoColumns": [
                        { "swidth": "1%" },
                        { "swidth": "20%" },
                        { "swidth": "83%" },
                        { "swidth": "60%" }
                       ],
            "bAutoWidth": false,
			"aaSorting": [[3, "desc"]],
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
			"aaSorting": [[5, "asc"]],
			"sAjaxSource": "Mod/ModUsulMusnah/bantai1.php"
		});

}
</script>

</script>
<form id="form1" name="form1" method="post" action="handle.php" enctype="multipart/form-data">
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
<div class="content-main-popup">
	<div id="pnlDetails" style="display:none">
		<table style="width:100%;" class="tb_grid" cellpadding="2" cellspacing="0">
			<tr>
				<td style="width:20%;"> Nomor Surat <font color="red">*</font></td>
				<td style="width:90%;">
					<input type="text" name="txt1" class="inputbox" style="width:20%;">&nbsp;
					<span id="req1" class="req_field" style="display:none;" title="Nomor Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" /></span>
				</td>
			</tr>
           <tr>
                <td>
                    Tanggal Surat <font color="red">*</font></td>
                <td valign="middle">
                    <input type="text" name="txt2" id="txt2" maxlength="12"
						style="width:75px;" class="inputbox" readonly="true" />
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
					<span id="req2" class="req_field" style="display:none;" title="Tanggal Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
				<td style="width:10%;" valign="top"> Upload Surat <font color="red">*</font></td>
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
                <br /><br /><p><b>Pilih Berkas :</b></p><hr/>
                 <table cellpadding="0" cellspacing="0" border="0" class="display" id="loadberkas">
                 <thead>
                   <tr>
                      <th width="1%">No</th>
                      <th>Nomor Berkas</th>
                      <th>Nama Berkas</th>
                      <th>Unit Kerja</th>
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
			<th style="width:10%">Nomor Surat</th>
			<th style="width:10%">Tanggal</th>
            <th style="width:20%">File Surat</th>
            <th style="width:10%">Keterangan</th>
            <th style="width:10%">...</th>
		</tr>
     </thead>
     <tbody>
            <tr>
                <td colspan="5" class="dataTables_empty">Loading data from server</td>
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

