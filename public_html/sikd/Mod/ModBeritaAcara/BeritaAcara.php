<?php
$mod = $_REQUEST['mod'];
$ids = $_REQUEST['ids'];
$task = $_REQUEST['req'];

  switch ($mod){
  case 'up' : $label = "Berita Acara Pemindahan Arsip ke Record Center";
              break;
  }

if($task=='edit' or $task=='delete'){
 $sql = "SELECT berita_acara.Nomor, date_format(berita_acara.Tgl, '%d/%m/%Y') as Tgl, berita_acara.UploadSurat, permohonanusul.NoSurat, permohonanusul.TglSurat, berita_acara.BeritaId
         FROM berita_acara
         Inner Join permohonanusul ON berita_acara.PermohonanId = permohonanusul.PermohonanId
         WHERE berita_acara.PermohonanId =  '$ids'";
 $query = mysql_query($sql);
 $data = mysql_fetch_array($query);
}
else {
$task = "new";
$sql = "SELECT NoSurat, TglSurat, berkasid FROM permohonanusul WHERE PermohonanId = '$ids' ";
$query = mysql_query($sql);
$data = mysql_fetch_array($query);
}
    include "include/fungsi_indotgl.php";
?>

<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />
<?php
echo '
<script type="text/javascript" charset="utf-8">
	document.getElementById("title").innerHTML = "'.$label.'";
</script>';
?>
<form id="form1" name="form1" method="post" action="handle.php" enctype="multipart/form-data">
<div class="content-main-popup">
	<div id="pnlDetails">
		<table style="width:100%;" class="tb_grid" cellpadding="2" cellspacing="0">
			<tr>
				<td style="width:20%;"> Nomor Berita Acara <font color="red">*</font></td>
				<td style="width:90%;">
					<input type="text" name="txt1" class="inputbox" style="width:20%;" value='<?php echo $data['Nomor']; ?>'>&nbsp;
					<span id="req1" class="req_field" style="display:none;" title="Nomor Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" /></span>
				</td>
			</tr>
           <tr>
                <td>
                    Tanggal Berita Acara <font color="red">*</font>                </td>
                <td valign="middle">
                    <input type="text" name="txt2" id="txt2" maxlength="12"
						style="width:75px;" class="inputbox" readonly="true" value='<?php echo $data['Tgl']; ?>' />
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
					<span id="req2" class="req_field" style="display:none;" title="Tanggal Surat Wajib Diisi !">
					<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
				<td style="width:10%;" valign="top"> Nomor Surat Permohonan <font color="red">*</font></td>
				<td style="width:90%;">
                     <?php

                     echo $data['NoSurat']." / ".tgl_indo($data['TglSurat']);
                     ?>
                     <input type="hidden" name="txt3" value="<?php echo $ids; ?>">
                     <input type="hidden" name="berkasid" value="<?php echo $data['berkasid'] ?>">
				</td>
			</tr>
            <tr>
				<td style="width:10%;" valign="top"> Upload File <font color="red">*</font></td>
				<td style="width:90%;">
                    <input type="file" name="files" id="files" class="inputbox" style="width:50%;"><br />
                    <div id="fl" style="display:none"></div>
                    <span id="req5" class="req_field" style="display:none;">
					<img src="images/Alert.gif" height="12" width="12" /></span>
                    <input type="hidden" name='temp_file' value="<?php echo $data[2]; ?>" />
                    <?php if(!empty($data['UploadSurat'])){
                            $file = explode("/",$data['UploadSurat']);
                            echo 'Filename : <a href="'.$data["UploadSurat"].'">'.$file[2].'</a>';
                            }
                    ?>
                </td>
			</tr>
            <tr>
				<td colspan="3">
                  <hr>
                </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" id="task" value="<?php echo $task; ?>" />
					<input type="hidden" name="id" id="id" value="<?php echo $data['BeritaId']?>" />
					<input type="hidden" name="count" value="4" />
					<input type="button" id="btnSimpan" name="btnSimpan" onclick="confirmValidate()" class="art-button" value="Proses">&nbsp;
					<input type="button" id="btnBatal" value=" Batal " onclick="setList()" class="art-button">
				</td>
			</tr>
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

