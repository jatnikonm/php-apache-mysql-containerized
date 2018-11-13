<?php
	if($_SESSION["GroupId"] == ""){
		die("<script>location.href='../../index.php'</script>");
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Ubah Kata Sandi';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">
	<table width="410px" cellspacing="0px" border="0" cellpadding="5px" class="form">
		<tr>
			<td align="right" colspan="2" class="indikator">
				<font color="red">*</font> kolom wajib diisi
			</td>
		</tr>
		<tr>
			<td valign="top">
				Kata Sandi Saat Ini <font color="red">*</font>
			</td>
			<td>
				<input type="password" name="txt1" class="inputbox" maxlength="6" style="width:50%;">&nbsp;
				<span id="req1" class="require_field" style="display:none">
					<img src="images/Alert.gif" />
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top">
				Kata Sandi Baru <font color="red">*</font>
			</td>
			<td>
				<input type="password" name="txt2" class="inputbox" maxlength="6" style="width:50%;">&nbsp;
				<span id="req2" class="require_field" style="display:none">
					<img src="images/Alert.gif" />
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top">
				Ulangi <font color="red">*</font>
			</td>
			<td>
				<input type="password" name="txt3" class="inputbox" maxlength="6" style="width:50%;">&nbsp;
				<span id="req3" class="require_field" style="display:none">
					<img src="images/Alert.gif" />
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top">&nbsp;
				<input type="hidden" name="option" value="ChangePass" />
				<input type="hidden" name="task" value="update" />
				<input type="hidden" name="count" value="3" />
			</td>
			<td>
				<input type="button" class="art-button" value=" Simpan " onclick="setSave()" />&nbsp;&nbsp;
				<input type="button" class="art-button" value=" Tutup " onclick="parent.TINY.box.hide();" />
			</td>
		</tr>
	</table>
</form>