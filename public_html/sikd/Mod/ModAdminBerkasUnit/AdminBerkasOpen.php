<?php
	$sql = "select BerkasNumber, BerkasName from berkas 
		where BerkasKey = '" . $_SESSION["AppKey"] . "' 
			and BerkasId = '$id'";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)){
		$nmr = $row[0];
		$name = $row[1];
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Buka Berkas';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">
	<table cellspacing="0" cellpadding="3px" width="100%">
		<tr>
			<td style="width:20%;" class="tabel-upload-label">Nomor</td>
			<td style="width:80%;" class="tabel-upload-content"><strong><?php echo $nmr; ?></strong></td>
		</tr>
		<tr>
			<td style="width:20%;" class="tabel-upload-label">Nama</td>
			<td style="width:80%;" class="tabel-upload-content"><strong><?php echo $name; ?></strong></td>
		</tr>
		<tr>
			<td style="width:20%;" class="tabel-upload-label">&nbsp;</td>
			<td style="width:80%;" class="tabel-upload-label">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:20%;" class="tabel-upload-label">
				<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="task" value="<?php echo $task; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
			</td>
			<td style="width:80%;" class="tabel-upload-content">
				<input type="button" value="Buka Berkas" class="art-button" onclick="setSave()" /> &nbsp;&nbsp;
				<input type="button" value=" Tutup " onclick="parent.closeWindow();" class="art-button" /></td>
		</tr>
	</table>
</form>
