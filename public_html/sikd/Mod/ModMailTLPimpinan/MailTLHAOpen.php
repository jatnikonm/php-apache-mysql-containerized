<?
	$id = $_REQUEST["NId"];
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Penambahan Hak Akses';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">
	<div style="height:auto; width:90%; float:left; background-color: #FFFFFF; max-height:150px; ">
		<iframe id="frmCC" name="frmCC" frameborder="0" scrolling="auto" width="100%"></iframe>
	</div>
	<div style="width:8%; float:left; text-align:center;">
		<input type="button" style="background:url(images/createcontent-1.gif) no-repeat;border:0px;" height="18" width="18" onclick="ShowPeople()" />
		<br />
		<br />
		<input type="button" style="background:url(images/delete.png) no-repeat; border:0px;" height="18" width="18" onclick="relocateCC('')" />
		<br />
		<br />
		<br />
		<br />
	</div>
	<div style="margin-top:20px; width:100%; display:block; text-align:right">
		<input type="hidden" name="txt1" value="" />
		<input type="hidden" name="option" value="MailTL" />
		<input type="hidden" name="task" value="saveHA" />
		<input type="hidden" name="id" value="<? echo $id; ?>" />
		<input type="hidden" name="count" value="1" />
	</div>
	<div style="margin-top:50px; width:100%; float:left;">
		<input type="button" class="art-button" value=" Simpan " onclick="setSave()" />&nbsp;&nbsp;
		<input type="button" class="art-button" value=" Tutup " onclick="window.close();" />
	</div>
</form>
		