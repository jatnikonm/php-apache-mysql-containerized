<?
	//check for Status Berkas
	$query = "select BerkasStatus 
			  from berkas b 
			  where BerkasKey = '" . $_SESSION["AppKey"] . "' 
				and BerkasId = '" . $id . "' 
				and BerkasStatus = 'closed'
				and RetensiValue_InActive <= '" . date('Y-m-d') . "'";
	$result = mysql_query($query);	
	if(mysql_num_rows($result) == 0){
		die("<script>
			alert('Status Berkas Harus Ditutup dan Melewati Masa InAktif untuk dapat diproses !');
			window.close();
			</script>");
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Tindakan Penyusutan Akhir Berkas';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">
	<?
	$query = "select BerkasId, BerkasNumber, BerkasName, SusutId 
			  from berkas b 
			  where BerkasKey = '" . $_SESSION["AppKey"] . "' 
				and BerkasId = '" . $id . "'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
		$BerkasId = $row["BerkasId"];
	?>
	<table cellspacing="0" cellpadding="3px" width="100%">
		<tr>
			<td style="width:30%;" class="tabel-upload-label">Nomor Berkas</td>
			<td style="width:70%;" class="tabel-upload-content"><strong><? echo $row["BerkasNumber"]; ?></strong></td>
		</tr>
		<tr>
			<td class="tabel-upload-label">Nama Berkas</td>
			<td class="tabel-upload-content"><strong><? echo $row["BerkasName"]; ?></strong></td>
		</tr>
		<tr>
			<td class="tabel-upload-label">&nbsp;</td>
			<td class="tabel-upload-label">&nbsp;</td>
		</tr>
		<tr>
		  <td class="tabel-upload-label">Petugas</td>
		  <td class="tabel-upload-content"><? echo $_SESSION["Name"]; ?></td>
	  </tr>
		<tr>
		  <td class="tabel-upload-label">Tanggal Penyusutan </td>
		  <td class="tabel-upload-content">
			<input type="text" name="txt1" id="txt1" width="12" class="inputbox" 
				value="<? echo strftime('%d/%m/%Y', strtotime(date('Y-m-d'))); ?>" 
				maxlength="12" style="width:70px;" readonly="readonly" />&nbsp;
			<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
					id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
		  </td>
	  </tr>
		<tr>
		  <td class="tabel-upload-label">Tindakan Penyusutan Akhir </td>
		  <td class="tabel-upload-content">
			 <select name="txt2" class="inputbox">
				<?
					$sql2 = "select SusutId, SusutName from master_penyusutan 
							where SusutId like '" . $_SESSION["AppKey"] . "%' 
							order by SusutName";
					$result2 = mysql_query($sql2);
					while($row2 = mysql_fetch_array($result2)){
						echo "<option value='" . $row2["SusutId"] . "'";
						if($row2["SusutId"] == $row["SusutId"]){
							echo "selected";
						}
						echo ">" . $row2["SusutName"] . "</option>";
					}
				?>
			</select>
		  </td>
	  </tr>
		<tr>
		  <td class="tabel-upload-label">&nbsp;</td>
		  <td class="tabel-upload-label">&nbsp;</td>
	  </tr>
		<tr>
			<td class="tabel-upload-label">
				<input type="hidden" name="option" value="<? echo $option; ?>" />
				<input type="hidden" name="task" value="<? echo $task; ?>" />
				<input type="hidden" name="id" value="<? echo $id; ?>" />
				<input type="hidden" name="count" value="2" />
			</td>
			<td class="tabel-upload-label">
				<input type="button" value="Mulai Proses" class="art-button" onclick="setProses()" /> &nbsp;&nbsp;
				<input type="button" value=" Tutup " onclick="window.close();" class="art-button" /></td>
		</tr>
	</table>
	<? } ?>
	<script language="javascript">
		Calendar.setup(
			{
			  inputField  : "txt1",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger1",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
		
	</script>	
</form>