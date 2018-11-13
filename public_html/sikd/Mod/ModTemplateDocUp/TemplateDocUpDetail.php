<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Upload Template Dokumen';
</script>
<br />
<form name="form1" id="form1" enctype="multipart/form-data" method="post" action="handle.php" target="MyWindowDetail">
	<table width="620" cellspacing="0" border="0" cellpadding="4" >
		<tr>
			<td style="width:25%;">Nama Template Dokumen</td>
			<td style="width:65%;"><input type="text" class="inputbox" name="txt1" style="width:80%;">
            &nbsp;<span id="req" class="require_field" style="display:none">!</span></td>
		</tr>
		<tr>
			<td>Pilih Dokumen</td>
			<td><input type="file" name="file" id="file" style="width:100%;" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="art-button" value=" Upload " /></td>
		</tr>
	</table>
	<input type="hidden" name="option" value="TemplateDocUp" />
	<input type="hidden" name="task" value="upload" />
	<input type="hidden" name="count" value="1" />
</form>