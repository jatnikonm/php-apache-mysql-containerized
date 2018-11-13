<?php
	function loadFrontpage($param){
		$sql = "select $param from master_front";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				echo $row[0];
			}
		}
	}
?>
<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Pengaturan Umum -> Halaman Depan';
</script>
<form id="form1" name="form1" method="post" action="handle.php">
	<input type="hidden" name="txt1" id="txt1" value="" />
	<table id="listDocuments" width="100%" cellspacing="0">
		<tr>
			<td class="navrightheader" valign="middle" nowrap="nowrap">
				&nbsp;
				<span class="navIcon">
					<input type="button" id="btnTambah" value="Upload" class="btn_add" onclick="UploadGambar();" />
				</span>
				<span class="navIcon">
					<input type="button" id="btnSimpan" value=" Simpan Perubahan " class="btn_save" onclick="getSave();" />
				</span>
			</td>
		</tr>
	</table>
	<div style="text-align: center; margin: 10px auto; width:100%; height: auto;">
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div style="margin: 0 auto; width: 250px; border:1px solid #79A7E3;">
						<div class="login_header" style="font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center;">
							Login Sistem
						</div>
						<div class="login_body">
							<table width="100%" border="0" cellspacing="6" style="font-size:12px;">
								<tr>
									<td colspan="2">
										<br />
									</td>
								</tr>
								<tr>
									<td>
										Nama Pengguna
									</td>
									<td>
										<input type="text" id="ssss" name="ssss" class="text_login" disabled="disabled" maxlength="15" width="80%">
									</td>
								</tr>
								<tr>
									<td>
										Kata Sandi
									</td>
									<td>
										<input type="password" id="ddd" name="ddd" class="text_login" disabled="disabled" maxlength="6" width="80%">
									</td>
								</tr>
								<tr>
									<td colspan="1">
									</td>
									<td>
										<input type="submit" class="art-button" value="Masuk" disabled="disabled" />
									</td>
								</tr>
							</table>
						</div>
					</div>					
				</td>
				<td rowspan="2">
					<input type="text" id="txt2" name="txt2" style="width:80%;" value="<?php echo loadFrontpage('FrontTitle'); ?>" /><br /><br />
					<textarea name="txt3" id="txt3" wrap="soft" style="width:80%; height:auto;" >
						<?php echo loadFrontpage('FrontLabel'); ?>
					</textarea>
				</td>
			</tr>
			<tr>
				<td style="padding:5px;">
					<div style="margin-top: 20px; width:200px; clear: both; text-align:center;">
						<img id="imgFront" name="imgFront" width="260" height="265" src="<?php echo loadFrontpage('FrontImage'); ?>" />
					</div>
				</td>
			</tr>
		</table>
	</div>	
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="update" />
	<input type="hidden" name="count" value="3" />
</form>