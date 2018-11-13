<?
	if($_SESSION["GroupId"] == "" || 
		$_SESSION["PeopleID"] == ""){
		die("<script>location.href='index.php'</script>");
	}

	$query = "select * from berkas 
				where BerkasId = (select BerkasId from inbox where NId = '" . $id . "')";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
	$BerkasId = $row["BerkasId"];
	?>
	<script type="text/javascript">
		document.getElementById("title").innerHTML = 'Tutup Berkas';
	</script>
	<form id="form1" name="form1" method="post" action="handle.php" target="MyWindowDetail">
		<table cellspacing="0" cellpadding="3px" width="100%">
			<tr>
				<td align="right" colspan="2" class="indikator">
					<font color="red">*</font> kolom wajib diisi
				</td>
			</tr>
			<tr>
				<td style="width:20%;" class="tabel-upload-label">Diberkaskan di <font color="red">*</font></td>
				<td style="width:80%;" class="tabel-upload-content">
					<input type="hidden" name="txt1" value="<? echo $row["RoleId"]; ?>" />
					<select name="txt2" class="inputbox">
						<?
							$sql = "select RoleId, RoleDesc from role 
								where RoleKey='" . $_SESSION["AppKey"] . "' 
								and ((RoleName not like 'Administrator%') or (RoleId not like 'root%'))";
							
							if ($_REQUEST["closeFrom"] == "surat") {
								$sql .= " and (RoleId in (select RoleId_To from inbox_receiver where NId = '" . $id . "' and ReceiverAs in('to', 'cc1', 'to_reply')) ";
								$sql .= "        or RoleId in (select RoleId_From from inbox_receiver where NId = '" . $id . "')) ";
							}elseif ($_REQUEST["closeFrom"] == "berkas") {
								$sql .= " and (RoleId in (select RoleId from berkas where BerkasId = '" . $id . "') ";
								$sql .= "        or RoleId in (select RoleId_To from inbox_receiver where NId in (select NId from inbox where BerkasId = '" . $id . "') ) ";
								$sql .= "        or RoleId in (select RoleId_From from inbox_receiver where NId in (select NId from inbox where BerkasId = '" . $id . "') ) ) ";
							}
							$res = mysql_query($sql);
							while($rw = mysql_fetch_array($res)){
								echo "<option value='" . $rw["RoleId"] . "'";
								if($row["RoleId"] == $rw["RoleId"]){
									echo " selected ";
								}
								echo ">" . $rw["RoleDesc"] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tabel-upload-label">Berkas</td>
				<td class="tabel-upload-content"><? echo $row["BerkasNumber"] . " - " . $row["BerkasName"]; ?></td>
			</tr>
			<tr>
				<td class="tabel-upload-label">Retensi</td>
				<td class="tabel-upload-content">Perhitungan Dimulai dari : 
					<? 	if($row["BerkasCountSince"] == "created"){
							echo 'Sejak Berkas Dibuat';
						}else{
							echo 'Saat Berkas Ditutup';
						} ?></td>
			</tr>
			<tr>
				<td class="tabel-upload-label">&nbsp;</td>
				<td class="tabel-upload-content">Aktif s/d 
					<?  
						if($row["BerkasCountSince"] != "open"){
							echo strftime('%d/%m/%Y', strtotime($row["RetensiValue_Active"]));
						}else{
							"";
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="tabel-upload-label">&nbsp;</td>
				<td class="tabel-upload-content">InAktif s/d 
					<?  
						if($row["BerkasCountSince"] != "open"){
							echo strftime('%d/%m/%Y', strtotime($row["RetensiValue_InActive"]));
						}else{
							"";
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="tabel-upload-label">Lokasi Fisik <font color="red">*</font></td>
				<td class="tabel-upload-content">
					<input type="text" name="txt3" class="inputbox" style="width:75%;" value="<? echo $row["BerkasLokasi"]; ?>" />
				</td>
			</tr>
			<tr>
				<td class="tabel-upload-label">&nbsp;</td>
				<td class="tabel-upload-content">
					<input type="hidden" name="txt4" />
				</td>
			</tr>
			<tr>
				<td style="text-align:right;">
					<input type="hidden" name="option" value="MailTL" />
					<input type="hidden" name="task" value="tutupBerkas" />
					<input type="hidden" name="id" value="<? echo $BerkasId; ?>" />
					<input type="hidden" name="count" value="4" />
				</td>
				<td class="tabel-upload-content">
					<input type="button" name="btnSimpan" class="art-button" value=" Proses Tutup Berkas " onclick="setSave();" />
					&nbsp;&nbsp;
					<input class="art-button" onclick="window.close();" type="button" 
						value=" Tutup " />
				</td>
			</tr>
		</table>
	</form>
	<?
	}