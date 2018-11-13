<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Usul Hapus File Digital';
</script>
<form id="form1" name="form1" method="post" action="handle.php" target="MyWindowDetail">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="<?php echo $task; ?>" />
	<input type="hidden" name="GIR_Id" value="<?php echo $_REQUEST["GIR_Id"]; ?>" />
	<input type="hidden" name="NId" value="<?php echo $_REQUEST["NId"]; ?>" />
	<input type="hidden" name="count" value="1" />
	<table cellspacing="0" cellpadding="3px" width="600">
		<tr>
			<td align="right" colspan="2" class="style1">
				<font color="red">*</font> kolom wajib diisi
			</td>
		</tr>
		<tr>
			<td class="tabel-upload-label" valign="top" style="width:30%;">
				Pesan <font color="red">*</font>
			</td>
			<td class="tabel-upload-content" style="width:70%;">
				<textarea name="txt1" rows="4" class="inputbox" style="width:80%;" ></textarea>
				<span id="req1" class="require_field" style="display:none;" title="Pesan Wajib Diisi !">
					<img src="images/Alert.gif" alt="Pesan Wajib Diisi !" />
				</span>
			</td>
		</tr>
		<tr>
			<td class="tabel-upload-label" valign="top" style="width:30%;">&nbsp;
				
			</td>
			<td class="tabel-upload-label" style="width:70%;">
				<input type="button" class="art-button" value=" Kirim " onclick="setSave();" />&nbsp;&nbsp;
				<input type="button" class="art-button" value=" Tutup " onclick="parent.closeWindow();" />
			</td>
		</tr>
	</table>
</form>
