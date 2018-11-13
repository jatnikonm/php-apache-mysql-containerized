<?php
	$id = $_REQUEST["NId"];
	$BerkasId = $_REQUEST["BerkasId"];
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Tambah Referensi';
</script>
<form id="form1" name="form1" autocomplete="off" method="post" action="handle.php" target="MyWindowDetail">
	<table width="800" class="adminform" cellpadding="3" cellspacing="0">
		<tr>
			<td class="tabel-upload-label" style="width:25%;">Surat</td>
			<td class="tabel-upload-content" style="width:75%;">
				<input type="text" name="txt1" class="inputbox" style="width:75%;" />
				<input type="hidden" name="txt2" />
				<input type="hidden" name="txt3" />
				&nbsp;
				<input type="button" 
					style="background: url(images/view2.png) no-repeat; border:0px; width:20px;height:18px;"
				 	onclick="openRef();" />
			</td>
		</tr>
		<tr>
			<td class="tabel-upload-label">Jenis Referensi</td>
			<td class="tabel-upload-content">
				<select name="txt4" class="inputbox" style="width:50%;">
					<?php
						$text = array('Balasan', 'Referensi');
						$val = array('reply', 'ref');
						for($a=0;$a<(count($val));$a++){
							echo "<option value='" . $val[$a] . "'";									
							echo ">" . $text[$a] . "</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="tabel-upload-label" style="text-align:right;">
				<input type="hidden" name="txt5" />
				<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="task" value="Ref" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="BerkasId" value="<?php echo $BerkasId; ?>" />
				<input type="hidden" name="count" value="5" />
				<input type="button" value=" Simpan " class="art-button" onclick="setSave();" />
				<input type="button" class="art-button" value=" Tutup "  onclick="parent.changeRef('list');" />
			</td>
		</tr>
	</table>
</form>