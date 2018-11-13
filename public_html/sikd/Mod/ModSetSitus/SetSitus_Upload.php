<script type="text/javascript">
<!--
	function Tutup()
	{
		window.returnValue = vReturnValue;
		window.close();
	}            

	-->
</script>
<form name="form1" id="form1" method="post" enctype="multipart/form-data" action="handle.php" target="MyWindowDetail">
	<table width="100%" cellpadding="3" cellspacing="0">
		<tr>
			<td style="width:15%; padding:3px;">File</td>
			<td style="padding:3px;">
			<input type="file" id="file" name="file" style="width:80%;" /><br />
			<small>(size : <i>280 x 285 px</i>) | (ext : <i>*.jpg, *.jpeg, *.gif, *.png</i>)</small></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="option" value="<? echo $option; ?>" />
				<input type="hidden" name="task" value="upload" />
			</td>
			<td><input type="submit" id="btnUpload" class="art-button" value=" upload " /></td>
		</tr>                    
	</table>
</form>
